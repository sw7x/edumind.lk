<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class EditorUpdateRequest extends FormRequest
{
    private $recordId    = null;
    public  $validator   = null;

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
        //dd($this->recordId);
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
            'editor_name'      => 'required|unique:users,full_name,'.$this->recordId,
            'editor_phone'     => 'required|unique:users,phone,'.$this->recordId,
            'editor_birth_year'=> 'digits:4|integer|min:1922|max:'.(date('Y')+1),
            'editor_gender'    => 'required',
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
            'editor_name.required' => 'Name field is required',
            'editor_name.unique'   => "{$this->get('editor_name')} is already been used as a full name",
            'editor_phone.unique'  => "{$this->get('editor_phone')} is already been used as a phone number",
        
        ];
    }



    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'editor_name'      => 'name',
            'editor_phone'     => 'phone',
            'editor_birth_year'=> 'year of birth',
            'editor_gender'    => 'gender',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        //dd()
        return redirect()
            ->route('admin.users.update-editor',$this->recordId)
            ->withErrors($validator)
            ->withInput();
           //->with(['is_teacher_usernameFill' => $this->is_usernameFill]);
        // parent::failedValidation($validator);
    }
}
