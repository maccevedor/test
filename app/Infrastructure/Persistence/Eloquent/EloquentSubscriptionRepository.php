<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\SubscriptionRepository;
use App\Models\Subscription;

class EloquentSubscriptionRepository implements SubscriptionRepository
{
    public function findById(int $id): ?Subscription
    {
        return Subscription::find($id);
    }

    public function save(Subscription $subscription): void
    {
        $subscription->save();
    }

    public function delete(Subscription $subscription): void
    {
        $subscription->delete();
    }

    public function findActiveSubscriptionForCompany(int $companyId): ?Subscription
    {
        return Subscription::where('company_id', $companyId)
                           ->where('status', 'active')
                           ->first();
    }
}