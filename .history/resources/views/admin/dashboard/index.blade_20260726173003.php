@extends('layouts.admin')

@section('title', 'Executive Dashboard')

@section('content')
<div class="row g-4">
    <div class="col-md-4 col-xl-2">
        <div class="card"><div class="card-body">
            <span class="text-muted">Total Donors</span>
            <h3 class="mt-1 mb-0">{{ number_format($stats['total_donors']) }}</h3>
        </div></div>
    </div>
    <div class="col-md-4 col-xl-2">
        <div class="card"><div class="card-body">
            <span class="text-muted">Total Raised</span>
            <h3 class="mt-1 mb-0">{{ number_format($stats['total_raised'], 2) }}</h3>
        </div></div>
    </div>
    <div class="col-md-4 col-xl-2">
        <div class="card"><div class="card-body">
            <span class="text-muted">Active Campaigns</span>
            <h3 class="mt-1 mb-0">{{ number_format($stats['active_campaigns']) }}</h3>
        </div></div>
    </div>
    <div class="col-md-4 col-xl-2">
        <div class="card"><div class="card-body">
            <span class="text-muted">Approved Beneficiaries</span>
            <h3 class="mt-1 mb-0">{{ number_format($stats['beneficiaries']) }}</h3>
        </div></div>
    </div>
    <div class="col-md-4 col-xl-2">
        <div class="card"><div class="card-body">
            <span class="text-muted">Pending Approval</span>
            <h3 class="mt-1 mb-0 text-warning">{{ number_format($stats['pending_beneficiaries']) }}</h3>
        </div></div>
    </div>
    <div class="col-md-4 col-xl-2">
        <div class="card"><div class="card-body">
            <span class="text-muted">Active Grants</span>
            <h3 class="mt-1 mb-0">{{ number_format($stats['active_grants']) }}</h3>
        </div></div>
    </div>
</div>

<div class="row g-4 mt-1">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header"><h5 class="mb-0">Donations Trend (last 6 months)</h5></div>
            <div class="card-body">
                <div id="donationsTrendChart"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header"><h5 class="mb-0">Top Campaigns</h5></div>
            <div class="card-body">
                @forelse ($topCampaigns as $campaign)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>{{ $campaign->title }}</span>
                            <span class="fw-semibold">{{ number_format($campaign->raised_amount, 0) }} / {{ number_format($campaign->goal_amount, 0) }}</span>
                        </div>
                        <div class="progress" style="height:6px;">
                            <div class="progress-bar" style="width: {{ $campaign->progress_percent }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">No campaigns yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header"><h5 class="mb-0">Recent Donations</h5></div>
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Receipt</th><th>Donor</th><th>Campaign</th><th>Amount</th><th>Date</th><th>Status</th></tr></thead>
            <tbody>
            @forelse ($recentDonations as $donation)
                <tr>
                    <td>{{ $donation->receipt_no }}</td>
                    <td>{{ $donation->donor->display_name ?? '-' }}</td>
                    <td>{{ $donation->campaign->title ?? '—' }}</td>
                    <td>{{ number_format($donation->amount, 2) }} {{ $donation->currency }}</td>
                    <td>{{ $donation->donation_date->format('d M Y') }}</td>
                    <td><span class="badge bg-label-{{ $donation->status === 'completed' ? 'success' : ($donation->status === 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($donation->status) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">No donations recorded yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels = @json($monthlyDonations->pluck('ym'));
    const values = @json($monthlyDonations->pluck('total'));
    new ApexCharts(document.querySelector('#donationsTrendChart'), {
        chart: { type: 'area', height: 300, toolbar: { show: false } },
        series: [{ name: 'Donations', data: values }],
        xaxis: { categories: labels },
        colors: ['#5A8DEE'],
        dataLabels: { enabled: false },
    }).render();
});
</script>
@endpush
