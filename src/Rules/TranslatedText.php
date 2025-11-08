<?php

namespace Molitor\Language\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Molitor\Language\Repositories\LanguageRepositoryInterface;

class TranslatedText implements ValidationRule
{
    const OPTIONAL = 0;
    const MIN_ONE_REQUIRED = 1;
    const ALL_REQUIRED = 2;

    protected LanguageRepositoryInterface $languageRepository;

    public function __construct(
        protected int $required = self::MIN_ONE_REQUIRED
    ) {
        $this->languageRepository = app(LanguageRepositoryInterface::class);
    }

    protected function filterValue(mixed $value): array
    {
        $filteredValues = [];
        foreach ($value as $item) {
            if (is_array($item) &&
                isset($item['value']) &&
                !empty($item['value']) &&
                isset(
                    $item['language_id']
                )) {
                $filteredValues[(int)$item['language_id']] = (string)$item['value'];
            }
        }
        return $filteredValues;
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_array($value)) {
            $fail('The ' . $attribute . ' field must be a valid translation.');
            return;
        }

        $filteredValues = $this->filterValue($value);

        $countOfValidValues = 0;
        foreach ($this->languageRepository->getEnabledLanguages() as $language) {
            if (array_key_exists($language->id, $filteredValues)) {
                $countOfValidValues++;
            } else {
                if ($this->required === self::ALL_REQUIRED) {
                    $fail('A ' . $language->name . ' kötelező.');
                }
            }
        }

        if ($this->required === self::MIN_ONE_REQUIRED && $countOfValidValues === 0) {
            $fail('Minimum egy érték megadása kötelező.');
        }
    }
}
