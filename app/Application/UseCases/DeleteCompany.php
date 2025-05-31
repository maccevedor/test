<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\CompanyRepository;
use App\Domain\Exceptions\CompanyNotFoundException;

class DeleteCompany
{
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function execute(int $companyId): void // Use Case still takes the ID as input
    {
        // 1. Find the Company Aggregate using the repository
        $company = $this->companyRepository->findById($companyId);

        // 2. Check if the company exists
        if (!$company) {
            // Throw an exception if the company is not found
            throw new CompanyNotFoundException("Company with ID {$companyId} not found.");
        }

        // 3. Pass the Company Aggregate instance to the repository's delete method
        $this->companyRepository->delete($company);
    }
}
