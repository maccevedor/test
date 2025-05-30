<?php

    namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\CompanyRepository;
use App\Domain\Aggregates\Company as DomainCompany;
use App\Models\Company as EloquentCompany;
use Illuminate\Support\Collection;
use Carbon\Carbon;

    class EloquentCompanyRepository implements CompanyRepository
    {
        private \App\Models\Company $model;

        public function __construct(\App\Models\Company $model)
        {
            $this->model = $model;
        }

        public function findById(int $id): ?DomainCompany
        {
            $eloquentCompany = EloquentCompany::find($id);

            if (!$eloquentCompany) {
                return null;
            }

            // Map Eloquent model to Domain Aggregate
            return $this->mapEloquentToDomain($eloquentCompany);
        }

    public function save(DomainCompany $company): DomainCompany // Ensure return type is DomainCompany
    {
        $eloquentCompany = $company->getId() ? EloquentCompany::find($company->getId()) : new EloquentCompany();

        $eloquentCompany->name = $company->getName();
        // ... map other properties from DomainCompany to EloquentCompany

        try {
            $eloquentCompany->save(); // Attempt to save
        } catch (\Exception $e) {
            // Log the error for debugging
            logger()->error('Error saving company: ' . $e->getMessage(), ['exception' => $e]);
            // Re-throw the exception or handle it as appropriate for your application
            throw $e;
        }


        // Set the ID and timestamps back on the DomainCompany aggregate
        $company->setId($eloquentCompany->id);
        $company->setTimestamps($eloquentCompany->created_at, $eloquentCompany->updated_at);

        return $company; // *** CRITICAL: Ensure this line is present and returns $company ***
    }

    // Method to map Eloquent model to Domain Aggregate
        private function mapEloquentToDomain(EloquentCompany $eloquentCompany): DomainCompany
        {
            return new DomainCompany(
                $eloquentCompany->id,
                $eloquentCompany->name,
                $eloquentCompany->created_at, // Map created_at
                $eloquentCompany->updated_at // Map updated_at
            );
        }

        public function findAll(): array
        {
            $eloquentCompanies = EloquentCompany::all();

            return $eloquentCompanies->map(function (EloquentCompany $eloquentCompany) {
                return $this->mapEloquentToDomain($eloquentCompany); // Returns DomainCompany objects
            })->all(); // This converts the collection to an array
        }

        public function delete(DomainCompany $company): void
        {
        $eloquentCompany = EloquentCompany::find($company->getId()); // Assuming getId() exists

        if ($eloquentCompany) {
            $eloquentCompany->delete();
        }
        // Optionally, handle the case where the company is not found if needed
        }



        // ... other methods
    }
