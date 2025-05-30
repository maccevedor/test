<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\PlanRepository;

class DeletePlan
{
    private PlanRepository $planRepository;

    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function execute(int $planId): void
    {
        $plan = $this->planRepository->findById($planId);
        if (!$plan) {
            throw new \Exception('Plan not found'); // Example: throw an exception
        }
        $this->planRepository->delete($plan);
    }
}