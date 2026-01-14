<?php

namespace Molitor\Language\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'translations' => 'required|array',
            'translations.*.name' => 'required|string|max:100',
        ];
    }
}
