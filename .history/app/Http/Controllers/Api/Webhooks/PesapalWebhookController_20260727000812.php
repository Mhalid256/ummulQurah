<?php

namespace App\Http\Controllers\Api\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Services\Payments\PesapalGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PesapalWebhookController extends Controller
{
    /**
     * Pesapal calls this (registered as a GET IPN) with OrderTrackingId and
     * OrderMerchantReference as query params. It doesn't tell us the actual
     * payment outcome directly — we have to call GetTransactionStatus to
     * find out, then update our donation and acknowledge in the exact JSON
     * shape Pesapal expects.
     */
    public function handle(Request $request, PesapalGateway $gateway)
    {
        $orderTrackingId = $request->query('OrderTrackingId') ?? $request->query('orderTrackingId');
        $merchantReference = $request->query('OrderMerchantReference') ?? $request->query('orderMerchantReference');
        $notificationType = $request->query('OrderNotificationType', 'IPNCHANGE');

        if (! $orderTrackingId) {
            return response()->json(['message' => 'Missing OrderTrackingId'], 422);
        }

        $donation = Donation::where('transaction_ref', $orderTrackingId)->first();

        if (! $donation) {
            Log::warning('Pesapal webhook: no matching donation', ['order_tracking_id' => $orderTrackingId]);
        } elseif ($donation->status !== 'completed') {
            try {
                $result = $gateway->verifyTransaction($orderTrackingId);

                if ($result['status'] === 'successful') {
                    $donation->update(['status' => 'completed']);
                    $donation->applyToTotals();
                } elseif ($result['status'] === 'failed') {
                    $donation->update(['status' => 'failed']);
                }
                // 'pending' — leave as-is, Pesapal will likely call again
            } catch (\Throwable $e) {
                Log::error('Pesapal webhook: verification failed', ['error' => $e->getMessage()]);
            }
        }

        // Pesapal expects exactly this acknowledgement shape back.
        return response()->json([
            'orderNotificationType' => $notificationType,
            'orderTrackingId' => $orderTrackingId,
            'orderMerchantReference' => $merchantReference,
            'status' => 200,
        ]);
    }
}