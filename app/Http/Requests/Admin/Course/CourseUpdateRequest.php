<?php

namespace App\Http\Requests\Admin\Course;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CourseUpdateRequest extends FormRequest
{
    
    public  $validator   = null;
    private $recordId    = null;
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
            'course-name'   => 'required|min:3|unique:courses,name,'.$this->recordId,
            'subject'       => 'required',
            'teacher'       => 'required',
            'course-heading'=> 'required'            
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
            'course-name.required'      => 'Course name field is required',
            'course-name.min'           => 'Course name must be minimum 3 characters long',            
            'course-name.unique'        => "Course name {$this->get('course-name')} already exist",         
            'subject.required'          => 'Subject need to assign for a course',
            'teacher.required'          => 'Teacher need to assign for a course',
            'course-heading.required'   => 'Course heading field is required'
        ];
    }


    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'course-name'   => 'Course name',
            'subject'       => 'Course subject',
            'teacher'       => 'Course teacher',
            'course-heading'=> 'Course heading',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        //dd()
        return redirect()
            ->route('admin.course.update',$this->recordId)
            ->withErrors($validator)
            ->withInput();
           //->with(['is_teacher_usernameFill' => $this->is_usernameFill]);
        // parent::failedValidation($validator);
    }
}
