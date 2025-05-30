<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\CompanyRepository;
use App\Domain\Entities\Company;
use App\Application\DTOs\RegisterCompanyCommand;
use App\Application\DTOs\CompanyDto;

class RegisterCompany
{
    private CompanyRepository $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function execute(RegisterCompanyCommand $command): CompanyDto
    {
        $company = Company::create(['name' => $command->name]); // Assuming Company model has fillable 'name'
        $this->companyRepository->save($company);
        return new CompanyDto($company->id, $company->name, $company->created_at, $company->updated_at);

        // Placeholder return
        return new CompanyDto(1, $command->name, now(), now());
    }
}