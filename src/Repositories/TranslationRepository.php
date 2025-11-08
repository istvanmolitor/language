<?php

declare(strict_types=1);

namespace Molitor\Language\Repositories;

use Molitor\Language\Models\Translation;

class TranslationRepository implements TranslationRepositoryInterface
{
    private Translation $translation;

    public function __construct()
    {
        $this->translation = new Translation();
    }

    public function setTranslationValue(int $languageId, int $translationTypeId, int $foreignId, string $value): void
    {
        $translation = $this->translation->where('language_id', $languageId)
            ->where('translation_type_id', $translationTypeId)
            ->where('foreign_id', $foreignId)
            ->first();

        if (!$translation) {
            $translation = new Translation();
            $translation->language_id = $languageId;
            $translation->translation_type_id = $translationTypeId;
            $translation->foreign_id = $foreignId;
        }
        $translation->value = $value;
        $translation->save();
    }

    public function getTranslationValue(int $languageId, int $translationTypeId, int $foreignId): ?string
    {
        $translation = $this->translation->where('language_id', $languageId)
            ->where('translation_type_id', $translationTypeId)
            ->where('foreign_id', $foreignId)
            ->first();

        if ($translation) {
            return $translation->value;
        }
        return null;
    }

    public function getTranslationValues(int $languageId, array $translationTypes, int $foreignId): array
    {
        return $this->translation->where('translations.language_id', $languageId)
            ->join('translation_types', 'translation_types.id', '=', 'translations.translation_type_id')
            ->whereIn('translation_types.name', $translationTypes)
            ->where('translations.foreign_id', $foreignId)
            ->select('translations.value', 'translation_types.name')
            ->pluck('translations.value', 'translation_types.name')
            ->toArray();
    }
}
