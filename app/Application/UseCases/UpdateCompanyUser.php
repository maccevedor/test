<?php

namespace App\Application\UseCases;

use App\Application\DTOs\UpdateCompanyUserCommand;
use App\Application\Exceptions\CompanyUserNotFoundException;
use App\Application\DTOs\CompanyUserDto;
use App\Domain\Repositories\CompanyUserRepository;

class UpdateCompanyUser
{
    private $companyUserRepository;

    public function __construct(CompanyUserRepository $companyUserRepository)
    {
        $this->companyUserRepository = $companyUserRepository;
    }

    public function execute(UpdateCompanyUserCommand $command): CompanyUserDto
    {
        // Find the company user by ID and company ID
        $companyUser = $this->companyUserRepository->findByIdAndCompanyId($command->id, $command->company_id);

        if (!$companyUser) {
            throw new CompanyUserNotFoundException("Company user with ID {$command->id} not found for company ID {$command->company_id}.");
        }

        // Update the company user properties based on the command DTO
        $companyUser->name = $command->name;
        $companyUser->email = $command->email;

        // Only update password if it's provided in the command
        if ($command->password !== null) {
            // Hash the password before saving (implementation depends on your hashing strategy)
            $companyUser->password = bcrypt($command->password); // Example hashing
        }

        // Save the updated company user
        $this->companyUserRepository->save($companyUser);

        // Return the updated company user as a DTO
        return new CompanyUserDto(
            $companyUser->id,
            $companyUser->company_id,
            $companyUser->name,
            $companyUser->email,
            $companyUser->created_at,
            $companyUser->updated_at
        );
    }
}