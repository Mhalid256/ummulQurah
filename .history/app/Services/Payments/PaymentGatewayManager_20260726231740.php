<?php

namespace App\Services\Payments;

use App\Services\Payments\Contracts\PaymentGatewayContract;
use InvalidArgumentException;

class PaymentGatewayManager
{
    /**
     * Card and bank transfer always go through Flutterwave's hosted checkout.
     * Mobile money uses direct M-Pesa STK push if configured (better UX —
     * no redirect, just a phone prompt); otherwise it falls back to
     * Flutterwave's checkout, which also supports mobile money networks.
     */
    public function resolve(string $paymentMethod): PaymentGatewayContract
    {
        if ($paymentMethod === 'mobile_money' && config('services.mpesa.consumer_key')) {
            return new MpesaGateway();
        }

        return match ($paymentMethod) {
            'card', 'bank_transfer', 'mobile_money' => new FlutterwaveGateway(),
            default => throw new InvalidArgumentException("No payment gateway configured for [{$paymentMethod}]."),
        };
    }
}