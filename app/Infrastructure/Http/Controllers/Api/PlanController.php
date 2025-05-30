<?php

namespace App\Infrastructure\Http\Controllers\Api;

use App\Application\UseCases\CreatePlan;
use App\Application\UseCases\UpdatePlan;
use App\Application\UseCases\DeletePlan;
use App\Application\UseCases\GetPlan;
use App\Application\UseCases\ListPlans;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}