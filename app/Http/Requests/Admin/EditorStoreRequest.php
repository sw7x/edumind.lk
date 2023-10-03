<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class EditorStoreRequest extends FormRequest
{
    public  $validator          = null;
    public  $is_usernameFill    = null;
    
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
        $email      = $this->get('editor_email');
        $username   = $this->get('editor_uname');
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
            'editor_uname' => $username,
            //'editor_name' => '',
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
            'editor_name'      => 'required|unique:users,full_name',
            'editor_email'     => 'required|email|unique:users,email',
            //'editor_uname'     => 'alpha_dash|unique:users,username',
            'editor_uname'     => 'alpha_dash',
            'editor_phone'     => 'required|unique:users,phone',
            'editor_password'  => 'required|min:6|max:12',
            'editor_gender'    => 'required',
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
            'editor_name.required' => 'Name field is required',
            'editor_email.required' => 'Email field is required',
        ];
    }



    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'editor_name'      => 'name',
            'editor_email'     => 'email',
            'editor_uname'     => 'username',
            'editor_phone'     => 'phone',
            'editor_password'  => 'password',
            'editor_gender'    => 'gender',
        ];
    }




    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        return redirect(route('admin.users.create', []))
            ->with(['is_editor_usernameFill' => $this->is_usernameFill]);

    }
}
