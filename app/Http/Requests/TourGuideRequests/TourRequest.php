<?php

namespace App\Http\Requests\TourGuideRequests;

use Illuminate\Foundation\Http\FormRequest;

class TourRequest extends FormRequest
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
            "t_name" => "string|max:255",
            "t_description" => "string|max:288",
            "t_image.*" => 'image|mimes:jpeg,png,jpg,gif',
            "t_rate" => "string",
            "t_date" => "string",
            "t_price" => "integer",
            "t_videos.*" => 'file|mimes:mp4,mov',
            't_duration' => 'string',
            'visitor_limit' => 'integer',
            't_places.*' => 'string|max:2800'
        ];
    }
}
