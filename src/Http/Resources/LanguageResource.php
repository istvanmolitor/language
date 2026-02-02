<?php

namespace Molitor\Language\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Molitor\Language\Http\Resources\TranslationsResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Language",
    title: "Language",
    description: "Language information",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "code", type: "string", example: "hu"),
        new OA\Property(property: "enabled", type: "boolean", example: true),
        new OA\Property(property: "name", type: "string", example: "Magyar"),
        new OA\Property(
            property: "translations",
            type: "object",
            additionalProperties: new OA\AdditionalProperties(
                type: "object",
                properties: [
                    new OA\Property(property: "name", type: "string")
                ]
            ),
            example: ["1" => ["name" => "Magyar"], "2" => ["name" => "Hungarian"]]
        ),
        new OA\Property(property: "created_at", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time")
    ]
)]
class LanguageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'enabled' => (bool)$this->enabled,
            'name' => $this->name, // a TranslatableModel miatt ez az aktuális nyelven adja vissza
            'translations' => new TranslationsResource($this->getTranslations()),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
