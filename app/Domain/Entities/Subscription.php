<?php

namespace App\Domain\Entities;

use Carbon\Carbon;

class Subscription
{
    private ?int $id;
    private int $company_id;
    private int $plan_id;
    private Carbon $start_date;
    private ?Carbon $end_date;
    private string $status;
    private ?Carbon $created_at;
    private ?Carbon $updated_at;

    public function __construct(
        ?int $id,
        int $company_id,
        int $plan_id,
        Carbon $start_date,
        ?Carbon $end_date,
        string $status,
        ?Carbon $created_at = null,
        ?Carbon $updated_at = null
    ) {
        $this->id = $id;
        $this->company_id = $company_id;
        $this->plan_id = $plan_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->status = $status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyId(): int
    {
        return $this->company_id;
    }

    public function getPlanId(): int
    {
        return $this->plan_id;
    }

    public function getStartDate(): Carbon
    {
        return $this->start_date;
    }

    public function getEndDate(): ?Carbon
    {
        return $this->end_date;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setTimestamps(Carbon $createdAt, Carbon $updatedAt): void
    {
        $this->created_at = $createdAt;
        $this->updated_at = $updatedAt;
    }

    public function setEndDate(?Carbon $end_date): void
    {
        $this->end_date = $end_date;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}