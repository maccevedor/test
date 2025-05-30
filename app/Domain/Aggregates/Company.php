<?php

namespace App\Domain\Aggregates;

class Company
{
    private ?int $id;
    private string $name;

    public function __construct(?int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    // You might add methods here for business logic related to a Company,
    // such as adding users, managing subscriptions (if Subscription is part of this aggregate), etc.
}