<?php

namespace App\Http\Requests\AdminRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class EventRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "user_id" => 'exists:users,id',
            "event_type_id" => "exists:event_types,id",
            "e_name" => "required|string|max:255",
            "e_images.*" => 'required|image|mimes:jpeg,png,jpg,gif',
            "e_location" => "required|string",
            "e_price" => "required",
            "e_description" => "required|string|max:288",
            "e_date" => "required",
            "e_rate" => "required",
            "e_videos.*" => "mimes:mp4,mov"
        ];
    }
}
