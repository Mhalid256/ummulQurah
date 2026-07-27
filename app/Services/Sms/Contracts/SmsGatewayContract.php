<?php

namespace App\Services\Sms\Contracts;

interface SmsGatewayContract
{
    /**
     * Send an SMS. Returns:
     * ['sent' => bool, 'provider_id' => string|null, 'raw' => array]
     */
    public function send(string $toPhone, string $message): array;
}