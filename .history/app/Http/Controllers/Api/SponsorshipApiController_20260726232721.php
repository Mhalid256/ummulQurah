<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sponsorship;
use Illuminate\Http\Request;

class SponsorshipApiController extends Controller
{
    public function index(Request $request)
    {
        $sponsorships = Sponsorship::with(['sponsor:id,first_name,last_name,organization_name', 'beneficiary:id,first_name,last_name'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->paginate($request->integer('per_page', 20));

        return response()->json($sponsorships);
    }

    public function show(Sponsorship $sponsorship)
    {
        return response()->json($sponsorship->load('sponsor', 'beneficiary'));
    }
}