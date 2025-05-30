<?php

    namespace App\Infrastructure\Persistence\Eloquent;

    use App\Domain\Repositories\CompanyRepository;
    use App\Domain\Aggregates\Company as DomainCompany; // Alias for clarity
    use App\Models\Company as EloquentCompany; // Alias for clarity

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

        public function save(DomainCompany $company): void // Matching the interface signature
        {
            // Map Domain Aggregate to Eloquent model
            $eloquentCompany = EloquentCompany::find($company->getId()); // Assuming getId() exists on DomainCompany

            if (!$eloquentCompany) {
                $eloquentCompany = new EloquentCompany();
            }

            // Populate Eloquent model from Domain Aggregate
            $eloquentCompany->name = $company->getName(); // Assuming getName() exists on DomainCompany
            // ... map other properties

            $eloquentCompany->save();
        }

        // Method to map Eloquent model to Domain Aggregate
        private function mapEloquentToDomain(EloquentCompany $eloquentCompany): DomainCompany
        {
            // Implement the mapping logic here
            // Create a new DomainCompany instance and populate its properties from the Eloquent model
            return new DomainCompany(
                $eloquentCompany->id,
                $eloquentCompany->name
                // ... map other properties
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
