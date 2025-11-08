<?php

namespace Molitor\Language\Dto;

class Multilingual
{
    protected array $translations = [];

    public function __construct($translations = [])
    {
        $this->setTranslations($translations);
    }

    public function setTranslations(array $translations): void
    {
        foreach ($translations as $language => $text) {
            $this->set($language, $text);
        }
    }

    public function getTranslations(): array
    {
        return $this->translations;
    }

    public function toArray(): array
    {
        return $this->getTranslations();
    }

    public function set(string $language, string|null $text): void
    {
        $this->translations[$language] = (string)$text;
    }

    public function __set(string $name, string|null $value): void
    {
        $this->set($name, $value);
    }

    public function get(string $language): string
    {
        return $this->translations[$language] ?? '';
    }

    public function __get(string $name): string
    {
        return $this->get($name);
    }

    public function has(string $language): bool
    {
        return isset($this->translations[$language]);
    }

    public function __isset(string $name): bool
    {
        return $this->has($name);
    }
}
