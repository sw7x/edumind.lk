<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class MarketerUpdateRequest extends FormRequest
{
    private $recordId  = null;
    public  $validator = null;
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
        $this->recordId = $this->route('id');   
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //userId
        //reset_pw_stat
        return [
            'marketer-name'      => 'required|unique:users,full_name,'.$this->recordId,
            'marketer-phone'     => 'required|unique:users,phone,'.$this->recordId,
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
            'marketer-name.unique'   => "{$this->get('marketer-name')} is already been used as a full name",
            'marketer-phone.unique'  => "{$this->get('marketer-phone')} is already been used as a phone number",
        
        ];
    }

    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'marketer-name'      => 'name',
            'marketer-phone'     => 'phone',
            'marketer-gender'    => 'gender',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        //dd()
        return redirect()
            ->route('admin.user.update-marketer',$this->recordId)
            ->withErrors($validator)
            ->withInput();
           //->with(['is_teacher_usernameFill' => $this->is_usernameFill]);
        // parent::failedValidation($validator);
    }


}
