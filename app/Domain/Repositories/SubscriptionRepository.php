<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Subscription;
use App\Domain\Entities\Company;
use DateTimeInterface;

interface SubscriptionRepository
{
    public function findById(int $id): ?Subscription;

    public function save(Subscription $subscription): void;

    public function delete(Subscription $subscription): void;

    public function findActiveSubscriptionForCompany(Company $company, ?DateTimeInterface $date = null): ?Subscription;

    public function findSubscriptionsForCompany(Company $company): array;
}