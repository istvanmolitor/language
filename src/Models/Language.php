<?php

declare(strict_types=1);

namespace Molitor\Language\Models;

class Language extends TranslatableModel
{
    protected $fillable = [
        'enabled',
        'code',
    ];

    public function getTranslationModelClass(): string
    {
        return LanguageTranslation::class;
    }

    public $timestamps = true;

    public function __toString(): string
    {
        return $this->code;
    }
}
