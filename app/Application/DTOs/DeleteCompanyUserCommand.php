<?php

namespace App\Application\DTOs;

class DeleteCompanyUserCommand
{
    public function __construct(
        public int $id,
        public int $company_id
    ) {
    }
}