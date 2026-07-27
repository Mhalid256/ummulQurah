<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\Grant;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_donors' => Donor::count(),
            'total_raised' => Donation::where('status', 'completed')->sum('amount'),
            'active_campaigns' => Campaign::where('status', 'active')->count(),
            'beneficiaries' => Beneficiary::where('status', 'approved')->count(),
            'pending_beneficiaries' => Beneficiary::where('status', 'pending')->count(),
            'active_grants' => Grant::whereIn('status', ['awarded', 'active'])->count(),
        ];

        // Group donations by month — the date-formatting function differs per database driver.
        $driver = DB::connection()->getDriverName();
        $monthExpr = match ($driver) {
            'sqlite' => "strftime('%Y-%m', donation_date)",
            'pgsql' => "to_char(donation_date, 'YYYY-MM')",
            default => "DATE_FORMAT(donation_date, '%Y-%m')", // mysql / mariadb
        };

        $monthlyDonations = Donation::select(
                DB::raw("{$monthExpr} as ym"),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'completed')
            ->where('donation_date', '>=', now()->subMonths(6)->startOfMonth())
            ->groupBy('ym')
            ->orderBy('ym')
            ->get();

        $recentDonations = Donation::with(['donor', 'campaign'])
            ->latest('donation_date')
            ->take(8)
            ->get();

        $topCampaigns = Campaign::orderByDesc('raised_amount')->take(5)->get();

        return view('admin.dashboard.index', compact(
            'stats', 'monthlyDonations', 'recentDonations', 'topCampaigns'
        ));
    }
}