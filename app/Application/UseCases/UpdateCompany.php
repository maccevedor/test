<?php

namespace App\Application\UseCases;

use App\Application\DTOs\UpdateCompanyCommand;
use App\Application\DTOs\CompanyDto;
use App\Domain\Repositories\CompanyRepository;

class UpdateCompany
{
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function execute(UpdateCompanyCommand $command): CompanyDto
    {
        $company = $this->companyRepository->findById($command->id);

        if (!$company) {
            throw new \DomainException('Company not found.');
        }

        $company->name = $command->name;
        $this->companyRepository->save($company);

        // Return a CompanyDto
        return new CompanyDto(
            $company->id,
            $company->name,
            $company->created_at,
            $company->updated_at
        );
    }
}