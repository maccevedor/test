<?php

    namespace App\Application\UseCases;

    use App\Application\DTOs\RegisterCompanyCommand;
    use App\Application\DTOs\CompanyDto;
    use App\Domain\Repositories\CompanyRepository;
    use App\Domain\Aggregates\Company; // Import the Company Aggregate

    class RegisterCompany
    {
        private CompanyRepository $companyRepository;

        public function __construct(CompanyRepository $companyRepository)
        {
            $this->companyRepository = $companyRepository;
        }

        public function execute(RegisterCompanyCommand $command): CompanyDto
        {
            // 1. Create a new Company Aggregate instance using its constructor
            // Assuming your Company constructor is like: public function __construct(?int $id, string $name)
            // For a new company, the ID is null initially
            $company = new Company(null, $command->name); // Assuming $command->name holds the company name

            // 2. Use the Repository to save the Company Aggregate
            $this->companyRepository->save($company);

            // 3. Retrieve the saved company to get its ID (since save is void) and return a DTO
            // This might require finding the company by its unique name after saving,
            // or if your save implementation sets the ID on the passed object, use that.
            // A more robust solution would be for save to return the persisted aggregate.
            // Given the interface is void, finding by name is one option, or
            // alternatively, adjust the interface and implementation of save.
            // For simplicity in fixing this error, let's assume save modifies the object or you find by name.
            // A better approach is to have `save` return the persisted aggregate.
            // Let's adjust the save method signature in the interface and implementation.

            // ***Correction: Let's revisit the save method signature to return the Aggregate***
            // It's better for the repository's save method to return the persisted aggregate
            // so the Use Case doesn't have to refetch.

            // Assuming you change CompanyRepository::save to:
            // public function save(Company $company): Company;

            // And EloquentCompanyRepository::save to match.

            // Then the Use Case would be:

            // $persistedCompany = $this->companyRepository->save($company);
            // return CompanyDto::fromEntity($persistedCompany);


            // **If we stick to the void save for now (less ideal but matches the error context):**
            // You'd need a way to get the full company with ID after saving.
            // Finding by name might work if names are guaranteed unique immediately after save.
            // This is less ideal in a concurrent environment.
            // Let's assume for the sake of fixing this error that your Eloquent save updates the object passed by reference (PHP objects are passed by reference by default in this context).

             // After $this->companyRepository->save($company);
             // $company now has the ID set by Eloquent if your repository does that.

            return CompanyDto::fromEntity($company); // Assuming fromEntity can map from the updated Company Aggregate
        }
    }
