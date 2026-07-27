<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Family;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function index()
    {
        $families = Family::withCount('beneficiaries')->latest()->paginate(15);
        return view('admin.families.index', compact('families'));
    }

    public function create()
    {
        return view('admin.families.form', ['family' => new Family()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['family_code'] = 'FAM-' . strtoupper(uniqid());

        Family::create($data);

        return redirect()->route('admin.families.index')->with('success', 'Family registered successfully.');
    }

    public function edit(Family $family)
    {
        return view('admin.families.form', compact('family'));
    }

    public function update(Request $request, Family $family)
    {
        $family->update($this->validated($request));
        return redirect()->route('admin.families.index')->with('success', 'Family updated successfully.');
    }

    public function destroy(Family $family)
    {
        $family->delete();
        return back()->with('success', 'Family removed.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'head_name' => 'required|string|max:255',
            'members_count' => 'required|integer|min:1',
            'address' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'income_level' => 'required|in:very_low,low,moderate',
            'status' => 'required|in:active,inactive',
        ]);
    }
}
