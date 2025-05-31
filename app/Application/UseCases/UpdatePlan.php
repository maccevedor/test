<?php

namespace App\Application\UseCases;

use App\Application\DTOs\UpdatePlanCommand;
use App\Application\DTOs\PlanDto;
use App\Domain\Repositories\PlanRepository;
use App\Domain\Exceptions\PlanNotFoundException;
use App\Domain\Entities\Plan;

class UpdatePlan
{
    private $planRepository;

    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function execute(UpdatePlanCommand $command): PlanDto
    {
        // Logic to update the plan using the repository
        $plan = $this->planRepository->findById($command->id);

        if (!$plan) {
            throw new PlanNotFoundException("Plan with ID {$command->id} not found.");
        }

        // Assuming Plan entity has setter methods (recommended) or public properties
        $plan->setName($command->name);
        $plan->setPrice($command->price);
        $plan->setUserLimit($command->user_limit);
        $plan->setFeatures($command->features);

        $persistedPlan = $this->planRepository->save($plan);

        return PlanDto::fromEntity($persistedPlan);
    }
}