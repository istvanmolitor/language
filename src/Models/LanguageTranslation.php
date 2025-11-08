<?php

declare(strict_types=1);

namespace Molitor\Language\Models;

class LanguageTranslation extends TranslationModel
{
    public function getTranslatableModelClass(): string
    {
        return Language::class;
    }

    public function getTranslationForeignKey(): string
    {
        return 'base_language_id';
    }

    public function getTranslatableFields(): array
    {
        return [
            'name',
        ];
    }
}
