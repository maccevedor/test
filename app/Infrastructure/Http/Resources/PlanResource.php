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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'user_limit' => $this->user_limit,
            'features' => json_decode($this->features, true), // Assuming features are stored as JSON string
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}