<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\PlanRepository;
use App\Domain\Entities\Plan;
use App\Application\DTOs\PlanDto;
use App\Domain\Exceptions\PlanNotFoundException;

class GetPlan
{
    private PlanRepository $planRepository;

    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function execute(int $planId): PlanDto
    {
        /** @var Plan|null $plan */
        $plan = $this->planRepository->findById($planId);

        if (is_null($plan)) {
            throw new PlanNotFoundException("Plan with ID {$planId} not found.");
        }

        // Assuming PlanDto has a fromEntity method
        return PlanDto::fromEntity($plan);
    }
}