<?php

namespace App\Application\UseCases;

use App\Domain\Entities\Plan;
use App\Domain\Repositories\PlanRepository;
use App\Domain\Exceptions\PlanNotFoundException;

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
            throw new PlanNotFoundException("Plan with ID {$planId} not found.");
        }
        $this->planRepository->delete($plan);
    }
}