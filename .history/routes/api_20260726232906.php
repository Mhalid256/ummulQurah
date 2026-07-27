<?php

use App\Http\Controllers\Api\BeneficiaryApiController;
use App\Http\Controllers\Api\CampaignApiController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\DonationApiController;
use App\Http\Controllers\Api\GrantApiController;
use App\Http\Controllers\Api\ProjectApiController;
use App\Http\Controllers\Api\SponsorshipApiController;
use App\Http\Controllers\Api\VolunteerApiController;
use App\Http\Controllers\Api\Webhooks\FlutterwaveWebhookController;
use App\Http\Controllers\Api\Webhooks\MpesaWebhookController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard/stats', [DashboardApiController::class, 'stats']);

    Route::get('/campaigns', [CampaignApiController::class, 'index']);
    Route::get('/campaigns/{campaign}', [CampaignApiController::class, 'show']);

    Route::get('/donations', [DonationApiController::class, 'index']);
    Route::get('/donations/{donation}', [DonationApiController::class, 'show']);

    Route::get('/beneficiaries', [BeneficiaryApiController::class, 'index']);
    Route::get('/beneficiaries/{beneficiary}', [BeneficiaryApiController::class, 'show']);

    Route::get('/volunteers', [VolunteerApiController::class, 'index']);
    Route::get('/volunteers/{volunteer}', [VolunteerApiController::class, 'show']);

    Route::get('/sponsorships', [SponsorshipApiController::class, 'index']);
    Route::get('/sponsorships/{sponsorship}', [SponsorshipApiController::class, 'show']);

    Route::get('/projects', [ProjectApiController::class, 'index']);
    Route::get('/projects/{project}', [ProjectApiController::class, 'show']);

    Route::get('/grants', [GrantApiController::class, 'index']);
    Route::get('/grants/{grant}', [GrantApiController::class, 'show']);
});

/*
|--------------------------------------------------------------------------
| Payment gateway webhooks (public routes — verified by signature/token
| inside each controller, NOT by Sanctum, since the gateway calls these,
| not a logged-in user)
|--------------------------------------------------------------------------
*/
Route::post('/webhooks/flutterwave', [FlutterwaveWebhookController::class, 'handle'])->name('webhooks.flutterwave');
Route::post('/webhooks/mpesa', [MpesaWebhookController::class, 'handle'])->name('webhooks.mpesa');