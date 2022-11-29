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
        $email      = $this->get('marketer-email');
        $username   = $this->get('marketer-uname');
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
            'marketer-uname' => $username,
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
            'marketer-name'      => 'required|unique:users,full_name',
            'marketer-email'     => 'required|email|unique:users,email',
            //'marketer-uname'     => 'alpha_dash|unique:users,username',
            'marketer-uname'     => 'alpha_dash',
            'marketer-phone'     => 'required|unique:users,phone',
            'marketer-password'  => 'required|min:6|max:12',
            'marketer-gender'    => 'required',
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
            'marketer-name.required' => 'Name field is required',
            'marketer-email.required' => 'Email field is required',
        ];
    }



    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'marketer-name'      => 'name',
            'marketer-email'     => 'email',
            'marketer-uname'     => 'username',
            'marketer-phone'     => 'phone',
            'marketer-password'  => 'password',
            'marketer-gender'    => 'gender',
        ];
    }




    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        return redirect(route('admin.user.create', []))
            ->with(['is_marketer_usernameFill' => $this->is_usernameFill]);
    }

}
