<?php

declare(strict_types=1);

namespace Molitor\Language\DataTables;

use Illuminate\Database\Eloquent\Builder;
use Molitor\Admin\DataTables\DataTable;
use Molitor\Language\Http\Resources\LanguageResource;
use Molitor\Language\Models\Language;

class LanguageDataTable extends DataTable
{
    protected function getModelClass(): string
    {
        return Language::class;
    }

    protected function getResourceClass(): string
    {
        return LanguageResource::class;
    }

    protected function getSearchPlaceholder(): string
    {
        return 'Keresés kód vagy név alapján...';
    }

    protected function initColumns(): void
    {
        $this->addColumn('code')
            ->setLabel('Kód')
            ->setSearchable()
            ->setOrderable();

        $this->addColumn('name')
            ->setLabel('Név')
            ->setSearchable();

        $this->addColumn('enabled')
            ->setLabel('Engedélyezve')
            ->setOrderable();
    }

    public function query(Builder $query): Builder
    {
        return $query->joinTranslation()->selectBase();
    }
}
