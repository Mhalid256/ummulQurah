@extends('layouts.admin')

@section('title', 'Ummul Qurah Executive Dashboard')

@section('content')
<style>
    /* -------------------------------------------------------------
       BASE STAT CARD LAYOUT & ENHANCEMENTS
    ------------------------------------------------------------- */
    .stat-card {
        border-radius: 14px;
        padding: 1rem 1.15rem;
        position: relative;
        overflow: hidden;
        min-height: 140px;
        height: 100%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* Hover Lift & Dynamic Glow */
    .stat-card:hover {
        transform: translateY(-5px);
    }

    /* Icon Container Enhancements */
    .stat-icon-wrapper {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover .stat-icon-wrapper {
        transform: scale(1.08);
    }

    /* Metric Number Sizing & Clipping Fix */
    .stat-value {
        font-size: 1.35rem;
        font-weight: 700;
        line-height: 1.2;
        letter-spacing: -0.02em;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Label Sizing & Truncation */
    .stat-label {
        font-size: 0.8rem;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* -------------------------------------------------------------
       LIGHT MODE PASTEL VARIANTS
    ------------------------------------------------------------- */
    .card-variant-blue {
        background-color: #eff6ff !important;
        border-color: #bfdbfe !important;
        border-top: 3px solid #3b82f6 !important;
    }
    .card-variant-blue:hover { box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.25); }

    .card-variant-green {
        background-color: #f0fdf4 !important;
        border-color: #bbf7d0 !important;
        border-top: 3px solid #22c55e !important;
    }
    .card-variant-green:hover { box-shadow: 0 10px 25px -5px rgba(34, 197, 94, 0.25); }

    .card-variant-cyan {
        background-color: #ecfeff !important;
        border-color: #a5f3fc !important;
        border-top: 3px solid #06b6d4 !important;
    }
    .card-variant-cyan:hover { box-shadow: 0 10px 25px -5px rgba(6, 182, 212, 0.25); }

    .card-variant-purple {
        background-color: #f5f3ff !important;
        border-color: #ddd6fe !important;
        border-top: 3px solid #8b5cf6 !important;
    }
    .card-variant-purple:hover { box-shadow: 0 10px 25px -5px rgba(139, 92, 246, 0.25); }

    .card-variant-amber {
        background-color: #fffbeb !important;
        border-color: #fde68a !important;
        border-top: 3px solid #f59e0b !important;
    }
    .card-variant-amber:hover { box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.25); }

    .card-variant-pink {
        background-color: #fdf2f8 !important;
        border-color: #fbcfe8 !important;
        border-top: 3px solid #ec4899 !important;
    }
    .card-variant-pink:hover { box-shadow: 0 10px 25px -5px rgba(236, 72, 153, 0.25); }


    /* -------------------------------------------------------------
       DARK MODE AUTO-ADAPTATION
    ------------------------------------------------------------- */
    html[data-bs-theme="dark"] .stat-card,
    html[data-theme="dark"] .stat-card,
    [data-bs-theme="dark"] .stat-card,
    body.dark-mode .stat-card,
    .dark-style .stat-card {
        background-color: rgba(30, 41, 59, 0.75) !important;
        backdrop-filter: blur(8px);
        border-color: rgba(255, 255, 255, 0.08) !important;
    }

    /* Dark Mode Accent Top Borders & Glowing Hover Shadows */
    html[data-bs-theme="dark"] .card-variant-blue,
    [data-bs-theme="dark"] .card-variant-blue,
    body.dark-mode .card-variant-blue,
    .dark-style .card-variant-blue { border-top: 3px solid #3b82f6 !important; }
    html[data-bs-theme="dark"] .card-variant-blue:hover,
    [data-bs-theme="dark"] .card-variant-blue:hover { box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4); }

    html[data-bs-theme="dark"] .card-variant-green,
    [data-bs-theme="dark"] .card-variant-green,
    body.dark-mode .card-variant-green,
    .dark-style .card-variant-green { border-top: 3px solid #22c55e !important; }
    html[data-bs-theme="dark"] .card-variant-green:hover,
    [data-bs-theme="dark"] .card-variant-green:hover { box-shadow: 0 10px 25px -5px rgba(34, 197, 94, 0.4); }

    html[data-bs-theme="dark"] .card-variant-cyan,
    [data-bs-theme="dark"] .card-variant-cyan,
    body.dark-mode .card-variant-cyan,
    .dark-style .card-variant-cyan { border-top: 3px solid #06b6d4 !important; }
    html[data-bs-theme="dark"] .card-variant-cyan:hover,
    [data-bs-theme="dark"] .card-variant-cyan:hover { box-shadow: 0 10px 25px -5px rgba(6, 182, 212, 0.4); }

    html[data-bs-theme="dark"] .card-variant-purple,
    [data-bs-theme="dark"] .card-variant-purple,
    body.dark-mode .card-variant-purple,
    .dark-style .card-variant-purple { border-top: 3px solid #a855f7 !important; }
    html[data-bs-theme="dark"] .card-variant-purple:hover,
    [data-bs-theme="dark"] .card-variant-purple:hover { box-shadow: 0 10px 25px -5px rgba(168, 85, 247, 0.4); }

    html[data-bs-theme="dark"] .card-variant-amber,
    [data-bs-theme="dark"] .card-variant-amber,
    body.dark-mode .card-variant-amber,
    .dark-style .card-variant-amber { border-top: 3px solid #f59e0b !important; }
    html[data-bs-theme="dark"] .card-variant-amber:hover,
    [data-bs-theme="dark"] .card-variant-amber:hover { box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.4); }

    html[data-bs-theme="dark"] .card-variant-pink,
    [data-bs-theme="dark"] .card-variant-pink,
    body.dark-mode .card-variant-pink,
    .dark-style .card-variant-pink { border-top: 3px solid #ec4899 !important; }
    html[data-bs-theme="dark"] .card-variant-pink:hover,
    [data-bs-theme="dark"] .card-variant-pink:hover { box-shadow: 0 10px 25px -5px rgba(236, 72, 153, 0.4); }

    /* -------------------------------------------------------------
       QUICK ACTION CARDS
    ------------------------------------------------------------- */
    .quick-action-card {
        border-radius: 12px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 0.85rem;
        text-decoration: none !important;
        color: inherit;
        transition: all 0.25s ease;
    }

    .quick-action-card:hover {
        transform: translateY(-3px);
    }

    .quick-action-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        flex-shrink: 0;
        background: #ffffff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }

    html[data-bs-theme="dark"] .quick-action-icon,
    [data-bs-theme="dark"] .quick-action-icon,
    body.dark-mode .quick-action-icon,
    .dark-style .quick-action-icon {
        background: rgba(255, 255, 255, 0.08) !important;
    }

    /* Dynamic Header Text Colors */
    .text-card-title {
        color: var(--bs-body-color, #334155);
    }
    
    html[data-bs-theme="dark"] .text-card-title,
    [data-bs-theme="dark"] .text-card-title,
    body.dark-mode .text-card-title,
    .dark-style .text-card-title {
        color: #f1f5f9 !important;
    }

    /* Icon Background Tints */
    .icon-bg-primary { background-color: rgba(59, 130, 246, 0.15); color: #3b82f6; }
    .icon-bg-success { background-color: rgba(34, 197, 94, 0.15); color: #22c55e; }
    .icon-bg-info { background-color: rgba(6, 182, 212, 0.15); color: #06b6d4; }
    .icon-bg-purple { background-color: rgba(168, 85, 247, 0.15); color: #a855f7; }
    .icon-bg-warning { background-color: rgba(245, 158, 11, 0.15); color: #f59e0b; }
    .icon-bg-danger { background-color: rgba(236, 72, 153, 0.15); color: #ec4899; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Executive Overview Banner with Live Clock -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg text-white" 
                 style="background: linear-gradient(135deg, #051650 0%, #3357b8 100%); border-radius: 1rem; border: 1px solid rgba(255, 255, 255, 0.08);">
                <div class="card-body p-4">
                    <div class="row align-items-center gy-3">
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

    <!-- Enhanced Theme-Adaptive KPI Cards -->
    <div class="row g-3 mb-4">
        @php
            $tiles = [
                ['label' => 'Total Donors', 'value' => number_format($stats['total_donors'] ?? 1), 'icon' => 'bx-user-pin', 'icon_bg' => 'icon-bg-primary', 'sub' => 'Last 30 days', 'variant' => 'card-variant-blue'],
                ['label' => 'Total Raised', 'value' => '$' . number_format($stats['total_raised'] ?? 1000000, 0), 'icon' => 'bx-donate-heart', 'icon_bg' => 'icon-bg-success', 'sub' => 'All time total', 'variant' => 'card-variant-green'],
                ['label' => 'Active Campaigns', 'value' => number_format($stats['active_campaigns'] ?? 1), 'icon' => 'bx-megaphone', 'icon_bg' => 'icon-bg-info', 'sub' => 'Currently live', 'variant' => 'card-variant-cyan'],
                ['label' => 'Approved Beneficiaries', 'value' => number_format($stats['beneficiaries'] ?? 1), 'icon' => 'bx-group', 'icon_bg' => 'icon-bg-purple', 'sub' => 'Verified records', 'variant' => 'card-variant-purple'],
                ['label' => 'Pending Approval', 'value' => number_format($stats['pending_beneficiaries'] ?? 0), 'icon' => 'bx-time-five', 'icon_bg' => 'icon-bg-warning', 'sub' => 'Requires review', 'variant' => 'card-variant-amber'],
                ['label' => 'Active Grants', 'value' => number_format($stats['active_grants'] ?? 0), 'icon' => 'bx-award', 'icon_bg' => 'icon-bg-danger', 'sub' => 'Allocated funds', 'variant' => 'card-variant-pink'],
            ];
        @endphp

        @foreach ($tiles as $tile)
            <div class="col-sm-6 col-md-4 col-xl-2">
                <div class="stat-card {{ $tile['variant'] }}">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="stat-icon-wrapper {{ $tile['icon_bg'] }}">
                            <i class="bx {{ $tile['icon'] }} fs-5"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-icon text-muted p-0" type="button" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item fs-7" href="#">View Details</a></li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <span class="text-secondary stat-label d-block mb-1" title="{{ $tile['label'] }}">{{ $tile['label'] }}</span>
                        <div class="stat-value text-card-title mb-1" title="{{ $tile['value'] }}">{{ $tile['value'] }}</div>
                        <small class="text-muted fs-tiny d-block text-truncate">{{ $tile['sub'] }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Quick Actions Section -->
    <div class="mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="fw-bold mb-0 text-card-title">Quick Actions</h5>
            <small class="text-secondary">Frequently used management tools</small>
        </div>
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <a href="#" class="quick-action-card stat-card card-variant-blue">
                    <div class="quick-action-icon text-primary">
                        <i class="bx bx-plus-circle"></i>
                    </div>
                    <div class="overflow-hidden">
                        <h6 class="mb-0 fw-bold fs-7 text-card-title text-truncate">New Campaign</h6>
                        <small class="text-secondary fs-tiny d-block text-truncate">Create & launch</small>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="#" class="quick-action-card stat-card card-variant-green">
                    <div class="quick-action-icon text-success">
                        <i class="bx bx-user-plus"></i>
                    </div>
                    <div class="overflow-hidden">
                        <h6 class="mb-0 fw-bold fs-7 text-card-title text-truncate">Add Donor</h6>
                        <small class="text-secondary fs-tiny d-block text-truncate">Register new profile</small>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="#" class="quick-action-card stat-card card-variant-amber">
                    <div class="quick-action-icon text-warning">
                        <i class="bx bx-check-shield"></i>
                    </div>
                    <div class="overflow-hidden">
                        <h6 class="mb-0 fw-bold fs-7 text-card-title text-truncate">Review Applications</h6>
                        <small class="text-secondary fs-tiny d-block text-truncate">Pending beneficiaries</small>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="#" class="quick-action-card stat-card card-variant-pink">
                    <div class="quick-action-icon text-danger">
                        <i class="bx bx-file"></i>
                    </div>
                    <div class="overflow-hidden">
                        <h6 class="mb-0 fw-bold fs-7 text-card-title text-truncate">Generate Report</h6>
                        <small class="text-secondary fs-tiny d-block text-truncate">Financial export</small>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Analytics Charts Section -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card h-100 shadow-sm border rounded-3">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom border-opacity-10 pb-3">
                    <div>
                        <h5 class="card-title mb-1 fw-bold text-card-title">Donations Trend</h5>
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

        <div class="col-lg-4">
            <div class="card h-100 shadow-sm border rounded-3">
                <div class="card-header bg-transparent border-bottom border-opacity-10 pb-3">
                    <h5 class="card-title mb-1 fw-bold text-card-title">Beneficiaries Status</h5>
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
        <div class="col-lg-4">
            <div class="card h-100 shadow-sm border rounded-3">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom border-opacity-10 pb-3">
                    <h5 class="card-title mb-0 fw-bold text-card-title">Top Campaigns</h5>
                    <a href="#" class="fs-7 fw-semibold text-primary">View All</a>
                </div>
                <div class="card-body pt-3">
                    @forelse ($topCampaigns ?? [] as $campaign)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-semibold text-truncate text-card-title" style="max-width: 180px;">{{ $campaign->title }}</span>
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

        <div class="col-lg-8">
            <div class="card h-100 shadow-sm border rounded-3">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom border-opacity-10 pb-3">
                    <div>
                        <h5 class="card-title mb-0 fw-bold text-card-title">Recent Transactions</h5>
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
                                        <span class="fw-medium text-card-title">{{ $donation->donor->display_name ?? 'Anonymous' }}</span>
                                    </div>
                                </td>
                                <td><span class="text-truncate d-inline-block" style="max-width: 150px;">{{ $donation->campaign->title ?? 'General Fund' }}</span></td>
                                <td><span class="fw-bold text-card-title">{{ number_format($donation->amount, 2) }}</span> <small class="text-secondary">{{ $donation->currency }}</small></td>
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
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Clock Script
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

    // Area Chart Data
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

    // Radial Bar Chart
    const approved = {{ (int) ($stats['beneficiaries'] ?? 75) }};
    const pending = {{ (int) ($stats['pending_beneficiaries'] ?? 25) }};
    const total = approved + pending;
    const approvedPct = total > 0 ? Math.round((approved / total) * 100) : 0;
    const pendingPct = total > 0 ? Math.round((pending / total) * 100) : 0;

    const radialChartOptions = {
        chart: { type: 'radialBar', height: 290, background: 'transparent' },
        series: [approvedPct, pendingPct],
        labels: ['Approved', 'Pending'],
        colors: ['#22c55e', '#f59e0b'],
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


<!-- Core JS -->
<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

<!-- Vendor JS (Apexcharts) -->
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>



@endpush