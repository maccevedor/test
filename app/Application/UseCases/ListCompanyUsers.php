<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\CompanyRepository;
use App\Domain\Repositories\CompanyUserRepository;
use App\Domain\Exceptions\CompanyNotFoundException;
use App\Application\DTOs\CompanyUserDto;

class ListCompanyUsers
{
    private $companyUserRepository;

    public function __construct(CompanyUserRepository $companyUserRepository)
    {    private $companyRepository;

    public function __construct(CompanyRepository $companyRepository, CompanyUserRepository $companyUserRepository)
    {
        $this->companyRepository = $companyRepository;
        $this->companyUserRepository = $companyUserRepository;
    }

    public function execute(int $companyId): array
    {
        $company = $this->companyRepository->findById($companyId);

    public function execute(int $companyId): array
    {
        $companyUsers = $this->companyUserRepository->findByCompanyId($companyId);

        $companyUserDtos = [];
        foreach ($companyUsers as $companyUser) {
            $companyUserDtos[] = new CompanyUserDto(
                $companyUser->id,
                $companyUser->company_id,
                $companyUser->name,
                $companyUser->email,
                $companyUser->created_at,
                $companyUser->updated_at
            );
        }

        return $companyUserDtos;
    }
}