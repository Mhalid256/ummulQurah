<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\Donor;
use App\Models\Sponsorship;
use Illuminate\Http\Request;

class SponsorshipController extends Controller
{
    public function index(Request $request)
    {
        $sponsorships = Sponsorship::with(['sponsor', 'beneficiary'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.sponsorships.index', compact('sponsorships'));
    }

    public function create()
    {
        return view('admin.sponsorships.form', [
            'sponsorship' => new Sponsorship(),
            'donors' => Donor::orderBy('first_name')->get(),
            'beneficiaries' => Beneficiary::where('status', 'approved')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Sponsorship::create($this->validated($request));
        return redirect()->route('admin.sponsorships.index')->with('success', 'Sponsorship created successfully.');
    }

    public function edit(Sponsorship $sponsorship)
    {
        return view('admin.sponsorships.form', [
            'sponsorship' => $sponsorship,
            'donors' => Donor::orderBy('first_name')->get(),
            'beneficiaries' => Beneficiary::where('status', 'approved')->get(),
        ]);
    }

    public function update(Request $request, Sponsorship $sponsorship)
    {
        $sponsorship->update($this->validated($request));
        return redirect()->route('admin.sponsorships.index')->with('success', 'Sponsorship updated successfully.');
    }

    public function destroy(Sponsorship $sponsorship)
    {
        $sponsorship->delete();
        return back()->with('success', 'Sponsorship removed.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'sponsor_id' => 'required|exists:donors,id',
            'beneficiary_id' => 'required|exists:beneficiaries,id',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|string|max:8',
            'frequency' => 'required|in:one_off,monthly,quarterly,annual',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:active,paused,ended',
            'notes' => 'nullable|string',
        ]);
    }
}
