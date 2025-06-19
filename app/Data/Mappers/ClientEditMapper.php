<?php

namespace App\Data\Mappers;

use App\Data\DTOs\ClientEditDto;
use App\Data\DTOs\ProductDto;

class ClientEditMapper
{
    public static function fromArray(array $data): ClientEditDto
    {
        return new ClientEditDto(
            name: $data['name']
        );
    }
}
