<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Project;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $campaigns = Campaign::query()
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        $projects = Project::orderBy('name')->get();
        return view('admin.campaigns.form', ['campaign' => new Campaign(), 'projects' => $projects]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['created_by'] = auth()->id();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('campaigns', 'public');
        }

        Campaign::create($data);

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign created successfully.');
    }

    public function edit(Campaign $campaign)
    {
        $projects = Project::orderBy('name')->get();
        return view('admin.campaigns.form', compact('campaign', 'projects'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $data = $this->validated($request);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('campaigns', 'public');
        }

        $campaign->update($data);

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign updated successfully.');
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return back()->with('success', 'Campaign deleted.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'summary' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:4096',
            'goal_amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:8',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:draft,active,completed,cancelled',
        ]);
    }
}
