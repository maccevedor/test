<?php

namespace App\Application\UseCases;
use Illuminate\Support\Facades\Hash;
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
        // Find the company user by ID
        $companyUser = $this->companyUserRepository->findById($command->id);

        // Check if the user exists and belongs to the company
        $companyUser = $this->companyUserRepository->findByIdAndCompanyId($command->id, $command->company_id);

        if (!$companyUser) {
            throw new CompanyUserNotFoundException("Company user with ID {$command->id} not found for company ID {$command->company_id}.");
        }

        // Update the company user properties based on the command DTO
        $companyUser->name = $command->name;
        $companyUser->email = $command->email;

        // Only update password if it's provided in the command
        if ($command->password !== null) {
            $companyUser->password = Hash::make($command->password);
        }

        // Save the updated company user
        $this->companyUserRepository->save($companyUser);

        return CompanyUserDto::fromEntity($companyUser);
    }
}