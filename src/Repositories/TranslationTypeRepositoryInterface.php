<?php

declare(strict_types=1);

namespace Molitor\Language\Repositories;

use Molitor\Language\Models\TranslationType;

interface TranslationTypeRepositoryInterface
{
    public function getMyName(string $name): TranslationType;
}
