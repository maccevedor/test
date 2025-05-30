<?php

namespace App\Application\DTOs;

use Carbon\Carbon;

class CompanyUserDto
{
    public int $id;
    public int $company_id;
    public string $name;
    public string $email;
    public Carbon $created_at;
    public Carbon $updated_at;

    public function __construct(int $id, int $company_id, string $name, string $email, Carbon $created_at, Carbon $updated_at)
    {
        $this->id = $id;
        $this->company_id = $company_id;
        $this->name = $name;
        $this->email = $email;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}