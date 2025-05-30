<?php

namespace App\Infrastructure\Http\Controllers\Api;

use App\Application\UseCases\CancelCompanySubscription;
use App\Application\UseCases\SubscribeCompanyToPlan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SubscriptionController extends Controller
{
    private SubscribeCompanyToPlan $subscribeCompanyToPlan;
    private CancelCompanySubscription $cancelCompanySubscription;

    public function __construct(
        SubscribeCompanyToPlan $subscribeCompanyToPlan,
        CancelCompanySubscription $cancelCompanySubscription
    ) {
        $this->subscribeCompanyToPlan = $subscribeCompanyToPlan;
        $this->cancelCompanySubscription = $cancelCompanySubscription;
    }

    public function subscribe(Request $request): JsonResponse
    {
        // Implement logic to handle subscription request
        // - Validate input using a Form Request (e.g., SubscribeCompanyToPlanRequest)
        // - Create a SubscribeCompanyToPlanCommand DTO from validated data
        // - Call $this->subscribeCompanyToPlan->execute($command)
        // - Return a success or error JSON response

        return response()->json(['message' => 'Subscription logic not implemented'], 501);
    }

    public function cancel(Request $request): JsonResponse
    {
        // Implement logic to handle subscription cancellation request
        // - Validate input using a Form Request (e.g., CancelCompanySubscriptionRequest)
        // - Create a CancelCompanySubscriptionCommand DTO from validated data
        // - Call $this->cancelCompanySubscription->execute($command)
        // - Return a success or error JSON response

        return response()->json(['message' => 'Subscription cancellation logic not implemented'], 501);
    }
}