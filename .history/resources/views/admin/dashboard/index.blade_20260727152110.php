@extends('layouts.admin')

@section('title', 'Executive Dashboard')

@push('styles')
<style>
    /* Claymorphism & Pastel Theme Overrides */
    :root {
        --clay-bg: #f3f0f8;
        --clay-card-bg: #ffffff;
        --clay-shadow-light: #ffffff;
        --clay-shadow-dark: rgba(166, 175, 195, 0.25);
        --clay-radius: 24px;
        --clay-radius-sm: 16px;
        --pastel-purple: #e2d9f3;
        --pastel-purple-dark: #7c5dfa;
        --pastel-peach: #ffe5d9;
        --pastel-yellow: #fff3c4;
        --pastel-blue: #d0f4de;
        --pastel-pink: #fde2e4;
    }

    body {
        background-color: var(--clay-bg) !important;
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
    }

    /* Soft Clay Card Shadow */
    .clay-card {
        background: var(--clay-card-bg);
        border-radius: var(--clay-radius);
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 12px 12px 24px var(--clay-shadow-dark), 
                    -12px -12px 24px var(--clay-shadow-light);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .clay-card:hover {
        transform: translateY(-3px);
        box-shadow: 16px 16px 32px var(--clay-shadow-dark), 
                    -16px -16px 32px var(--clay-shadow-light);
    }

    /* Hero Banner */
    .hero-banner {
        background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
        border-radius: 30px;
        padding: 2.5rem;
        color: #2b2d42;
        box-shadow: 0 20px 40px rgba(142, 197, 252, 0.35);
        position: relative;
        overflow: hidden;
    }

    /* Soft Pastel Icon Wrappers */
    .clay-icon {
        width: 52px;
        height: 52px;
        border-radius: var(--clay-radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: inset 2px 2px 4px rgba(255, 255, 255, 0.6), 
                    inset -2px -2px 4px rgba(0, 0, 0, 0.05);
    }

    .bg-pastel-primary { background-color: #e2d9f3; color: #6c5ce7; }
    .bg-pastel-success { background-color: #d4edda; color: #27ae60; }
    .bg-pastel-info { background-color: #cce5ff; color: #2980b9; }
    .bg-pastel-warning { background-color: #fff3cd; color: #e67e22; }
    .bg-pastel-secondary { background-color: #e2e3e5; color: #6c757d; }

    /* Custom Modern Table */
    .clay-table {
        border-collapse: separate;
        border-spacing: 0 0.75rem;
    }

    .clay-table tbody tr {
        background-color: #ffffff;
        border-radius: var(--clay-radius-sm);
        box-shadow: 4px 4px 10px rgba(0,0,0,0.03);
    }

    .clay-table tbody td {
        padding: 1rem 1.25rem;
        border: none;
    }

    .clay-table tbody td:first-child { border-top-left-radius: var(--clay-radius-sm); border-bottom-left-radius: var(--clay-radius-sm); }
    .clay-table tbody td:last-child { border-top-right-radius: var(--clay-radius-sm); border-bottom-right-radius: var(--clay-radius-sm); }

    /* Custom Soft Progress Bars */
    .clay-progress {
        height: 12px;
        border-radius: 20px;
        background-color: #f0f2f5;
        box-shadow: inset 2px 2px 4px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    .clay-progress-bar {
        border-radius: 20px;
        background: linear-gradient(90deg, #7c5dfa, #9d85fc);
    }

    /* Soft Badges */
    .badge-clay {
        padding: 0.5em 0.85em;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.75rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">

    <!-- Hero Banner -->
    <div class="hero-banner mb-5 d-flex justify-content-between align-items-center">
        <div>
            <span class="badge bg-white text-dark rounded-pill px-3 py-2 mb-2 font-weight-bold">
                ☀️ Executive Overview
            </span>
            <h1 class="fw-bold mb-1" style="color: #2b1b54;">Welcome Back, Admin!</h1>
            <p class="mb-0 text-muted" style="font-size: 1.05rem;">
                Here is what is happening with your campaigns, grants, and donors today.
            </p>
        </div>
        <div class="d-none d-md-block">
            <a href="#recent-donations" class="btn btn-light rounded-pill px-4 py-2 fw-semibold shadow-sm" style="color: #6c5ce7;">
                View Latest Activity
            </a>
        </div>
    </div>

    <!-- Stat Tiles Grid -->
    @php
        $tiles = [
            ['label' => 'Total Donors', 'value' => number_format($stats['total_donors']), 'icon' => 'bx-user-pin', 'color' => 'primary'],
            ['label' => 'Total Raised', 'value' => '$' . number_format($stats['total_raised'], 2), 'icon' => 'bx-donate-heart', 'color' => 'success'],
            ['label' => 'Active Campaigns', 'value' => number_format($stats['active_campaigns']), 'icon' => 'bx-megaphone', 'color' => 'info'],
            ['label' => 'Approved Beneficiaries', 'value' => number_format($stats['beneficiaries']), 'icon' => 'bx-group', 'color' => 'primary'],
            ['label' => 'Pending Approval', 'value' => number_format($stats['pending_beneficiaries']), 'icon' => 'bx-time-five', 'color' => 'warning'],
            ['label' => 'Active Grants', 'value' => number_format($stats['active_grants']), 'icon' => 'bx-award', 'color' => 'secondary'],
        ];
    @endphp

    <div class="row g-4 mb-4">
        @foreach ($tiles as $tile)
            <div class="col-sm-6 col-xl-2">
                <div class="card clay-card h-100 border-0 p-3">
                    <div class="card-body p-2 d-flex flex-column justify-content-between">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="clay-icon bg-pastel-{{ $tile['color'] }}">
                                <i class="bx {{ $tile['icon'] }} fs-3"></i>
                            </div>
                        </div>
                        <div>
                            <span class="text-muted fw-semibold d-block fs-7 mb-1">{{ $tile['label'] }}</span>
                            <h3 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;">{{ $tile['value'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card clay-card h-100 border-0 p-3">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center pt-2">
                    <h5 class="fw-bold text-dark mb-0">Donations Trend</h5>
                    <span class="badge bg-light text-muted rounded-pill px-3 py-2">Last 6 Months</span>
                </div>
                <div class="card-body">
                    <div id="donationsTrendChart"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card clay-card h-100 border-0 p-3">
                <div class="card-header bg-transparent border-0 pt-2">
                    <h5 class="fw-bold text-dark mb-0">Beneficiaries Status</h5>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div id="beneficiariesRadialChart"></div>
                    <div class="d-flex justify-content-center gap-4 mt-3">
                        <div class="d-flex align-items-center">
                            <span class="badge rounded-circle bg-success p-1 me-2" style="width: 10px; height: 10px;"></span>
                            <small class="fw-semibold text-muted">Approved</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge rounded-circle bg-warning p-1 me-2" style="width: 10px; height: 10px;"></span>
                            <small class="fw-semibold text-muted">Pending</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Tables & Campaigns -->
    <div class="row g-4">
        <!-- Top Campaigns -->
        <div class="col-lg-4">
            <div class="card clay-card h-100 border-0 p-3">
                <div class="card-header bg-transparent border-0 pt-2 mb-2">
                    <h5 class="fw-bold text-dark mb-0">Top Campaigns</h5>
                </div>
                <div class="card-body">
                    @forelse ($topCampaigns as $campaign)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-semibold text-dark">{{ $campaign->title }}</span>
                                <span class="small fw-bold text-primary">
                                    ${{ number_format($campaign->raised_amount, 0) }} / ${{ number_format($campaign->goal_amount, 0) }}
                                </span>
                            </div>
                            <div class="clay-progress">
                                <div class="clay-progress-bar h-100" style="width: {{ min($campaign->progress_percent, 100) }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0 text-center py-4">No active campaigns found.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Donations -->
        <div class="col-lg-8" id="recent-donations">
            <div class="card clay-card h-100 border-0 p-3">
                <div class="card-header bg-transparent border-0 pt-2 mb-2">
                    <h5 class="fw-bold text-dark mb-0">Recent Donations</h5>
                </div>
                <div class="table-responsive">
                    <table class="table clay-table align-middle">
                        <thead>
                            <tr class="text-muted small text-uppercase">
                                <th class="border-0">Receipt</th>
                                <th class="border-0">Donor</th>
                                <th class="border-0">Campaign</th>
                                <th class="border-0">Amount</th>
                                <th class="border-0">Date</th>
                                <th class="border-0">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($recentDonations as $donation)
                            <tr>
                                <td class="fw-bold text-dark">{{ $donation->receipt_no }}</td>
                                <td>{{ $donation->donor->display_name ?? 'Anonymous' }}</td>
                                <td class="text-muted">{{ $donation->campaign->title ?? '—' }}</td>
                                <td class="fw-bold text-dark">{{ number_format($donation->amount, 2) }} {{ $donation->currency }}</td>
                                <td class="text-muted small">{{ $donation->donation_date->format('d M Y') }}</td>
                                <td>
                                    @php
                                        $statusClass = match($donation->status) {
                                            'completed' => 'bg-pastel-success text-success',
                                            'pending' => 'bg-pastel-warning text-warning',
                                            default => 'bg-pastel-pink text-danger'
                                        };
                                    @endphp
                                    <span class="badge badge-clay {{ $statusClass }}">
                                        {{ ucfirst($donation->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No recent donations recorded.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- ApexCharts Pastel Theme Options ---
    const labels = @json($monthlyDonations->pluck('ym'));
    const values = @json($monthlyDonations->pluck('total'));

    // Area Chart - Soft Curved Gradient
    new ApexCharts(document.querySelector('#donationsTrendChart'), {
        chart: { 
            type: 'area', 
            height: 310, 
            toolbar: { show: false },
            fontFamily: 'Plus Jakarta Sans, sans-serif'
        },
        series: [{ name: 'Donations', data: values }],
        xaxis: { 
            categories: labels,
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        colors: ['#7c5dfa'],
        dataLabels: { enabled: false },
        fill: {
            type: 'gradient',
            gradient: { 
                shadeIntensity: 1, 
                opacityFrom: 0.45, 
                opacityTo: 0.05, 
                stops: [0, 90, 100] 
            }
        },
        stroke: { curve: 'smooth', width: 3 },
        grid: {
            borderColor: '#f1f1f1',
            strokeDashArray: 4
        }
    }).render();

    // Radial Chart - Rounded Soft Doughnut
    const approved = {{ (int) $stats['beneficiaries'] }};
    const pending = {{ (int) $stats['pending_beneficiaries'] }};
    const total = approved + pending;
    const approvedPct = total > 0 ? Math.round((approved / total) * 100) : 0;
    const pendingPct = total > 0 ? Math.round((pending / total) * 100) : 0;

    new ApexCharts(document.querySelector('#beneficiariesRadialChart'), {
        chart: { 
            type: 'radialBar', 
            height: 290,
            fontFamily: 'Plus Jakarta Sans, sans-serif'
        },
        series: [approvedPct, pendingPct],
        labels: ['Approved', 'Pending'],
        colors: ['#27ae60', '#f39c12'],
        plotOptions: {
            radialBar: {
                hollow: { size: '48%' },
                track: { background: '#f0f2f5' },
                dataLabels: {
                    name: { fontSize: '13px', color: '#888' },
                    value: { fontSize: '22px', fontWeight: '700', color: '#2b2d42' },
                    total: {
                        show: true,
                        label: 'Approved',
                        formatter: () => approvedPct + '%'
                    }
                }
            }
        },
        stroke: { lineCap: 'round' }
    }).render();
});
</script>
@endpush