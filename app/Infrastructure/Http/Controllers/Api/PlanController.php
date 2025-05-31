<?php

namespace App\Infrastructure\Http\Controllers\Api;

use App\Application\UseCases\CreatePlan;
use App\Application\UseCases\UpdatePlan;
use App\Application\UseCases\DeletePlan;
use App\Application\UseCases\GetPlan;
use App\Application\UseCases\ListPlans;
use App\Infrastructure\Http\Requests\StorePlanRequest;
use App\Infrastructure\Http\Requests\UpdatePlanRequest;
use App\Infrastructure\Http\Resources\PlanResource;
use App\Http\Controllers\Controller;
use App\Domain\Exceptions\PlanNotFoundException;
use Illuminate\Http\JsonResponse;

class PlanController extends Controller
{
    private $createPlan;
    private $updatePlan;
    private $deletePlan;
    private $getPlan;
    private $listPlans;

    public function __construct(
        CreatePlan $createPlan,
        UpdatePlan $updatePlan,
        DeletePlan $deletePlan,
        GetPlan $getPlan,
        ListPlans $listPlans
    ) {
        $this->createPlan = $createPlan;
        $this->updatePlan = $updatePlan;
        $this->deletePlan = $deletePlan;
        $this->getPlan = $getPlan;
        $this->listPlans = $listPlans;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $plansDto = $this->listPlans->execute();

        return PlanResource::collection($plansDto)->toJsonResponse();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlanRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $command = new \App\Application\DTOs\CreatePlanCommand(
            $validated['name'],
            $validated['price'],
            $validated['user_limit'],
            $validated['features'] ?? [] // Assume features is an optional array
        );

        $planDto = $this->createPlan->execute($command);

        return (new PlanResource($planDto))
            ->response()
            ->setStatusCode(JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        try {
            $planDto = $this->getPlan->execute($id);

            return (new PlanResource($planDto))->toJsonResponse();

        } catch (PlanNotFoundException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlanRequest $request, int $id): JsonResponse
    {
        $validated = $request->validated();

        $command = new \App\Application\DTOs\UpdatePlanCommand(
            $id,
            $validated['name'],
            $validated['price'],
            $validated['user_limit'],
            $validated['features'] ?? []
        );

        try {
            $planDto = $this->updatePlan->execute($command);

            return (new PlanResource($planDto))->toJsonResponse();

        } catch (PlanNotFoundException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->deletePlan->execute((int) $id);

            return new JsonResponse([
                'message' => "Plan with ID {$id} deleted successfully.",
                'deleted_count' => 1,
            ], JsonResponse::HTTP_OK);

        } catch (PlanNotFoundException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_NOT_FOUND);
        }
    }
}