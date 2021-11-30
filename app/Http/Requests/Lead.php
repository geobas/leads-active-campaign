<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Lead extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email_address' => 'required|email',
            'industry' => 'sometimes|filled|in:Accounting,Automotive,Software,Hospitality',
            'consent' => 'required|boolean',
        ];
    }

    /**
     * {@inheritDoc}
     */   
    public function messages()
    {
        return [
            'first_name.required' => ':attribute is required',
            'first_name.string' => ':attribute must be a string',
            'last_name.required' => ':attribute is required',
            'last_name.string' => ':attribute must be a string',
            'email_address.required' => ':attribute is required',
            'email_address.email' => ':attribute is not valid',
            'industry.filled' => ':attribute should not be empty',
            'industry.in' => ':attribute must be one of the following types: :values',
            'consent.required' => ':attribute is required',
            'consent.boolean' => ':attribute value is not valid',
        ];
    }
}
