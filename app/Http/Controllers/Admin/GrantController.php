<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grant;
use App\Models\Project;
use Illuminate\Http\Request;

class GrantController extends Controller
{
    public function index(Request $request)
    {
        $grants = Grant::with('project')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.grants.index', compact('grants'));
    }

    public function create()
    {
        return view('admin.grants.form', ['grant' => new Grant(), 'projects' => Project::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        Grant::create($this->validated($request));
        return redirect()->route('admin.grants.index')->with('success', 'Grant record created.');
    }

    public function edit(Grant $grant)
    {
        return view('admin.grants.form', ['grant' => $grant, 'projects' => Project::orderBy('name')->get()]);
    }

    public function update(Request $request, Grant $grant)
    {
        $grant->update($this->validated($request));
        return redirect()->route('admin.grants.index')->with('success', 'Grant updated.');
    }

    public function destroy(Grant $grant)
    {
        $grant->delete();
        return back()->with('success', 'Grant removed.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'funder_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:8',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:applied,awarded,active,closed,declined',
            'reporting_due_date' => 'nullable|date',
            'contact_person' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);
    }
}
