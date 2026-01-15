<?php

declare(strict_types=1);

namespace Molitor\Language\Repositories;

use Molitor\Language\Models\Language;
use Illuminate\Database\Eloquent\Collection;

class LanguageRepository implements LanguageRepositoryInterface
{
    private Language $language;

    private array $idCache = [];
    private array $codeCache = [];

    public function __construct()
    {
        $this->language = new Language();
    }

    protected function cacheLanguage(Language $language): void
    {
        $this->idCache[$language->id] = $language;
        $this->codeCache[$language->code] = $language;
    }

    public function getIdByCode(string $code): int|null
    {
        return $this->getByCode($code)?->id;
    }

    public function getCodeById(int $id): string|null
    {
        return $this->getById($id)?->code;
    }

    public function getById(int $id): Language|null
    {
        if (!array_key_exists($id, $this->idCache)) {
            $language = $this->language->where('id', $id)->first();
            if ($language) {
                $this->cacheLanguage($language);
            }
            else {
                $this->idCache[$id] = null;
            }
        }
        return $this->idCache[$id];
    }

    public function getByCode(string $code): Language|null
    {
        if (!array_key_exists($code, $this->codeCache)) {
            $language = $this->language->where('code', $code)->first();
            if ($language) {
                $this->cacheLanguage($language);
            }
            else {
                $this->codeCache[$code] = null;
            }
        }
        return $this->codeCache[$code];
    }

    public function getDefaultLanguage(): Language|null
    {
        return $this->getByCode(config('app.locale'));
    }

    public function getDefaultId(): int|null
    {
        return $this->getDefaultLanguage()?->id;
    }

    public function getDefaultLanguageCode(): string|null
    {
        return $this->getDefaultLanguage()?->code;
    }

    public function getAll(): Collection
    {
        return $this->language->joinTranslation()->orderByTranslation('name')->get();
    }

    public function getEnabledLanguages(): Collection
    {
        return $this->language
            ->with('translations')
            ->where('enabled', 1)
            ->get();
    }
}
