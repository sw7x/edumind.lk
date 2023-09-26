<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class MarketerStoreRequest extends FormRequest
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
        $email      = $this->get('marketer_email');
        $username   = $this->get('marketer_uname');
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
            'marketer_uname' => $username,
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
            'marketer_name'      => 'required|unique:users,full_name',
            'marketer_email'     => 'required|email|unique:users,email',
            //'marketer_uname'     => 'alpha_dash|unique:users,username',
            'marketer_uname'     => 'alpha_dash',
            'marketer_phone'     => 'required|unique:users,phone',
            'marketer_password'  => 'required|min:6|max:12',
            'marketer_gender'    => 'required',
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
            'marketer_name.required' => 'Name field is required',
            'marketer_email.required' => 'Email field is required',
        ];
    }



    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'marketer_name'      => 'name',
            'marketer_email'     => 'email',
            'marketer_uname'     => 'username',
            'marketer_phone'     => 'phone',
            'marketer_password'  => 'password',
            'marketer_gender'    => 'gender',
        ];
    }




    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        return redirect(route('admin.user.create', []))
            ->with(['is_marketer_usernameFill' => $this->is_usernameFill]);
    }

}
