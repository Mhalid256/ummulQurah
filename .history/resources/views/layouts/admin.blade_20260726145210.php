<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed layout-navbar-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets/') }}/" data-template="vertical-menu-template">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Dashboard') | {{ config('app.name') }} Admin</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
    @stack('styles')
</head>
<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
                    <span class="app-brand-logo demo"><i class="bx bxs-heart text-primary fs-2"></i></span>
                    <span class="app-brand-text demo menu-text fw-bold ms-2">{{ config('app.name') }}</span>
                </a>
                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                    <i class="bx menu-toggle-icon fs-4 d-none d-xl-block align-middle"></i>
                    <i class="bx bx-x bx-sm d-xl-none d-block align-middle"></i>
                </a>
            </div>
            <div class="menu-divider mt-0"></div>
            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
                @php $active = fn($p) => request()->routeIs($p) ? 'active' : ''; @endphp

                <li class="menu-item {{ $active('admin.dashboard') }}">
                    <a href="{{ route('admin.dashboard') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-home-circle"></i>
                        <div>Dashboard</div>
                    </a>
                </li>

                <li class="menu-header small text-uppercase"><span class="menu-header-text">Fundraising</span></li>
                <li class="menu-item {{ $active('admin.donors.*') }}">
                    <a href="{{ route('admin.donors.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-user-pin"></i><div>Donors</div></a>
                </li>
                <li class="menu-item {{ $active('admin.campaigns.*') }}">
                    <a href="{{ route('admin.campaigns.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-megaphone"></i><div>Campaigns</div></a>
                </li>
                <li class="menu-item {{ $active('admin.donations.*') }}">
                    <a href="{{ route('admin.donations.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-donate-heart"></i><div>Donations</div></a>
                </li>

                <li class="menu-header small text-uppercase"><span class="menu-header-text">Programs</span></li>
                <li class="menu-item {{ $active('admin.beneficiaries.*') }}">
                    <a href="{{ route('admin.beneficiaries.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-group"></i><div>Beneficiaries</div></a>
                </li>
                <li class="menu-item {{ $active('admin.families.*') }}">
                    <a href="{{ route('admin.families.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-home-alt"></i><div>Families</div></a>
                </li>
                <li class="menu-item {{ $active('admin.sponsorships.*') }}">
                    <a href="{{ route('admin.sponsorships.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-link"></i><div>Sponsorships</div></a>
                </li>
                <li class="menu-item {{ $active('admin.projects.*') }}">
                    <a href="{{ route('admin.projects.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-briefcase"></i><div>Projects</div></a>
                </li>
                <li class="menu-item {{ $active('admin.volunteers.*') }}">
                    <a href="{{ route('admin.volunteers.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-run"></i><div>Volunteers</div></a>
                </li>
                <li class="menu-item {{ $active('admin.events.*') }}">
                    <a href="{{ route('admin.events.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-calendar-event"></i><div>Events</div></a>
                </li>

                <li class="menu-header small text-uppercase"><span class="menu-header-text">Finance</span></li>
                <li class="menu-item {{ $active('admin.budgets.*') }}">
                    <a href="{{ route('admin.budgets.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-wallet"></i><div>Budgets</div></a>
                </li>
                <li class="menu-item {{ $active('admin.expenses.*') }}">
                    <a href="{{ route('admin.expenses.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-receipt"></i><div>Expenses</div></a>
                </li>
                <li class="menu-item {{ $active('admin.grants.*') }}">
                    <a href="{{ route('admin.grants.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-award"></i><div>Grants</div></a>
                </li>
                <li class="menu-item {{ $active('admin.inventory.*') }}">
                    <a href="{{ route('admin.inventory.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-package"></i><div>Inventory</div></a>
                </li>

                <li class="menu-header small text-uppercase"><span class="menu-header-text">Engagement</span></li>
                <li class="menu-item {{ $active('admin.communications.*') }}">
                    <a href="{{ route('admin.communications.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-envelope"></i><div>Communication</div></a>
                </li>
                <li class="menu-item {{ $active('admin.documents.*') }}">
                    <a href="{{ route('admin.documents.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-folder"></i><div>Documents</div></a>
                </li>
                <li class="menu-item {{ $active('admin.reports.*') }}">
                    <a href="{{ route('admin.reports.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i><div>Reports</div></a>
                </li>

                @role('Super Administrator|Organization Administrator')
                <li class="menu-header small text-uppercase"><span class="menu-header-text">Administration</span></li>
                <li class="menu-item {{ $active('admin.staff.*') }}">
                    <a href="{{ route('admin.staff.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-id-card"></i><div>Staff</div></a>
                </li>
                <li class="menu-item {{ $active('admin.roles.*') }}">
                    <a href="{{ route('admin.roles.index') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-shield-quarter"></i><div>Roles &amp; Permissions</div></a>
                </li>
                <li class="menu-item {{ $active('admin.settings.*') }}">
                    <a href="{{ route('admin.settings.general') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-cog"></i><div>Settings</div></a>
                </li>
                @endrole
                <li class="menu-item {{ $active('admin.two-factor.show') }}">
                    <a href="{{ route('admin.two-factor.show') }}" class="menu-link"><i class="menu-icon tf-icons bx bx-lock-alt"></i><div>Security (2FA)</div></a>
                </li>
            </ul>
        </aside>

        <div class="layout-page">
            <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
                <div class="container-fluid">
                    <div class="layout-menu-toggle navbar-nav d-xl-none align-items-xl-center me-3 me-xl-0">
                        <a class="nav-item nav-link px-0" href="javascript:void(0)"><i class="bx bx-menu bx-sm"></i></a>
                    </div>
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <div class="navbar-nav align-items-center">
                            <span class="fw-semibold">{{ auth()->user()->organization->name ?? 'Platform Administration' }}</span>
                        </div>
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <span class="avatar avatar-online">
                                        <span class="avatar-initial rounded-circle bg-label-primary">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><h6 class="dropdown-header">{{ auth()->user()->name }}</h6></li>
                                    <li><div class="dropdown-divider"></div></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item"><i class="bx bx-power-off me-2"></i>Log Out</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="content-wrapper">
                <div class="container-fluid flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4">@yield('title')</h4>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>

                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-fluid d-flex flex-wrap justify-content-between py-2">
                        <div>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
</div>

<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
@stack('scripts')
</body>
</html>