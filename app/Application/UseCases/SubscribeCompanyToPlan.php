<?php

namespace App\Application\UseCases;

use App\Application\DTOs\SubscribeCompanyToPlanCommand;
use App\Domain\Repositories\CompanyRepository;
use App\Domain\Repositories\PlanRepository;
use App\Domain\Entities\Subscription;
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
        if (!$company) {
            throw new \DomainException('Company not found.');
        }

        $plan = $this->planRepository->findById($command->plan_id);
        if (!$plan) {
            throw new \DomainException('Plan not found.');
        }

        $subscription = new Subscription($company->id, $plan->id, $command->start_date, null, 'active');

        $this->subscriptionRepository->save($subscription);
    }
}