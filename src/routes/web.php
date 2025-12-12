<?php

use Illuminate\Support\Facades\Route;
use Molitor\Language\Http\Controllers\LanguageController;

Route::middleware(['web'])->group(function () {
    Route::get('/lang/{code}', [LanguageController::class, 'switch'])
        ->where('code', '[A-Za-z_\-]+')
        ->name('language.switch');
});
