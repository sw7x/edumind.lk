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
        $email      = $this->get('editor-email');
        $username   = $this->get('editor-uname');
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
            'editor-uname' => $username,
            //'editor-name' => '',
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
            'editor-name'      => 'required|unique:users,full_name',
            'editor-email'     => 'required|email|unique:users,email',
            //'editor-uname'     => 'alpha_dash|unique:users,username',
            'editor-uname'     => 'alpha_dash',
            'editor-phone'     => 'required|unique:users,phone',
            'editor-password'  => 'required|min:6|max:12',
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
            'editor-email.required' => 'Email field is required',
        ];
    }



    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'editor-name'      => 'name',
            'editor-email'     => 'email',
            'editor-uname'     => 'username',
            'editor-phone'     => 'phone',
            'editor-password'  => 'password',
            'editor-gender'    => 'gender',
        ];
    }




    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        return redirect(route('admin.user.create', []))
            ->with(['is_editor_usernameFill' => $this->is_usernameFill]);

    }
}
