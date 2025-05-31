<?php

namespace App\Application\UseCases;

use App\Application\DTOs\CancelCompanySubscriptionCommand;
use App\Domain\Repositories\SubscriptionRepository;
use App\Domain\Exceptions\SubscriptionNotFoundException;

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

        // Throw SubscriptionNotFoundException if no active subscription is found
        if (!$subscription) {
            throw new SubscriptionNotFoundException('Active subscription not found for this company.');
        }

        // Assuming your Subscription entity has a method to cancel the subscription
        // This encapsulates the domain logic within the entity
        $subscription->cancel($command->end_date);

        $subscription->end_date = $command->end_date;

        $this->subscriptionRepository->save($subscription);
    }
}