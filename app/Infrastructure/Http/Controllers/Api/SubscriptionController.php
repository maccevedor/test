<?php

namespace App\Infrastructure\Http\Controllers\Api;

use App\Application\UseCases\CancelCompanySubscription;
use App\Application\DTOs\CancelCompanySubscriptionCommand;
use App\Application\UseCases\SubscribeCompanyToPlan;
use App\Application\DTOs\SubscribeCompanyToPlanCommand;
use App\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\SubscribeCompanyToPlanRequest;
use App\Infrastructure\Http\Requests\CancelCompanySubscriptionRequest;
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

    // ... (other methods like index, show, etc. if they exist)

    /**
     * Subscribe a company to a plan.
     */
    public function subscribe(Request $request): JsonResponse
    {
        $request = app(SubscribeCompanyToPlanRequest::class); // Validate input
        $validated = $request->validated();

        $command = new SubscribeCompanyToPlanCommand(
            $validated['company_id'],
            $validated['plan_id']
        );

        try {
            $this->subscribeCompanyToPlan->execute($command);
            return new JsonResponse(['message' => 'Company subscribed successfully.'], JsonResponse::HTTP_CREATED); // 201 Created
        } catch (\App\Domain\Exceptions\CompanyNotFoundException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND); // 404 Not Found
        } catch (\App\Domain\Exceptions\PlanNotFoundException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND); // 404 Not Found
        } catch (\Exception $e) { // Catch other potential business logic errors (like already subscribed)
             logger()->error('Error subscribing company: ' . $e->getMessage(), ['exception' => $e]);
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST); // 400 Bad Request for business rules
        }
    }

    /**
     * Cancel a company's subscription.
     */
    public function cancel(Request $request): JsonResponse
    {
        $request = app(CancelCompanySubscriptionRequest::class); // Validate input
        $validated = $request->validated();

        $command = new CancelCompanySubscriptionCommand($validated['company_id']);

        try {
            $this->cancelCompanySubscription->execute($command);
            return new JsonResponse(['message' => 'Company subscription cancelled successfully.'], JsonResponse::HTTP_OK); // 200 OK
        } catch (\App\Domain\Exceptions\CompanyNotFoundException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND); // 404 Not Found
        } catch (\App\Domain\Exceptions\SubscriptionNotFoundException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND); // 404 Not Found
        } catch (\Exception $e) { // Catch other potential business logic errors (like no active subscription)
             logger()->error('Error cancelling subscription: ' . $e->getMessage(), ['exception' => $e]);
             // You might want a more specific exception in Domain for "NoActiveSubscriptionFound"
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST); // 400 Bad Request
        }
    }
}