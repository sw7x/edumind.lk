<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;



class ContactUsFormRequest extends FormRequest
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
        
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [               
        /*            
            'full_name'             =>'sometimes|required',
            'subject'               =>'required|max:50',
            'message'               =>'required',
            'g-recaptcha-response'  =>'required',  */           


            'full_name'             =>'sometimes|required',
            'subject'               =>'required|min:30|max:50|email',
            'message'               =>'required|min:30|email',
            'g-recaptcha-response'  =>'required',                          
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

            'subject.required'              => 'Subject field is required.',
            'subject.min'                   => 'Subject should have minimum 3 characters.',
            'subject.max'                   => 'Subject should not exceed 50 characters.',

            'message.required'              => 'Message field is required.',
            'g-recaptcha-response.required' => 'Recaptcha is required.',
        ];
        
    }


    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'full_name'     => 'Full name',
            'subject'       => 'Subject',
            'message'       => 'Message',
            'g-recaptcha'   => 'Google recaptcha',
            
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        
        $this->validator = $validator;
        //dd('ggg');
        
        //todo
        return redirect()
            //->route('contact-us.view')
            ->back()
            //->withErrors($this->isValidContentJson)
            ->withErrors($validator,'contactUsForm')
            ->withInput();
            //->with(['isValidContentJson' => $this->isValidContentJson]);;
        
        // parent::failedValidation($validator);
    }

}









