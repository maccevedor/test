<?php

namespace App\Domain\Repositories;

use App\Domain\Aggregates\Company;

interface CompanyRepository
{
    public function findById(int $id): ?Company;

    public function save(Company $company): void;

    public function delete(Company $company): void;

    public function findAll(): array;

}