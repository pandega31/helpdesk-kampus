<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\StatsController;
use App\Http\Controllers\Api\TicketController;
use Illuminate\Support\Facades\Route;

// Awalan nama "api." supaya tidak bentrok dengan nama route web (tickets.index, dst.)
Route::name('api.')->group(function () {
    Route::get('/stats', StatsController::class)->name('stats');
    Route::apiResource('tickets', TicketController::class)->only(['index', 'show']);
    Route::apiResource('categories', CategoryController::class);
});