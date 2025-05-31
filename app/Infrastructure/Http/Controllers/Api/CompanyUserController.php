<?php

namespace App\Infrastructure\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Application\UseCases\AddCompanyUser;
use App\Application\UseCases\UpdateCompanyUser;
use App\Application\UseCases\DeleteCompanyUser;
use App\Application\UseCases\GetCompanyUser;
use App\Application\UseCases\ListCompanyUsers;
use App\Infrastructure\Http\Requests\StoreCompanyUserRequest;
use App\Infrastructure\Http\Requests\UpdateCompanyUserRequest;
use App\Infrastructure\Http\Resources\CompanyUserResource;
use App\Application\DTOs\AddCompanyUserCommand;
use App\Application\DTOs\UpdateCompanyUserCommand;
use App\Application\DTOs\DeleteCompanyUserCommand;
use Illuminate\Http\JsonResponse;


class CompanyUserController extends Controller
{
    private $addCompanyUser;
    private $updateCompanyUser;
    private $deleteCompanyUser;
    private $getCompanyUser;
    private $listCompanyUsers;

    public function __construct(
        AddCompanyUser $addCompanyUser,
        UpdateCompanyUser $updateCompanyUser,
        DeleteCompanyUser $deleteCompanyUser,
        GetCompanyUser $getCompanyUser,
        ListCompanyUsers $listCompanyUsers
    ) {
        $this->addCompanyUser = $addCompanyUser;
        $this->updateCompanyUser = $updateCompanyUser;
        $this->deleteCompanyUser = $deleteCompanyUser;
        $this->getCompanyUser = $getCompanyUser;
        $this->listCompanyUsers = $listCompanyUsers;
    }

    /**
     * Display a listing of the company users for a given company.
     */
    public function index(int $companyId): JsonResponse
    {
        try {
            $usersDto = $this->listCompanyUsers->execute($companyId);

            return CompanyUserResource::collection($usersDto)->toJsonResponse();
        } catch (\App\Domain\Exceptions\CompanyNotFoundException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
             logger()->error('Error listing company users: ' . $e->getMessage(), ['exception' => $e]);
            return new JsonResponse(['message' => 'An error occurred while listing company users.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created company user in storage.
     */
    public function store(StoreCompanyUserRequest $request, int $companyId): JsonResponse
    {
        try {
            $validated = $request->validated();

            $command = new AddCompanyUserCommand(
                $companyId,
                $validated['name'],
                $validated['email'],
                $validated['password']
            );

            $userDto = $this->addCompanyUser->execute($command);

            return (new CompanyUserResource($userDto))
                ->response()
                ->setStatusCode(JsonResponse::HTTP_CREATED);

        } catch (\App\Domain\Exceptions\CompanyNotFoundException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (\App\Domain\Exceptions\UserLimitExceededException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST); // 400 for business rule violation
        } catch (\Exception $e) {
             logger()->error('Error adding company user: ' . $e->getMessage(), ['exception' => $e]);
            return new JsonResponse(['message' => 'An error occurred while adding the company user.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified company user.
     */
    public function show(int $companyId, int $userId): JsonResponse
    {
        try {
            $userDto = $this->getCompanyUser->execute($companyId, $userId);
            return new CompanyUserResource($userDto);
        } catch (\App\Domain\Exceptions\UserNotFoundException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
             logger()->error('Error getting company user: ' . $e->getMessage(), ['exception' => $e]);
            return new JsonResponse(['message' => 'An error occurred while getting the company user.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified company user in storage.
     */
    public function update(UpdateCompanyUserRequest $request, int $companyId, int $userId): JsonResponse
    {
        try {
            $validated = $request->validated();

            $command = new UpdateCompanyUserCommand(
                $userId,
                $companyId, // Pass companyId for checking ownership
                $validated['name'] ?? null, // Pass nullable if not required in UpdateRequest
                $validated['email'] ?? null,
                $validated['password'] ?? null // Pass nullable if not required in UpdateRequest
            );

            $userDto = $this->updateCompanyUser->execute($command);

            return new CompanyUserResource($userDto);

        } catch (\App\Domain\Exceptions\UserNotFoundException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
             logger()->error('Error updating company user: ' . $e->getMessage(), ['exception' => $e]);
            return new JsonResponse(['message' => 'An error occurred while updating the company user.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified company user from storage.
     */
    public function destroy(int $companyId, int $userId): JsonResponse
    {
        try {
             $command = new DeleteCompanyUserCommand($userId, $companyId); // Pass companyId for checking ownership
            $this->deleteCompanyUser->execute($command);

            return new JsonResponse([
                'message' => "Company user with ID {$userId} deleted successfully for company ID {$companyId}.",
                'deleted_count' => 1,
            ], JsonResponse::HTTP_OK);

        } catch (\App\Domain\Exceptions\UserNotFoundException $e) {
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
             logger()->error('Error deleting company user: ' . $e->getMessage(), ['exception' => $e]);
            return new JsonResponse(['message' => 'An error occurred while deleting the company user.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}