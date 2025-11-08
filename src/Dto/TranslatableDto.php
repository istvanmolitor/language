<?php

namespace Molitor\Language\Dto;

trait TranslatableDto
{
    public function toArray(): array
    {
        $data = [];
        foreach (get_object_vars($this) as $property => $value) {
            if ($value instanceof Multilingual) {
                $data[$property] = $value->toArray();
            } elseif (is_array($value) && !empty($value) && $value[0] instanceof TranslatableDto) {
                $data[$property] = array_map(fn($item) => $item->toArray(), $value);
            } else {
                $data[$property] = $value;
            }
        }
        return $data;
    }
}
