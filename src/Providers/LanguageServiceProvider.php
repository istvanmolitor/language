<?php

namespace Molitor\Language\Providers;

use Illuminate\Support\ServiceProvider;
use Molitor\Language\Repositories\LanguageRepository;
use Molitor\Language\Repositories\LanguageRepositoryInterface;
use Molitor\Language\Repositories\TranslationTypeRepository;
use Molitor\Language\Repositories\TranslationTypeRepositoryInterface;

class LanguageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'language');
    }

    public function register()
    {
        $this->app->bind(LanguageRepositoryInterface::class, LanguageRepository::class);
        $this->app->bind(TranslationTypeRepositoryInterface::class, TranslationTypeRepository::class);
    }
}
