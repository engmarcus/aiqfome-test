<?php

namespace App\Data\DTOs;

class ProductDto
{
    public function __construct(
        public int $id,
        public string $title,
        public string $image,
        public float $price,
        public ?float $review = null
    ) {}
}
