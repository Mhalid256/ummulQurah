<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;
use App\Services\Payments\PaymentGatewayManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PublicSiteController extends Controller
{
    public function home()
    {
        $featuredCampaigns = Campaign::where('status', 'active')->latest()->take(3)->get();
        $stats = [
            'total_raised' => Donation::where('status', 'completed')->sum('amount'),
            'total_donors' => Donor::count(),
            'active_campaigns' => Campaign::where('status', 'active')->count(),
        ];

        return view('public.home', compact('featuredCampaigns', 'stats'));
    }

    public function about()
    {
        return view('public.about');
    }

    public function campaigns()
    {
        $campaigns = Campaign::where('status', 'active')->paginate(9);
        return view('public.campaigns', compact('campaigns'));
    }

    public function campaignShow(Campaign $campaign)
    {
        return view('public.campaign-show', compact('campaign'));
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function donateForm(Campaign $campaign)
    {
        return view('public.donate', compact('campaign'));
    }

    public function donateSubmit(Request $request, Campaign $campaign, PaymentGatewayManager $gateways)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:50',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:mobile_money,card,bank_transfer',
        ]);

        $donor = Donor::firstOrCreate(
            ['email' => $data['email'], 'organization_id' => $campaign->organization_id],
            [
                'donor_no' => 'DNR-' . strtoupper(uniqid()),
                'type' => 'individual',
                'first_name' => $data['name'],
                'phone' => $data['phone'] ?? null,
                'status' => 'active',
            ]
        );

        $donation = Donation::create([
            'organization_id' => $campaign->organization_id,
            'donor_id' => $donor->id,
            'campaign_id' => $campaign->id,
            'amount' => $data['amount'],
            'currency' => $campaign->currency,
            'payment_method' => $data['payment_method'],
            'status' => 'pending',
            'donation_date' => now(),
        ]);

        try {
            $gateway = $gateways->resolve($data['payment_method']);
            $result = $gateway->initiate($donation, [
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'name' => $data['name'],
            ]);

            if ($result['type'] === 'redirect') {
                return redirect()->away($result['redirect_url']);
            }

            // 'push' type (e.g. M-Pesa STK) — donor confirms on their phone, no redirect
            return redirect()
                ->route('public.campaign.show', $campaign)
                ->with('success', $result['message']);
        } catch (\Throwable $e) {
            Log::error('Donation payment initiation failed', [
                'donation_id' => $donation->id,
                'error' => $e->getMessage(),
            ]);

            // Payment gateway not configured yet, or the provider rejected the request —
            // don't lose the pledge, just let them know it needs manual follow-up.
            return redirect()
                ->route('public.campaign.show', $campaign)
                ->with('success', 'Thank you! Your pledge has been recorded. If payment does not go through automatically, our team will follow up with you shortly.');
        }
    }

    /**
     * Where Flutterwave redirects the donor back to after checkout.
     * The actual "mark as completed" happens via the webhook (source of
     * truth), but we also verify here so the donor gets instant feedback
     * even if the webhook is delayed by a few seconds.
     */
    public function donateCallback(Request $request, Campaign $campaign)
    {
        $txRef = $request->query('tx_ref');
        $status = $request->query('status'); // 'successful', 'cancelled', 'failed'

        if ($txRef) {
            $donation = Donation::where('transaction_ref', $txRef)->first();

            if ($donation && $donation->status !== 'completed' && $status === 'successful') {
                $donation->update(['status' => 'completed']);
                $donation->applyToTotals();
            } elseif ($donation && in_array($status, ['cancelled', 'failed'])) {
                $donation->update(['status' => 'failed']);
            }
        }

        $message = match ($status) {
            'successful' => 'Thank you! Your donation was received successfully.',
            'cancelled' => 'Your donation was cancelled — no payment was taken.',
            default => 'We could not confirm your payment. If you were charged, please contact us.',
        };

        return redirect()->route('public.campaign.show', $campaign)->with('success', $message);
    }
}