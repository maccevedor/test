<?php

namespace App\Application\UseCases;

use App\Application\DTOs\UpdatePlanCommand;
use App\Application\DTOs\PlanDto;
use App\Application\DTOs\PlanDto;
use App\Domain\Repositories\PlanRepository;

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
            throw new \Exception("Plan not found."); // Or a more specific custom exception
        }

        $plan->name = $command->name;
        $plan->price = $command->price;
        $plan->user_limit = $command->user_limit;
        $plan->features = $command->features;

        $this->planRepository->save($plan);

        return new PlanDto($plan->id, $plan->name, $plan->price, $plan->user_limit, $plan->features, $plan->created_at, $plan->updated_at);
    }
}