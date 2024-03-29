<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
        $email      = $this->get('stud_email');
        $username   = $this->get('stud_uname');
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
            'stud_uname' => $username,
            //'stud_name' => '',
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
            'stud_name'      => 'required|unique:users,full_name',
            'stud_email'     => 'required|email|unique:users,email',
            //'stud_uname'     => 'alpha_dash|unique:users,username',
            'stud_uname'     => 'alpha_dash',
            'stud_phone'     => 'required|unique:users,phone',
            'stud_password'  => 'required|min:6|max:12',
            'stud_birth_year'=> 'digits:4|integer|min:1922|max:'.(date('Y')+1),
            'stud_gender'    => 'required',



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
            'stud_name.required' => 'Name field is required',
            'stud_email.required' => 'Email field is required',
        ];
    }



    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'stud_name'      => 'name',
            'stud_email'     => 'email',
            'stud_uname'     => 'username',
            'stud_phone'     => 'phone',
            'stud_password'  => 'password',
            'stud_birth_year'=> 'year of birth',
            'stud_gender'    => 'gender',
        ];
    }




    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;

        return redirect(route('admin.users.create', []). '#tab-add-students')
        ->with(['is_student_usernameFill' => $this->is_usernameFill]);


        //return redirect(route('admin.users.create', []). '#tab-add-students')
        //->withErrors($validator)
        //->withInput()
        //->with(['is_student_usernameFill' => $this->is_usernameFill]);


        /*
        return redirect()->route('admin.users.create',['','#tab-add-students'])
            ->withErrors($validator)
            ->withInput()
            ->with(['is_student_usernameFill' => $this->is_usernameFill]);
        */
        // parent::failedValidation($validator);
    }

}
