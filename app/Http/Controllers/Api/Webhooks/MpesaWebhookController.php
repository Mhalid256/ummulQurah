<?php

namespace App\Http\Controllers\Api\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MpesaWebhookController extends Controller
{
    /**
     * NOTE: Unlike Flutterwave, Safaricom's Daraja API does not sign its
     * callbacks. Safaricom recommends relying on the secrecy of your
     * callback URL and, ideally, restricting it to Safaricom's published
     * IP ranges at your firewall/load balancer — that check belongs at
     * the infrastructure level, not in this controller.
     */
    public function handle(Request $request)
    {
        $callback = $request->input('Body.stkCallback', []);
        $checkoutRequestId = $callback['CheckoutRequestID'] ?? null;
        $resultCode = $callback['ResultCode'] ?? null;

        if (! $checkoutRequestId) {
            return response()->json(['message' => 'Missing CheckoutRequestID'], 422);
        }

        $donation = Donation::where('transaction_ref', $checkoutRequestId)->first();

        if (! $donation) {
            Log::warning('M-Pesa webhook: no matching donation', ['checkout_request_id' => $checkoutRequestId]);
            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted (no matching donation)']);
        }

        if ($donation->status === 'completed') {
            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Already processed']); // idempotent
        }

        if ((int) $resultCode === 0) {
            $items = collect($callback['CallbackMetadata']['Item'] ?? [])->pluck('Value', 'Name');

            $donation->update([
                'status' => 'completed',
                'transaction_ref' => $items['MpesaReceiptNumber'] ?? $checkoutRequestId,
            ]);
            $donation->applyToTotals();
        } else {
            $donation->update(['status' => 'failed']);
        }

        // Safaricom expects this exact acknowledgement shape.
        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
    }
}