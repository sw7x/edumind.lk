<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;


class TeacherUpdateRequest extends FormRequest
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
            'teacher-name'      => 'required',
            'teacher-phone'     => 'required',
            'teacher_birth_year'=> 'digits:4|integer|min:1922|max:'.(date('Y')+1),
            'teacher-gender'    => 'required',
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
            'teacher-name.required' => 'Name field is required',
        ];
    }



    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'teacher-name'      => 'name',
            'teacher-phone'     => 'phone',
            'teacher_birth_year'=> 'year of birth',
            'teacher-gender'    => 'gender',
        ];
    }




//    protected function failedValidation(Validator $validator)
//    {
//        $this->validator = $validator;
//
//        return redirect()->route('admin.user.update-teacher')
//           ->withErrors($validator)
//           ->withInput();
//           //->with(['is_teacher_usernameFill' => $this->is_usernameFill]);
//        // parent::failedValidation($validator);
//    }




}
