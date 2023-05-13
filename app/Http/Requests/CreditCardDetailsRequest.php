<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;




class CreditCardDetailsRequest extends FormRequest
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
        //dump($this->get('benificiary'));
        //dd($this->get('beneficiary_share_percentage_from_discount'));
        
        //dump($this->get('card_number'));
        
        //todo
        if($this->get('card_number')){
            $cardNumber      = $this->get('card_number');
            $cleanCardNumber = str_replace(['-', ' '], '', $cardNumber);
            $this->merge(['card_number' => $cleanCardNumber]);
        }


        // dump($this->get('card_number'));
        // dump($this->get('full_name'));
        // dump($this->get('expiry'));
        // dump($this->get('cvc'));

    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [               
                'card_number' => 'required|numeric',               
                
                'full_name'   => 'required',
                
                //greate than today
                'expiry'      => 'required|date_format:m/y|after:today',

                //number with 3 digits
                'cvc'         => 'required|digits:3',                            
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
            
            'card_number.required'  => ':attribute field is required.',
            
            'full_name.required'    => ':attribute field is required.',
            
            'expiry.required'       => ':attribute field is required.',
            'expiry.date_format'    => 'Please provide a valid expiration date in the format MM/YY.',
            'expiry.after'          => ':attribute must be in the future.',
            
            'cvc.required'          => ':attribute field is required.',
            'cvc.digits'            => ':attribute must be a 3-digit number.',



        ];
        
    }


    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'card_number'     => 'Credit card number',
            'full_name'       => 'Full name',
            'expiry'          => 'Expire dare',
            'cvc'             => 'CVC',
            
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        
        $this->validator = $validator;
        //dd('ggg');
        
        //todo
        return redirect()
            ->route('checkout3')
            //->withErrors($this->isValidContentJson)
            ->withErrors($validator,'creditCardPay')
            ->withInput();
            //->with(['isValidContentJson' => $this->isValidContentJson]);;
        
        // parent::failedValidation($validator);
    }

}









