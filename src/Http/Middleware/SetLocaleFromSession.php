<?php

declare(strict_types=1);

namespace Molitor\Language\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Molitor\Language\Services\LanguageService;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleFromSession
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var LanguageService $languageService */
        $languageService = app()->make(LanguageService::class);
        $language = $languageService->getLanguage();
        if($language) {
            app()->setLocale($language->code);
        }

        return $next($request);
    }
}
