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
        //dd($this->request);
        if(!$this->get('course-price')){
            $this->merge(['course-price' => 0]);
        }

        if(!$this->get('author_share_percentage')){
            $this->merge(['author_share_percentage' => '60']);
        }
        //dd($this->get('contentJson'));
        try {
            $contentArr = json_decode($this->get('contentJson'), true, 512, JSON_THROW_ON_ERROR);
            $topicsArr  = json_decode($this->get('topicsJson'), true, 512, JSON_THROW_ON_ERROR);
            
            $tempContentArr = array();
            foreach ($contentArr as $key => $value) {
                $tempContentArr[base64_encode($key)] = $value;
            }

            $tempTopicsArr = array();
            foreach ($topicsArr as $key => $value) {
                $tempTopicsArr[$key] = base64_encode($value);
            }

            //dd();
            $this->isValidContentJson = true;
            $this->merge([
                'contentArr' => $tempContentArr,
                'topicsArr'  => $tempTopicsArr,
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

            'course-duration-minutes'   => 'required|numeric|between:0,59',
            'course-duration-hours'     => 'numeric|min:0',


                    



            
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
            
            'contentArr.*'                  => 'array', //OK  
            //'contentArr.*'                  => 'required|array',
            
            'contentArr.*.*'                => 'required|array',   //OK          
            //'contentArr.*.*'                => 'required|string',

            'contentArr.*.*.inputText'      => 'required|string', //OK
            //'contentArr.*.*.inputText'      => 'string|email',

            'contentArr.*.*.inputUrl'       => 'required|url', //OK
            //'contentArr.*.*.inputUrl'       => 'string|email',

            'contentArr.*.*.linkParam'      => 'present|string', //OK
            //'contentArr.*.*.linkParam'      => 'string|email',
            
            'contentArr.*.*.isFree'         => 'required|boolean', //OK
            //'contentArr.*.*.isFree'         => 'string|email',
            
            'contentArr.*.*.type'           => [
                'required',
                Rule::in(['download', 'other', 'video']),
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
        //dump($this->request->get('contentArr'));
        if(null != $this->request->get('contentArr')){
            foreach ($this->request->get('contentArr') as $encrypt_secHeading => $secContent) {            
                
                /* 'contentArr.*' => 'array'   */            
                //$contentArrMessages['contentArr.' . $encrypt_secHeading . '.required'] = 'content is required';
                $contentArrMessages['contentArr.' . $encrypt_secHeading . '.array']    = 'content is not in corect format';

                foreach ($secContent as $linkIndex => $linkContent) {
                    $linkPosition = $linkIndex + 1;

                    /* 'contentArr.*.*' => 'required|array' */
                    $contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.required'] = 'link is required'; 
                    $contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.array']    = 'link is not in corect format';
                    //$contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.string'] = 'link must be string'; 
                    //$contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.email']    = 'link must be email';
                                       
                    
                    /* 'contentArr.*.*.inputText' => 'required|string' */
                    $contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.inputText'.'.required']  = 'text is required';
                    $contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.inputText'.'.string']    = 'text must be string';
                    //$contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.inputText'.'.string']  = 'text must be string';
                    //$contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.inputText'.'.email']   = 'text must be email';


                    /* 'contentArr.*.*.inputUrl'  => 'required|string' */ 
                    $contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.inputUrl'.'.required']   = 'url is required';
                    $contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.inputUrl'.'.url']     = 'must be vali URL';
                    //$contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.inputUrl'.'.string']   = 'url must be string';
                    //$contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.inputUrl'.'.email']     = 'url must be email';

                    
                    /* 'contentArr.*.*.linkParam' => 'present|string' */
                    $contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.linkParam'.'.present']   = 'Duration/Size field must be present';
                    $contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.linkParam'.'.string']    = 'Duration/Size field value must be string';
                    //$contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.linkParam'.'.string']   = 'Duration/Size field must be string';
                    //$contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.linkParam'.'.email']    = 'Duration/Size field value must be email';


                    /* 'contentArr.*.*.isFree'    => 'required|boolean' */
                    $contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.isFree'.'.required']     = 'price type is required';
                    $contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.isFree'.'.boolean']      = 'price type is invalid';
                    //$contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.isFree'.'.string']     = 'price type must be string';
                    //$contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.isFree'.'.email']      = 'price type must be email';


                    /* 'contentArr.*.*.type'      => ['required',Rule::in(['download', 'other', 'qvideo'])]  */             
                    $contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.type'.'.required']   = 'link type is required';
                    $contentArrMessages['contentArr.' . $encrypt_secHeading . '.'. $linkIndex .'.type'.'.in']         = 'link type is invalid';
                }            
            }      
            //echo '<pre>',print_r($contentArrMessages,true),'</pre>';dd();
        }
        
        return [
            'course-name.required'      => 'Course name field is required.',
            'course-name.min'           => 'Course name must be minimum 3 characters long.',
            'course-name.unique'        => 'Course name already exist.',
            'subject.required'          => 'Subject need to assign for a course.',
            'teacher.required'          => 'Teacher need to assign for a course.',            
            'course-heading.required'   => 'Course heading field is required.',
            'video-count.numeric'       => ':attribute must be a number.',
            'video-count.min'           => ':attribute value must be greater than zero.',   

            'course-duration-hours.numeric'     => "Course duration hour count must be a number",
            'course-duration-hours.min'         => "Course duration hour count cannot be minus",
            
            'course-duration-minutes.required'  => "Course duration minute count is required",
            'course-duration-minutes.numeric'   => "Course duration minute count is invalid",
            'course-duration-minutes.between'   => "Course duration minute count must be a number between 0 and 59, including both 0 and 59",                         
        
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
            ->route('admin.courses.create')
            //->withErrors($this->isValidContentJson)
            ->withErrors($validator,'courseCreate')
            ->withInput()
            ->with(['isValidContentJson' => $this->isValidContentJson]);;
        // parent::failedValidation($validator);
    }

}
