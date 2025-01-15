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
            "e_name" => "string|max:255",
            "e_images.*" => 'image|mimes:jpeg,png,jpg,gif',
            "e_location" => "string",
            "e_price" => "integer",
            "e_description" => "string|max:288",
            "e_date" => "string",
            "e_rate" => "string",
            "e_videos.*" => "mimes:mp4,mov",
            'e_lang' => 'required|between:0,9999.999999',
            'e_lat' => 'required|between:0,9999.999999'
        ];
    }
}
