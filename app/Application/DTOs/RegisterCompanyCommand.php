<?php

namespace App\Application\DTOs;

class RegisterCompanyCommand
{
    public function __construct(
        public string $name
    ) {
    }
}