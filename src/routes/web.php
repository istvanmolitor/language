<?php

use Illuminate\Support\Facades\Route;
use Molitor\Language\Http\Controllers\Admin\LanguageController;

Route::middleware(['web'])->group(function () {
    Route::get('/lang/{code}', [\Molitor\Language\Http\Controllers\LanguageController::class, 'switch'])
        ->where('code', '[A-Za-z_\-]+')
        ->name('language.switch');
});
