<?php

namespace App\Application\DTOs;

use App\Domain\Entities\CompanyUser;
use Carbon\Carbon;

class CompanyUserDto
{
    public function __construct(
        public ?int $id,
        public int $company_id,
        public string $name,
        public string $email,
        public ?Carbon $created_at,
        public ?Carbon $updated_at
    ) {
    }

    /**
     * Create a CompanyUserDto from a CompanyUser Entity.
     *
     * @param CompanyUser $companyUser The CompanyUser Entity instance.
     * @return self
     */
    public static function fromEntity(CompanyUser $companyUser): self
    {
        return new self(
            $companyUser->getId(),
            $companyUser->getCompanyId(),
            $companyUser->getName(),
            $companyUser->getEmail(),
            $companyUser->getCreatedAt(),
            $companyUser->getUpdatedAt()
        );
    }
}
        $this->company_id = $company_id;
        $this->name = $name;
        $this->email = $email;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}