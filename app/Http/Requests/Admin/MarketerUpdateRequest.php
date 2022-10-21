<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class MarketerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //todo - if admin then only true
        return true;
    }



    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {

    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //userId
        //reset_pw_stat
        return [
            'editor-name'      => 'required',
            'editor-phone'     => 'required',
            'editor-gender'    => 'required',
        ];
    }


    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'editor-name.required' => 'Name field is required',
        ];
    }



    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'editor-name'      => 'name',
            'editor-phone'     => 'phone',
            'editor-gender'    => 'gender',
        ];
    }


}
