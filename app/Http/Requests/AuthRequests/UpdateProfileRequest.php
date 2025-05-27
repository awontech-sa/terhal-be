<?php

namespace App\Http\Requests\AuthRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'phone' => 'string|max:10|min:10|unique:users,phone',
            'gender' => 'string|in:ذكر,أنثى',
            'age' => 'integer|min:1|max:120',
            'password' => [
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',        // Must contain at least one uppercase letter
                'regex:/[a-z]/',        // Must contain at least one lowercase letter
                'regex:/[0-9]/',        // Must contain at least one number
                'regex:/[@$!%*?&#-_]/'    // Must contain at least one special character
            ]
        ];
    }

}
