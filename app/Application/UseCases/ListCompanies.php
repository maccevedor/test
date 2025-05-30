<?php

namespace App\Application\UseCases;

use App\Application\DTOs\CompanyDto;
use App\Domain\Repositories\CompanyRepository;

class ListCompanies
{
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function execute(): array
    {
        $companies = $this->companyRepository->findAll(); // $companies is an array of DomainCompany

        $companyDtos = [];
        foreach ($companies as $company) {
            $companyDtos[] = CompanyDto::fromEntity($company); // Assuming fromEntity can take DomainCompany
        }

        return $companyDtos; // Return an array of CompanyDto
    }
}