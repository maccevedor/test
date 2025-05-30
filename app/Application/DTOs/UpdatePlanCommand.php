<?php

namespace App\Application\DTOs;

class UpdatePlanCommand
{
    public int $id;
    public string $name;
    public float $price;
    public int $user_limit;
    public ?array $features;

    public function __construct(int $id, string $name, float $price, int $user_limit, ?array $features = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->user_limit = $user_limit;
        $this->features = $features;
    }
}