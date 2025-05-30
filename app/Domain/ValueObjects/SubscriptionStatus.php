<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class SubscriptionStatus
{
    private string $status;

    private const VALID_STATUSES = [
        'active',
        'cancelled',
        'expired',
        'pending',
    ];

    public function __construct(string $status)
    {
        if (!in_array($status, self::VALID_STATUSES)) {
            throw new InvalidArgumentException(sprintf('Invalid subscription status: %s', $status));
        }

        $this->status = $status;
    }

    public function getValue(): string
    {
        return $this->status;
    }

    public function equals(SubscriptionStatus $other): bool
    {
        return $this->status === $other->status;
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isExpired(): bool
    {
        return $this->status === 'expired';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}