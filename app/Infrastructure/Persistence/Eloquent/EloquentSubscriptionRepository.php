<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Repositories\SubscriptionRepository;
use App\Domain\Entities\Subscription as DomainSubscription;
use App\Domain\Repositories\SubscriptionRepository;
use App\Models\Subscription as EloquentSubscription;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class EloquentSubscriptionRepository implements SubscriptionRepository
{
    public function findById(int $id): ?DomainSubscription
    {
        $eloquentSubscription = EloquentSubscription::find($id);

        return $eloquentSubscription ? $this->mapEloquentToDomain($eloquentSubscription) : null;
    }

    public function save(DomainSubscription $subscription): DomainSubscription
    {
        $eloquentSubscription = $subscription->getId() ? EloquentSubscription::find($subscription->getId()) : new EloquentSubscription();

        $eloquentSubscription->company_id = $subscription->getCompanyId();
        $eloquentSubscription->plan_id = $subscription->getPlanId();
        $eloquentSubscription->start_date = $subscription->getStartDate();
        $eloquentSubscription->end_date = $subscription->getEndDate();
        $eloquentSubscription->status = $subscription->getStatus();

        $eloquentSubscription->save();

        // Set the ID and timestamps back on the DomainSubscription entity
        $subscription->setId($eloquentSubscription->id);
        $subscription->setTimestamps($eloquentSubscription->created_at, $eloquentSubscription->updated_at);

        return $subscription; // Return the updated DomainSubscription entity
    }

    public function delete(DomainSubscription $subscription): void
    {
        EloquentSubscription::where('id', $subscription->getId())->delete();
    }

    public function findAll(): Collection
    {
        $eloquentSubscriptions = EloquentSubscription::all();

        return $eloquentSubscriptions->map(function ($eloquentSubscription) {
            return $this->mapEloquentToDomain($eloquentSubscription);
        });
    }

    public function findActiveByCompanyId(int $companyId): ?DomainSubscription
    {
        $eloquentSubscription = EloquentSubscription::where('company_id', $companyId)
                           ->where('status', 'active')
                           ->first();

        return $eloquentSubscription ? $this->mapEloquentToDomain($eloquentSubscription) : null;
    }

    private function mapEloquentToDomain(EloquentSubscription $eloquentSubscription): DomainSubscription
    {
        return new DomainSubscription($eloquentSubscription->id, $eloquentSubscription->company_id, $eloquentSubscription->plan_id, $eloquentSubscription->start_date, $eloquentSubscription->end_date, $eloquentSubscription->status, $eloquentSubscription->created_at, $eloquentSubscription->updated_at);
    }
    }
}