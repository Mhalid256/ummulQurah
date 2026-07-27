<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use Illuminate\Http\Request;

class BeneficiaryApiController extends Controller
{
    public function index(Request $request)
    {
        $beneficiaries = Beneficiary::with('family:id,head_name,family_code')
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->category, fn ($q) => $q->where('category', $request->category))
            ->select('id', 'beneficiary_no', 'first_name', 'last_name', 'category', 'status', 'location', 'family_id')
            ->paginate($request->integer('per_page', 20));

        return response()->json($beneficiaries);
    }

    public function show(Beneficiary $beneficiary)
    {
        return response()->json($beneficiary->load('family', 'project', 'sponsorships'));
    }
}