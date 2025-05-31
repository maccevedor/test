<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Implement your authorization logic here
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // Get the plan ID from the route parameters
        $planId = $this->route('plan'); // Assuming your route parameter is named 'plan'

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('plans', 'name')->ignore($planId), // Ignore the current plan's ID
            ],
            'price' => ['required', 'numeric', 'min:0'],
            'user_limit' => ['required', 'integer', 'min:0'],
            'features' => 'nullable|json',
        ];
    }
}