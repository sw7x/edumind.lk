<?php

namespace App\Http\Requests\Admin\Course;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class CourseStoreRequest extends FormRequest
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
        //dump($this->request);
        if(!$this->get('course-price')){
            $this->merge(['course-price' => 0]);
        }

        if(!$this->get('author_share_percentage')){
            $this->merge(['author_share_percentage' => '60']);
        }
        
        try {

            $contentArr = json_decode($this->get('contentJson'), true, 512, JSON_THROW_ON_ERROR);
            $topicsArr  = json_decode($this->get('topicsJson'), true, 512, JSON_THROW_ON_ERROR);

            //dd($contentArr);
            $this->isValidContentJson = true;

            $this->merge([
                'contentArr' => $contentArr,
                'topicsArr'  => $topicsArr,
            ]);
            //$this->merge(['contentArr' => array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43")]);
            //$this->merge(['contentArr' => [1,2,3]]);
            //$this->merge(['contentArr' => []]);
        }  
        catch (\JsonException $exception) {  
            $this->isValidContentJson = false;
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
            'course-name'   => 'required|unique:courses,name|min:3',
            'subject'       => 'required',
            'teacher'       => 'required',
            'course-heading'=> 'required',
            'video-count'   => 'nullable|numeric|min:0',            
            
            'course-img'    =>  [
                function ($attribute, $value, $fail) {               
                    //validate file type
                    try {
                        if(null == $this->get('course-img'))return;                        
                        $courseImg      = json_decode($this->get('course-img'), true, 512, JSON_THROW_ON_ERROR);
                        $validFileTypes = array('webp', 'png', 'jpeg', 'jpg', 'gif');
                        $ext            = strtolower(explode(".",$courseImg['name'])[1]);
                        $msg = (!in_array($ext,$validFileTypes))?'Course image can be these file types jpg/png/jpeg/gif/webp.':'';
                    }  
                    catch (\Exception $exception) { 
                        $msg = 'Course image file type is invalid.!';
                    }                    
                    if($msg != '')$fail($msg);
                },
                function ($attribute, $value, $fail) {   
                    // validate file size          
                    try {
                        if(null == $this->get('course-img'))return;
                        $courseImg      = json_decode($this->get('course-img'), true, 512, JSON_THROW_ON_ERROR);                   
                        $msg =(($courseImg['size']/(1024*1024)) > 1)?'Course image file size must be less than 1MB':'';                        
                    }  
                    catch (\Exception $exception) { 
                        $msg = 'Course image file size is invalid.!';
                    }
                    if($msg != '')$fail($msg);
                }
            ],
            //'course-img'    => 'image|max:1024',
            'contentArr'    => [
                'present',
                function ($attribute, $value, $fail) {                    
                    if($value == []) return;                    

                    if(!Arr::isAssoc($value)){
                        $fail('Array is not a associative array');
                    }
                }
            ],
            'contentArr.*'                  => 'required|array',
            //'contentArr.*'                  => 'array',
            'contentArr.*.*'                => 'required|array',            
            
            //'contentArr.*.*.inputText'      => 'required|string',
            'contentArr.*.*.inputText'      => 'string|email',

            'contentArr.*.*.inputUrl'       => 'required|string',
            'contentArr.*.*.linkParam'      => 'present|string',
            'contentArr.*.*.isFree'         => 'required|boolean',
            'contentArr.*.*.type'           => [
                'required',
                Rule::in(['qdownload', 'qother', 'qvideo']),
            ]

        ];
    }


    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {                
        $contentArrMessages = [];

        foreach ($this->request->get('contentArr') as $secHeading => $secContent) {
            /* 'contentArr.*' => 'array'   */
            $contentArrMessages['contentArr.' . $secHeading . '.required'] = 'content is required';/////


            $contentArrMessages['contentArr.' . $secHeading . '.array']    = 'content is not in corect format';

            foreach ($secContent as $linkIndex => $linkContent) {
                $linkPosition = $linkIndex + 1;

                /* 'contentArr.*.*' => 'required|array' */
                $contentArrMessages['contentArr.' . $secHeading . '.'. $linkIndex .'.required'] = 'link is required'; 
                $contentArrMessages['contentArr.' . $secHeading . '.'. $linkIndex .'.array']    = 'link is not in corect format';
                                
                /* 'contentArr.*.*.inputText' => 'required|string' */
                //$contentArrMessages['contentArr.' . $secHeading . '.'. $linkIndex .'.inputText'.'.required']  = 'text is required';
                //$contentArrMessages['contentArr.' . $secHeading . '.'. $linkIndex .'.inputText'.'.string']    = 'text must be string';
                $contentArrMessages['contentArr.' . $secHeading . '.'. $linkIndex .'.inputText'.'.string']  = 'text must be string';
                $contentArrMessages['contentArr.' . $secHeading . '.'. $linkIndex .'.inputText'.'.email']   = 'text must be email';


                /* 'contentArr.*.*.inputUrl'  => 'required|string' */ 
                $contentArrMessages['contentArr.' . $secHeading . '.'. $linkIndex .'.inputUrl'.'.required']   = 'url is required';
                $contentArrMessages['contentArr.' . $secHeading . '.'. $linkIndex .'.inputUrl'.'.string']     = 'url must be string';

                /* 'contentArr.*.*.linkParam' => 'present|string' */
                $contentArrMessages['contentArr.' . $secHeading . '.'. $linkIndex .'.linkParam'.'.present']   = 'Duration/Size field must be present';
                $contentArrMessages['contentArr.' . $secHeading . '.'. $linkIndex .'.linkParam'.'.string']    = 'Duration/Size field value must be string';

                /* 'contentArr.*.*.isFree'    => 'required|boolean' */
                $contentArrMessages['contentArr.' . $secHeading . '.'. $linkIndex .'.isFree'.'.required']     = 'price type is required';
                $contentArrMessages['contentArr.' . $secHeading . '.'. $linkIndex .'.isFree'.'.boolean']      = 'price type is invalid';
                
                /* 'contentArr.*.*.type'      => ['required',Rule::in(['download', 'other', 'qvideo'])]  */             
                $contentArrMessages['contentArr.' . $secHeading . '.'. $linkIndex .'.type'.'.required']   = 'link type is required';
                $contentArrMessages['contentArr.' . $secHeading . '.'. $linkIndex .'.type'.'.in']         = 'link type is invalid';
            }            
        }      
        //echo '<pre>',print_r($contentArrMessages,true),'</pre>';dd();
        return [
            'course-name.required'      => 'Course name field is required.',
            'course-name.min'           => 'Course name must be minimum 3 characters long.',
            'course-name.unique'        => 'Course name already exist.',
            'subject.required'          => 'Subject need to assign for a course.',
            'teacher.required'          => 'Teacher need to assign for a course.',            
            'course-heading.required'   => 'Course heading field is required.',
            'video-count.numeric'       => ':attribute must be a number.',
            'video-count.min'           => ':attribute value must be greater than zero.',            
        
        ] + $contentArrMessages;
        
    }


    // Special Naming for Attributes
    public function attributes()
    {
        return [
            'course-name'   => 'Course name',
            'subject'       => 'Course subject',
            'teacher'       => 'Course teacher',
            'course-heading'=> 'Course heading',
            'video-count'   => 'Video count',
            'course-img'    => 'Course image',          

            'contentArr'    => 'Course content',            
            /*
            'contentArr.*'              => 'sections of course content',
            'contentArr.*.*'            => 'links of course content',            
            'contentArr.*.*.inputText'  => 'link names of course content',
            'contentArr.*.*.inputUrl'   => 'link urls of course content',
            'contentArr.*.*.linkParam'  => 'link parameter values of course content',
            'contentArr.*.*.isFree'     => 'link free/paid types of course content',
            'contentArr.*.*.type'       => 'link types of course content'
            */

        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
        
        return redirect()
            ->route('admin.course.create')
            //->withErrors($this->isValidContentJson)
            ->withErrors($validator,'courseCreate')
            ->withInput()
            ->with(['isValidContentJson' => $this->isValidContentJson]);;
        // parent::failedValidation($validator);
    }

}
