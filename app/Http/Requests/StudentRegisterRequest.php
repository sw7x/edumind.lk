<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StudentRegisterRequest extends FormRequest
{
    /** @var \Illuminate\Support\Facades\Validator */
    public  $validator          = null;

    protected $stopOnFirstFailure = false;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
        return [               
                
            'full_name'             =>'required|min:3|max:100|unique:users,full_name',
            'email'                 =>'required|email|unique:users,email',
            'username'              =>'nullable|sometimes|unique:users,username',
            'password'              =>'required|min:6|max:12',
            'phone'                 =>'required|unique:users,phone',
            'gender'                =>'required',
            'g-recaptcha-response'  =>'required',
            'dob_year'              =>'required|digits:4|integer|min:'.(date('Y')-100).'|max:'.date('Y')                         
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
            'full_name.required'            => 'Full name field is required.',
            'full_name.unique'              => 'This full name is already been used',
            'email.unique'                  => 'This Email is already been used',
            'phone.unique'                  => 'This phone number is already been used',
            'message.required'              => 'Message field is required.',
            'g-recaptcha-response.required' => 'Recaptcha is required.',
            'dob_year.digits'               => 'Date of birth year format is invalid.'
        ];
        
    }


    // Special Naming for Attributes
    public function attributes()
    {
        return [            
            'full_name'             => 'Full name',           
            'email'                 => 'Email',
            'username'              => 'Username',
            'password'              => 'Password',
            'phone'                 => 'Phone',
            'gender'                => 'Gender',
            'g-recaptcha-response'  => 'Google recaptcha',
            'dob_year'              => 'Birth year'            
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        
        $this->validator = $validator;
                
        //todo
        return redirect()
            ->route('auth.register')
            //->withErrors($this->isValidContentJson)
            ->withErrors($validator,'studentReg')
            ->withInput();
            //->with(['isValidContentJson' => $this->isValidContentJson]);;
        
        // parent::failedValidation($validator);
    }


}
