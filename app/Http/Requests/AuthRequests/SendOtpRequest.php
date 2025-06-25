<?php

namespace App\Http\Requests\AuthRequests;

use Illuminate\Foundation\Http\FormRequest;

class SendOtpRequest extends FormRequest
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
     * @return array<string, Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'forget_pass_type' => 'required|string|in:email,phone',
            'email' => 'nullable|required_if:forget_pass_type,email|email|exists:users,email',
            'phone' => 'nullable|required_if:forget_pass_type,phone|string|max:15'
        ];        
    }
}
