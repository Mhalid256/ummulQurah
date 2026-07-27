<?php

namespace App\Services\WhatsApp\Contracts;

interface WhatsAppGatewayContract
{
    /**
     * Send a WhatsApp text message. Returns:
     * ['sent' => bool, 'provider_id' => string|null, 'raw' => array]
     */
    public function send(string $toPhone, string $message): array;
}