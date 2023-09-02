<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class BillingInfoRequest extends FormRequest
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
        //todo - if admin,editor,teacher then only true
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // dump($this->get('fname'));
        // dump($this->get('lname'));
        // dump($this->get('email'));
        // dump($this->get('phone'));
        // dump($this->get('country'));
        // dump($this->get('city'));
        // dump($this->get('street_address'));   
      

    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
                'fname'             =>  'required',
                //'fname'             =>  'required|between:5,15',

                'lname'             =>  'required',
                //'lname'             =>  'required|between:5,15',

                'email'             =>  'required|email',
                
                //Allow only digits, spaces, parentheses, hyphens, and plus sign
                'phone'             =>  'required|regex:/^[\d\s()+-]+$/',
                
                'country'           =>  'required',    
                'city'              =>  'required',
                'street_address'    =>  'required'   
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
            'fname.required'            => ':attribute is required',
            //'fname.between'            => ':attribute is required',
            
            'lname.required'            => ':attribute is required',
            
            
            'email.required'            => ':attribute is required',
            'email.email'               => ':attribute must be a valid email address',
            
            'phone.required'            => ':attribute is required',
            'phone.regex'               => ':attribute must contain only digits, spaces, parentheses, hyphens, and plus sign',
            
            'country.required'          => ':attribute is required',
            
            
            'city.required'             => ':attribute is required',
           
            
            'street_address.required'   => ':attribute is required',
            
        ];
        
    }


    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'fname'             => 'First name',
            'lname'             => 'Last name',
            'email'             => 'Email',
            'phone'             => 'Phone number',
            'country'           => 'Country',
            'city'              => 'City', 
            'street_address'    => 'Street address',        
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        
        $this->validator = $validator;
        //dd('ggg');
        
        //todo
        return redirect()
            ->route('submit-billing-info')
            //->withErrors($this->isValidContentJson)
            ->withErrors($validator,'billingInfo')
            ->withInput();
            //->with(['isValidContentJson' => $this->isValidContentJson]);;
        
        // parent::failedValidation($validator);
    }

}









