<?php

namespace App\Application\DTOs;

class PlanDto
{
    public int $id;
    public string $name;
    public float $price;
    public int $user_limit;
    public ?array $features;
    public string $created_at;
    public string $updated_at;

    public function __construct(
        int $id,
        string $name,
        float $price,
        int $user_limit,
        ?array $features,
        string $created_at,
        string $updated_at
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->user_limit = $user_limit;
        $this->features = $features;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}