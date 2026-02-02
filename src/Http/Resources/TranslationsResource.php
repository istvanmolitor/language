<?php

namespace Molitor\Language\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Molitor\Language\Models\TranslatableModel;

class TranslationsResource extends JsonResource
{
    public function __construct(TranslatableModel $resource)
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
                $translations[$langId] = array_intersect_key(
                    $translation->toArray(),
                    array_flip($translation->getTranslatableFields())
                );
            }
        }

        return $translations;
    }
}
