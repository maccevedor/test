<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\CompanyUser; // Using Entity as planned

interface CompanyUserRepository
{
    /**
     * Find a CompanyUser by its ID.
     *
     * @param int $id The ID of the CompanyUser.
     * @return CompanyUser|null The CompanyUser entity or null if not found.
     */
    public function findById(int $id): ?CompanyUser;

    /**
     * Save a CompanyUser entity.
     *
     * @param CompanyUser $companyUser The CompanyUser entity to save.
     * @return CompanyUser The saved CompanyUser entity with updated properties (like ID and timestamps).
     */
    public function save(CompanyUser $companyUser): CompanyUser;

    /**
     * Delete a CompanyUser entity.
     *
     * @param CompanyUser $companyUser The CompanyUser entity to delete.
     */
    public function delete(CompanyUser $companyUser): void;

    /**
     * Find all CompanyUser entities.
     *
     * @return CompanyUser[] An array of all CompanyUser entities.
     */
    public function findAll(): array;

    /**
     * Find all CompanyUser entities for a specific company.
     *
     * @param int $companyId The ID of the company.
     * @return CompanyUser[] An array of CompanyUser entities belonging to the company.
     */
    public function findByCompanyId(int $companyId): array;

    /**
     * Count the number of users for a specific company.
     *
     * @param int $companyId The ID of the company.
     * @return int The number of users for the company.
     */
    public function countByCompanyId(int $companyId): int;
}