<?php

namespace Molitor\Language\Filament\Resources\LanguageResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Molitor\Language\Filament\Resources\LanguageResource;

class CreateLanguage extends CreateRecord
{
    protected static string $resource = LanguageResource::class;

    public function getTitle(): string
    {
        return __('language::common.create');
    }
}
