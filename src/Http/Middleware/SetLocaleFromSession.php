<?php

declare(strict_types=1);

namespace Molitor\Language\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleFromSession
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('app.locale'));
        app()->setLocale($locale);

        return $next($request);
    }
}
