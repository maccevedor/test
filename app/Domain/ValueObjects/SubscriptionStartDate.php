<?php

namespace App\Domain\ValueObjects;

use DateTimeImmutable;

class SubscriptionStartDate
{
    private DateTimeImmutable $startDate;

    public function __construct(DateTimeImmutable $startDate)
    {
        $this->startDate = $startDate;
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function equals(SubscriptionStartDate $other): bool
    {
        return $this->startDate == $other->getStartDate();
    }
}