<?php

namespace StreetWorks\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessInfoRequest extends FormRequest
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
            'description' => 'string',
            'address_1'   => 'required|string|max:255',
            'address_2'   => 'string|max:255',
            'address_3'   => 'string|max:255',
            'city'        => 'required|string|max:100',
            'state'       => 'required|size:2',
            'country'     => 'required|size:3',
            'phone'       => 'required|max:11',
            'email'       => 'required|email|max:255'
        ];
    }
}
