<?php

namespace App\Http\Controllers\Api\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Services\Payments\FlutterwaveGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FlutterwaveWebhookController extends Controller
{
    public function handle(Request $request)
    {
        if (! FlutterwaveGateway::verifyWebhookSignature($request->header('verif-hash'))) {
            Log::warning('Rejected Flutterwave webhook: bad signature');
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        $payload = $request->input('data', []);
        $txRef = $payload['tx_ref'] ?? null;
        $status = $payload['status'] ?? null;

        if (! $txRef) {
            return response()->json(['message' => 'Missing tx_ref'], 422);
        }

        $donation = Donation::where('transaction_ref', $txRef)->first();

        if (! $donation) {
            Log::warning('Flutterwave webhook: no matching donation', ['tx_ref' => $txRef]);
            return response()->json(['message' => 'Donation not found'], 404);
        }

        if ($donation->status === 'completed') {
            return response()->json(['message' => 'Already processed']); // idempotent
        }

        if ($status === 'successful') {
            $donation->update(['status' => 'completed']);
            $donation->applyToTotals();
        } elseif (in_array($status, ['failed', 'cancelled'])) {
            $donation->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'OK']);
    }
}