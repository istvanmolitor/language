<?php

namespace Molitor\Language\Filament\Components;

use Filament\Forms;
use Molitor\Language\Repositories\LanguageRepositoryInterface;

class TranslatableFields
{
    static function schema(array $schema = []) {

        /** @var LanguageRepositoryInterface $languageRepository */
        $languageRepository = app(LanguageRepositoryInterface::class);

        $schema = array_merge([
            Forms\Components\Select::make('language_id')
                ->label(__('language::common.language'))
                ->relationship(name: 'language', titleAttribute: 'code')
                ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                ->default($languageRepository->getDefaultId())
                ->searchable()
                ->preload()
                ->required(),
        ], $schema ?? []);

        return Forms\Components\Repeater::make('translations')
            ->label(__('language::language.form.translations'))
            ->relationship('translations')
            ->schema($schema);
    }
}
