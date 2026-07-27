<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;
use Illuminate\Http\Request;

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

    public function donateSubmit(Request $request, Campaign $campaign)
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

        // NOTE: Payment gateway integration intentionally not wired up yet (Phase 2).
        // This creates the donation record as "pending" until a real gateway confirms it.
        Donation::create([
            'organization_id' => $campaign->organization_id,
            'donor_id' => $donor->id,
            'campaign_id' => $campaign->id,
            'amount' => $data['amount'],
            'currency' => $campaign->currency,
            'payment_method' => $data['payment_method'],
            'status' => 'pending',
            'donation_date' => now(),
        ]);

        return redirect()
            ->route('public.campaign.show', $campaign)
            ->with('success', 'Thank you! Your pledge has been recorded and is awaiting payment confirmation.');
    }
}
