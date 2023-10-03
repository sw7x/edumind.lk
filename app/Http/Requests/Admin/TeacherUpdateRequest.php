<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\CustomException;
use Illuminate\Http\Request;

class TeacherUpdateRequest extends FormRequest
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
        //dd(request()->route('id'));
        //dd($this->request->get('teacher_name'));        
        $this->recordId = $this->route('id');
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'teacher_name'      => 'required|unique:users,full_name,'.$this->recordId,
            //'teacher_name'      => 'required|unique:users,full_name',
            
            'teacher_phone'     => 'required|unique:users,phone,'.$this->recordId,
            //'teacher_phone'     => 'required|unique:users,phone',
            
            'teacher_birth_year'=> 'digits:4|integer|min:1922|max:'.(date('Y')+1),
            'teacher_gender'    => 'required',
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
            'teacher_name.required' => 'Name field is required',
            'teacher_name.unique'   => "{$this->get('teacher_name')} is already been used as a full name",
            'teacher_phone.unique'  => "{$this->get('teacher_phone')} is already been used as a phone number",
        ];
    }


    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'teacher_name'      => 'name',
            'teacher_phone'     => 'phone',
            'teacher_birth_year'=> 'year of birth',
            'teacher_gender'    => 'gender',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        //dd()
        return redirect()
            ->route('admin.users.update-teacher',$this->recordId)
            ->withErrors($validator)
            ->withInput();
           //->with(['is_teacher_usernameFill' => $this->is_usernameFill]);
        // parent::failedValidation($validator);
    }






    


}
