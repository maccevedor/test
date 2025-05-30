<?php

namespace App\Application\UseCases;

use App\Application\DTOs\RegisterCompanyCommand;
use App\Application\DTOs\CompanyDto;
use App\Domain\Repositories\CompanyRepository;
use App\Domain\Aggregates\Company;

class RegisterCompany
{
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function execute(RegisterCompanyCommand $command): CompanyDto
    {
        $company = new Company(null, $command->name); // Creates a new Company Aggregate (Line 24)

        // This is likely the new line 26:
        $persistedCompany = $this->companyRepository->save($company); // Saves and returns the aggregate

        return CompanyDto::fromEntity($persistedCompany); // Calling fromEntity with $persistedCompany (Line 27)
    }


}
