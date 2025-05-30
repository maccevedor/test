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

        // Create a new Company instance with the updated name
        $updatedCompany = new \App\Domain\Aggregates\Company(
            $company->getId(),
            $command->name,
            $company->getCreatedAt(),
            $company->getUpdatedAt()
        );
        
        $this->companyRepository->save($updatedCompany);

        // Return a CompanyDto with the updated company data
        return new CompanyDto(
            $updatedCompany->getId(),
            $updatedCompany->getName(),
            $updatedCompany->getCreatedAt(),
            $updatedCompany->getUpdatedAt()
        );
    }
}