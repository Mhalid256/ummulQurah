<?php

use App\Http\Controllers\Api\CampaignApiController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\DonationApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard/stats', [DashboardApiController::class, 'stats']);

    Route::get('/campaigns', [CampaignApiController::class, 'index']);
    Route::get('/campaigns/{campaign}', [CampaignApiController::class, 'show']);

    Route::get('/donations', [DonationApiController::class, 'index']);
    Route::get('/donations/{donation}', [DonationApiController::class, 'show']);
});
