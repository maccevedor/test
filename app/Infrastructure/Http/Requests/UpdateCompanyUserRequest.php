<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Implement authorization logic here, e.g., check if the authenticated
        // user has permission to update users for this company.
        // For now, we'll return true to allow all requests for demonstration.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user');
        $companyId = $this->route('company');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // Ensure email is unique within the scope of the company, excluding the current user's email.
                Rule::unique('company_users')->ignore($userId)->where(function ($query) use ($companyId) {
                    return $query->where('company_id', $companyId);
                }),
            ],
            // Password is nullable and not required for update if not provided.
            'password' => ['nullable', 'string', 'min:8'],
        ];
    }
}