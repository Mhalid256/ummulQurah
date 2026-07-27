<?php

namespace App\Services\Sms;

use App\Services\Sms\Contracts\SmsGatewayContract;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Africa's Talking SMS — widely used across Uganda, Kenya, Nigeria, and
 * other African markets for bulk/transactional SMS.
 *
 * Docs: https://developers.africastalking.com/docs/sms/overview
 * Required .env: AFRICASTALKING_USERNAME, AFRICASTALKING_API_KEY,
 * optional AFRICASTALKING_SENDER_ID
 */
class AfricasTalkingGateway implements SmsGatewayContract
{
    public function send(string $toPhone, string $message): array
    {
        $username = config('services.africastalking.username');
        $apiKey = config('services.africastalking.api_key');

        if (! $username || ! $apiKey) {
            Log::warning('Africa\'s Talking SMS not configured — message not sent', ['to' => $toPhone]);
            return ['sent' => false, 'provider_id' => null, 'raw' => ['error' => 'not_configured']];
        }

        $endpoint = $username === 'sandbox'
            ? 'https://api.sandbox.africastalking.com/version1/messaging'
            : 'https://api.africastalking.com/version1/messaging';

        $response = Http::asForm()
            ->withHeaders(['apiKey' => $apiKey, 'Accept' => 'application/json'])
            ->post($endpoint, array_filter([
                'username' => $username,
                'to' => $this->normalizePhone($toPhone),
                'message' => $message,
                'from' => config('services.africastalking.sender_id'),
            ]));

        $recipient = $response->json('SMSMessageData.Recipients.0');
        $sent = $recipient && ($recipient['status'] ?? '') === 'Success';

        if (! $sent) {
            Log::warning('Africa\'s Talking SMS send failed', ['response' => $response->body()]);
        }

        return [
            'sent' => (bool) $sent,
            'provider_id' => $recipient['messageId'] ?? null,
            'raw' => $response->json(),
        ];
    }

    protected function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '256' . substr($phone, 1); // default Uganda; adjust per your primary market
        }

        return '+' . $phone;
    }
}