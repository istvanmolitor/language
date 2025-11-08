<?php

namespace Molitor\Language\Filament\Resources\LanguageResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Molitor\Language\Filament\Resources\LanguageResource;

class EditLanguage extends EditRecord
{
    protected static string $resource = LanguageResource::class;

    public function getTitle(): string
    {
        return __('language::common.edit');
    }
}
