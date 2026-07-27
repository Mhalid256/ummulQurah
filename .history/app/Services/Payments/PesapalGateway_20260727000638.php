<?php

namespace App\Services\Payments;

use App\Models\Donation;
use App\Services\Payments\Contracts\PaymentGatewayContract;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * Pesapal v3 API — a hosted checkout page covering card, mobile money
 * (MTN, Airtel), and bank payments, widely used across Uganda, Kenya,
 * Tanzania, Malawi, Zambia, Rwanda.
 *
 * Docs: https://developer.pesapal.com/how-to-integrate/api-30-overview
 * Required .env: PESAPAL_ENV (sandbox|production), PESAPAL_CONSUMER_KEY,
 * PESAPAL_CONSUMER_SECRET, PESAPAL_CALLBACK_URL
 *
 * Flow: RequestToken -> (RegisterIPN once) -> SubmitOrderRequest -> redirect
 * donor to the returned URL -> Pesapal calls our IPN URL and/or redirects
 * the donor back to callback_url with an OrderTrackingId -> we call
 * GetTransactionStatus to confirm.
 */
class PesapalGateway implements PaymentGatewayContract
{
    protected function baseUrl(): string
    {
        return config('services.pesapal.env') === 'production'
            ? 'https://pay.pesapal.com/v3'
            : 'https://cybqa.pesapal.com/pesapalv3';
    }

    protected function consumerKey(): ?string
    {
        return config('services.pesapal.consumer_key');
    }

    protected function consumerSecret(): ?string
    {
        return config('services.pesapal.consumer_secret');
    }

    protected function accessToken(): string
    {
        return Cache::remember('pesapal_access_token', 290, function () { // Pesapal tokens expire after ~5 minutes
            if (! $this->consumerKey() || ! $this->consumerSecret()) {
                throw new RuntimeException('Pesapal is not configured. Set PESAPAL_CONSUMER_KEY / PESAPAL_CONSUMER_SECRET in .env.');
            }

            $response = Http::acceptJson()->post($this->baseUrl() . '/api/Auth/RequestToken', [
                'consumer_key' => $this->consumerKey(),
                'consumer_secret' => $this->consumerSecret(),
            ]);

            if (! $response->successful() || ! $response->json('token')) {
                Log::error('Pesapal auth failed', ['response' => $response->body()]);
                throw new RuntimeException('Could not authenticate with Pesapal.');
            }

            return $response->json('token');
        });
    }

    /**
     * Pesapal requires an IPN URL to be registered before it can be used
     * in an order request, and gives back an ipn_id to reference. We only
     * need to do this once — cached indefinitely (clear the cache key if
     * you ever change PESAPAL_CALLBACK/IPN URL).
     */
    protected function ipnId(): string
    {
        if (config('services.pesapal.ipn_id')) {
            return config('services.pesapal.ipn_id');
        }

        return Cache::rememberForever('pesapal_ipn_id', function () {
            $response = Http::withToken($this->accessToken())->acceptJson()
                ->post($this->baseUrl() . '/api/URLSetup/RegisterIPN', [
                    'url' => config('services.pesapal.ipn_url'),
                    'ipn_notification_type' => 'GET',
                ]);

            if (! $response->successful() || ! $response->json('ipn_id')) {
                Log::error('Pesapal IPN registration failed', ['response' => $response->body()]);
                throw new RuntimeException('Could not register Pesapal IPN URL.');
            }

            return $response->json('ipn_id');
        });
    }

    public function initiate(Donation $donation, array $context = []): array
    {
        $merchantRef = 'DON-' . $donation->id . '-' . now()->timestamp;
        $name = trim((string) ($context['name'] ?? $donation->donor->display_name));
        [$firstName, $lastName] = array_pad(explode(' ', $name, 2), 2, '');

        $response = Http::withToken($this->accessToken())->acceptJson()
            ->post($this->baseUrl() . '/api/Transactions/SubmitOrderRequest', [
                'id' => $merchantRef,
                'currency' => $donation->currency,
                'amount' => (float) $donation->amount,
                'description' => 'Donation to ' . optional($donation->campaign)->title,
                'callback_url' => route('public.donate.callback', $donation->campaign),
                'notification_id' => $this->ipnId(),
                'billing_address' => [
                    'email_address' => $context['email'] ?? $donation->donor->email,
                    'phone_number' => $context['phone'] ?? $donation->donor->phone,
                    'first_name' => $firstName ?: 'Donor',
                    'last_name' => $lastName ?: '-',
                ],
            ]);

        if (! $response->successful() || ! $response->json('redirect_url')) {
            Log::error('Pesapal SubmitOrderRequest failed', ['response' => $response->body()]);
            throw new RuntimeException('Could not start payment with Pesapal. Please try again.');
        }

        // order_tracking_id is what GetTransactionStatus and the IPN both key off,
        // so that's what we store as our transaction_ref, not the merchant reference.
        $donation->update(['transaction_ref' => $response->json('order_tracking_id')]);

        return [
            'type' => 'redirect',
            'redirect_url' => $response->json('redirect_url'),
            'reference' => $response->json('order_tracking_id'),
            'message' => null,
        ];
    }

    public function verifyTransaction(string $reference): array
    {
        $response = Http::withToken($this->accessToken())->acceptJson()
            ->get($this->baseUrl() . '/api/Transactions/GetTransactionStatus', [
                'orderTrackingId' => $reference,
            ]);

        $description = $response->json('payment_status_description'); // COMPLETED | FAILED | INVALID | REVERSED

        $status = match ($description) {
            'COMPLETED' => 'successful',
            'FAILED', 'INVALID', 'REVERSED' => 'failed',
            default => 'pending',
        };

        return [
            'status' => $status,
            'amount' => $response->json('amount'),
            'raw' => $response->json(),
        ];
    }
}