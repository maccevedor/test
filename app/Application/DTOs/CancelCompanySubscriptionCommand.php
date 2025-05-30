<?php

namespace App\Application\DTOs;

use Carbon\Carbon;

class CancelCompanySubscriptionCommand
{
    public function __construct(
        public int $company_id,
        public Carbon $end_date
    ) {
    }
}