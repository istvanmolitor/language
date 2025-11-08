<?php

namespace Molitor\Language\Services;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Molitor\Language\Dto\Multilingual;
use Molitor\Language\Models\TranslatableModel;
use Molitor\Language\Models\TranslationModel;
use Molitor\Language\Repositories\LanguageRepositoryInterface;

class LanguageService
{
    protected array $translatableModels = [];

    public function __construct(
        protected LanguageRepositoryInterface $languageRepository,
    )
    {
    }

    protected function getTranslatableModel(string $translatableModelClass): TranslatableModel
    {
        if(array_key_exists($translatableModelClass, $this->translatableModels)) {
            return $this->translatableModels[$translatableModelClass];
        }
        $model = new $translatableModelClass();
        if($model instanceof TranslatableModel) {
            return $this->translatableModels[$translatableModelClass] = $model;
        }
        throw new Exception('Model is not translatable');
    }

    public function getByMultilingual(string $translatableModelClass, string $fieldName, Multilingual $value): TranslatableModel|null
    {
        $translatableModel = $this->getTranslatableModel($translatableModelClass);
        $translationModel = $translatableModel->getTranslationModel();
        $translatableFields = $translationModel->getTranslatableFields();
        if(!in_array($fieldName, $translatableFields)) {
            throw new Exception("Field $fieldName is not translatable");
        }

        $translations = $value->getTranslations();
        if(count($translations) === 0) {
            return null;
        }

        $translationTable = $translationModel->getTable();

        $translationRecords = $translationModel
            ->join('languages', 'languages.id', '=', $translationTable . '.language_id')
            ->where(function ($query) use ($translationTable, $fieldName, $translations) {
                foreach ($translations as $code => $value) {
                    $query->orWhere(function ($query) use ($translationTable, $fieldName, $code, $value) {
                        $query->where('languages.code', $code)
                            ->where($translationTable . '.' . $fieldName, $value);
                    });
                }
            })->select([
                $translationModel->getTranslationForeignKey() . ' AS translatable_id',
                'languages.code AS code',
            ])->pluck('translatable_id', 'code')->toArray();

        if(!count($translationRecords)) {
            return null;
        }

        $defaultLanguageCode = $this->languageRepository->getDefaultLanguageCode();
        if($defaultLanguageCode and array_key_exists($defaultLanguageCode, $translationRecords)) {
            $translatableId = $translationRecords[$defaultLanguageCode];
        }
        else {
            $translatableId = $translationRecords[array_key_first($translationRecords)];
            if($translatableId === null) {
                return null;
            }
        }

        return $translatableModel->where('id', $translatableId)->first();
    }
}
