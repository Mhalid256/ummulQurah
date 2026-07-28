@extends('layouts.admin')

@section('title', 'Ummul Qurah Executive Dashboard')

@section('content')
<style>
    /* Base Stat Card Layout */
    .stat-card {
        border-radius: 14px;
        padding: 1.25rem;
        position: relative;
        overflow: hidden;
        height: 100%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -10px rgba(0, 0, 0, 0.12);
    }

    /* Light Mode Tinted Color Variants */
    .card-variant-blue {
        background-color: #eff6ff !important;
        border-color: #bfdbfe !important;
    }
    .card-variant-green {
        background-color: #f0fdf4 !important;
        border-color: #bbf7d0 !important;
    }
    .card-variant-pink {
        background-color: #fdf2f8 !important;
        border-color: #fbcfe8 !important;
    }
    .card-variant-purple {
        background-color: #f5f3ff !important;
        border-color: #ddd6fe !important;
    }
    .card-variant-amber {
        background-color: #fffbeb !important;
        border-color: #fde68a !important;
    }
    .card-variant-cyan {
        background-color: #ecfeff !important;
        border-color: #a5f3fc !important;
    }

    /* Dark Mode Support (Automatically adapts to your layout theme attribute) */
    html[data-bs-theme="dark"] .card-variant-blue,
    [data-theme="dark"] .card-variant-blue,
    body.dark-mode .card-variant-blue {
        background-color: rgba(30, 58, 138, 0.25) !important;
        border-color: rgba(59, 130, 246, 0.3) !important;
    }

    html[data-bs-theme="dark"] .card-variant-green,
    [data-theme="dark"] .card-variant-green,
    body.dark-mode .card-variant-green {
        background-color: rgba(20, 83, 45, 0.25) !important;
        border-color: rgba(34, 197, 94, 0.3) !important;
    }

    html[data-bs-theme="dark"] .card-variant-pink,
    [data-theme="dark"] .card-variant-pink,
    body.dark-mode .card-variant-pink {
        background-color: rgba(131, 24, 67, 0.25) !important;
        border-color: rgba(236, 72, 153, 0.3) !important;
    }

    html[data-bs-theme="dark"] .card-variant-purple,
    [data-theme="dark"] .card-variant-purple,
    body.dark-mode .card-variant-purple {
        background-color: rgba(88, 28, 135, 0.25) !important;
        border-color: rgba(168, 85, 247, 0.3) !important;
    }

    html[data-bs-theme="dark"] .card-variant-amber,
    [data-theme="dark"] .card-variant-amber,
    body.dark-mode .card-variant-amber {
        background-color: rgba(120, 53, 15, 0.25) !important;
        border-color: rgba(245, 158, 11, 0.3) !important;
    }

    html[data-bs-theme="dark"] .card-variant-cyan,
    [data-theme="dark"] .card-variant-cyan,
    body.dark-mode .card-variant-cyan {
        background-color: rgba(22, 78, 99, 0.25) !important;
        border-color: rgba(6, 182, 212, 0.3) !important;
    }

    /* Quick Action Cards */
    .quick-action-card {
        border-radius: 12px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        text-decoration: none !important;
        color: inherit;
        transition: all 0.25s ease;
    }

    .quick-action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .quick-action-icon {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        flex-shrink: 0;
        background: #ffffff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }

    /* Helper for crisp text headings across themes */
    .text-body-heading {
        color: var(--bs-heading-color, #1e293b);
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: rgba(0, 0, 0, 0.15); border-radius: 3px; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Executive Hero Banner with Live Clock -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg text-white" 
                 style="background: linear-gradient(135deg, #051650 0%, #3357b8 100%); border-radius: 1rem; border: 1px solid rgba(255, 255, 255, 0.08);">
                <div class="card-body p-4">
                    <div class="row align-items-center gy-3">
                        <!-- Left Info Block -->
                        <div class="col-lg-7">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <h2 class="text-white fw-bold mb-0">Executive Overview</h2>
                                <span class="badge bg-white bg-opacity-20 text-white border border-white border-opacity-25 rounded-pill px-3 py-1 fs-tiny text-uppercase fw-semibold">
                                    Analytics
                                </span>
                            </div>
                            <p class="text-white-50 mb-4 fs-6">
                                Comprehensive management system for campaigns, donor allocations, beneficiaries, and active grants.
                            </p>
                            
                            <!-- Date, Clock & Action Controls -->
                            <div class="d-flex flex-wrap align-items-center gap-3">
                                <div class="px-3 py-2 rounded-3 bg-dark bg-opacity-50 border border-secondary border-opacity-25 d-flex align-items-center gap-2">
                                    <i class="bx bx-calendar text-info fs-5"></i>
                                    <span class="fw-medium text-white-50 fs-7" id="dashboard-date">{{ now()->format('l, F j, Y') }}</span>
                                </div>
                                <div class="px-3 py-2 rounded-3 bg-dark bg-opacity-50 border border-secondary border-opacity-25 d-flex align-items-center gap-2">
                                    <i class="bx bx-time-five text-warning fs-5"></i>
                                    <span class="fw-bold text-white fs-7 font-monospace" id="dashboard-clock">00:00:00 AM</span>
                                </div>
                                <button type="button" onclick="window.location.reload();" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm rounded-3">
                                    <i class="bx bx-refresh fs-5"></i>
                                    <span>Refresh</span>
                                </button>
                            </div>
                        </div>

                        <!-- Right Summary Badges -->
                        <div class="col-lg-5">
                            <div class="row g-3 text-center justify-content-lg-end">
                                <div class="col-6 col-sm-5">
                                    <div class="p-3 rounded-3 bg-dark bg-opacity-25 border border-secondary border-opacity-10">
                                        <h2 class="text-white fw-bold mb-1">{{ number_format($stats['total_donors'] ?? 1) }}</h2>
                                        <span class="text-white-50 fs-7 fw-medium text-uppercase tracking-wider">Total Donors</span>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-5">
                                    <div class="p-3 rounded-3 bg-dark bg-opacity-25 border border-secondary border-opacity-10">
                                        <h2 class="text-white fw-bold mb-1">{{ number_format($stats['active_campaigns'] ?? 1) }}</h2>
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

    <!-- Colorful Light/Dark Adaptive Metric KPI Cards -->
    <div class="row g-4 mb-4">
        @php
            $tiles = [
                ['label' => 'Total Donors', 'value' => number_format($stats['total_donors'] ?? 1), 'icon' => 'bx-user-pin', 'color' => 'primary', 'sub' => 'Last 30 days', 'variant' => 'card-variant-blue'],
                ['label' => 'Total Raised', 'value' => '$' . number_format($stats['total_raised'] ?? 1000000, 0), 'icon' => 'bx-donate-heart', 'color' => 'success', 'sub' => 'All time total', 'variant' => 'card-variant-green'],
                ['label' => 'Active Campaigns', 'value' => number_format($stats['active_campaigns'] ?? 1), 'icon' => 'bx-megaphone', 'color' => 'info', 'sub' => 'Currently live', 'variant' => 'card-variant-cyan'],
                ['label' => 'Approved Beneficiaries', 'value' => number_format($stats['beneficiaries'] ?? 1), 'icon' => 'bx-group', 'color' => 'primary', 'sub' => 'Verified records', 'variant' => 'card-variant-purple'],
                ['label' => 'Pending Approval', 'value' => number_format($stats['pending_beneficiaries'] ?? 0), 'icon' => 'bx-time-five', 'color' => 'warning', 'sub' => 'Requires review', 'variant' => 'card-variant-amber'],
                ['label' => 'Active Grants', 'value' => number_format($stats['active_grants'] ?? 0), 'icon' => 'bx-award', 'color' => 'danger', 'sub' => 'Allocated funds', 'variant' => 'card-variant-pink'],
            ];
        @endphp

        @foreach ($tiles as $tile)
            <div class="col-sm-6 col-md-4 col-xl-2">
                <div class="stat-card {{ $tile['variant'] }}">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar-initial rounded-3 bg-white shadow-sm p-2 d-flex align-items-center justify-content-center">
                            <i class="bx {{ $tile['icon'] }} fs-4 text-{{ $tile['color'] }}"></i>
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
                        <span class="text-secondary fw-semibold d-block fs-7 text-truncate mb-1">{{ $tile['label'] }}</span>
                        <h3 class="mb-1 fw-bold text-body-heading">{{ $tile['value'] }}</h3>
                        <small class="text-muted fs-tiny d-block">{{ $tile['sub'] }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Quick Actions Section -->
    <div class="mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="fw-bold mb-0 text-body-heading">Quick Actions</h5>
            <small class="text-secondary">Frequently used management tools</small>
        </div>
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <a href="#" class="quick-action-card card-variant-blue">
                    <div class="quick-action-icon text-primary">
                        <i class="bx bx-plus-circle"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold fs-7 text-body-heading">New Campaign</h6>
                        <small class="text-secondary fs-tiny">Create & launch</small>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="#" class="quick-action-card card-variant-green">
                    <div class="quick-action-icon text-success">
                        <i class="bx bx-user-plus"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold fs-7 text-body-heading">Add Donor</h6>
                        <small class="text-secondary fs-tiny">Register new profile</small>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="#" class="quick-action-card card-variant-amber">
                    <div class="quick-action-icon text-warning">
                        <i class="bx bx-check-shield"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold fs-7 text-body-heading">Review Applications</h6>
                        <small class="text-secondary fs-tiny">Pending beneficiaries</small>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="#" class="quick-action-card card-variant-pink">
                    <div class="quick-action-icon text-danger">
                        <i class="bx bx-file"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold fs-7 text-body-heading">Generate Report</h6>
                        <small class="text-secondary fs-tiny">Financial export</small>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Analytics Charts Section -->
    <div class="row g-4 mb-4">
        <!-- Area Chart: Donations Trend -->
        <div class="col-lg-8">
            <div class="card h-100 shadow-sm border rounded-3">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom border-opacity-10 pb-3">
                    <div>
                        <h5 class="card-title mb-1 fw-bold text-body-heading">Donations Trend</h5>
                        <small class="text-secondary">Overview of contributions over time</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                            Filter
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
                    <h5 class="card-title mb-1 fw-bold text-body-heading">Beneficiaries Status</h5>
                    <small class="text-secondary">Approval distribution breakdown</small>
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

    <!-- Top Campaigns & Recent Transactions -->
    <div class="row g-4">
        <!-- Top Performing Campaigns -->
        <div class="col-lg-4">
            <div class="card h-100 shadow-sm border rounded-3">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom border-opacity-10 pb-3">
                    <h5 class="card-title mb-0 fw-bold text-body-heading">Top Campaigns</h5>
                    <a href="#" class="fs-7 fw-semibold text-primary">View All</a>
                </div>
                <div class="card-body pt-3">
                    @forelse ($topCampaigns ?? [] as $campaign)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-semibold text-truncate text-body-heading" style="max-width: 180px;">{{ $campaign->title }}</span>
                                <span class="badge bg-primary fs-tiny">{{ number_format($campaign->progress_percent) }}%</span>
                            </div>
                            <div class="d-flex justify-content-between fs-tiny text-secondary mb-2">
                                <span>Raised: ${{ number_format($campaign->raised_amount, 0) }}</span>
                                <span>Goal: ${{ number_format($campaign->goal_amount, 0) }}</span>
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
                        <div class="text-center py-4 text-secondary">
                            <i class="bx bx-folder-open fs-1 mb-2 d-block"></i>
                            <p class="mb-0 fs-7">No active campaigns recorded.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Transactions Table -->
        <div class="col-lg-8">
            <div class="card h-100 shadow-sm border rounded-3">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom border-opacity-10 pb-3">
                    <div>
                        <h5 class="card-title mb-0 fw-bold text-body-heading">Recent Transactions</h5>
                        <small class="text-secondary">Latest contribution records</small>
                    </div>
                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                        <i class="bx bx-export me-1"></i> Export
                    </button>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
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
                        @forelse ($recentDonations ?? [] as $donation)
                            <tr>
                                <td><span class="fw-semibold text-primary">#{{ $donation->receipt_no }}</span></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xs me-2">
                                            <span class="avatar-initial rounded-circle bg-label-secondary fs-tiny fw-bold">
                                                {{ strtoupper(substr($donation->donor->display_name ?? 'A', 0, 2)) }}
                                            </span>
                                        </div>
                                        <span class="fw-medium text-body-heading">{{ $donation->donor->display_name ?? 'Anonymous' }}</span>
                                    </div>
                                </td>
                                <td><span class="text-truncate d-inline-block" style="max-width: 150px;">{{ $donation->campaign->title ?? 'General Fund' }}</span></td>
                                <td><span class="fw-bold text-body-heading">{{ number_format($donation->amount, 2) }}</span> <small class="text-secondary">{{ $donation->currency }}</small></td>
                                <td><small class="text-secondary">{{ $donation->donation_date->format('d M Y') }}</small></td>
                                <td>
                                    @php
                                        $statusClass = match($donation->status) {
                                            'completed' => 'success',
                                            'pending'   => 'warning',
                                            default     => 'danger'
                                        };
                                    @endphp
                                    <span class="badge rounded-pill bg-{{ $statusClass }} px-3">
                                        {{ ucfirst($donation->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-secondary py-4">
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
<!-- ApexCharts & Dashboard Clock Scripts -->
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Live Clock ---
    function updateLiveClock() {
        const clockElement = document.getElementById('dashboard-clock');
        if (!clockElement) return;

        const now = new Date();
        let hours = now.getHours();
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';

        hours = hours % 12 || 12;
        clockElement.textContent = `${String(hours).padStart(2, '0')}:${minutes}:${seconds} ${ampm}`;
    }
    updateLiveClock();
    setInterval(updateLiveClock, 1000);

    // --- Safely Parsed Area Chart Data ---
    const labels = {!! json_encode(isset($monthlyDonations) ? $monthlyDonations->pluck('ym') : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']) !!};
    const values = {!! json_encode(isset($monthlyDonations) ? $monthlyDonations->pluck('total') : [1200, 1900, 3000, 5000, 4200, 6800]) !!};

    const trendChartOptions = {
        chart: { type: 'area', height: 315, toolbar: { show: false }, background: 'transparent' },
        series: [{ name: 'Donations', data: values }],
        xaxis: { categories: labels },
        yaxis: { labels: { formatter: (v) => '$' + (v >= 1000 ? (v/1000).toFixed(1) + 'k' : v) } },
        colors: ['#3357b8'],
        stroke: { curve: 'smooth', width: 3 },
        fill: { type: 'gradient', gradient: { opacityFrom: 0.4, opacityTo: 0.05 } },
        grid: { strokeDashArray: 4 }
    };
    new ApexCharts(document.querySelector('#donationsTrendChart'), trendChartOptions).render();

    // --- Radial Bar Chart: Beneficiaries Status ---
    const approved = {{ (int) ($stats['beneficiaries'] ?? 75) }};
    const pending = {{ (int) ($stats['pending_beneficiaries'] ?? 25) }};
    const total = approved + pending;
    const approvedPct = total > 0 ? Math.round((approved / total) * 100) : 0;
    const pendingPct = total > 0 ? Math.round((pending / total) * 100) : 0;

    const radialChartOptions = {
        chart: { type: 'radialBar', height: 290, background: 'transparent' },
        series: [approvedPct, pendingPct],
        labels: ['Approved', 'Pending'],
        colors: ['#10b981', '#f59e0b'],
        plotOptions: {
            radialBar: {
                hollow: { size: '52%' },
                track: { opacity: 0.2 },
                dataLabels: {
                    value: { formatter: (v) => v + '%' },
                    total: { show: true, label: 'Approved', formatter: () => approvedPct + '%' }
                }
            }
        }
    };
    new ApexCharts(document.querySelector('#beneficiariesRadialChart'), radialChartOptions).render();
});
</script>
@endpush