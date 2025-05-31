<?php

namespace App\Application\UseCases;

use App\Application\DTOs\CompanyUserDto;
use App\Domain\Exceptions\CompanyUserNotFoundException;
use App\Domain\Repositories\CompanyUserRepository;

class GetCompanyUser
{
    private $companyUserRepository;

    public function __construct(CompanyUserRepository $companyUserRepository)
    {
        $this->companyUserRepository = $companyUserRepository;
    }

    public function execute(int $userId, int $companyId): CompanyUserDto
    {
        $companyUser = $this->companyUserRepository->findByIdAndCompany($userId, $companyId);
        
        if (!$companyUser) {
 throw new CompanyUserNotFoundException("Company User with ID {$userId} not found for Company ID {$companyId}.");
 }

 return CompanyUserDto::fromEntity($companyUser);
    }
}