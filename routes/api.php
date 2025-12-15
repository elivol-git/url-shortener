<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LinkController;

Route::post('/links', [LinkController::class, 'store']);
