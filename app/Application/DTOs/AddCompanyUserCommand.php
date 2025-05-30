<?php

namespace App\Application\DTOs;

class AddCompanyUserCommand
{
    public function __construct(
        public int $company_id,
        public string $name,
        public string $email,
        public string $password
    ) {
    }
}