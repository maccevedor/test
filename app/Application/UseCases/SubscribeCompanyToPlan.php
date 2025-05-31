<?php

namespace App\Application\UseCases;

use App\Application\DTOs\SubscribeCompanyToPlanCommand;
use App\Domain\Repositories\CompanyRepository;
use App\Domain\Repositories\PlanRepository;
use App\Domain\Entities\Subscription;
use App\Domain\Exceptions\CompanyNotFoundException;
use App\Domain\Exceptions\PlanNotFoundException;
use App\Domain\Exceptions\SubscriptionAlreadyActiveException;
use App\Domain\Repositories\SubscriptionRepository;

class SubscribeCompanyToPlan
{
    private CompanyRepository $companyRepository;
    private PlanRepository $planRepository;
    private SubscriptionRepository $subscriptionRepository;

    public function __construct(
        CompanyRepository $companyRepository,
        PlanRepository $planRepository,
        SubscriptionRepository $subscriptionRepository
    ) {
        $this->companyRepository = $companyRepository;
        $this->planRepository = $planRepository;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function execute(SubscribeCompanyToPlanCommand $command): void
    {
        $company = $this->companyRepository->findById($command->company_id);
        if (null === $company) {
            throw new CompanyNotFoundException("Company with ID {$command->company_id} not found.");
        }

        $plan = $this->planRepository->findById($command->plan_id);
        if (null === $plan) {
            throw new PlanNotFoundException("Plan with ID {$command->plan_id} not found.");
        }

        // Check if the company already has an active subscription
        $activeSubscription = $this->subscriptionRepository->findActiveByCompanyId($command->company_id);
        if (null !== $activeSubscription) {
            throw new SubscriptionAlreadyActiveException("Company with ID {$command->company_id} already has an active subscription.");
        }

        $subscription = new Subscription(null, $company->getId(), $plan->getId(), $command->start_date, null, 'active');

        $this->subscriptionRepository->save($subscription);
    }
}