<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $donations = Donation::with(['donor', 'campaign'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->campaign_id, fn ($q) => $q->where('campaign_id', $request->campaign_id))
            ->latest('donation_date')
            ->paginate(15)
            ->withQueryString();

        $campaigns = Campaign::orderBy('title')->get();

        return view('admin.donations.index', compact('donations', 'campaigns'));
    }

    public function create()
    {
        return view('admin.donations.form', [
            'donation' => new Donation(),
            'donors' => Donor::orderBy('first_name')->get(),
            'campaigns' => Campaign::orderBy('title')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['received_by'] = auth()->id();

        Donation::create($data);

        return redirect()->route('admin.donations.index')->with('success', 'Donation recorded successfully.');
    }

    public function show(Donation $donation)
    {
        $donation->load(['donor', 'campaign', 'receiver']);
        return view('admin.donations.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        return view('admin.donations.form', [
            'donation' => $donation,
            'donors' => Donor::orderBy('first_name')->get(),
            'campaigns' => Campaign::orderBy('title')->get(),
        ]);
    }

    public function update(Request $request, Donation $donation)
    {
        $donation->update($this->validated($request));
        return redirect()->route('admin.donations.index')->with('success', 'Donation updated successfully.');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return back()->with('success', 'Donation deleted.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'donor_id' => 'required|exists:donors,id',
            'campaign_id' => 'nullable|exists:campaigns,id',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|string|max:8',
            'payment_method' => 'required|in:cash,bank_transfer,mobile_money,card,cheque,other',
            'transaction_ref' => 'nullable|string|max:255',
            'status' => 'required|in:pending,completed,failed,refunded',
            'donation_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);
    }
}
