<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCompanyUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Add your authorization logic here
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Company ID is obtained from the route, but we still validate its existence
            // in the database to ensure a valid company is being targeted.
            // 'required' and 'integer' are usually handled by the route model binding implicitly
            // but it's good practice to include 'exists' for explicit validation.
            'company_id' => ['exists:companies,id'], // The route parameter should be named 'company'
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('company_users')->where('company_id', $this->input('company_id')),
            ],
            'password' => ['required', 'string', 'min:8'],
        ];
    }
}