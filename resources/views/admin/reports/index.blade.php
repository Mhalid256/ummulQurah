@extends('layouts.admin')
@section('title', 'Reports')
@section('content')
<div class="row g-4">
    <div class="col-md-4"><div class="card"><div class="card-body">
        <h5><i class="bx bx-wallet text-primary me-2"></i>Financial Report</h5>
        <p class="text-muted">Donations vs. expenses over a date range, by payment method.</p>
        <a href="{{ route('admin.reports.financial') }}" class="btn btn-outline-primary btn-sm">View Report</a>
    </div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body">
        <h5><i class="bx bx-user-pin text-primary me-2"></i>Donor Report</h5>
        <p class="text-muted">Top donors ranked by lifetime giving.</p>
        <a href="{{ route('admin.reports.donors') }}" class="btn btn-outline-primary btn-sm">View Report</a>
    </div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body">
        <h5><i class="bx bx-group text-primary me-2"></i>Beneficiary Report</h5>
        <p class="text-muted">Beneficiary counts by category and approval status.</p>
        <a href="{{ route('admin.reports.beneficiaries') }}" class="btn btn-outline-primary btn-sm">View Report</a>
    </div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body">
        <h5><i class="bx bx-megaphone text-primary me-2"></i>Campaign / Impact Report</h5>
        <p class="text-muted">All campaigns ranked by funds raised.</p>
        <a href="{{ route('admin.reports.campaigns') }}" class="btn btn-outline-primary btn-sm">View Report</a>
    </div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body">
        <h5><i class="bx bx-run text-primary me-2"></i>Volunteer Report</h5>
        <p class="text-muted">Volunteer counts by status.</p>
        <a href="{{ route('admin.reports.volunteers') }}" class="btn btn-outline-primary btn-sm">View Report</a>
    </div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body">
        <h5><i class="bx bx-export text-primary me-2"></i>Export Donations</h5>
        <p class="text-muted">Download the full donations ledger as CSV.</p>
        <a href="{{ route('admin.reports.donations.export') }}" class="btn btn-outline-primary btn-sm">Download CSV</a>
    </div></div></div>
</div>
@endsection
