<?php

namespace App\Services\Payments;

use App\Models\Donation;
use App\Services\Payments\Contracts\PaymentGatewayContract;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * Flutterwave Standard Checkout — covers card, bank transfer, and mobile
 * money (MTN/Airtel etc.) for Uganda, Kenya, Nigeria, Ghana, and more,
 * all through a single hosted checkout link.
 *
 * Docs: https://developer.flutterwave.com/docs/collecting-payments/standard
 * Required .env: FLUTTERWAVE_SECRET_KEY, FLUTTERWAVE_SECRET_HASH
 */
class FlutterwaveGateway implements PaymentGatewayContract
{
    protected string $baseUrl = 'https://api.flutterwave.com/v3';

    public function initiate(Donation $donation, array $context = []): array
    {
        $secretKey = config('services.flutterwave.secret_key');

        if (! $secretKey) {
            throw new RuntimeException('Flutterwave is not configured. Set FLUTTERWAVE_SECRET_KEY in .env.');
        }

        $txRef = 'DON-' . $donation->id . '-' . now()->timestamp;

        $response = Http::withToken($secretKey)
            ->acceptJson()
            ->post("{$this->baseUrl}/payments", [
                'tx_ref' => $txRef,
                'amount' => (string) $donation->amount,
                'currency' => $donation->currency,
                'redirect_url' => route('public.donate.callback', $donation->campaign),
                'customer' => [
                    'email' => $context['email'] ?? $donation->donor->email,
                    'phonenumber' => $context['phone'] ?? $donation->donor->phone,
                    'name' => $context['name'] ?? $donation->donor->display_name,
                ],
                'customizations' => [
                    'title' => config('app.name') . ' Donation',
                    'description' => 'Donation to ' . optional($donation->campaign)->title,
                ],
                'meta' => [
                    'donation_id' => $donation->id,
                ],
            ]);

        if (! $response->successful() || $response->json('status') !== 'success') {
            Log::error('Flutterwave initiate failed', ['response' => $response->body()]);
            throw new RuntimeException('Could not start payment with Flutterwave. Please try again.');
        }

        $donation->update(['transaction_ref' => $txRef]);

        return [
            'type' => 'redirect',
            'redirect_url' => $response->json('data.link'),
            'reference' => $txRef,
            'message' => null,
        ];
    }

    public function verifyTransaction(string $reference): array
    {
        $secretKey = config('services.flutterwave.secret_key');

        // Flutterwave's verify-by-reference endpoint needs the numeric transaction id,
        // which we get by searching transactions with our tx_ref first.
        $search = Http::withToken($secretKey)->acceptJson()
            ->get("{$this->baseUrl}/transactions", ['tx_ref' => $reference]);

        $transaction = $search->json('data.0');

        if (! $transaction) {
            return ['status' => 'pending', 'amount' => null, 'raw' => $search->json()];
        }

        $verify = Http::withToken($secretKey)->acceptJson()
            ->get("{$this->baseUrl}/transactions/{$transaction['id']}/verify");

        $status = $verify->json('data.status') === 'successful' ? 'successful' : 'failed';

        return [
            'status' => $status,
            'amount' => $verify->json('data.amount'),
            'raw' => $verify->json(),
        ];
    }

    /**
     * Verify that an incoming webhook really came from Flutterwave by
     * comparing the "verif-hash" header against our configured secret hash.
     */
    public static function verifyWebhookSignature(?string $signatureHeader): bool
    {
        $expected = config('services.flutterwave.secret_hash');

        return $expected && $signatureHeader && hash_equals($expected, $signatureHeader);
    }
}