<?php

namespace App\Data\Mappers;

use App\Data\DTOs\ProductDto;

class ProductMapper
{
    public static function fromArray(array $data): ProductDto
    {
        return new ProductDto(
            id: $data['id'],
            title: $data['title'],
            image: $data['image'],
            price: (float) $data['price'],
            review: $data['rating']['rate'] ?? null
        );
    }
}
