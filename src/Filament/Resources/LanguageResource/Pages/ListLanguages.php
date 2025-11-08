<?php

namespace Molitor\Language\Filament\Resources\LanguageResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Molitor\Language\Filament\Resources\LanguageResource;

class ListLanguages extends ListRecords
{
    protected static string $resource = LanguageResource::class;

    public function getBreadcrumb(): string
    {
        return __('language::common.list');
    }

    public function getTitle(): string
    {
        return __('language::language.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(__('language::language.create'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
