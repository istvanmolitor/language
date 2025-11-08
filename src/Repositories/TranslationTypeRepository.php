<?php

declare(strict_types=1);

namespace Molitor\Language\Repositories;

use Molitor\Language\Models\TranslationType;

class TranslationTypeRepository implements TranslationTypeRepositoryInterface
{
    private TranslationType $translationType;
    private array $nameCache = [];

    public function __construct()
    {
        $this->translationType = new TranslationType();
    }

    public function getMyName(string $name): TranslationType
    {
        if (!array_key_exists($name, $this->nameCache)) {
            $this->nameCache[$name] = $this->translationType->where('name', $name)->first();
            if ($this->nameCache[$name] === null) {
                $this->nameCache[$name] = $this->translationType->create([
                    'name' => $name,
                ]);
            }
        }
        return $this->nameCache[$name];
    }


}
