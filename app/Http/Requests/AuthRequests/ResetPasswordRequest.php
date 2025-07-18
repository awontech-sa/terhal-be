<?php

namespace App\Http\Requests\AuthRequests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'forget_pass_type' => 'required|string|in:email,phone',
            'email' => 'nullable|required_if:forget_pass_type,email|email|exists:users,email',
            'phone' => 'nullable|required_if:forget_pass_type,phone|string|max:15',
            'otp' => 'required',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',        // Must contain at least one uppercase letter
                'regex:/[a-z]/',        // Must contain at least one lowercase letter
                'regex:/[0-9]/',        // Must contain at least one number
                'regex:/[@$!%*?&#]/'    // Must contain at least one special character
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
