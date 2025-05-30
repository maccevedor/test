<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * Get the subscriptions for the company.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the company users for the company.
     */
    public function companyUsers()
    {
        return $this->hasMany(CompanyUser::class);
    }
}
