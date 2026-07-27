@extends('layouts.admin')

@section('title', 'Executive Dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header Summary Section -->
    <div class="row g-4 mb-4">
        @php
            $tiles = [
                ['label' => 'Total Donors', 'value' => number_format($stats['total_donors']), 'icon' => 'bx-user-pin', 'color' => 'primary', 'trend' => '+12.5%', 'trend_color' => 'success'],
                ['label' => 'Total Raised', 'value' => number_format($stats['total_raised'], 2), 'icon' => 'bx-donate-heart', 'color' => 'success', 'trend' => '+8.2%', 'trend_color' => 'success'],
                ['label' => 'Active Campaigns', 'value' => number_format($stats['active_campaigns']), 'icon' => 'bx-megaphone', 'color' => 'info', 'trend' => 'Live', 'trend_color' => 'info'],
                ['label' => 'Approved Beneficiaries', 'value' => number_format($stats['beneficiaries']), 'icon' => 'bx-group', 'color' => 'primary', 'trend' => '+5.4%', 'trend_color' => 'success'],
                ['label' => 'Pending Approval', 'value' => number_format($stats['pending_beneficiaries']), 'icon' => 'bx-time-five', 'color' => 'warning', 'trend' => 'Action Needed', 'trend_color' => 'warning'],
                ['label' => 'Active Grants', 'value' => number_format($stats['active_grants']), 'icon' => 'bx-award', 'color' => 'secondary', 'trend' => 'Stable', 'trend_color' => 'secondary'],
            ];
        @endphp

        @foreach ($tiles as $tile)
            <div class="col-sm-6 col-md-4 col-xl-2">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="avatar-initial rounded-3 bg-label-{{ $tile['color'] }} p-2 d-flex align-items-center justify-content-center">
                                <i class="bx {{ $tile['icon'] }} fs-4"></i>
                            </span>
                            <span class="badge bg-label-{{ $tile['trend_color'] }} fs-tiny rounded-pill">
                                {{ $tile['trend'] }}
                            </span>
                        </div>
                        <div>
                            <span class="text-muted fw-medium d-block fs-7 text-truncate">{{ $tile['label'] }}</span>
                            <h4 class="mb-0 fw-bold mt-1 text-heading">{{ $tile['value'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Analytics Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Main Area Chart: Revenue / Donations Trend -->
        <div class="col-lg-8">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0 pb-0">
                    <div>
                        <h5 class="card-title mb-1 fw-bold">Donations Trend</h5>
                        <small class="text-muted">Overview of contributions over the last 6 months</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle rounded-pill" type="button" data-bs-toggle="dropdown">
                            Last 6 Months
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                            <li><a class="dropdown-item" href="#">Last 6 Months</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <div id="donationsTrendChart" style="min-height: 315px;"></div>
                </div>
            </div>
        </div>

        <!-- Radial Bar Chart: Beneficiary Distribution -->
        <div class="col-lg-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header bg-transparent border-bottom-0 pb-0">
                    <h5 class="card-title mb-1 fw-bold">Beneficiaries Status</h5>
                    <small class="text-muted">Approval distribution breakdown</small>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                    <div id="beneficiariesRadialChart" class="w-100"></div>
                    <div class="d-flex justify-content-center gap-4 mt-3 w-100 pt-2 border-top">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge rounded-pill bg-success p-1"></span>
                            <span class="fw-semibold fs-7">Approved</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge rounded-pill bg-warning p-1"></span>
                            <span class="fw-semibold fs-7">Pending</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Campaigns & Recent Activity Table -->
    <div class="row g-4">
        <!-- Top Performing Campaigns -->
        <div class="col-lg-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <h5 class="card-title mb-0 fw-bold">Top Campaigns</h5>
                    <a href="javascript:void(0);" class="fs-7 fw-semibold text-primary">View All</a>
                </div>
                <div class="card-body">
                    @forelse ($topCampaigns as $campaign)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-semibold text-heading text-truncate style="max-width: 180px;">{{ $campaign->title }}</span>
                                <span class="badge bg-label-primary fs-tiny ms-2">{{ number_format($campaign->progress_percent) }}%</span>
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
                            <p class="mb-0">No active campaigns recorded.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Donations / Orders Table -->
        <div class="col-lg-8">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                    <div>
                        <h5 class="card-title mb-0 fw-bold">Recent Transactions</h5>
                        <small class="text-muted">Latest contribution records</small>
                    </div>
                    <button class="btn btn-sm btn-label-secondary rounded-pill">
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
                        <tbody class="table-border-bottom-0">
                        @forelse ($recentDonations as $donation)
                            <tr>
                                <td>
                                    <span class="fw-semibold text-primary">#{{ $donation->receipt_no }}</span>
                                </td>
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
    // Helper to get Computed Theme Colors dynamically (works across light & dark theme switchers)
    const getThemeColor = (cssVar, fallback) => {
        return getComputedStyle(document.documentElement).getPropertyValue(cssVar).trim() || fallback;
    };

    const primaryColor = getThemeColor('--bs-primary', '#5A8DEE');
    const successColor = getThemeColor('--bs-success', '#39DA8A');
    const warningColor = getThemeColor('--bs-warning', '#FDAC41');
    const textColor = getThemeColor('--bs-body-color', '#a1acb8');
    const borderColor = getThemeColor('--bs-border-color', '#444b54');

    // --- Area Chart: Donations Trend ---
    const labels = @json($monthlyDonations->pluck('ym'));
    const values = @json($monthlyDonations->pluck('total'));

    const trendChartOptions = {
        chart: {
            type: 'area',
            height: 310,
            toolbar: { show: false },
            sparkline: { enabled: false },
            background: 'transparent'
        },
        series: [{ name: 'Donations', data: values }],
        xaxis: {
            categories: labels,
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: {
                style: { colors: textColor, fontSize: '12px' }
            }
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
                opacityFrom: 0.45,
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
                hollow: { size: '50%' },
                track: {
                    background: borderColor,
                    opacity: 0.3
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