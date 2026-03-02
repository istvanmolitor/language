<?php

use Illuminate\Support\Facades\Route;
use Molitor\Language\Http\Controllers\LanguageSwitchController;

Route::middleware(['web'])->group(function () {
    Route::get('/lang/{code}', [LanguageSwitchController::class, 'switch'])
        ->where('code', '[A-Za-z_\-]+')
        ->name('language.switch');
});
