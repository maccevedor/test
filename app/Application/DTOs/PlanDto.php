<?php

namespace App\Application\DTOs;

use App\Domain\Entities\Plan;
use Carbon\Carbon;

class PlanDto
{
    public ?int $id;
    public string $name;
    public float $price;
    public int $user_limit;
    public ?array $features;
    public ?Carbon $created_at;
    public ?Carbon $updated_at;

    public function __construct(
        ?int $id,
        string $name,
        float $price,
        int $user_limit,
        ?array $features,
        ?Carbon $created_at,
        ?Carbon $updated_at
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->user_limit = $user_limit;
        $this->features = $features;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function fromEntity(Plan $plan): self
    {
        return new self(
            $plan->getId(),
            $plan->getName(),
            $plan->getPrice(),
            $plan->getUserLimit(),
            $plan->getFeatures(),
            $plan->getCreatedAt(),
            $plan->getUpdatedAt()
        );
    }
}