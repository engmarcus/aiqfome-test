<?php

namespace App\Data\DTOs;

class ClientPasswordResetDto
{
    public function __construct(
        public string $email,
        public string $password,
        public string $newPassword,
    ) {}

}
