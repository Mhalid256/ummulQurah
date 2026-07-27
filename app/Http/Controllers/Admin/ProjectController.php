<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('manager')->latest()->paginate(15);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.form', ['project' => new Project(), 'managers' => User::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        Project::create($this->validated($request));
        return redirect()->route('admin.projects.index')->with('success', 'Project created.');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.form', ['project' => $project, 'managers' => User::orderBy('name')->get()]);
    }

    public function update(Request $request, Project $project)
    {
        $project->update($this->validated($request));
        return redirect()->route('admin.projects.index')->with('success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return back()->with('success', 'Project removed.');
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sector' => 'nullable|string|max:100',
            'manager_id' => 'nullable|exists:users,id',
            'budget_amount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:planned,active,completed,suspended',
        ]);
    }
}
