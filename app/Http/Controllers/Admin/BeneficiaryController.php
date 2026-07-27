<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\Family;
use App\Models\Project;
use Illuminate\Http\Request;

class BeneficiaryController extends Controller
{
    public function index(Request $request)
    {
        $beneficiaries = Beneficiary::with('family')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->category, fn ($q) => $q->where('category', $request->category))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.beneficiaries.index', compact('beneficiaries'));
    }

    public function create()
    {
        return view('admin.beneficiaries.form', [
            'beneficiary' => new Beneficiary(),
            'families' => Family::orderBy('head_name')->get(),
            'projects' => Project::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['beneficiary_no'] = 'BEN-' . strtoupper(uniqid());
        $data['registered_by'] = auth()->id();
        $data['status'] = 'pending';

        Beneficiary::create($data);

        return redirect()->route('admin.beneficiaries.index')->with('success', 'Beneficiary registered and pending approval.');
    }

    public function edit(Beneficiary $beneficiary)
    {
        return view('admin.beneficiaries.form', [
            'beneficiary' => $beneficiary,
            'families' => Family::orderBy('head_name')->get(),
            'projects' => Project::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Beneficiary $beneficiary)
    {
        $beneficiary->update($this->validated($request));
        return redirect()->route('admin.beneficiaries.index')->with('success', 'Beneficiary record updated.');
    }

    public function approve(Beneficiary $beneficiary)
    {
        $beneficiary->approve(auth()->user());
        return back()->with('success', "{$beneficiary->full_name} has been approved.");
    }

    public function reject(Beneficiary $beneficiary)
    {
        $beneficiary->update(['status' => 'rejected']);
        return back()->with('success', "{$beneficiary->full_name} has been rejected.");
    }

    public function destroy(Beneficiary $beneficiary)
    {
        $beneficiary->delete();
        return back()->with('success', 'Beneficiary removed.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'family_id' => 'nullable|exists:families,id',
            'project_id' => 'nullable|exists:projects,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'category' => 'required|in:child,elderly,disabled,family,other',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);
    }
}
