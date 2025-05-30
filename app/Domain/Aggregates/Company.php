<?php

namespace App\Domain\Aggregates;

use Carbon\Carbon; // Assuming you use Carbon for timestamps

class Company
{
    private ?int $id;
    private string $name;
    private ?Carbon $created_at; // Add created_at property
    private ?Carbon $updated_at; // Add updated_at property

    public function __construct(?int $id, string $name, ?Carbon $created_at = null, ?Carbon $updated_at = null) // Update constructor
    {
        $this->id = $id;
        $this->name = $name;
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

    public function getCreatedAt(): ?Carbon // Add getter for created_at
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?Carbon // Add getter for updated_at
    {
        return $this->updated_at;
    }

    // Method to set ID after persistence (often done by repository)
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    // Methods to set timestamps after persistence (often done by repository)
    public function setTimestamps(Carbon $createdAt, Carbon $updatedAt): void
    {
        $this->created_at = $createdAt;
        $this->updated_at = $updatedAt;
    }

    // ... other methods or properties
}
