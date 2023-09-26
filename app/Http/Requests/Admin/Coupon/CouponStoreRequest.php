<?php

namespace App\Http\Requests\Admin\Coupon;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CouponStoreRequest extends FormRequest
{
    /** @var \Illuminate\Support\Facades\Validator */
    public  $validator          = null;

    public  $isValidContentJson = null;
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
        //dump($this->get('beneficiary'));
        //dd($this->get('beneficiary_share_percentage_from_discount'));
        
        if(!$this->get('beneficiary')){
            $this->merge(['beneficiary_share_percentage_from_discount' => null]);
        }       

    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'cc-code'                 => 'required|regex:/^[a-zA-Z0-9]+$/|size:6|unique:coupons,code',
            'discount_percentage'     => 'required|numeric|min:1|max:99',
            'course'                  => 'required',
            'cc-count'                => 'required|numeric|min:1',
            'beneficiary'             => 'nullable',            
            'beneficiary_share_percentage_from_discount' => 'nullable|numeric|min:0|max:100'

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
            'cc-code.required'  => ':attribute is required',
            'cc-code.regex'     => ":attribute should be in alpha numeric characters",
            'cc-code.size'      => ":attribute length should be 6 characters",
            'cc-code.unique'    => ":attribute already exists",

            'discount_percentage.required' => ':attribute is required',
            'discount_percentage.numeric'  => ':attribute should be a number',
            'discount_percentage.min'      => ':attribute minimum value can be 1',
            'discount_percentage.max'      => ':attribute maximum value can be 99',

            'course.required'             => ':attribute is required.',
            
            'cc-count.required'           => ':attribute count is required',
            'cc-count.numeric'            => ':attribute count should be a number',
            'cc-count.min'                => ':attribute count minimum value can be 1',

            'beneficiary_share_percentage_from_discount.numeric'           => ':attribute should be a number',
            'beneficiary_share_percentage_from_discount.min'               => ':attribute minimum value can be 0',
            'beneficiary_share_percentage_from_discount.max'               => ':attribute maximum value can be 100',

        ];
        
    }


    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'cc-code'                   => 'Coupon code',
            'discount_percentage'       => 'Discount percentage',
            'course'                    => 'Course',
            'cc-count'                  => 'Coupon code count',
            'beneficiary'               => 'Beneficiary',
            'beneficiary_share_percentage_from_discount'   => 'Author share percentage',        
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        //dd('ggg');
        return redirect()
            ->route('admin.coupon-code.create')
            //->withErrors($this->isValidContentJson)
            ->withErrors($validator,'couponCreate')
            ->withInput();
            //->with(['isValidContentJson' => $this->isValidContentJson]);;
        
        // parent::failedValidation($validator);
    }

}
