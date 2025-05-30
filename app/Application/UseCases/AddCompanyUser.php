<?php

namespace App\Application\UseCases;

use App\Application\DTOs\AddCompanyUserCommand;
use App\Application\DTOs\CompanyUserDto;
use App\Domain\Repositories\CompanyRepository;
use App\Domain\Repositories\CompanyUserRepository;
use App\Domain\Repositories\SubscriptionRepository;
use App\Domain\Repositories\PlanRepository;
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
            throw new \Exception("Company not found."); // Or a custom exception
        }

        // Find the company's active subscription
        $activeSubscription = $this->subscriptionRepository->findActiveByCompanyId($company->getId());

        if (!$activeSubscription) {
            throw new \Exception("Company does not have an active subscription."); // Or a custom exception
        }

        // Get the plan associated with the active subscription
        // Assuming Subscription entity has a getPlanId() method
        $plan = $this->planRepository->findById($activeSubscription->getPlanId());

        // Check if adding a new user exceeds the plan's user limit
        $currentUserCount = $this->companyUserRepository->countByCompanyId($company->getId());

        if ($currentUserCount >= $plan->getUserLimit()->getValue()) {
            throw new \Exception("User limit exceeded for this company's plan."); // Or a custom exception
        }

        // Create the CompanyUser entity (assuming entities are created with Value Objects)
        $companyUser = $company->addUser(
            // Assuming Company entity has an addUser method
            new UserName($command->name),
            new \App\Domain\ValueObjects\UserEmail($command->email),
            new \App\Domain\ValueObjects\UserPassword(\Illuminate\Support\Facades\Hash::make($command->password))
        );

        // Save the new user
        $this->companyUserRepository->save($companyUser);

        // Return the CompanyUserDto
        return new CompanyUserDto(
            $companyUser->getId(),
            $companyUser->getCompanyId(),
            $companyUser->getName()->getValue(),
            $companyUser->getEmail()->getValue(),
            $companyUser->getCreatedAt(),
            $companyUser->getUpdatedAt()
        );
    }
}