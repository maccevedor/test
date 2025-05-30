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

    public function execute(int $companyId): void
    {
        $company = $this->companyRepository->findById($companyId);
        if (!$company) {
            throw new CompanyNotFoundException("Company with ID {$companyId} not found.");
        }
        $this->companyRepository->delete($companyId);
    }
}