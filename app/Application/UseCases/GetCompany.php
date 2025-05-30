<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\CompanyRepository;
use App\Domain\Exceptions\CompanyNotFoundException;
use App\Application\DTOs\CompanyDto;

class GetCompany
{
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function execute(int $companyId): CompanyDto
    {
        $company = $this->companyRepository->findById($companyId);

        if ($company === null) {
            return null;
        }

        return new CompanyDto(
            $company->id,
            $company->name,
            $company->created_at,
            $company->updated_at
        );
    }
}