<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DonorController extends Controller
{
    public function index(Request $request)
    {
        $donors = Donor::query()
            ->when($request->search, fn ($q) => $q->where(function ($qq) use ($request) {
                $qq->where('first_name', 'like', "%{$request->search}%")
                   ->orWhere('last_name', 'like', "%{$request->search}%")
                   ->orWhere('organization_name', 'like', "%{$request->search}%")
                   ->orWhere('email', 'like', "%{$request->search}%");
            }))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.donors.index', compact('donors'));
    }

    public function create()
    {
        return view('admin.donors.form', ['donor' => new Donor()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['donor_no'] = 'DNR-' . strtoupper(Str::random(6));

        Donor::create($data);

        return redirect()->route('admin.donors.index')->with('success', 'Donor registered successfully.');
    }

    public function edit(Donor $donor)
    {
        return view('admin.donors.form', compact('donor'));
    }

    public function update(Request $request, Donor $donor)
    {
        $donor->update($this->validated($request));

        return redirect()->route('admin.donors.index')->with('success', 'Donor updated successfully.');
    }

    public function destroy(Donor $donor)
    {
        $donor->delete();

        return back()->with('success', 'Donor removed.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'type' => 'required|in:individual,organization',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'organization_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'is_recurring' => 'nullable|boolean',
            'status' => 'required|in:active,inactive',
            'notes' => 'nullable|string',
        ]);
    }
}
