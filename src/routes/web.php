<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::get('/lang/{code}', [LanguageController::class, 'switch'])
        ->where('code', '[A-Za-z_\-]+')
        ->name('language.switch');
});

Route::prefix('admin')
    ->middleware(['web', 'auth'])
    ->group(function () {
        Route::resource('language', \Molitor\Language\Http\Controllers\Admin\LanguageController::class)
            ->names('language');
    });

