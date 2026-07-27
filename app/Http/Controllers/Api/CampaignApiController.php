<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;

class CampaignApiController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::where('status', 'active')
            ->select('id', 'title', 'slug', 'goal_amount', 'raised_amount', 'currency', 'end_date')
            ->paginate(20);

        return response()->json($campaigns);
    }

    public function show(Campaign $campaign)
    {
        return response()->json($campaign);
    }
}
