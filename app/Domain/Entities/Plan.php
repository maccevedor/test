<?php

namespace App\Domain\Entities;

use Carbon\Carbon;

class Plan
{
    private ?int $id;
    private string $name;
    private float $price;
    private int $user_limit;
    private ?array $features;
    private ?Carbon $created_at;
    private ?Carbon $updated_at;

    public function __construct(
        ?int $id,
        string $name,
        float $price,
        int $user_limit,
        ?array $features = null,
        ?Carbon $created_at = null,
        ?Carbon $updated_at = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->user_limit = $user_limit;
        $this->features = $features;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getUserLimit(): int
    {
        return $this->user_limit;
    }

    public function getFeatures(): ?array
    {
        return $this->features;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setTimestamps(Carbon $createdAt, Carbon $updatedAt): void
    {
        $this->created_at = $createdAt;
        $this->updated_at = $updatedAt;
    }
}