<?php

namespace App\Http\Requests\AdminRequests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceRequest extends FormRequest
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
            'place_type_id' => 'exists:place_types,id',
            'p_name' => 'string|max:255',
            'p_lang' => 'between:0,9999.999999',
            'p_lat' => 'between:0,9999.999999'
        ];
    }
}
