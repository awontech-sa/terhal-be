<?php

namespace App\Http\Requests\StoreRequests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_type_id' => 'exists:product_types,id',
            'user_id' => 'exists:users,id',
            'pr_images.*' => 'required|image|mimes:jpeg,png,jpg,gif',
            'pr_videos.*' => 'required|mimes:mp4,mov',
            'pr_name' => 'required|string|max:255',
            'pr_price' => 'required|numeric',
            'pr_rates' => 'required|numeric',
            'pr_description' => 'required|string|max:288',
        ];
    }
}
