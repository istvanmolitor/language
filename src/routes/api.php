<?php

use Illuminate\Support\Facades\Route;
use Molitor\Language\Http\Controllers\Api\LanguageController;

// Admin routes
Route::prefix('admin')
    ->middleware(['api', 'auth:sanctum', 'permission:language'])
    ->name('language.admin.')
    ->group(function () {
        Route::get('languages', [LanguageController::class, 'index'])->name('languages.index');
        Route::get('languages/options', [LanguageController::class, 'options'])->name('languages.options');
        Route::get('languages/select', [LanguageController::class, 'select'])->name('languages.select');
        Route::get('languages/default', [LanguageController::class, 'default'])->name('languages.default');
        Route::resource('languages', LanguageController::class)->except(['index', 'create']);
    });
