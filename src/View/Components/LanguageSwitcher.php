<?php

declare(strict_types=1);

namespace Molitor\Language\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;
use Molitor\Language\Repositories\LanguageRepositoryInterface;

class LanguageSwitcher extends Component
{
    public Collection $enabledLanguages;

    public string $currentLocale;

    public string $uid;

    /**
     * Create a new component instance.
     */
    public function __construct(
        protected LanguageRepositoryInterface $languageRepository
    ) {
        $this->enabledLanguages = $this->languageRepository->getEnabledLanguages();
        $this->currentLocale = app()->getLocale();
        $this->uid = 'lang-switcher-'.uniqid();
    }

    /**
     * Determine if the component should be rendered.
     */
    public function shouldRender(): bool
    {
        return $this->enabledLanguages->count() > 1;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('language::components.language-switcher');
    }
}
