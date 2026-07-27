<?php

namespace App\Services\Payments;

use App\Services\Payments\Contracts\PaymentGatewayContract;
use InvalidArgumentException;

class PaymentGatewayManager
{
    /**
     * Resolution priority:
     *
     * - mobile_money: direct M-Pesa STK push first (best UX — no redirect,
     *   just a phone prompt), then Pesapal, then Flutterwave.
     * - card / bank_transfer: Pesapal first (dominant in Uganda), then
     *   Flutterwave.
     *
     * Whichever provider has credentials configured wins; if none are
     * configured for a given method, we throw so the caller can show a
     * friendly "not available yet" message instead of a silent failure.
     */
    public function resolve(string $paymentMethod): PaymentGatewayContract
    {
        if ($paymentMethod === 'mobile_money') {
            if (config('services.mpesa.consumer_key')) {
                return new MpesaGateway();
            }
            if (config('services.pesapal.consumer_key')) {
                return new PesapalGateway();
            }
            if (config('services.flutterwave.secret_key')) {
                return new FlutterwaveGateway();
            }
        }

        if (in_array($paymentMethod, ['card', 'bank_transfer', 'mobile_money'])) {
            if (config('services.pesapal.consumer_key')) {
                return new PesapalGateway();
            }
            if (config('services.flutterwave.secret_key')) {
                return new FlutterwaveGateway();
            }
        }

        throw new InvalidArgumentException(
            "No payment gateway is configured for [{$paymentMethod}]. Set up Pesapal, Flutterwave, or M-Pesa credentials in .env."
        );
    }
}