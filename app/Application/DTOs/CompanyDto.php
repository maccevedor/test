<?php

namespace App\Application\DTOs;

use App\Domain\Aggregates\Company; // Import the Company Aggregate
use Carbon\Carbon; // Assuming you're using Carbon for timestamps

class CompanyDto
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?Carbon $created_at,
        public ?Carbon $updated_at
    ) {}

    /**
     * Create a CompanyDto from a Company Aggregate.
     *
     * @param Company $company The Company Aggregate instance.
     * @return self
     */
    public static function fromEntity(Company $company): self
    {
        return new self(
            $company->getId(), // Assuming getId() method exists on Company Aggregate
            $company->getName(), // Assuming getName() method exists on Company Aggregate
            $company->getCreatedAt(), // Assuming getCreatedAt() method exists
            $company->getUpdatedAt() // Assuming getUpdatedAt() method exists
        );
    }

    // ... other methods or properties
}
