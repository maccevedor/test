<?php

namespace App\Application\DTOs;

class UpdateCompanyUserCommand
{
    public function __construct(
        public int $id,
        public int $company_id,
        public string $name,
        public string $email,
        public ?string $password = null
    ) {
    }
}