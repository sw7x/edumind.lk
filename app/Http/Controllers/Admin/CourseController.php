<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use App\Services\TeacherService;
use App\Services\UserService;
//use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

use App\Http\Requests\Admin\Course\CourseStoreRequest;
use App\Http\Requests\Admin\Course\CourseUpdateRequest;
use Illuminate\Support\Facades\Session;

use App\Services\CourseService;
use App\Utils\FileUploadUtil;
use App\Utils\UrlUtil;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    private $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;       

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       
        try{            
            //$this->authorize('viewAny',Course::class);            
            $data       = Course::withoutGlobalScope('published')->orderBy('id')->get();
            return view('admin-panel.course-list')->withData($data);            

        }catch(AuthorizationException $e){           
            return redirect(route('admin.dashboard'))->with([
                'message'   =>'You dont have Permissions view all users',
                'cls'       =>'flash-danger',
                'msgTitle'  =>'Permission Denied!'
            ]);

        }catch(\Exception $e){               
            session()->flash('message','Failed to show courses');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('admin-panel.user-list');
        }        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            //$this->authorize('create',Course::class);        
            $subjectsDataSet    =  Subject::all ('id','name')->toArray();    
            
            $teacherService     = new TeacherService();
            $allTeachers        = $teacherService->getAllTeachers();
            $teachersDataSet    = $allTeachers->map(function ($teacher) {
                                    return collect($teacher->toArray())
                                        ->only(['id', 'full_name', 'email'])
                                        ->all();
                                })->toArray();            

            return view('admin-panel.course-add')->with([
                'teachers'       => $teachersDataSet,
                //'teachers'       => [],
                'subjects'       => $subjectsDataSet,
            ]);


        }catch(AuthorizationException $e){
            return redirect(route('admin.course.index'))->with([
                'message'   =>'You dont have Permissions to create courses',
                'cls'       =>'flash-danger',
                'msgTitle'  =>'Permission Denied!'
            ]);

        }catch(\Exception $e){
            session()->flash('message',  'Failed to show course add form');
            session()->flash('cls',      'flash-danger');
            session()->flash('msgTitle', 'Error!');
            return view('admin-panel.course-add');
        }
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseStoreRequest $request)
    {
        try{
            //$this->authorize('create',Course::class);

            //dump(Session::all());
            //dump(Session::get('errors'));
            //dump(Session::get('errors')->courseCreate);
            //dd(Session::get('errors')->courseCreate->getMessages());                      

            //throw new \Exception("Error Processing Request", 1);
                                  
            /* if course content is in correct format then 
            send it to view to recive as old values */
            if($request->isValidContentJson === true){
                $contentString = array();
                foreach ($request->get('contentArr') as $key => $value) {
                    $contentString[base64_decode($key)] = $value;
                }

                $topicsString = array();
                foreach ($request->get('topicsArr') as $key => $value) {
                    $topicsString[$key] = base64_decode($value);
                }

                $validationErrMsg = '';
                $contentInputStr  = json_encode($contentString,512);
            }else{
                $validationErrMsg = 'Course content is not in valid format';
                $contentInputStr  = '{}';
            }
            $request->merge(['contentInputStr' => $contentInputStr]);

            
            
            /* creating validation eroors for view*/
            if(null != Session::get('errors') && null != Session::get('errors')->courseCreate->getMessages()){
                $courseValErrors = $this->courseService->getCourseValidationErrors(Session::get('errors')->courseCreate->getMessages());
            }
            //dd($courseValErrors);


            /* if have validation errors */
            if (isset($request->validator) && $request->validator->fails()) {
                $validationErrMsg .= ($validationErrMsg != '') ? ' and ':'';
                $validationErrMsg .= 'Form validation is failed';
            }
            if($validationErrMsg){
                $validationErrMsg .= ' !';
                throw new CustomException($validationErrMsg);
            }

            /* image upload */
            $file = $request->input('course-img');
            if(isset($file)){
                $fileUploadUtil = new FileUploadUtil();
                $destination    = $fileUploadUtil->upload($file,'courses/');
            }else{
                $destination =null;
            }




            $hours  = $request->get('course-duration-hours');
            $minutes = $request->get('course-duration-minutes');                      

            $duration  = (!$hours)?'0 Hours : ':(($hours ==1)?'1 Hour : ':$hours.' Hours : ');
            $duration .= (!$minutes)?'0 Minutes':(($minutes ==1)?'1 Minute':$hours.' Minutes');

            
            Course::create([
                'name'                    => $request->get('course-name'),
                'subject_id'              => $request->get('subject'),
                'teacher_id'              => $request->get('teacher'),
                'heading_text'            => $request->get('course-heading'),
                'description'             => $request->get('course-description'),
                'duration'                => $duration,
                'video_count'             => $request->get('video-count'),
                'author_share_percentage' => $request->get('author_share_percentage'),
                'price'                   => $request->get('course-price'),                
                'status'                  => ($request->get('course_stat') == Course::PUBLISHED)? Course::PUBLISHED: Course::DRAFT,
                'image'                   => $destination,
                'topics'                  => $topicsString, 
                'content'                 => $contentString,
                'slug'                    => UrlUtil::generateCourseShortUrl($request->get('course-name'))
            ]);            

            return redirect()->route('admin.course.create')->with([
                'message' => 'Course created successfully',
                'cls'     => 'flash-success',
                'msgTitle'=> 'Success',
            ]);            

        }catch(CustomException $e){

            /* when $courseContentLinkErrMsgArr send as a meessage bag error as following code
            ->withErrors($courseContentLinkErrMsgArr,'courseContentLinkErrMsgArr')
            then laravel automatically remove all duplicated message in one key element in array */

            return redirect(route('admin.course.create'))
                ->withErrors($courseValErrors['contentErrMsgArr'] ?? [],'contentErrMsgArr')            
                ->withErrors($courseValErrors['infoErrMsgArr'] ?? [],'infoErrMsgArr')
                ->withInput($request->input())            
                ->with([
                    'message'               => $e->getMessage(),
                    //'message'             => $e->getMessage(),         
                    'cls'                   => 'flash-danger',
                    'msgTitle'              => 'Error!',
                    'contentLinksErrMsgArr' => $courseValErrors['contentLinksErrMsgArr'] ?? []
                ]);

        }catch(AuthorizationException $e){
            return redirect(route('admin.course.create'))            
                ->with([
                    'message'  => 'You dont have Permissions to create Teachers !',
                    //'message2' => $pwResetTxt,                
                    'cls'     => 'flash-danger',
                    'msgTitle'=> 'Permission Denied!'                    
                ]);

        }catch(\Exception $e){
            /* when $courseContentLinkErrMsgArr send as a meessage bag error as following code
            ->withErrors($courseContentLinkErrMsgArr,'courseContentLinkErrMsgArr')
            then laravel automatically remove all duplicated message in one key element in array */

            return redirect(route('admin.course.create'))
                ->withErrors($courseValErrors['contentErrMsgArr'] ?? [],'contentErrMsgArr')            
                ->withErrors($courseValErrors['infoErrMsgArr'] ?? [],'infoErrMsgArr')
                ->withInput($request->input())
                ->with([
                    'message'  => 'Add Teacher Failed!',
                    //'message'  => $e->getMessage(),
                    //'message2' => $pwResetTxt,
                    'cls'     => 'flash-danger',
                    'msgTitle'=> 'Error!',
                    'contentLinksErrMsgArr' => $courseValErrors['contentLinksErrMsgArr'] ?? []
                ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{           
            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }
            $course = Course::withoutGlobalScope('published')->find($id);            
            //$this->authorize('view',$course); //todo

            if($course == null){
                //throw new ModelNotFoundException;
                throw new CustomException('Course does not found');                
            }

            //validate course content format
            if(is_array($course->content) && Arr::isAssoc($course->content)){
                $courseContent          = $course->content;
                $courseContentInvFormat = false;
            }else{
                $courseContent = [];
                $courseContentInvFormat = true;
            }         
    
            return view('admin-panel.course-view')->with([
                'course'                => $course,
                'courseContent'         => $courseContent,
                'courseContentInvFormat'=> $courseContentInvFormat,
            ]);
            
        }catch(CustomException $e){
            session()->flash('message',$e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('admin-panel.course-view');  

        }catch(AuthorizationException $e){
            return redirect(route('admin.course.index'))->with([            
                'message'     => 'You dont have Permissions to view the course !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);
            
        }catch(\Exception $e){
            session()->flash('message','Course does not exist!');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!'); 
            return view('admin-panel.course-view');

        }       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {       
        try{            
            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }
            $course = Course::withoutGlobalScope('published')->find($id);
            //todo--------------$this->authorize('update',$course);     
                               
            if($course == null){
                throw new CustomException('Course does not found');             
            }
                 
            $subjectsDataSet =  Subject::where('status',Subject::PUBLISHED)->get(['id','name'])->toArray();            
            
            $teacherService = new TeacherService();
            $allTeachers = $teacherService->getAllTeachers();            

            $teachersDataSet = $allTeachers->map(function ($teacher) {
                return collect($teacher->toArray())
                    ->only(['id', 'full_name', 'email'])
                    ->all();
            })->toArray();

            $courseContent = json_encode($course->content,512);

            // using duration string located in database get hour, minute count
            $dur_parts = array_map('trim', Str::of($course->duration)->explode(':')->toArray());              
            $course->duration_hours     =   intval(Str::of($dur_parts[0])->before('Hour')->trim()->__toString());
            $course->duration_minutes   =   intval(Str::of($dur_parts[1])->before('Minute')->trim()->__toString());
       

            return view('admin-panel.course-edit')->with([
                'course'            => $course,
                'courseContent'     => $courseContent,
                'teachers'          => $teachersDataSet,
                //'teachers'        => [],
                'subjects'          => $subjectsDataSet
            ]);
            
            
        }catch(CustomException $e){
            $exData = $e->getData();
            session()->flash('message'  ,$e->getMessage());
            session()->flash('cls'      ,$exData['cls'] ?? "flash-danger");
            session()->flash('msgTitle' ,$exData['msgTitle']  ?? 'Error !');
            return view('admin-panel.course-edit');            

        }catch(AuthorizationException $e){
            return redirect(route('admin.course.index'))->with([            
                'message'     => 'You dont have Permissions to edit the course',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);

        }
        catch(\Exception $e){
            //session()->flash('message'  ,'Failed to load course edit form!');
            session()->flash('message'  ,$e->getMessage());
            session()->flash('cls'      ,'flash-danger');
            session()->flash('msgTitle' ,'Error!'); 
            return view('admin-panel.course-edit');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseUpdateRequest $request, $id)
    {
        try{
            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }                        
            
            $course = Course::withoutGlobalScope('published')->find($id);   
            //todo--------------$this->authorize('update',$course);

            if($course == null){
                throw new CustomException('Course does not exist!',[
                    'cls'     => 'flash-warning',
                    'msgTitle'=> 'Warning!',
                ]);
            }
            
            
            /* if user entered course content is in correct format then 
            send it to view to recive as old values */
            if($request->isValidContentJson === true){
                $contentString = array();
                foreach ($request->get('contentArr') as $key => $value) {
                    $contentString[base64_decode($key)] = $value;
                }

                $topicsString = array();
                foreach ($request->get('topicsArr') as $key => $value) {
                    $topicsString[$key] = base64_decode($value);
                }

                $validationErrMsg = '';
                $contentInputStr  = json_encode($contentString,512);
            }else{
                $validationErrMsg = 'Course content is not in valid format';
                $contentInputStr  = '';
            }
            $request->merge(['contentInputStr' => $contentInputStr]);


            /* creating validation eroors for view*/
            if(null != Session::get('errors') && null != Session::get('errors')->courseUpdate->getMessages()){
                $courseValErrors = $this->courseService->getCourseValidationErrors(Session::get('errors')->courseUpdate->getMessages());
            }
            //dd($courseValErrors);

            
            /* if have validation errors */
            if (isset($request->validator) && $request->validator->fails()) {
                $validationErrMsg .= ($validationErrMsg != '') ? ' and ':'';
                $validationErrMsg .= 'Form validation is failed';
            }
            if($validationErrMsg){
                $validationErrMsg .= ' !';
                throw new CustomException($validationErrMsg);
            }                     

            
            /* start - upload image if have one */
            $file = $request->input('course-img');
            if(!isset($file)){ 
                //todo delete prev image when update image path
                // when teacher_img_add_count < 1 then delete prev image
                $imgDest = null;
            }else{
                //input filed with name = teacher_img_add_count vale equals 0 when initially filpond loads image
                if( $request->hidden_file_add_count == 0){
                    
                    // previously no image now new image is uploaded and submit form
                    if($request->hidden_course_img_url == null){
                        $fileUploadUtil = new FileUploadUtil();
                        $imgDest        = $fileUploadUtil->upload($file,'courses/');
                    }else{
                        // no change to previously upload image and submit edit form
                        $imgDest = $request->hidden_course_img_url;
                    }
                }else{
                    // previously image is uploaded and now change the image and upload
                    //todo delete prviously uploaded image
                    $fileUploadUtil = new FileUploadUtil();
                    $imgDest        = $fileUploadUtil->upload($file,'courses/');
                }
            }
            /* end  - upload image if have one */
            
            $hours  = $request->get('course-duration-hours');
            $minutes = $request->get('course-duration-minutes');                      

            $duration  = (!$hours)?'0 Hours : ':(($hours ==1)?'1 Hour : ':$hours.' Hours : ');
            $duration .= (!$minutes)?'0 Minutes':(($minutes ==1)?'1 Minute':$minutes.' Minutes');



            $course->name                    = $request->get('course-name');
            $course->subject_id              = $request->get('subject');
            $course->teacher_id              = $request->get('teacher');
            $course->heading_text            = $request->get('course-heading');
            $course->description             = $request->get('course-description');
            $course->duration                = $duration;
            $course->video_count             = $request->get('video-count');
            $course->author_share_percentage = $request->get('author_share_percentage');
            $course->price                   = $request->get('course-price');
            $course->status                  = ($request->get('course_stat') == Course::PUBLISHED)? Course::PUBLISHED :Course::DRAFT;
            $course->image                   = $imgDest;
            $course->topics                  = $topicsString;
            $course->content                 = $contentString;                    
            $course->save();
                                
            return redirect()->route('admin.course.index')->with([
                'message' => 'Course updated successfully',
                'cls'     => 'flash-success',
                'msgTitle'=> 'Success',
            ]);           
            

        }catch(CustomException $e){

            //dump($request->input());
            //dd($courseValErrors);

            /* when $courseContentLinkErrMsgArr send as a meessage bag error as following code
            ->withErrors($courseContentLinkErrMsgArr,'courseContentLinkErrMsgArr')
            then laravel automatically remove all duplicated message in one key element in array */
            return redirect(route('admin.course.edit',$id))
                ->withErrors($courseValErrors['contentErrMsgArr'] ?? [],'contentErrMsgArr')            
                ->withErrors($courseValErrors['infoErrMsgArr'] ?? [],'infoErrMsgArr')
                ->withInput($request->input())           
                ->with([
                    'message'               => $e->getMessage(),
                    //'message'             => $e->getMessage(),         
                    'cls'                   => 'flash-danger',
                    'msgTitle'              => 'Error!',
                    'contentLinksErrMsgArr' => $courseValErrors['contentLinksErrMsgArr'] ?? []
                ]);
            
        }catch(AuthorizationException $e){
            return redirect()->route('admin.course.index')
                ->with([
                    'message'     => 'You dont have Permissions to update the course!',
                    'cls'         => 'flash-danger',
                    'msgTitle'    => 'Permission Denied !',
                ]);

        }catch(\Exception $e){
            return redirect(route('admin.course.edit',$id))
                ->withErrors($courseValErrors['contentErrMsgArr'] ?? [],'contentErrMsgArr')            
                ->withErrors($courseValErrors['infoErrMsgArr'] ?? [],'infoErrMsgArr')
                ->withInput($request->input())
                ->with([
                    'message'  => 'Course update failed!',
                    //'message'  => $e->getMessage(),
                    //'message2' => $pwResetTxt,
                    'cls'     => 'flash-danger',
                    'msgTitle'=> 'Error!',
                    'contentLinksErrMsgArr' => $courseValErrors['contentLinksErrMsgArr'] ?? []
                ]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }
            
            $course = Course::withoutGlobalScope('published')->find($id);
            // $this->authorize('delete',$course);

            if($course == null){
                throw new CustomException('Course does not exist!',[
                    'cls'     => 'flash-warning',
                    'msgTitle'=> 'Warning!',
                ]);
            }
           
            $course->delete();
            return redirect(route('admin.course.index'))->with([
                'message'  => 'successfully deleted the course',
                'cls'     => 'flash-success',
                'msgTitle'=> 'Success!',
            ]);

            
        }catch(CustomException $e){
            //dd('CustomException');
            $exData = $e->getData();
            return redirect(route('admin.course.index'))->with([
                'message'     => $e->getMessage(),
                'cls'         => $exData['cls'] ?? "flash-danger",
                'msgTitle'    => $exData['msgTitle']  ?? 'Error!',
            ]);

        }catch(\Exception $e){
            return redirect(route('admin.course.index'))->with([
                'message'     => 'Course delete failed!',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }
    }


    public function checkEmpty(Request $request)
    {
        try{            
            if(!filter_var($request->courseId, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid Course id');
            }

            $course = Course::withoutGlobalScope('published')->find($request->courseId);
            $this->authorize('delete',$course);
            
            if ($course) {                
                $status = $course->isEmpty();                
                return response()->json([
                    'message'  => $status,
                    'status' => 'success',
                ]);

            } else {
                return response()->json([
                    'message'  => 'Course does not exist!',
                    'status' => 'error',
                ]);
            }

        }catch(CustomException $e){
            return response()->json([
                'message'  => $e->getMessage(),
                'status' => 'error',
            ]);

        }catch(AuthorizationException $e){          
            return response()->json([
                'message'  => 'You dont have Permissions to delete the course!',
                'status' => 'error',
            ]);            
        }catch(\Exception $e){
            return response()->json([
                //'message'  => '----'.$e->getMessage(),
                'message'   => 'Course status check failed!',
                'status'    => 'error',
            ]);
        }
    }



    /*
    public function courseContent()
    {
        return view('admin-panel.course-content');
    }
    */


    public function addCourseCopy()
    {
        return view('admin-panel.course-add-copy');
    }


    public function changeStatus(Request $request){
        
        try{            
            if(!filter_var($request->courseId, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id - User status update failed');
            }
            
            $course = Course::withoutGlobalScope('published')->find($request->courseId);
            $this->authorize('changeStatus',$course);
            
            if ($course) {
                $status = $request->status;
                $teacherUpdateInfo = ['status'=> $status];
                Course::where('id',$request->courseId)->update($teacherUpdateInfo);

                return response()->json([
                    'message'  => 'User status update success',
                    'status' => 'success',
                ]);

            } else {
                return response()->json([
                    'message'  => 'User does not exist!',
                    'status' => 'error',
                ]);
            }

        }catch(CustomException $e){
            return response()->json([
                'message'  => $e->getMessage(),
                'status' => 'error',
            ]);

        }catch(AuthorizationException $e){          
            return response()->json([
                'message'  => 'You dont have Permissions to change the status of the course!',
                'status' => 'error',
            ]);            
        }catch(\Exception $e){
            return response()->json([
                'message'  => 'User status update failed!',
                'status' => 'error',
            ]);
        }

    }


    public function viewCourseEnrollmentList(){
        $data = Course::orderBy('id')->get();
        return view('admin-panel.admin.course-enrollments')->withData($data);
    }   


    public function viewCourseCompleteList(){
        $data = Course::orderBy('id')->get();
        return view('admin-panel.admin.course-completions')->withData($data);
    }   



        

}
