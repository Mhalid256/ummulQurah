<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\Expense;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function financial(Request $request)
    {
        $from = $request->date('from') ?? now()->subMonths(6);
        $to = $request->date('to') ?? now();

        $donations = Donation::where('status', 'completed')
            ->whereBetween('donation_date', [$from, $to])->sum('amount');
        $expenses = Expense::where('status', 'approved')
            ->whereBetween('expense_date', [$from, $to])->sum('amount');

        $byMethod = Donation::where('status', 'completed')
            ->whereBetween('donation_date', [$from, $to])
            ->selectRaw('payment_method, SUM(amount) as total')
            ->groupBy('payment_method')->get();

        return view('admin.reports.financial', compact('donations', 'expenses', 'byMethod', 'from', 'to'));
    }

    public function donors()
    {
        $donors = Donor::orderByDesc('total_donated')->take(50)->get();
        return view('admin.reports.donors', compact('donors'));
    }

    public function beneficiaries()
    {
        $summary = Beneficiary::selectRaw('category, status, COUNT(*) as total')
            ->groupBy('category', 'status')->get();
        return view('admin.reports.beneficiaries', compact('summary'));
    }

    public function campaigns()
    {
        $campaigns = Campaign::orderByDesc('raised_amount')->get();
        return view('admin.reports.campaigns', compact('campaigns'));
    }

    public function volunteers()
    {
        $summary = Volunteer::selectRaw('status, COUNT(*) as total')->groupBy('status')->get();
        return view('admin.reports.volunteers', compact('summary'));
    }

    public function exportDonationsCsv()
    {
        $donations = Donation::with('donor', 'campaign')->get();

        return Response::streamDownload(function () use ($donations) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Receipt No', 'Donor', 'Campaign', 'Amount', 'Currency', 'Method', 'Status', 'Date']);
            foreach ($donations as $d) {
                fputcsv($out, [
                    $d->receipt_no, $d->donor->display_name ?? '', $d->campaign->title ?? '',
                    $d->amount, $d->currency, $d->payment_method, $d->status, $d->donation_date->format('Y-m-d'),
                ]);
            }
            fclose($out);
        }, 'donations-export.csv');
    }
}
