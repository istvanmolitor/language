<?php

declare(strict_types=1);

namespace Molitor\Language\Repositories;

use Molitor\Language\Models\Language;
use Illuminate\Database\Eloquent\Collection;

interface LanguageRepositoryInterface
{
    public function getIdByCode(string $code): int|null;

    public function getCodeById(int $id): string|null;

    public function getById(int $id): Language|null;

    public function getByCode(string $code): Language|null;

    public function getDefaultLanguage(): Language|null;

    public function getDefaultId(): int|null;

    public function getDefaultLanguageCode(): string|null;

    public function getEnabledLanguages(): Collection;

    public function getAll(): Collection;
}

