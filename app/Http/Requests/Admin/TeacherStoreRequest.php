<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;


class TeacherStoreRequest extends FormRequest
{

    public $validator = null;
    public $is_usernameFill = null;

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
        $email      = $this->get('teacher-email');
        $username   = $this->get('teacher-uname');
        //dd($email);

        if($username == null){
            // Get the username
            $username = strstr($email, '@', true);

            //remove non-alphanumeric characters
            $username = preg_replace( '/[\W]/', '', $username);
            $this->is_usernameFill = 'n';
        }else{
            $this->is_usernameFill = 'y';
        }

        $username = strtolower($username);
        $this->merge([
            'teacher-uname' => $username,
            //'teacher-name' => '',
        ]);

    }





    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'teacher-name'      => 'required|unique:users,full_name',
            'teacher-email'     => 'required|email|unique:users,email',
            //'teacher-uname'     => 'alpha_dash|unique:users,username',
            'teacher-uname'     => 'alpha_dash',
            'teacher-phone'     => 'required|unique:users,phone',
            'teacher-password'  => 'required|min:6|max:12',
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
            'teacher-email.required' => 'Email field is required',            
        ];
    }



    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'teacher-name'      => 'name',
            'teacher-email'     => 'email',
            'teacher-uname'     => 'username',
            'teacher-phone'     => 'phone',
            'teacher-password'  => 'password',
            'teacher_birth_year'=> 'year of birth',
            'teacher-gender'    => 'gender',
        ];
    }




    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;

        return redirect()->route('admin.user.create')
           ->withErrors($validator)
           ->withInput()
           ->with(['is_teacher_usernameFill' => $this->is_usernameFill]);
        // parent::failedValidation($validator);
    }




}
