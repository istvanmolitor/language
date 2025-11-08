<?php

namespace Molitor\Language\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Molitor\Language\Dto\Multilingual;

abstract class TranslationModel extends Model
{
    public abstract function getTranslatableModelClass(): string;

    public abstract function getTranslationForeignKey(): string;

    public abstract function getTranslatableFields(): array;

    public function translatable(): BelongsTo
    {
        return $this->belongsTo($this->getTranslatableModelClass(), $this->getTranslationForeignKey());
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function getCode(): string {
        return (string)$this->language;
    }

    public function getFillable(): array
    {
        return array_merge([
            $this->getTranslationForeignKey(),
            'language_id'
        ], $this->getTranslatableFields());
    }

    public $timestamps = false;

    public function scopeWhereMultilingual(Builder $query, string $fieldName, Multilingual $value): Builder
    {
        $translatableFields = $this->getTranslatableFields();
        if(!in_array($fieldName, $translatableFields)) {
            return $query->whereRaw('0 = 1');
        }

        $tableName = $this->getTable();
        $translatedValue = $value->getTranslations();

        return $query->join('languages', 'languages.id', '=', $tableName . '.language_id')
            ->where(function ($query) use ($tableName, $fieldName, $translatedValue) {
                foreach ($translatedValue as $code => $value) {
                    $query->orWhere(function ($query) use ($tableName, $fieldName, $code, $value) {
                        $query->where('languages.code', $code)
                            ->where($tableName . '.' . $fieldName, $value);
                    });
                }
            });
    }
}
