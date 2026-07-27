@extends('layouts.admin')

@section('title', 'Executive Dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Top Executive Hero Banner with Live Clock -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg text-white style-hero-banner" 
                 style="background: linear-gradient(135deg, #12192c 0%, #1a233a 100%); border-radius: 1rem; border: 1px solid rgba(255, 255, 255, 0.08);">
                <div class="card-body p-4">
                    <div class="row align-items-center gy-3">
                        <!-- Left Info Block -->
                        <div class="col-lg-7">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <h2 class="text-white fw-bold mb-0">Executive Dashboard</h2>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 fs-tiny text-uppercase fw-semibold">
                                    Overview
                                </span>
                            </div>
                            <p class="text-white-50 mb-4 fs-6">
                                Comprehensive management and analytics system for campaigns, donors, and programs.
                            </p>
                            
                            <!-- Date, Clock & Action Controls -->
                            <div class="d-flex flex-wrap align-items-center gap-3">
                                <div class="px-3 py-2 rounded-3 bg-dark bg-opacity-50 border border-secondary border-opacity-25 d-flex align-items-center gap-2">
                                    <i class="bx bx-calendar text-primary fs-5"></i>
                                    <span class="fw-medium text-white-50 fs-7" id="dashboard-date">{{ now()->format('l, F j, Y') }}</span>
                                </div>
                                <div class="px-3 py-2 rounded-3 bg-dark bg-opacity-50 border border-secondary border-opacity-25 d-flex align-items-center gap-2">
                                    <i class="bx bx-time-five text-info fs-5"></i>
                                    <span class="fw-bold text-white fs-7 font-monospace" id="dashboard-clock">00:00:00 AM</span>
                                </div>
                                <button type="button" onclick="window.location.reload();" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm rounded-3">
                                    <i class="bx bx-refresh fs-5"></i>
                                    <span>Refresh</span>
                                </button>
                            </div>
                        </div>

                        <!-- Right Quick Stats Summary -->
                        <div class="col-lg-5">
                            <div class="row g-3 text-center justify-content-lg-end">
                                <div class="col-6 col-sm-5">
                                    <div class="p-3 rounded-3 bg-dark bg-opacity-25 border border-secondary border-opacity-10">
                                        <h2 class="text-white fw-bold mb-1">{{ number_format($stats['total_donors']) }}</h2>
                                        <span class="text-white-50 fs-7 fw-medium text-uppercase tracking-wider">Total Donors</span>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-5">
                                    <div class="p-3 rounded-3 bg-dark bg-opacity-25 border border-secondary border-opacity-10">
                                        <h2 class="text-white fw-bold mb-1">{{ number_format($stats['active_campaigns']) }}</h2>
                                        <span class="text-white-50 fs-7 fw-medium text-uppercase tracking-wider">Active Campaigns</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Metric KPI Cards -->
    <div class="row g-4 mb-4">
        @php
            $tiles = [
                ['label' => 'Total Donors', 'value' => number_format($stats['total_donors']), 'icon' => 'bx-user-pin', 'color' => 'primary', 'sub' => 'Last 30 days'],
                ['label' => 'Total Raised', 'value' => number_format($stats['total_raised'], 2), 'icon' => 'bx-donate-heart', 'color' => 'success', 'sub' => 'All time total'],
                ['label' => 'Active Campaigns', 'value' => number_format($stats['active_campaigns']), 'icon' => 'bx-megaphone', 'color' => 'info', 'sub' => 'Currently live'],
                ['label' => 'Approved Beneficiaries', 'value' => number_format($stats['beneficiaries']), 'icon' => 'bx-group', 'color' => 'primary', 'sub' => 'Verified records'],
                ['label' => 'Pending Approval', 'value' => number_format($stats['pending_beneficiaries']), 'icon' => 'bx-time-five', 'color' => 'warning', 'sub' => 'Requires review'],
                ['label' => 'Active Grants', 'value' => number_format($stats['active_grants']), 'icon' => 'bx-award', 'color' => 'secondary', 'sub' => 'Allocated funds'],
            ];
        @endphp

        @foreach ($tiles as $tile)
            <div class="col-sm-6 col-md-4 col-xl-2">
                <div class="card h-100 shadow-sm border rounded-3">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="avatar-initial rounded-3 bg-label-{{ $tile['color'] }} p-2 d-flex align-items-center justify-content-center">
                                <i class="bx {{ $tile['icon'] }} fs-4"></i>
                            </span>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-icon text-muted" type="button" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded fs-5"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item fs-7" href="#">View Details</a></li>
                                </ul>
                            </div>
                        </div>
                        <div>
                            <span class="text-muted fw-medium d-block fs-7 text-truncate mb-1">{{ $tile['label'] }}</span>
                            <h3 class="mb-1 fw-bold text-heading">{{ $tile['value'] }}</h3>
                            <small class="text-muted fs-tiny d-block">{{ $tile['sub'] }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Main Analytics Charts Section -->
    <div class="row g-4 mb-4">
        <!-- Area Chart: Revenue / Donations Trend -->
        <div class="col-lg-8">
            <div class="card h-100 shadow-sm border rounded-3">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom border-opacity-10 pb-3">
                    <div>
                        <h5 class="card-title mb-1 fw-bold">Donations Trend</h5>
                        <small class="text-muted">Overview of contributions over the last 6 months</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                            Last 6 Months
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                            <li><a class="dropdown-item" href="#">Last 6 Months</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div id="donationsTrendChart" style="min-height: 315px;"></div>
                </div>
            </div>
        </div>

        <!-- Radial Bar Chart: Beneficiary Distribution -->
        <div class="col-lg-4">
            <div class="card h-100 shadow-sm border rounded-3">
                <div class="card-header bg-transparent border-bottom border-opacity-10 pb-3">
                    <h5 class="card-title mb-1 fw-bold">Beneficiaries Status</h5>
                    <small class="text-muted">Approval distribution breakdown</small>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div id="beneficiariesRadialChart" class="w-100"></div>
                    <div class="d-flex justify-content-center gap-4 mt-2 w-100 pt-3 border-top border-opacity-10">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge rounded-circle bg-success p-1"></span>
                            <span class="fw-semibold fs-7">Approved</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge rounded-circle bg-warning p-1"></span>
                            <span class="fw-semibold fs-7">Pending</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Campaigns & Recent Activity -->
    <div class="row g-4">
        <!-- Top Performing Campaigns -->
        <div class="col-lg-4">
            <div class="card h-100 shadow-sm border rounded-3">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom border-opacity-10 pb-3">
                    <h5 class="card-title mb-0 fw-bold">Top Campaigns</h5>
                    <a href="javascript:void(0);" class="fs-7 fw-semibold text-primary">View All</a>
                </div>
                <div class="card-body pt-3">
                    @forelse ($topCampaigns as $campaign)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-semibold text-heading text-truncate" style="max-width: 180px;">{{ $campaign->title }}</span>
                                <span class="badge bg-label-primary fs-tiny">{{ number_format($campaign->progress_percent) }}%</span>
                            </div>
                            <div class="d-flex justify-content-between fs-tiny text-muted mb-2">
                                <span>Raised: {{ number_format($campaign->raised_amount, 0) }}</span>
                                <span>Goal: {{ number_format($campaign->goal_amount, 0) }}</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 8px;">
                                <div class="progress-bar bg-primary rounded-pill" 
                                     role="progressbar" 
                                     style="width: {{ $campaign->progress_percent }}%" 
                                     aria-valuenow="{{ $campaign->progress_percent }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="bx bx-folder-open fs-1 mb-2 d-block"></i>
                            <p class="mb-0 fs-7">No active campaigns recorded.</p>
                        </div>
                    @forelse
                </div>
            </div>
        </div>

        <!-- Recent Transactions Table -->
        <div class="col-lg-8">
            <div class="card h-100 shadow-sm border rounded-3">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom border-opacity-10 pb-3">
                    <div>
                        <h5 class="card-title mb-0 fw-bold">Recent Transactions</h5>
                        <small class="text-muted">Latest contribution records</small>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                        <i class="bx bx-export me-1"></i> Export
                    </button>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Receipt</th>
                                <th>Donor</th>
                                <th>Campaign</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($recentDonations as $donation)
                            <tr>
                                <td><span class="fw-semibold text-primary">#{{ $donation->receipt_no }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xs me-2">
                                            <span class="avatar-initial rounded-circle bg-label-secondary fs-tiny fw-bold">
                                                {{ strtoupper(substr($donation->donor->display_name ?? 'A', 0, 2)) }}
                                            </span>
                                        </div>
                                        <span class="fw-medium">{{ $donation->donor->display_name ?? 'Anonymous' }}</span>
                                    </div>
                                </td>
                                <td><span class="text-truncate d-inline-block" style="max-width: 150px;">{{ $donation->campaign->title ?? 'General Fund' }}</span></td>
                                <td><span class="fw-bold">{{ number_format($donation->amount, 2) }}</span> <small class="text-muted">{{ $donation->currency }}</small></td>
                                <td><small class="text-muted">{{ $donation->donation_date->format('d M Y') }}</small></td>
                                <td>
                                    @php
                                        $statusClass = match($donation->status) {
                                            'completed' => 'success',
                                            'pending'   => 'warning',
                                            default     => 'danger'
                                        };
                                    @endphp
                                    <span class="badge rounded-pill bg-label-{{ $statusClass }} px-3">
                                        {{ ucfirst($donation->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bx bx-receipt fs-2 mb-1 d-block"></i>
                                    No donation transactions found.
                                </td>
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
    // --- Live Digital Clock Script ---
    function updateLiveClock() {
        const clockElement = document.getElementById('dashboard-clock');
        if (!clockElement) return;

        const now = new Date();
        let hours = now.getHours();
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';

        hours = hours % 12;
        hours = hours ? hours : 12; // 0 becomes 12
        const formattedHours = String(hours).padStart(2, '0');

        clockElement.textContent = `${formattedHours}:${minutes}:${seconds} ${ampm}`;
    }

    updateLiveClock();
    setInterval(updateLiveClock, 1000);

    // --- Dynamic Theme Colors for ApexCharts ---
    const getThemeColor = (cssVar, fallback) => {
        return getComputedStyle(document.documentElement).getPropertyValue(cssVar).trim() || fallback;
    };

    const primaryColor = getThemeColor('--bs-primary', '#5A8DEE');
    const successColor = getThemeColor('--bs-success', '#39DA8A');
    const warningColor = getThemeColor('--bs-warning', '#FDAC41');
    const textColor = getThemeColor('--bs-body-color', '#a1acb8');
    const borderColor = getThemeColor('--bs-border-color', 'rgba(255, 255, 255, 0.1)');

    // --- Area Chart: Donations Trend ---
    const labels = @json($monthlyDonations->pluck('ym'));
    const values = @json($monthlyDonations->pluck('total'));

    const trendChartOptions = {
        chart: {
            type: 'area',
            height: 315,
            toolbar: { show: false },
            background: 'transparent'
        },
        series: [{ name: 'Donations', data: values }],
        xaxis: {
            categories: labels,
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: { style: { colors: textColor, fontSize: '12px' } }
        },
        yaxis: {
            labels: {
                style: { colors: textColor, fontSize: '12px' },
                formatter: (val) => val >= 1000 ? (val / 1000).toFixed(1) + 'k' : val
            }
        },
        colors: [primaryColor],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.05,
                stops: [0, 95, 100]
            }
        },
        grid: {
            borderColor: borderColor,
            strokeDashArray: 4,
            padding: { top: 0, right: 10, bottom: 0, left: 10 }
        },
        tooltip: {
            theme: 'dark',
            y: { formatter: (val) => '$' + Number(val).toLocaleString() }
        }
    };

    new ApexCharts(document.querySelector('#donationsTrendChart'), trendChartOptions).render();

    // --- Radial Bar Chart: Beneficiaries Status ---
    const approved = {{ (int) $stats['beneficiaries'] }};
    const pending = {{ (int) $stats['pending_beneficiaries'] }};
    const total = approved + pending;
    const approvedPct = total > 0 ? Math.round((approved / total) * 100) : 0;
    const pendingPct = total > 0 ? Math.round((pending / total) * 100) : 0;

    const radialChartOptions = {
        chart: {
            type: 'radialBar',
            height: 290,
            background: 'transparent'
        },
        series: [approvedPct, pendingPct],
        labels: ['Approved', 'Pending'],
        colors: [successColor, warningColor],
        plotOptions: {
            radialBar: {
                offsetY: 0,
                startAngle: 0,
                endAngle: 360,
                hollow: { size: '52%' },
                track: {
                    background: borderColor,
                    opacity: 0.2
                },
                dataLabels: {
                    name: {
                        fontSize: '13px',
                        color: textColor,
                        offsetY: -5
                    },
                    value: {
                        fontSize: '22px',
                        fontWeight: 'bold',
                        color: textColor,
                        offsetY: 5,
                        formatter: (val) => val + '%'
                    },
                    total: {
                        show: true,
                        label: 'Approved',
                        color: textColor,
                        formatter: () => approvedPct + '%'
                    }
                }
            }
        },
        legend: { show: false }
    };

    new ApexCharts(document.querySelector('#beneficiariesRadialChart'), radialChartOptions).render();
});
</script>
@endpush