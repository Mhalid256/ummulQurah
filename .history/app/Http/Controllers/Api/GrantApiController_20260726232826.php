<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grant;
use Illuminate\Http\Request;

class GrantApiController extends Controller
{
    public function index(Request $request)
    {
        $grants = Grant::with('project:id,name')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->paginate($request->integer('per_page', 20));

        return response()->json($grants);
    }

    public function show(Grant $grant)
    {
        return response()->json($grant->load('project'));
    }
}