<?php

use Illuminate\Support\Facades\Route;
use Molitor\Language\Http\Controllers\Admin\LanguageController;

// Admin routes
Route::prefix('admin')
    ->middleware(['api', 'auth:sanctum'])
    ->name('language.admin.')
    ->group(function () {
        Route::resource('languages', LanguageController::class);
    });
