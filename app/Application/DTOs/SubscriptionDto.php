php
<?php

namespace App\Application\DTOs;

use App\Domain\Entities\Subscription;
use Carbon\Carbon;

class SubscriptionDto
{
    public function __construct(
        public ?int $id,
        public int $company_id,
        public int $plan_id,
        public Carbon $start_date,
        public ?Carbon $end_date,
        public string $status,
        public ?Carbon $created_at,
        public ?Carbon $updated_at
    ) {
    }

    /**
     * Create a SubscriptionDto from a Subscription Entity.
     *
     * @param Subscription $subscription The Subscription Entity instance.
     * @return self
     */
    public static function fromEntity(Subscription $subscription): self
    {
        return new self(
            $subscription->getId(),
            $subscription->getCompanyId(),
            $subscription->getPlanId(),
            $subscription->getStartDate(),
            $subscription->getEndDate(),
            $subscription->getStatus(),
            $subscription->getCreatedAt(),
            $subscription->getUpdatedAt()
        );
    }
}