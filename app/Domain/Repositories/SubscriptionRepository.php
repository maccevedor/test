<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Subscription;
use App\Domain\Entities\Company;

interface SubscriptionRepository
{
    public function findById(int $id): ?Subscription;

    public function save(Subscription $subscription): Subscription;

    public function delete(Subscription $subscription): void; // Keeping void for delete as per previous working pattern

    public function findActiveByCompanyId(int $companyId): ?Subscription;
}