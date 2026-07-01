<?php

namespace Molitor\Language\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Molitor\Language\Http\Middleware\SetLocaleFromSession;
use Molitor\Language\Repositories\LanguageRepository;
use Molitor\Language\Repositories\LanguageRepositoryInterface;
use Molitor\Language\Repositories\TranslationTypeRepository;
use Molitor\Language\Repositories\TranslationTypeRepositoryInterface;
use Molitor\Language\Services\LanguageMenuBuilder;
use Molitor\Language\View\Components\LanguageSwitcher;
use Molitor\Menu\Services\MenuManager;

class LanguageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'language');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'language');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // Load API routes with /api prefix
        $this->app->make(Router::class)
            ->prefix('api')
            ->group(__DIR__.'/../routes/api.php');

        // Register locale middleware in web group
        $this->app['router']->pushMiddlewareToGroup('web', SetLocaleFromSession::class);

        // Register Blade components
        Blade::component('language-switcher', LanguageSwitcher::class);
        Blade::component('language::language-switcher', LanguageSwitcher::class);
    }

    public function register()
    {
        $this->app->bind(LanguageRepositoryInterface::class, LanguageRepository::class);
        $this->app->bind(TranslationTypeRepositoryInterface::class, TranslationTypeRepository::class);

        $this->callAfterResolving(MenuManager::class, function (MenuManager $menuManager) {
            $menuManager->addMenuBuilder(new LanguageMenuBuilder);
        });
    }
}
