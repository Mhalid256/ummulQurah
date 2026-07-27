<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationApiController extends Controller
{
    public function index(Request $request)
    {
        $donations = Donation::with(['donor:id,first_name,last_name,organization_name,type', 'campaign:id,title'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest('donation_date')
            ->paginate($request->integer('per_page', 20));

        return response()->json($donations);
    }

    public function show(Donation $donation)
    {
        return response()->json($donation->load(['donor', 'campaign']));
    }
}
