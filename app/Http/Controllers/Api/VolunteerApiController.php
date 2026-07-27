<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use Illuminate\Http\Request;

class VolunteerApiController extends Controller
{
    public function index(Request $request)
    {
        $volunteers = Volunteer::when($request->status, fn ($q) => $q->where('status', $request->status))
            ->select('id', 'volunteer_no', 'first_name', 'last_name', 'availability', 'status', 'project_id')
            ->paginate($request->integer('per_page', 20));

        return response()->json($volunteers);
    }

    public function show(Volunteer $volunteer)
    {
        return response()->json($volunteer->load('project', 'coordinator'));
    }
}