<?php

namespace App\Application\UseCases;

use App\Application\DTOs\CreatePlanCommand;
use App\Application\DTOs\PlanDto;
use App\Domain\Repositories\PlanRepository;
use App\Domain\Entities\Plan;

class CreatePlan
{
    private $planRepository;

    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function execute(CreatePlanCommand $command): PlanDto
    {
        // Create a new Plan Entity instance using its constructor.
        // ID and timestamps are null initially as it's a new entity.
        $plan = new Plan(
            null, // ID is null for a new entity
            $command->name,
            $command->price,
            $command->user_limit,
            $command->features,
            null, // created_at is null for a new entity
            null  // updated_at is null for a new entity
        );

        // Use the Repository to save the Plan Entity and get the persisted entity back (with ID and timestamps).
        $createdPlan = $this->planRepository->save($plan);

        // Return a PlanDto created from the persisted Plan Entity.
        return PlanDto::fromEntity($createdPlan);
    }
}