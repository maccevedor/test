<?php

namespace App\Application\DTOs;

use DateTimeInterface;

class SubscribeCompanyToPlanCommand
{
    public function __construct(
        public int $company_id,
        public int $plan_id,
        public DateTimeInterface $start_date
    ) {
    }
}