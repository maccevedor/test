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
        // TODO: Implement execute() method to list all plans using PlanRepository
        return []; // Placeholder
    }
}