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
            'marketer_name'      => 'required|unique:users,full_name,'.$this->recordId,
            'marketer_phone'     => 'required|unique:users,phone,'.$this->recordId,
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
            'marketer_name.unique'   => "{$this->get('marketer_name')} is already been used as a full name",
            'marketer_phone.unique'  => "{$this->get('marketer_phone')} is already been used as a phone number",
        
        ];
    }

    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'marketer_name'      => 'name',
            'marketer_phone'     => 'phone',
            'marketer_gender'    => 'gender',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        //dd()
        return redirect()
            ->route('admin.users.update-marketer',$this->recordId)
            ->withErrors($validator)
            ->withInput();
           //->with(['is_teacher_usernameFill' => $this->is_usernameFill]);
        // parent::failedValidation($validator);
    }


}
