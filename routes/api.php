<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LinkController;

Route::middleware(['api.key', 'throttle:api-key'])->group(function () {
    Route::post('/links', [LinkController::class, 'store']);
    Route::patch('/links/{slug}', [LinkController::class, 'updateAvailability']);
});


Route::get('/links/{slug}/stats', [LinkController::class, 'slugStats']);
