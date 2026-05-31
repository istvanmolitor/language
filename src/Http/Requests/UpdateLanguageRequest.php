<?php

namespace Molitor\Language\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'UpdateLanguageRequest',
    title: 'Update Language Request',
    description: 'Data for updating a language',
    required: ['code', 'translations'],
    properties: [
        new OA\Property(property: 'code', type: 'string', example: 'en'),
        new OA\Property(property: 'enabled', type: 'boolean', example: true),
        new OA\Property(
            property: 'translations',
            type: 'object',
            additionalProperties: new OA\AdditionalProperties(
                type: 'object',
                properties: [
                    new OA\Property(property: 'name', type: 'string'),
                ]
            ),
            example: ['1' => ['name' => 'Angol updated']]
        ),
    ]
)]
class UpdateLanguageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('acl', 'language');
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:10|unique:languages,code,'.$this->route('language')->id,
            'enabled' => 'boolean',
            'translations' => 'required|array',
            'translations.*.name' => 'required|string|max:100',
        ];
    }
}
