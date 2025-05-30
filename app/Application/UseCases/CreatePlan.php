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
        $plan = new Plan(
            $command->name,
            $command->price,
            $command->user_limit,
            $command->features
        );

        $createdPlan = $this->planRepository->save($plan);

        return new PlanDto(
            $createdPlan->getId(),
            $createdPlan->getName(),
            $createdPlan->getPrice(),
            $createdPlan->getUserLimit(),
            $createdPlan->getFeatures(),
            $createdPlan->getCreatedAt(),
            $createdPlan->getUpdatedAt()
        );
    }
}