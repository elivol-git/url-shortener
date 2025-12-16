<?php

use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/r/{slug}', RedirectController::class)
    ->where('slug', '[A-Za-z0-9_-]+');

//Route::get(' /admin/links', AdminController::class);
