<?php

namespace App\Application\DTOs;

use Carbon\Carbon;

class CompanyDto
{
    public function __construct(
        public int $id,
        public string $name,
        public Carbon $created_at,
        public Carbon $updated_at
    ) {
    }
}