<?php

declare(strict_types=1);

namespace Molitor\Language\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $fillable = [
        'language_id',
        'foreign_id',
        'name',
        'value',
    ];

    public $timestamps = false;
}
