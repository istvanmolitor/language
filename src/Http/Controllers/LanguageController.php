<?php

declare(strict_types=1);

namespace Molitor\Language\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Molitor\Language\Repositories\LanguageRepositoryInterface;

class LanguageController extends Controller
{
    public function __construct(
        protected LanguageRepositoryInterface $languageRepository
    ) {
    }

    public function switch(string $code): RedirectResponse
    {
        $language = $this->languageRepository->getByCode($code);
        if ($language && (int) $language->enabled === 1) {
            session(['locale' => $language->code]);
        }

        return Redirect::back();
    }
}
