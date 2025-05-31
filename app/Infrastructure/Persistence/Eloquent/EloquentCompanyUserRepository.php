<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Aggregates\Company;
use App\Domain\Repositories\CompanyUserRepository;
use App\Domain\Entities\CompanyUser as DomainCompanyUser;
use App\Models\CompanyUser as EloquentCompanyUser;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class EloquentCompanyUserRepository implements CompanyUserRepository
{
    public function findById(int $id): ?DomainCompanyUser
    {
        $eloquentCompanyUser = EloquentCompanyUser::find($id);

        if (!$eloquentCompanyUser) {
            return null;
        }

        return $this->mapEloquentToDomain($eloquentCompanyUser);
    }

    public function save(DomainCompanyUser $companyUser): DomainCompanyUser
    {
        $eloquentCompanyUser = $companyUser->getId() ? EloquentCompanyUser::find($companyUser->getId()) : new EloquentCompanyUser();

        $eloquentCompanyUser->company_id = $companyUser->getCompanyId();
        $eloquentCompanyUser->name = $companyUser->getName();
        $eloquentCompanyUser->email = $companyUser->getEmail();

        // Only hash password if it's provided (e.g., during creation or if updated)
        if ($companyUser->getPassword()) {
            $eloquentCompanyUser->password = Hash::make($companyUser->getPassword());
        }

        $eloquentCompanyUser->save();

        // Set the ID and timestamps back on the DomainCompanyUser entity
        $companyUser->setId($eloquentCompanyUser->id);
        $companyUser->setTimestamps($eloquentCompanyUser->created_at, $eloquentCompanyUser->updated_at);

        return $companyUser;
    }

    public function delete(DomainCompanyUser $companyUser): void
    {
        $eloquentCompanyUser = EloquentCompanyUser::find($companyUser->getId());

        if ($eloquentCompanyUser) {
            $eloquentCompanyUser->delete();
        }
    }

    public function findAll(): Collection
    {
        return EloquentCompanyUser::all()->map(fn($user) => $this->mapEloquentToDomain($user));
    }

    public function findByCompanyId(int $companyId): Collection
    {
        return EloquentCompanyUser::where('company_id', $companyId)->get()->map(fn($user) => $this->mapEloquentToDomain($user));
    }

    public function countByCompanyId(int $companyId): int
    {
        return EloquentCompanyUser::where('company_id', $companyId)->count();
    }

    private function mapEloquentToDomain(EloquentCompanyUser $eloquentCompanyUser): DomainCompanyUser
    {
        return new DomainCompanyUser(
            $eloquentCompanyUser->id,
            $eloquentCompanyUser->company_id,
            $eloquentCompanyUser->name,
            $eloquentCompanyUser->email,
            null, // We don't map the hashed password back to the domain entity usually
            $eloquentCompanyUser->created_at,
            $eloquentCompanyUser->updated_at
        );
    }
    }
}