<?php

declare(strict_types=1);

namespace Molitor\Language\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;
use Molitor\Language\Models\Language;
use Molitor\Language\Repositories\LanguageRepositoryInterface;
use Molitor\Language\Services\LanguageService;

class LanguageSwitcher extends Component
{
    public Collection $enabledLanguages;

    public ?Language $currentLanguage;

    /**
     * Create a new component instance.
     */
    public function __construct(
        protected LanguageRepositoryInterface $languageRepository,
        protected LanguageService $languageService
    ) {
        $this->enabledLanguages = $this->languageRepository->getEnabledLanguages();
        $this->currentLanguage = $this->languageService->getCurrentLanguage();
    }

    /**
     * Determine if the component should be rendered.
     */
    public function shouldRender(): bool
    {
        return $this->currentLanguage !== null && $this->enabledLanguages->count() > 1;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return template('language::components.language-switcher');
    }
}
