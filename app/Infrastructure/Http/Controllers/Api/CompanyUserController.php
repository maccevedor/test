<?php

namespace App\Infrastructure\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Application\UseCases\AddCompanyUser;
use App\Application\UseCases\UpdateCompanyUser;
use App\Application\UseCases\DeleteCompanyUser;
use App\Application\UseCases\GetCompanyUser;
use App\Application\UseCases\ListCompanyUsers;
use Illuminate\Http\Request;


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
    public function index($companyId)
    {
        //
    }

    /**
     * Store a newly created company user in storage.
     */
    public function store(Request $request, $companyId)
    {
        //
    }

    /**
     * Display the specified company user.
     */
    public function show($companyId, $userId)
    {
        //
    }

    /**
     * Update the specified company user in storage.
     */
    public function update(Request $request, $companyId, $userId)
    {
        //
    }

    /**
     * Remove the specified company user from storage.
     */
    public function destroy($companyId, $userId)
    {
        //
    }
}