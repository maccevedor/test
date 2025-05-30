<?php

namespace App\Application\DTOs;

class CreatePlanCommand
{
    public function __construct(
        public string $name,
        public float $price,
        public int $user_limit,
        public ?array $features = null
    ) {
    }
}