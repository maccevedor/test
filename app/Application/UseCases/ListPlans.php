<?php

namespace App\Application\UseCases;

use App\Domain\Repositories\PlanRepository;
use App\Application\DTOs\PlanDto;

class ListPlans
{
    private PlanRepository $planRepository;

    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function execute(): array
    {
        $plans = $this->planRepository->findAll();

        // Map each Plan entity to a PlanDto
        return $plans->map(fn($plan) => PlanDto::fromEntity($plan))->all();
    }
}