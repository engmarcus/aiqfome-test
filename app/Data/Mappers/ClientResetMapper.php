<?php

namespace App\Data\Mappers;

use App\Data\DTOs\ClientPasswordResetDto;

class ClientResetMapper
{
    public static function fromArray(array $data): ClientPasswordResetDto
    {
        return new ClientPasswordResetDto(
            email: $data['email'],
            password: $data['password'],
            newPassword:$data['newPassword']
        );
    }
}
