<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class Features
{
    private array $features;

    public function __construct(array $features)
    {
        // Basic validation: ensure features are an array
        // More specific validation can be added based on feature format if needed
        if (!is_array($features)) {
            throw new InvalidArgumentException('Features must be an array.');
        }

        $this->features = $features;
    }

    public function get(): array
    {
        return $this->features;
    }

    public function toJson(): string
    {
        return json_encode($this->features);
    }

    public function equals(Features $other): bool
    {
        return $this->features === $other->features;
    }
}