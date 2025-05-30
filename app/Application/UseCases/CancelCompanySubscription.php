<?php

namespace App\Application\UseCases;

use App\Application\DTOs\CancelCompanySubscriptionCommand;
use App\Domain\Entities\Subscription; // Assuming you have a Subscription entity
use App\Domain\Repositories\SubscriptionRepository;

class CancelCompanySubscription
{
    private SubscriptionRepository $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function execute(CancelCompanySubscriptionCommand $command): void
    {
        $subscription = $this->subscriptionRepository->findActiveByCompanyId($command->company_id);

        if (!$subscription) {
            throw new \Exception('Active subscription not found for this company.');
        }

        $subscription->status = 'cancelled';
        $subscription->end_date = $command->end_date;

        $this->subscriptionRepository->save($subscription);
    }
}