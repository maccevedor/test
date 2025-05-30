<?php

namespace App\Domain\Repositories;

use App\Domain\Aggregates\Plan;

interface PlanRepository
{
    /**
     * Find a Plan by its ID.
     *
     * @param int $id
     * @return Plan|null
     */
    public function findById(int $id): ?Plan;

    /**
     * Find all Plans.
     *
     * @return Plan[]
     */
    public function findAll(): array;

    /**
     * Save a Plan entity.
     *
     * @param Plan $plan
     * @return void
     */
    public function save(Plan $plan): void;

    /**
     * Delete a Plan entity.
     *
     * @param Plan $plan
     * @return void
     */
    public function delete(Plan $plan): void;
}