<?php

namespace App\Services\WhatsApp;

use App\Services\WhatsApp\Contracts\WhatsAppGatewayContract;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Meta's WhatsApp Business Cloud API.
 *
 * IMPORTANT LIMITATION: Meta only allows free-form text messages within a
 * 24-hour window after the recipient last messaged your business number.
 * For proactive outreach to donors/volunteers who haven't messaged you
 * first (the typical case for a "Communication" broadcast), you must use
 * a pre-approved message TEMPLATE instead — sendTemplate() below. Plain
 * send() will fail for anyone outside that 24-hour window.
 *
 * Docs: https://developers.facebook.com/docs/whatsapp/cloud-api
 * Required .env: WHATSAPP_PHONE_NUMBER_ID, WHATSAPP_ACCESS_TOKEN
 */
class WhatsAppCloudApiGateway implements WhatsAppGatewayContract
{
    protected function endpoint(): string
    {
        $phoneNumberId = config('services.whatsapp.phone_number_id');
        return "https://graph.facebook.com/v19.0/{$phoneNumberId}/messages";
    }

    public function send(string $toPhone, string $message): array
    {
        $token = config('services.whatsapp.access_token');

        if (! $token || ! config('services.whatsapp.phone_number_id')) {
            Log::warning('WhatsApp Cloud API not configured — message not sent', ['to' => $toPhone]);
            return ['sent' => false, 'provider_id' => null, 'raw' => ['error' => 'not_configured']];
        }

        $response = Http::withToken($token)->acceptJson()->post($this->endpoint(), [
            'messaging_product' => 'whatsapp',
            'to' => $this->normalizePhone($toPhone),
            'type' => 'text',
            'text' => ['body' => $message],
        ]);

        $messageId = $response->json('messages.0.id');

        if (! $messageId) {
            Log::warning('WhatsApp send failed', ['response' => $response->body()]);
        }

        return ['sent' => (bool) $messageId, 'provider_id' => $messageId, 'raw' => $response->json()];
    }

    /**
     * Send via a pre-approved template — required for the first message to
     * someone outside the 24-hour session window. $templateName and
     * $languageCode must match what you configured in Meta Business Manager.
     */
    public function sendTemplate(string $toPhone, string $templateName, array $params = [], string $languageCode = 'en_US'): array
    {
        $token = config('services.whatsapp.access_token');

        if (! $token) {
            return ['sent' => false, 'provider_id' => null, 'raw' => ['error' => 'not_configured']];
        }

        $response = Http::withToken($token)->acceptJson()->post($this->endpoint(), [
            'messaging_product' => 'whatsapp',
            'to' => $this->normalizePhone($toPhone),
            'type' => 'template',
            'template' => [
                'name' => $templateName,
                'language' => ['code' => $languageCode],
                'components' => empty($params) ? [] : [[
                    'type' => 'body',
                    'parameters' => array_map(fn ($p) => ['type' => 'text', 'text' => $p], $params),
                ]],
            ],
        ]);

        $messageId = $response->json('messages.0.id');

        return ['sent' => (bool) $messageId, 'provider_id' => $messageId, 'raw' => $response->json()];
    }

    protected function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (str_starts_with($phone, '0')) {
            $phone = '256' . substr($phone, 1); // default Uganda; adjust per your primary market
        }

        return $phone;
    }
}