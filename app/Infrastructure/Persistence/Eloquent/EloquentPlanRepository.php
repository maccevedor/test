<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\PlanRepository;
use App\Infrastructure\Persistence\Eloquent\Plan as EloquentPlan; // Alias Eloquent model to avoid naming conflicts
use App\Domain\Aggregates\Plan; // Assuming you have a Domain Plan aggregate

class EloquentPlanRepository implements PlanRepository
{
    protected EloquentPlan $model;

    public function __construct(EloquentPlan $model)
    {
        $this->model = $model;
    }

    public function findById(string $id): ?Plan
    {
        $eloquentPlan = $this->model->find($id);

        if (!$eloquentPlan) {
            return null;
        }

        // Map Eloquent model to Domain aggregate (you'll need a mapping logic)
        return $this->mapEloquentToDomain($eloquentPlan);
    }

    public function save(Plan $plan): void
    {
        $eloquentPlan = $this->model->find($plan->getId());

        if (!$eloquentPlan) {
            $eloquentPlan = new $this->model();
        }

        // Map Domain aggregate to Eloquent model (you'll need a mapping logic)
        $this->mapDomainToEloquent($plan, $eloquentPlan);

        $eloquentPlan->save();
    }

    public function delete(Plan $plan): void
    {
        $eloquentPlan = $this->model->find($plan->getId());

        if ($eloquentPlan) {
            $eloquentPlan->delete();
        }
    }

    public function findAll(): array
    {
        $eloquentPlans = $this->model->all();

        return $eloquentPlans->map(function ($eloquentPlan) {
            return $this->mapEloquentToDomain($eloquentPlan);
        })->all();
    }

    // You'll need to implement these mapping methods
    protected function mapEloquentToDomain(EloquentPlan $eloquentPlan): Plan
    {
        // Implement mapping logic from EloquentPlan to Domain\Aggregates\Plan
        // This will involve creating a new Domain\Aggregates\Plan instance
        // and populating it with data from the $eloquentPlan model.
        // Example (assuming Plan aggregate has a constructor like __construct($id, $name, $price, $userLimit, $features)):
         return new Plan(
             $eloquentPlan->id,
             $eloquentPlan->name,
             $eloquentPlan->price,
             $eloquentPlan->user_limit,
             json_decode($eloquentPlan->features, true) // Assuming features are stored as JSON
         );
    }

    protected function mapDomainToEloquent(Plan $plan, EloquentPlan $eloquentPlan): void
    {
        // Implement mapping logic from Domain\Aggregates\Plan to EloquentPlan
        $eloquentPlan->name = $plan->getName();
        $eloquentPlan->price = $plan->getPrice();
        $eloquentPlan->user_limit = $plan->getUserLimit();
        $eloquentPlan->features = json_encode($plan->getFeatures()); // Assuming features are an array
    }
}