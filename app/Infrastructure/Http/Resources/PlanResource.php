<?php

namespace App\Infrastructure\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Assuming the resource is a Plan Entity or DTO with the specified properties
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'user_limit' => $this->user_limit,
            // Decode the features JSON string into an array if it's not null
            'features' => $this->features ? json_decode($this->features, true) : null,
            'created_at' => $this->created_at ? $this->created_at->toIso8601String() : null, // Format timestamps
            'updated_at' => $this->updated_at ? $this->updated_at->toIso8601String() : null, // Format timestamps
        ];
    }
}