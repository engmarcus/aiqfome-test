<?php

namespace App\Data\DTOs;

class ClientEditDto
{
    public function __construct(
        public ?string $name = null
    ) {}
    public function toArray(): array
    {
        $data = get_object_vars($this);
        return array_filter($data, fn($value) => $value !== null);
    }
}
