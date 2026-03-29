<?php

declare(strict_types=1);

namespace Molitor\Language\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Molitor\Language\Models\Language;

interface LanguageRepositoryInterface
{
    public function getLanguage(int|string|Language|null $language): ?Language;

    public function getIdByCode(string $code): ?int;

    public function getCodeById(int $id): ?string;

    public function getById(int $id): ?Language;

    public function getByCode(string $code): ?Language;

    public function getDefaultLanguage(): ?Language;

    public function getDefaultId(): ?int;

    public function getDefaultLanguageCode(): ?string;

    public function getEnabledLanguages(): Collection;

    public function getAll(): Collection;
}
