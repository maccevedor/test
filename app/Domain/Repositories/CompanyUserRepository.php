<?php

namespace App\Domain\Repositories;

use App\Domain\Aggregates\CompanyUser;

interface CompanyUserRepository
{
    public function findById(int $id): ?CompanyUser;

    public function findByCompany(int $companyId): array;

    public function save(CompanyUser $companyUser): void;

    public function delete(CompanyUser $companyUser): void;

    public function countByCompany(int $companyId): int;
}