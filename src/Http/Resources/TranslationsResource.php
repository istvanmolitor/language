<?php

namespace Molitor\Language\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TranslationsResource extends JsonResource
{
    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $translations = [];
        $allTranslations = $this->resource;

        if ($allTranslations) {
            foreach ($allTranslations as $langId => $translation) {
                $languageId = (int) ($translation->language_id ?? $langId);
                $translations[(string) $languageId] = array_merge([
                    'language_id' => $languageId,
                ], array_intersect_key(
                    $translation->toArray(),
                    array_flip($translation->getTranslatableFields())
                ));
            }
        }

        return $translations;
    }
}
