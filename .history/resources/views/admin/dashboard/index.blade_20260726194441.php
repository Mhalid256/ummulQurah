@extends('layouts.admin')

@section('title', 'Executive Dashboard')

@section('content')
<div class="row g-4">
    @php
        $tiles = [
            ['label' => 'Total Donors', 'value' => number_format($stats['total_donors']), 'icon' => 'bx-user-pin', 'color' => 'primary'],
            ['label' => 'Total Raised', 'value' => number_format($stats['total_raised'], 2), 'icon' => 'bx-donate-heart', 'color' => 'success'],
            ['label' => 'Active Campaigns', 'value' => number_format($stats['active_campaigns']), 'icon' => 'bx-megaphone', 'color' => 'info'],
            ['label' => 'Approved Beneficiaries', 'value' => number_format($stats['beneficiaries']), 'icon' => 'bx-group', 'color' => 'primary'],
            ['label' => 'Pending Approval', 'value' => number_format($stats['pending_beneficiaries']), 'icon' => 'bx-time-five', 'color' => 'warning'],
            ['label' => 'Active Grants', 'value' => number_format($stats['active_grants']), 'icon' => 'bx-award', 'color' => 'secondary'],
        ];
    @endphp

    @foreach ($tiles as $tile)
        <div class="col-md-4 col-xl-2">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="avatar-initial rounded bg-label-{{ $tile['color'] }} p-2">
                            <i class="bx {{ $tile['icon'] }} fs-4"></i>
                        </span>
                    </div>
                    <span class="text-muted d-block">{{ $tile['label'] }}</span>
                    <h3 class="mt-1 mb-0">{{ $tile['value'] }}</h3>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-4 mt-1">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Donations Trend (last 6 months)</h5>
            </div>
            <div class="card-body">
                <div id="donationsTrendChart"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Beneficiaries Status</h5>
            </div>
            <div class="card-body d-flex flex-column align-items-center">
                <div id="beneficiariesRadialChart"></div>
                <div class="d-flex justify-content-center gap-4 mt-2">
                    <div class="d-flex align-items-center">
                        <span class="badge rounded-pill bg-success p-1 me-2"></span>
                        <small>Approved</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="badge rounded-pill bg-warning p-1 me-2"></span>
                        <small>Pending</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
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
    <div class="col-lg-8">
        <div class="card h-100">
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
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Area chart: Donations Trend ---
    const labels = @json($monthlyDonations->pluck('ym'));
    const values = @json($monthlyDonations->pluck('total'));
    new ApexCharts(document.querySelector('#donationsTrendChart'), {
        chart: { type: 'area', height: 300, toolbar: { show: false } },
        series: [{ name: 'Donations', data: values }],
        xaxis: { categories: labels },
        colors: ['#5A8DEE'],
        dataLabels: { enabled: false },
        fill: {
            type: 'gradient',
            gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] }
        },
        stroke: { curve: 'smooth', width: 2 },
    }).render();

    // --- Radial chart: Beneficiaries approved vs pending ---
    const approved = {{ (int) $stats['beneficiaries'] }};
    const pending = {{ (int) $stats['pending_beneficiaries'] }};
    const total = approved + pending;
    const approvedPct = total > 0 ? Math.round((approved / total) * 100) : 0;
    const pendingPct = total > 0 ? Math.round((pending / total) * 100) : 0;

    new ApexCharts(document.querySelector('#beneficiariesRadialChart'), {
        chart: { type: 'radialBar', height: 280 },
        series: [approvedPct, pendingPct],
        labels: ['Approved', 'Pending'],
        colors: ['#39da8a', '#fdac41'],
        plotOptions: {
            radialBar: {
                hollow: { size: '40%' },
                dataLabels: {
                    name: { fontSize: '14px' },
                    value: { fontSize: '20px', formatter: (val) => val + '%' },
                    total: {
                        show: true,
                        label: 'Approved',
                        formatter: () => approvedPct + '%'
                    }
                }
            }
        }
    }).render();
});
</script>
@endpush