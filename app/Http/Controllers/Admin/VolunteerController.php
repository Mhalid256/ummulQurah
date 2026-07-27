<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    public function index(Request $request)
    {
        $volunteers = Volunteer::with('project')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.volunteers.index', compact('volunteers'));
    }

    public function create()
    {
        return view('admin.volunteers.form', [
            'volunteer' => new Volunteer(),
            'projects' => Project::orderBy('name')->get(),
            'coordinators' => User::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['volunteer_no'] = 'VOL-' . strtoupper(uniqid());

        Volunteer::create($data);

        return redirect()->route('admin.volunteers.index')->with('success', 'Volunteer registered successfully.');
    }

    public function edit(Volunteer $volunteer)
    {
        return view('admin.volunteers.form', [
            'volunteer' => $volunteer,
            'projects' => Project::orderBy('name')->get(),
            'coordinators' => User::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Volunteer $volunteer)
    {
        $volunteer->update($this->validated($request));
        return redirect()->route('admin.volunteers.index')->with('success', 'Volunteer updated successfully.');
    }

    public function approve(Volunteer $volunteer)
    {
        $volunteer->update(['status' => 'active']);
        return back()->with('success', "{$volunteer->full_name} is now an active volunteer.");
    }

    public function destroy(Volunteer $volunteer)
    {
        $volunteer->delete();
        return back()->with('success', 'Volunteer removed.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'skills' => 'nullable|string|max:255',
            'availability' => 'required|in:weekdays,weekends,evenings,flexible',
            'status' => 'required|in:active,inactive,pending',
            'coordinator_id' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);
    }
}
