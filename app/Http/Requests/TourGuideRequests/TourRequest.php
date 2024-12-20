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
            "t_name" => "required|string|max:255",
            "t_description" => "required|string|max:288",
            "t_image.*" => 'required|image|mimes:jpeg,png,jpg,gif',
            "t_rate" => "required",
            "t_date" => "required",
            "t_price" => "required",
            "t_videos.*" => 'required|file|mimes:mp4,mov',
            't_duration' => 'required|string',
            'visitor_limit' => 'required'
        ];
    }
}
