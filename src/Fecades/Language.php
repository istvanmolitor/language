<?php

namespace Molitor\Language\Fecades;

use Illuminate\Support\Facades\Facade;

class Language extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'language';
    }
}
