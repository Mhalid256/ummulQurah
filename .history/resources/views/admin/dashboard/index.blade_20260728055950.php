@extends('layouts.admin')

@section('title', 'Ummul Qurah Executive Dashboard')

@section('content')
<style>
    :root {
        --primary-blue: #051650;
        --secondary-blue: #3357b8;
        --accent-blue: #4895ef;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #06b6d4;
    }

    /* Light Theme Variables */
    [data-theme="light"] {
        --card-bg: #ffffff;
        --text-primary: #1f2937;
        --text-secondary: #6b7280;
        --border-color: #e5e7eb;
        --background: #f8fafc;
        --hover-bg: #f3f4f6;
    }

    /* Dark Theme Variables */
    [data-theme="dark"] {
        --card-bg: #1e293b;
        --text-primary: #f9fafb;
        --text-secondary: #94a3b8;
        --border-color: #334155;
        --background: #0f172a;
        --hover-bg: rgba(255, 255, 255, 0.05);
    }

    body {
        background: var(--background);
        color: var(--text-primary);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* Stat Cards */
    .stat-card {
        background: var(--card-bg);
        border-radius: 12px;
        padding: 1.25rem;
        position: relative;
        overflow: hidden;
        border: 1px solid var(--border-color);
        height: 100%;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        border-color: var(--accent-blue);
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary-blue), var(--accent-blue));
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: var(--card-bg); }
    ::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 3px; }
    ::-webkit-scrollbar-thumb:hover { background: var(--accent-blue); }

    /* Theme Toggle Button */
    .theme-toggle-btn {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 0.5rem 1rem;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .theme-toggle-btn:hover { border-color: var(--accent-blue); }
    .search-bar {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 0.5rem 1rem;
        color: var(--text-primary);
        width: 250px;
    }
</style>

<script>
    document.documentElement.setAttribute('data-theme', localStorage.getItem('theme') || 'dark');
</script>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Top Navigation Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <h4 class="fw-bold mb-0 text-uppercase tracking-wider">UMMUL QURAH FOUNDATION</h4>
            <span class="badge bg-primary rounded-pill px-3 py-1">Executive Dashboard</span>
        </div>
        <div class="d-flex align-items-center gap-3">
            <input type="text" class="search-bar" placeholder="Search (Ctrl+/)">
            <button class="theme-toggle-btn" id="themeToggle">
                <i class="bx" id="themeIcon"></i>
                <span id="themeText"></span>
            </button>
        </div>
    </div>

    <!-- Executive Hero Banner with Live Clock -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg text-white style-hero-banner" 
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

                        <!-- Right Quick Stats Summary -->
                        <div class="col-lg-5">
                            <div class="row g-3 text-center justify-content-lg-end">
                                <div class="col-6 col-sm-5">
                                    <div class="p-3 rounded-3 bg-dark bg-opacity-25 border border-secondary border-opacity-10">
                                        <h2 class="text-white fw-bold mb-1">{{ number_format($stats['total_donors'] ?? 0) }}</h2>
                                        <span class="text-white-50 fs-7 fw-medium text-uppercase tracking-wider">Total Donors</span>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-5">
                                    <div class="p-3 rounded-3 bg-dark bg-opacity-25 border border-secondary border-opacity-10">
                                        <h2 class="text-white fw-bold mb-1">{{ number_format($stats['active_campaigns'] ?? 0) }}</h2>
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
                ['label' => 'Total Donors', 'value' => number_format($stats['total_donors'] ?? 0), 'icon' => 'bx-user-pin', 'color' => 'primary', 'sub' => 'Last 30 days'],
                ['label' => 'Total Raised', 'value' => '$' . number_format($stats['total_raised'] ?? 0, 2), 'icon' => 'bx-donate-heart', 'color' => 'success', 'sub' => 'All time total'],
                ['label' => 'Active Campaigns', 'value' => number_format($stats['active_campaigns'] ?? 0), 'icon' => 'bx-megaphone', 'color' => 'info', 'sub' => 'Currently live'],
                ['label' => 'Approved Beneficiaries', 'value' => number_format($stats['beneficiaries'] ?? 0), 'icon' => 'bx-group', 'color' => 'primary', 'sub' => 'Verified records'],
                ['label' => 'Pending Approval', 'value' => number_format($stats['pending_beneficiaries'] ?? 0), 'icon' => 'bx-time-five', 'color' => 'warning', 'sub' => 'Requires review'],
                ['label' => 'Active Grants', 'value' => number_format($stats['active_grants'] ?? 0), 'icon' => 'bx-award', 'color' => 'secondary', 'sub' => 'Allocated funds'],
            ];
        @endphp

        @foreach ($tiles as $tile)
            <div class="col-sm-6 col-md-4 col-xl-2">
                <div class="stat-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar-initial rounded-3 bg-label-{{ $tile['color'] }} p-2 d-flex align-items-center justify-content-center">
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
                        <span class="text-secondary fw-medium d-block fs-7 text-truncate mb-1">{{ $tile['label'] }}</span>
                        <h3 class="mb-1 fw-bold text-primary">{{ $tile['value'] }}</h3>
                        <small class="text-secondary fs-tiny d-block">{{ $tile['sub'] }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Main Analytics Charts Section -->
    <div class="row g-4 mb-4">
        <!-- Area Chart: Donations Trend -->
        <div class="col-lg-8">
            <div class="card h-100 shadow-sm border rounded-3 style-card">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom border-opacity-10 pb-3">
                    <div>
                        <h5 class="card-title mb-1 fw-bold">Donations Trend</h5>
                        <small class="text-secondary">Overview of contributions over the last 6 months</small>
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
            <div class="card h-100 shadow-sm border rounded-3 style-card">
                <div class="card-header bg-transparent border-bottom border-opacity-10 pb-3">
                    <h5 class="card-title mb-1 fw-bold">Beneficiaries Status</h5>
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

    <!-- Top Campaigns & Transactions -->
    <div class="row g-4">
        <!-- Top Performing Campaigns -->
        <div class="col-lg-4">
            <div class="card h-100 shadow-sm border rounded-3 style-card">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom border-opacity-10 pb-3">
                    <h5 class="card-title mb-0 fw-bold">Top Campaigns</h5>
                    <a href="javascript:void(0);" class="fs-7 fw-semibold text-primary">View All</a>
                </div>
                <div class="card-body pt-3">
                    @forelse ($topCampaigns ?? [] as $campaign)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-semibold text-truncate" style="max-width: 180px;">{{ $campaign->title }}</span>
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
            <div class="card h-100 shadow-sm border rounded-3 style-card">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom border-opacity-10 pb-3">
                    <div>
                        <h5 class="card-title mb-0 fw-bold">Recent Transactions</h5>
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
                                        <span class="fw-medium">{{ $donation->donor->display_name ?? 'Anonymous' }}</span>
                                    </div>
                                </td>
                                <td><span class="text-truncate d-inline-block" style="max-width: 150px;">{{ $donation->campaign->title ?? 'General Fund' }}</span></td>
                                <td><span class="fw-bold">{{ number_format($donation->amount, 2) }}</span> <small class="text-secondary">{{ $donation->currency }}</small></td>
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
<!-- ApexCharts & Theme Scripts -->
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Theme Switcher ---
    const themeToggleBtn = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const themeText = document.getElementById('themeText');

    function updateThemeUI() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        if (currentTheme === 'light') {
            themeIcon.className = 'bx bx-sun text-warning';
            themeText.textContent = 'Light';
        } else {
            themeIcon.className = 'bx bx-moon text-info';
            themeText.textContent = 'Dark';
        }
    }

    updateThemeUI();

    themeToggleBtn.addEventListener('click', function () {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const nextTheme = currentTheme === 'light' ? 'dark' : 'light';
        document.documentElement.setAttribute('data-theme', nextTheme);
        localStorage.setItem('theme', nextTheme);
        updateThemeUI();
        location.reload(); // Reload charts with new colors
    });

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

    // --- Dynamic ApexCharts Theme Setup ---
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const textColor = isDark ? '#94a3b8' : '#6b7280';
    const borderColor = isDark ? '#334155' : '#e5e7eb';

    // --- Area Chart: Donations Trend ---
    const labels = @json($monthlyDonations->pluck('ym') ?? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun']);
    const values = @json($monthlyDonations->pluck('total') ?? [1200, 1900, 3000, 5000, 4200, 6800]);

    const trendChartOptions = {
        chart: { type: 'area', height: 315, toolbar: { show: false }, background: 'transparent' },
        series: [{ name: 'Donations', data: values }],
        xaxis: { categories: labels, labels: { style: { colors: textColor } } },
        yaxis: { labels: { style: { colors: textColor }, formatter: (v) => '$' + (v >= 1000 ? (v/1000).toFixed(1) + 'k' : v) } },
        colors: ['#3357b8'],
        stroke: { curve: 'smooth', width: 3 },
        fill: { type: 'gradient', gradient: { opacityFrom: 0.4, opacityTo: 0.05 } },
        grid: { borderColor: borderColor, strokeDashArray: 4 },
        tooltip: { theme: isDark ? 'dark' : 'light' }
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
                track: { background: borderColor, opacity: 0.2 },
                dataLabels: {
                    name: { color: textColor },
                    value: { color: textColor, formatter: (v) => v + '%' },
                    total: { show: true, label: 'Approved', color: textColor, formatter: () => approvedPct + '%' }
                }
            }
        }
    };
    new ApexCharts(document.querySelector('#beneficiariesRadialChart'), radialChartOptions).render();
});
</script>
@endpush