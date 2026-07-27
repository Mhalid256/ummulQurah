<?php

use App\Http\Controllers\Admin\BeneficiaryController;
use App\Http\Controllers\Admin\BudgetController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\CommunicationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\DonorController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\GrantController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\InventoryTransactionController;
use App\Http\Controllers\Admin\OrganizationSwitchController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SponsorshipController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\VolunteerController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Public\PublicSiteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuditLogController;

/*
|--------------------------------------------------------------------------
| Public charity website (built on the modified WaterLand template)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicSiteController::class, 'home'])->name('public.home');
Route::get('/about', [PublicSiteController::class, 'about'])->name('public.about');
Route::get('/campaigns', [PublicSiteController::class, 'campaigns'])->name('public.campaigns');
Route::get('/campaigns/{campaign:slug}', [PublicSiteController::class, 'campaignShow'])->name('public.campaign.show');
Route::get('/campaigns/{campaign:slug}/donate', [PublicSiteController::class, 'donateForm'])->name('public.donate.form');
Route::post('/campaigns/{campaign:slug}/donate', [PublicSiteController::class, 'donateSubmit'])->name('public.donate.submit');
Route::get('/contact', [PublicSiteController::class, 'contact'])->name('public.contact');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Two-Factor Authentication challenge (auth required, but NOT two_factor-
| gated — otherwise a user who hasn't verified yet could never reach it)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/two-factor-challenge', [TwoFactorController::class, 'showChallenge'])->name('two-factor.challenge');
    Route::post('/two-factor-challenge', [TwoFactorController::class, 'verifyChallenge']);
});

/*
|--------------------------------------------------------------------------
| Admin / Backend (built on the wakulima-portal-ui admin theme)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'active.org', 'two_factor', 'acting_org'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Super Admin: pick which organization's data to work with
    Route::post('/switch-organization', [OrganizationSwitchController::class, 'switch'])->name('switch-organization');

    // Donor Management
    Route::resource('donors', DonorController::class)->except(['show']);

    // Campaign Management
    Route::resource('campaigns', CampaignController::class)->except(['show']);

    // Donation Management
    Route::resource('donations', DonationController::class);

    // Beneficiary Management
    Route::resource('beneficiaries', BeneficiaryController::class)->except(['show']);
    Route::post('beneficiaries/{beneficiary}/approve', [BeneficiaryController::class, 'approve'])->name('beneficiaries.approve');
    Route::post('beneficiaries/{beneficiary}/reject', [BeneficiaryController::class, 'reject'])->name('beneficiaries.reject');

    // Sponsorship Management
    Route::resource('sponsorships', SponsorshipController::class)->except(['show']);

    // Project Management (supports campaigns/beneficiaries/finance/grants)
    Route::resource('projects', ProjectController::class)->except(['show']);

    // Finance: Budgets & Expenses
    Route::resource('budgets', BudgetController::class)->except(['show']);
    Route::resource('expenses', ExpenseController::class)->except(['show']);
    Route::post('expenses/{expense}/approve', [ExpenseController::class, 'approve'])->name('expenses.approve');
    Route::post('expenses/{expense}/reject', [ExpenseController::class, 'reject'])->name('expenses.reject');

    // Grant Management
    Route::resource('grants', GrantController::class)->except(['show']);

    // Family records (support Beneficiary Management)
    Route::resource('families', FamilyController::class)->except(['show']);

    // Volunteer Management
    Route::resource('volunteers', VolunteerController::class)->except(['show']);
    Route::post('volunteers/{volunteer}/approve', [VolunteerController::class, 'approve'])->name('volunteers.approve');

    // Staff Management
    Route::resource('staff', StaffController::class)->parameters(['staff' => 'staffMember'])->except(['show']);

    // Inventory
    Route::resource('inventory', InventoryController::class)->except(['show']);
    Route::get('inventory/{item}/transactions', [InventoryTransactionController::class, 'index'])->name('inventory.transactions');
    Route::post('inventory/{item}/transactions', [InventoryTransactionController::class, 'store'])->name('inventory.transactions.store');

    // Events
    Route::resource('events', EventController::class)->except(['show']);

    // Document Management
    Route::resource('documents', DocumentController::class)->only(['index', 'create', 'store', 'destroy']);

    // Communication
    Route::resource('communications', CommunicationController::class)->only(['index', 'create', 'store', 'destroy']);

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/financial', [ReportController::class, 'financial'])->name('reports.financial');
    Route::get('reports/donors', [ReportController::class, 'donors'])->name('reports.donors');
    Route::get('reports/beneficiaries', [ReportController::class, 'beneficiaries'])->name('reports.beneficiaries');
    Route::get('reports/campaigns', [ReportController::class, 'campaigns'])->name('reports.campaigns');
    Route::get('reports/volunteers', [ReportController::class, 'volunteers'])->name('reports.volunteers');
    Route::get('reports/donations/export', [ReportController::class, 'exportDonationsCsv'])->name('reports.donations.export');

    // Settings
    Route::get('settings/general', [SettingsController::class, 'general'])->name('settings.general');
    Route::put('settings/general', [SettingsController::class, 'updateGeneral'])->name('settings.general.update');
    Route::get('settings/notifications', [SettingsController::class, 'notifications'])->name('settings.notifications');
    Route::put('settings/notifications', [SettingsController::class, 'updateNotifications'])->name('settings.notifications.update');
    Route::get('settings/profile', [SettingsController::class, 'profile'])->name('settings.profile');
    Route::put('settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');

    // Two-Factor Authentication management
    Route::get('settings/two-factor', [TwoFactorController::class, 'show'])->name('two-factor.show');
    Route::post('settings/two-factor/confirm', [TwoFactorController::class, 'confirm'])->name('two-factor.confirm');
    Route::delete('settings/two-factor', [TwoFactorController::class, 'disable'])->name('two-factor.disable');

    // Roles & Permissions (Super Admin / Org Admin)
    Route::middleware('role:Super Administrator|Organization Administrator')->group(function () {
        Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
        Route::get('audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('audit-logs.show');
    });
});