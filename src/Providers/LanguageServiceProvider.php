<?php

namespace Molitor\Language\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Blade;
use Molitor\Language\Repositories\LanguageRepository;
use Molitor\Language\Repositories\LanguageRepositoryInterface;
use Molitor\Language\Repositories\TranslationTypeRepository;
use Molitor\Language\Repositories\TranslationTypeRepositoryInterface;
use Molitor\Language\Http\Middleware\SetLocaleFromSession;
use Molitor\Language\Services\LanguageMenuBuilder;
use Molitor\Menu\Services\MenuManager;

class LanguageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'language');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'language');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Publish Vue components
        $this->publishes([
            __DIR__ . '/../../resources/js/pages' => resource_path('js/pages/Admin/Languages'),
        ], 'language-views');

        // Register locale middleware in web group
        $this->app['router']->pushMiddlewareToGroup('web', SetLocaleFromSession::class);
    }

    public function register()
    {
        $this->app->bind(LanguageRepositoryInterface::class, LanguageRepository::class);
        $this->app->bind(TranslationTypeRepositoryInterface::class, TranslationTypeRepository::class);

        $this->callAfterResolving(MenuManager::class, function (MenuManager $menuManager) {
            $menuManager->addMenuBuilder(new LanguageMenuBuilder());
        });
    }
}
