<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectApiController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with('manager:id,name')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->paginate($request->integer('per_page', 20));

        return response()->json($projects);
    }

    public function show(Project $project)
    {
        return response()->json($project->load('manager', 'campaigns:id,project_id,title,raised_amount,goal_amount'));
    }
}