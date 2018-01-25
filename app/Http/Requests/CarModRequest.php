<?php

namespace StreetWorks\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarModRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|string|max:255',
            'type'        => 'required|numeric',
            'car_id'      => 'required|exists:cars,id',
            'image_id'    => 'exists:images,id',
            'description' => 'string'
        ];
    }
}
