<?php

namespace App\Services\Payments\Contracts;

use App\Models\Donation;

interface PaymentGatewayContract
{
    /**
     * Kick off payment for a pending donation.
     *
     * Returns an array shaped like:
     * [
     *   'type' => 'redirect' | 'push',       // 'redirect' = send donor to a checkout URL,
     *                                          // 'push' = an STK/USSD prompt was sent to their phone
     *   'redirect_url' => string|null,        // present when type = 'redirect'
     *   'reference' => string,                // gateway's transaction/request reference — store this
     *   'message' => string|null,              // human-readable instructions, e.g. for STK push
     * ]
     */
    public function initiate(Donation $donation, array $context = []): array;

    /**
     * Actively check a transaction's status with the gateway (used as a
     * fallback if a webhook is missed, or for manual reconciliation).
     *
     * Returns: ['status' => 'successful'|'failed'|'pending', 'amount' => float|null, 'raw' => array]
     */
    public function verifyTransaction(string $reference): array;
}