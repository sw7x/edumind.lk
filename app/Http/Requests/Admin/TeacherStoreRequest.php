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
        $email      = $this->get('teacher_email');
        $username   = $this->get('teacher_uname');
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
            'teacher_uname' => $username,
            //'teacher_name' => '',
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
            'teacher_name'      => 'required|unique:users,full_name',
            'teacher_email'     => 'required|email|unique:users,email',
            //'teacher_uname'     => 'alpha_dash|unique:users,username',
            'teacher_uname'     => 'alpha_dash',
            'teacher_phone'     => 'required|unique:users,phone',
            'teacher_password'  => 'required|min:6|max:12',
            'teacher_birth_year'=> 'digits:4|integer|min:1922|max:'.(date('Y')+1),
            'teacher_gender'    => 'required',
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
            'teacher_name.required' => 'Name field is required',
            'teacher_email.required' => 'Email field is required',            
        ];
    }



    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'teacher_name'      => 'name',
            'teacher_email'     => 'email',
            'teacher_uname'     => 'username',
            'teacher_phone'     => 'phone',
            'teacher_password'  => 'password',
            'teacher_birth_year'=> 'year of birth',
            'teacher_gender'    => 'gender',
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
