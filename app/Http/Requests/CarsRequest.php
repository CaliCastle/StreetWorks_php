<?php

namespace StreetWorks\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarsRequest extends FormRequest
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
            'title'      => 'required|max:255',
            'make'       => 'required|max:255',
            'model'      => 'required|max:20',
            'model_year' => 'required|size:4',
            'primary'    => 'boolean',
            'license'    => 'max:11'
        ];
    }
}
