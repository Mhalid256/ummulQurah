<?php

namespace App\Services\Payments;

use App\Models\Donation;
use App\Services\Payments\Contracts\PaymentGatewayContract;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * Safaricom M-Pesa Daraja API — sends an STK Push prompt directly to the
 * donor's phone; they enter their M-Pesa PIN to confirm. No redirect needed.
 *
 * Docs: https://developer.safaricom.co.ke/Documentation
 * Required .env: MPESA_ENV (sandbox|production), MPESA_CONSUMER_KEY,
 * MPESA_CONSUMER_SECRET, MPESA_SHORTCODE, MPESA_PASSKEY, MPESA_CALLBACK_URL
 */
class MpesaGateway implements PaymentGatewayContract
{
    protected function baseUrl(): string
    {
        return config('services.mpesa.env') === 'production'
            ? 'https://api.safaricom.co.ke'
            : 'https://sandbox.safaricom.co.ke';
    }

    protected function accessToken(): string
    {
        return Cache::remember('mpesa_access_token', 3500, function () {
            $key = config('services.mpesa.consumer_key');
            $secret = config('services.mpesa.consumer_secret');

            if (! $key || ! $secret) {
                throw new RuntimeException('M-Pesa is not configured. Set MPESA_CONSUMER_KEY / MPESA_CONSUMER_SECRET in .env.');
            }

            $response = Http::withBasicAuth($key, $secret)
                ->get($this->baseUrl() . '/oauth/v1/generate', ['grant_type' => 'client_credentials']);

            if (! $response->successful()) {
                Log::error('M-Pesa OAuth failed', ['response' => $response->body()]);
                throw new RuntimeException('Could not authenticate with M-Pesa.');
            }

            return $response->json('access_token');
        });
    }

    public function initiate(Donation $donation, array $context = []): array
    {
        $shortcode = config('services.mpesa.shortcode');
        $passkey = config('services.mpesa.passkey');
        $timestamp = now()->format('YmdHis');
        $password = base64_encode($shortcode . $passkey . $timestamp);

        $phone = $this->normalizePhone($context['phone'] ?? $donation->donor->phone);

        $response = Http::withToken($this->accessToken())
            ->acceptJson()
            ->post($this->baseUrl() . '/mpesa/stkpush/v1/processrequest', [
                'BusinessShortCode' => $shortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => (int) ceil($donation->amount),
                'PartyA' => $phone,
                'PartyB' => $shortcode,
                'PhoneNumber' => $phone,
                'CallBackURL' => config('services.mpesa.callback_url'),
                'AccountReference' => 'DON' . $donation->id,
                'TransactionDesc' => 'Donation to ' . optional($donation->campaign)->title,
            ]);

        if (! $response->successful() || $response->json('ResponseCode') !== '0') {
            Log::error('M-Pesa STK push failed', ['response' => $response->body()]);
            throw new RuntimeException('Could not send the M-Pesa prompt. Please check the phone number and try again.');
        }

        $reference = $response->json('CheckoutRequestID');
        $donation->update(['transaction_ref' => $reference]);

        return [
            'type' => 'push',
            'redirect_url' => null,
            'reference' => $reference,
            'message' => 'Check your phone (' . $phone . ') and enter your M-Pesa PIN to complete the donation.',
        ];
    }

    public function verifyTransaction(string $reference): array
    {
        $shortcode = config('services.mpesa.shortcode');
        $passkey = config('services.mpesa.passkey');
        $timestamp = now()->format('YmdHis');
        $password = base64_encode($shortcode . $passkey . $timestamp);

        $response = Http::withToken($this->accessToken())
            ->acceptJson()
            ->post($this->baseUrl() . '/mpesa/stkpushquery/v1/query', [
                'BusinessShortCode' => $shortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'CheckoutRequestID' => $reference,
            ]);

        $resultCode = $response->json('ResultCode');
        $status = $resultCode === '0' || $resultCode === 0 ? 'successful' : ($resultCode === null ? 'pending' : 'failed');

        return ['status' => $status, 'amount' => null, 'raw' => $response->json()];
    }

    /** M-Pesa expects 2547XXXXXXXX / 2567XXXXXXXX, not 07XX or +2567XX */
    protected function normalizePhone(?string $phone): string
    {
        $phone = preg_replace('/\D/', '', (string) $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '256' . substr($phone, 1); // default to Uganda; adjust for Kenya (254) as needed
        }

        return $phone;
    }
}