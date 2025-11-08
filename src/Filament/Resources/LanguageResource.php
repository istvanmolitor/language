<?php

namespace Molitor\Language\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Gate;
use Molitor\Language\Filament\Components\TranslatableFields;
use Molitor\Language\Filament\Resources\LanguageResource\Pages;
use Molitor\Language\Models\Language;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;

    protected static \BackedEnum|null|string $navigationIcon = 'heroicon-o-language';

    public static function getNavigationGroup(): string
    {
        return __('language::common.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('language::language.title');
    }

    public static function canAccess(): bool
    {
        return Gate::allows('acl', 'language');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Toggle::make('enabled')
                    ->label(__('language::language.form.enabled'))
                    ->default(true),
                Forms\Components\TextInput::make('code')
                    ->label(__('language::language.form.code'))
                    ->required()
                    ->maxLength(10)
                    ->unique(ignoreRecord: true),
                TranslatableFields::schema([
                    Forms\Components\TextInput::make('name')
                        ->label(__('language::language.form.name'))
                        ->required()
                        ->maxLength(100),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('enabled')->boolean()->label(__('language::language.table.enabled')),
                Tables\Columns\TextColumn::make('code')->label(__('language::language.table.code'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('translations.name')
                    ->label(__('language::language.table.name'))
                    ->limit(30),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLanguages::route('/'),
            'create' => Pages\CreateLanguage::route('/create'),
            'edit' => Pages\EditLanguage::route('/{record}/edit'),
        ];
    }
}
