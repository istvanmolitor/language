<?php

namespace Molitor\Language\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "StoreLanguageRequest",
    title: "Store Language Request",
    description: "Data for creating a language",
    required: ["code", "native_name", "translations"],
    properties: [
        new OA\Property(property: "code", type: "string", example: "en"),
        new OA\Property(property: "enabled", type: "boolean", example: true),
        new OA\Property(property: "native_name", type: "string", example: "English"),
        new OA\Property(
            property: "translations",
            type: "object",
            additionalProperties: new OA\AdditionalProperties(
                type: "object",
                properties: [
                    new OA\Property(property: "name", type: "string")
                ]
            ),
            example: ["1" => ["name" => "Angol"]]
        )
    ]
)]
class StoreLanguageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:10|unique:languages,code',
            'enabled' => 'boolean',
            'native_name' => 'required|string|max:100',
            'translations' => 'required|array',
            'translations.*.name' => 'required|string|max:100',
        ];
    }
}
