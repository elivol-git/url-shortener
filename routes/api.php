<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LinkController;

Route::post('/links', [LinkController::class, 'store'])
    ->middleware('throttle:api-key');

Route::patch('/links/{slug}', [LinkController::class, 'updateAvailability'])
    ->middleware('throttle:api-key');


Route::get('/links/{slug}/stats', [LinkController::class, 'slugStats']);
