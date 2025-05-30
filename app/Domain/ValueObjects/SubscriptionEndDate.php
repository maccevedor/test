<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use Carbon\CarbonImmutable;
use InvalidArgumentException;

final class SubscriptionEndDate
{
    private ?CarbonImmutable $endDate;

    public function __construct(?string $endDate = null)
    {
        if ($endDate !== null) {
            try {
                $this->endDate = CarbonImmutable::parse($endDate);
            } catch (\Exception $e) {
                throw new InvalidArgumentException("Invalid subscription end date format: {$endDate}");
            }
        } else {
            $this->endDate = null;
        }
    }

    public static function fromString(?string $endDate = null): self
    {
        return new self($endDate);
    }

    public function getValue(): ?CarbonImmutable
    {
        return $this->endDate;
    }

    public function isNull(): bool
    {
        return $this->endDate === null;
    }

    public function __toString(): string
    {
        return $this->endDate ? $this->endDate->toDateString() : '';
    }
}