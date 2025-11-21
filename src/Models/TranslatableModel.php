<?php

declare(strict_types=1);

namespace Molitor\Language\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Molitor\Language\Dto\Multilingual;
use Molitor\Language\Exceptions\LanguageNotExistsException;
use Molitor\Language\Repositories\LanguageRepositoryInterface;

abstract class TranslatableModel extends Model
{
    private TranslationModel|null $translationModel = null;
    private int|null $currentLanguageId = null;
    private array|null $translationObjects = null;
    private array $codeIdMap = [];
    private array $idCodeMap = [];

    /****************************************************************************/

    public abstract function getTranslationModelClass(): string;

    public function getTranslationModel(): TranslationModel
    {
        if ($this->translationModel === null) {
            $translationModelClass = $this->getTranslationModelClass();
            $this->translationModel = new $translationModelClass();
        }
        return $this->translationModel;
    }

    public function getTranslationForeignKey(): string
    {
        return $this->getTranslationModel()->getTranslationForeignKey();
    }

    private function getTranslatableFields(): array
    {
        return $this->getTranslationModel()->getTranslatableFields();
    }

    public function isTranslatable($key): bool
    {
        return in_array($key, $this->getTranslatableFields());
    }

    public function getTranslationTable(): string
    {
        return $this->getTranslationModel()->getTable();
    }

    /*Translations***************************************************************************/

    public function translation(): HasOne
    {
        return $this->hasOne($this->getTranslationModelClass(), $this->getTranslationForeignKey())
            ->where($this->getTranslationTable() . '.language_id', $this->getCurrentLanguageId());
    }

    public function translations(): HasMany
    {
        return $this->hasMany($this->getTranslationModelClass(), $this->getTranslationForeignKey());
    }

    public function loadTranslations(): void
    {
        $this->translationObjects = [];
        $translations = $this->translations()->with('language')->get();
        /** @var TranslationModel $translation */
        foreach ($translations as $translation) {
            $this->translationObjects[$translation->language_id] = $translation;
            $language = $translation->language;
            $this->addMap($language->id, $language->code);
        }
    }

    public function getTranslations(): array
    {
        if ($this->translationObjects === null) {
            $this->loadTranslations();
        }
        return $this->translationObjects;
    }

    /**
     * Returns the translation record for the given language.
     * @param int|string|null $language
     * @return TranslationModel
     */
    public function getTranslation(int|string|null $language = null): TranslationModel
    {
        if ($this->translationObjects === null) {
            $this->loadTranslations();
        }

        $languageId = $this->makeLanguageId($language);
        if (array_key_exists($languageId, $this->translationObjects)) {
            return $this->translationObjects[$languageId];
        }

        return $this->makeTranslation($languageId);
    }

    private function makeTranslation($languageId): TranslationModel
    {
        $className = $this->getTranslationModelClass();
        /** @var TranslationModel $translationModel */
        $translationModel = new $className();

        $id = $this->getKey();
        if ($this->exists && $id !== null) {
            $translationModel->setAttribute($this->getTranslationForeignKey(), $id);
        }

        $translationModel->setAttribute('language_id', $languageId);
        $this->translationObjects[$languageId] = $translationModel;
        return $this->translationObjects[$languageId];
    }

    /*Current***************************************************************************/

    public function getCurrentLanguageId(): int
    {
        if ($this->currentLanguageId === null) {
            $this->currentLanguageId = $this->getDefaultId();
            if ($this->currentLanguageId === null) {
                throw new LanguageNotExistsException();
            }
        }
        return $this->currentLanguageId;
    }

    public function setCurrentLanguageId(int $currentLanguageId): void
    {
        $this->currentLanguageId = $currentLanguageId;
    }

    public function setCurrentCode(string $code): void
    {
        $this->setCurrentLanguageId($this->getIdByCode($code));
    }

    public function getCurrentCode(): string
    {
        return $this->getCodeById($this->getCurrentLanguageId());
    }

    public function getCurrentTranslation(): TranslationModel
    {
        return $this->getTranslation();
    }

    /*Scopes***************************************************************************/

    public function scopeJoinTranslation(Builder $query, int|string|null $language = null): Builder
    {
        $languageId = $this->makeLanguageId($language);
        $translationTable = $this->getTranslationTable();
        return $query->leftJoin($translationTable, function ($join) use ($translationTable, $languageId) {
            $join->on(
                $translationTable . '.' . $this->getTranslationForeignKey(),
                '=',
                $this->getTable() . '.id'
            )->where($translationTable . '.language_id', $languageId);
        })->with('translations');
    }

    public function scopeOrderByTranslation(Builder $query, string $attribute, string $direction = 'asc'): Builder
    {
        return $query->orderBy($this->getFieldName($attribute), $direction);
    }

    public function scopeWhereTranslation(Builder $query, string $attribute, $value): Builder
    {
        return $query->where($this->getFieldName($attribute), $value);
    }

    public function scopeWhereMultilingual(Builder $query, string $fieldName, Multilingual $value): Builder
    {
        $foreignKey = $this->getTranslationForeignKey();
        $ids = $this->getTranslationModel()->whereMultilingual($fieldName, $value)->select($foreignKey)->get()->pluck($foreignKey)->toArray();
        return $query->whereIn($this->primaryKey, $ids);
    }

    public function scopeSelectBase(Builder $query): Builder
    {
        $base = $query->getModel()->getTable();
        return $query->select($base . ".*");
    }

    /*Attributes***************************************************************************/

    public function setAttributeTranslation(string $key, string $value, int|string|null $language = null): void
    {
        $this->getTranslation($language)->setAttribute($key, $value);
    }

    public function getAttributeTranslation(string $key, int|string|null $language = null): mixed
    {
        return $this->getTranslation($language)->getAttribute($key);
    }

    public function setAttribute($key, $value): void
    {
        if ($this->isTranslatable($key)) {
            if($value instanceof Multilingual) {
                $this->setAttributeDto($key, $value);
            }
            else {
                $this->setAttributeTranslation($key, $value);
            }
        } else {
            parent::setAttribute($key, $value);
        }
    }

    public function getAttribute($key): mixed
    {
        if ($this->isTranslatable($key)) {
            return $this->getAttributeTranslation($key);
        } else {
            return parent::getAttribute($key);
        }
    }

    public function getAttributeDto(string $key): Multilingual
    {
        $dto = new Multilingual();
        /** @var TranslationModel $translationModel */
        foreach ($this->getTranslations() as $languageId => $translation) {
            $value = $translation->getAttribute($key);
            if (!empty($value)) {
                $dto->set($this->getCodeById($languageId), $value);
            }
        }
        return $dto;
    }

    public function setAttributeDto(string $key, Multilingual $dto): void
    {
        foreach ($dto->getTranslations() as $code => $value) {
            if (!empty($value)) {
                $this->setAttributeTranslation($key, $value, $code);
            }
        }
    }

    /****************************************************************************/

    public function save(array $options = []): bool
    {
        $saved = parent::save($options);
        if($saved) {
            /** @var TranslationModel $translationModel */
            foreach ($this->getTranslations() as $translationModel) {
                $translationModel->setAttribute($this->getTranslationForeignKey(), $this->getKey());
                $translationModel->save();
            }
        }
        return $saved;
    }

    public function delete(): bool
    {
        /** @var TranslationModel $translationModel */
        foreach ($this->getTranslations() as $translationModel) {
            $translationModel->delete();
        }
        return parent::delete();
    }

    public function toArray(): array
    {
        $array = parent::toArray();
        $array['translations'] = [];
        /** @var TranslationModel $translationModel */
        foreach ($this->translations as $translationModel) {
            $array['translations'][] = $translationModel->toArray();
        }
        return $array;
    }

    /*Helper***************************************************************************/

    private function addMap(int $id, string $code): void
    {
        $this->codeIdMap[$code] = $id;
        $this->idCodeMap[$id] = $code;
    }

    private function getIdByCode(string $code): int
    {
        if (!array_key_exists($code, $this->codeIdMap)) {
            $id = app(LanguageRepositoryInterface::class)->getIdByCode($code);
            $this->addMap($id, $code);
        }
        return $this->codeIdMap[$code];
    }

    private function getCodeById(int $id): string
    {
        if (!array_key_exists($id, $this->idCodeMap)) {
            $code = app(LanguageRepositoryInterface::class)->getCodeById($id);
            $this->addMap($id, $code);
        }
        return $this->idCodeMap[$id];
    }

    private function getDefaultId(): int|null
    {
        $defaultLanguage = app(LanguageRepositoryInterface::class)->getDefaultLanguage();
        if ($defaultLanguage === null) {
            return null;
        }
        $this->addMap($defaultLanguage->id, $defaultLanguage->code);
        return $defaultLanguage->id;
    }

    /**
     * @param int|string|null $value
     * @return int
     * @throws LanguageNotExistsException
     */
    private function makeLanguageId(int|string|null $value): int
    {
        if ($value === null) {
            return $this->getCurrentLanguageId();
        } elseif (is_string($value)) {
            return $this->getIdByCode($value);
        } else {
            return $value;
        }
    }

    private function getFieldName(string $key): string
    {
        if ($this->isTranslatable($key)) {
            return $this->getTranslationTable() . '.' . $key;
        } else {
            return $this->getTable() . '.' . $key;
        }
    }
}
