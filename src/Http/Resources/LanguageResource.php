<?php

namespace Molitor\Language\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $translations = [];
        $allTranslations = $this->getTranslations();
        if ($allTranslations) {
            foreach ($allTranslations as $langId => $translation) {
                $translations[$langId] = [
                    'name' => $translation->name,
                ];
            }
        }

        return [
            'id' => $this->id,
            'code' => $this->code,
            'enabled' => (bool)$this->enabled,
            'name' => $this->name, // a TranslatableModel miatt ez az aktuális nyelven adja vissza
            'translations' => $translations,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
