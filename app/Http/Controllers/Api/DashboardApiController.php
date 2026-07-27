<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;

class DashboardApiController extends Controller
{
    public function stats()
    {
        return response()->json([
            'total_donors' => Donor::count(),
            'total_raised' => Donation::where('status', 'completed')->sum('amount'),
            'active_campaigns' => Campaign::where('status', 'active')->count(),
            'approved_beneficiaries' => Beneficiary::where('status', 'approved')->count(),
        ]);
    }
}
