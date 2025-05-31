<?php

namespace App\Domain\Entities;

use Carbon\Carbon;

class CompanyUser
{
    private ?int $id;
    private int $company_id;
    private string $name;
    private string $email;
    private string $password; // Note: Hashed password
    private ?Carbon $created_at;
    private ?Carbon $updated_at;

    public function __construct(
        ?int $id,
        int $company_id,
        string $name,
        string $email,
        string $password,
        ?Carbon $created_at = null,
        ?Carbon $updated_at = null
    ) {
        $this->id = $id;
        $this->company_id = $company_id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
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

    // You might add methods for password handling here if needed in the Domain
    // public function checkPassword(string $password): bool { ... }

    // You might add methods for updating properties
    // public function updateName(string $name): void { $this->name = $name; }
    // public function updateEmail(string $email): void { $this->email = $email; }
    // public function updatePassword(string $password): void { $this->password = $password; }
}