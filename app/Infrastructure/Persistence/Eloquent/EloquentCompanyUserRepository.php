<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\CompanyUserRepository;
use App\Models\CompanyUser;
use Illuminate\Database\Eloquent\Collection;

class EloquentCompanyUserRepository implements CompanyUserRepository
{
    public function findById(int $id): ?CompanyUser
    {
        return CompanyUser::find($id);
    }

    public function save(CompanyUser $companyUser): CompanyUser
    {
        $companyUser->save();
        return $companyUser;
    }

    public function delete(CompanyUser $companyUser): void
    {
        $companyUser->delete();
    }

    public function findByCompany(int $companyId): Collection
    {
        return CompanyUser::where('company_id', $companyId)->get();
    }

    public function getUserCountForCompany(int $companyId): int
    {
        return CompanyUser::where('company_id', $companyId)->count();
    }
}