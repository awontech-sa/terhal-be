<?php

namespace App\Http\Requests\AuthRequests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'user_type_id' => 'required|integer|between:2,5',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'status' => 'required|string',
            'age' => 'required|integer',
            'gender' => 'required|string',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',        // Must contain at least one uppercase letter
                'regex:/[a-z]/',        // Must contain at least one lowercase letter
                'regex:/[0-9]/',        // Must contain at least one number
                'regex:/[@$!%*?&#-_]/'    // Must contain at least one special character
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character.',
        ];
    }
}