<?php

namespace App\Infrastructure\Http\Controllers\Api;

use App\Application\UseCases\RegisterCompany;
use App\Application\UseCases\UpdateCompany;
use App\Application\UseCases\DeleteCompany;
use App\Application\UseCases\GetCompany;
use App\Application\UseCases\ListCompanies;
// use Illuminate\Http\Controller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    private RegisterCompany $registerCompany;
    private UpdateCompany $updateCompany;
    private DeleteCompany $deleteCompany;
    private GetCompany $getCompany;
    private ListCompanies $listCompanies;

    public function __construct(
        RegisterCompany $registerCompany,
        UpdateCompany $updateCompany,
        DeleteCompany $deleteCompany,
        GetCompany $getCompany,
        ListCompanies $listCompanies
    ) {
        $this->registerCompany = $registerCompany;
        $this->updateCompany = $updateCompany;
        $this->deleteCompany = $deleteCompany;
        $this->getCompany = $getCompany;
        $this->listCompanies = $listCompanies;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $companies = $this->listCompanies->execute();
        // TODO: Use CompanyResource for response
        return response()->json($companies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), (new \App\Infrastructure\Http\Requests\StoreCompanyRequest())->rules());

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $command = new \App\Application\DTOs\RegisterCompanyCommand(
            name: $request->input('name')
        );

        $companyDto = $this->registerCompany->execute($command);

        return response()->json($companyDto, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $companyDto = $this->getCompany->execute($id);
            // TODO: Use CompanyResource for response
            return response()->json($companyDto);
        } catch (\DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:companies,name,' . $id]
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $command = new \App\Application\DTOs\UpdateCompanyCommand(
            id: $id,
            name: $request->input('name')
        );

        try {
            $companyDto = $this->updateCompany->execute($command);
            return response()->json($companyDto);
        } catch (\DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->deleteCompany->execute($id);
            return response()->json(null, 204);
        } catch (\DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
