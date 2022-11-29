<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
{
    private $recordId = null;
    public $validator = null;
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
        $this->recordId = $this->route('id');        
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
            'stud-name'      => 'required|unique:users,full_name,'.$this->recordId,
            'stud-phone'     => 'required|unique:users,phone,'.$this->recordId,
            'stud_birth_year'=> 'digits:4|integer|min:1922|max:'.(date('Y')+1),
            'stud-gender'    => 'required',
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
            'stud-name.required' => 'Name field is required',
            'stud-name.unique'   => "{$this->get('stud-name')} is already been used as a full name",
            'stud-phone.unique'  => "{$this->get('stud-phone')} is already been used as a phone number",
        
        ];
    }



    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'stud-name'      => 'name',
            'stud-phone'     => 'phone',
            'stud_birth_year'=> 'year of birth',
            'stud-gender'    => 'gender',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        return redirect()
            ->route('admin.user.update-student',$this->recordId)
            ->withErrors($validator)
            ->withInput();

        // parent::failedValidation($validator);
    }

}
