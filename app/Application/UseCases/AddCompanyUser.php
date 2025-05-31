<?php

namespace App\Application\UseCases;

use App\Application\DTOs\AddCompanyUserCommand;
use App\Application\DTOs\CompanyUserDto;
use App\Domain\Repositories\CompanyRepository;
use App\Domain\Repositories\CompanyUserRepository;
use App\Domain\Repositories\SubscriptionRepository;
use App\Domain\Exceptions\CompanyNotFoundException;
use App\Domain\Exceptions\SubscriptionNotFoundException;
use App\Domain\Exceptions\UserLimitExceededException;
use App\Domain\Aggregates\Company;
use App\Domain\Entities\CompanyUser;
use App\Domain\Aggregates\Company;
use App\Domain\Entities\Subscription;
use App\Domain\ValueObjects\UserEmail;
use App\Domain\ValueObjects\UserName;
class AddCompanyUser
{
    private CompanyRepository $companyRepository;
    private CompanyUserRepository $companyUserRepository;
    private SubscriptionRepository $subscriptionRepository;

    public function __construct(
        CompanyRepository $companyRepository, 
        CompanyUserRepository $companyUserRepository, 
        SubscriptionRepository $subscriptionRepository
    ) {
        $this->companyRepository = $companyRepository;
        $this->companyUserRepository = $companyUserRepository;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function execute(AddCompanyUserCommand $command): CompanyUserDto
    {
        // Find the company
        $company = $this->companyRepository->findById($command->company_id);

        if (!$company) {
            throw new CompanyNotFoundException("Company with ID {$command->company_id} not found.");
        }

        // Find the company's active subscription
        $activeSubscription = $this->subscriptionRepository->findActiveByCompanyId($company->getId());

        if (!$activeSubscription) {
            throw new SubscriptionNotFoundException("Company with ID {$command->company_id} does not have an active subscription.");
        }

        // Get the plan associated with the active subscription
        // Assuming Subscription entity has a getPlanId() method
        // This requires PlanRepository injection or accessing plan from Subscription
        // Assuming Subscription entity has a getPlan() method that returns the Plan entity
        $plan = $activeSubscription->getPlan();

        // Check if adding a new user exceeds the plan's user limit
        $currentUserCount = $this->companyUserRepository->countByCompanyId($company->getId());

        if ($currentUserCount >= $plan->getUserLimit()) { // Assuming Plan::getUserLimit returns the integer directly
            throw new UserLimitExceededException("User limit of {$plan->getUserLimit()} exceeded for company ID {$company->getId()}.");
        }

        // Create the CompanyUser entity (assuming entities are created with Value Objects)
        $companyUser = new \App\Domain\Entities\CompanyUser(
            null, // ID is null for new user
            new \App\Domain\ValueObjects\UserEmail($command->email),
            new \App\Domain\ValueObjects\UserPassword(\Illuminate\Support\Facades\Hash::make($command->password))
        );

        // Save the new user
        $this->companyUserRepository->save($companyUser);

        // Return the CompanyUserDto
        return new CompanyUserDto(
            $companyUser->getId(), // ID is set after save by the repository
            $companyUser->getCompanyId(),
            $companyUser->getName()->getValue(),
            $companyUser->getEmail()->getValue(),
            $companyUser->getCreatedAt(),
            $companyUser->getUpdatedAt()
        );
    }
}