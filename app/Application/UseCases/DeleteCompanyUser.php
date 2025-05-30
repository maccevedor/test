<?php

namespace App\Application\UseCases;

use App\Application\DTOs\DeleteCompanyUserCommand;
use App\Domain\Exceptions\CompanyUserNotFoundException;
use App\Domain\Repositories\CompanyUserRepository;

class DeleteCompanyUser
{
    private $companyUserRepository;

    public function __construct(CompanyUserRepository $companyUserRepository)
    {
        $this->companyUserRepository = $companyUserRepository;
    }

    public function execute(DeleteCompanyUserCommand $command): void
    {
        $user = $this->companyUserRepository->findById($command->getId());

        if (!$user || $user->company_id !== $command->getCompanyId()) {
            throw new CompanyUserNotFoundException("Company user with ID {$command->getId()} not found or does not belong to company {$command->getCompanyId()}.");
        }

        $this->companyUserRepository->delete($user);
    }
}