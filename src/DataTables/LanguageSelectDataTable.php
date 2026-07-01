<?php

declare(strict_types=1);

namespace Molitor\Language\DataTables;

use Illuminate\Database\Eloquent\Builder;

class LanguageSelectDataTable extends LanguageDataTable
{
    public bool $includeDisabled = false;

    public function query(Builder $query): Builder
    {
        if($this->includeDisabled) {
           return $query;
        }
        return parent::query($query)->where('enabled', 1);
    }
}
