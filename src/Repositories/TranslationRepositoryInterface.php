<?php

declare(strict_types=1);

namespace Molitor\Language\Repositories;

use Molitor\Language\Models\Translation;

interface TranslationRepositoryInterface
{
    public function setTranslationValue(int $languageId, int $translationTypeId, int $foreignId, string $value): void;

    public function getTranslationValue(int $languageId, int $translationTypeId, int $foreignId): ?string;

    public function getTranslationValues(int $languageId, array $translationTypes, int $foreignId): array;
}
