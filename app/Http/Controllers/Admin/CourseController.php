<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use App\Services\TeacherService;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

use App\Http\Requests\Admin\Course\CourseStoreRequest;
use App\Http\Requests\Admin\Course\CourseUpdateRequest;
use Illuminate\Support\Facades\Session;

use App\Services\CourseService;
use App\Utils\FileUploadUtil;
use App\Utils\UrlUtil;
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
        
        /*try{
            
           $rr = Course::find(42);


            dump('eeee');
            dump(Course::find(42));


            dump(Course::find(42)->toArray());
            dump(Course::find(42)->content);
            dump(Course::find(42)->topics);
            //dd('ffff');
        }catch(\Exception $e){

            dump($e);
            //dd('tt');
            
        }*/


        



        //dd('index');
        //todo - Enrolled, Completed, Rating

        //dd(cleanUsernameString('WW.e rr..rt gg...ppp A1aasas _asas  gg"jj / ss h/h__oo s\de dd2!!@@#@DD 6&&& && jjjj$/$  f gg  hh   ii    k'));
        //'ww.e rr..rt gg...ppp aasas _asas ss hh_oo sde dd2!!@@#@DD 6&&& && jjjj$/$  f gg  hh   ii    k'));
        //"ww.e rr..rt gg...ppp aasas _asas ss hh_oo sde dd2!!@@#@DD 6&&& && jjjj$/$ f gg hh ii k"
        //"ww.e.rr..rt.gg...ppp.aasas._asas.ss.hh_oo.sde.dd2!!@@#@DD.6&&&.&&.jjjj$/$.f.gg.hh.ii.k"
        //"ww.e.rr.rt.gg.ppp.aasas._asas.ss.hh_oo.sde.dd2DD.6.jjjj.f.gg.hh.ii.k"



        //"ww.err..rtgg...pppaasas_asassshh_oosdedd2DD6jjjjfgghhiik"
        //"ww.err.rtgg.pppaasas_asassshh_oosdedd2DD6jjjjfgghhiik"

        //"ww.err..rtgg...pppaasas_asassshh_oosdedd2DD6jjjjfgghhiik"
        //"ww.err.rtgg.pppaasas_asassshh_oosdedd2DD6jjjjfgghhiik"
        $us = new UserService();

        //if($us->checkUsernameExists('ggg'))
        //dd($us->generateUniqueUsername('wxaluma'));




        $data = Course::orderBy('id')->get();

        //dd($data->toArray());


//        $data->each(function($item, $key) {
//            var_dump($item->id);
//
//            var_dump($item->subject->name);
//            var_dump($item->teacher->full_name);
//
//
//
//
//        });
        //dd($data);

        return view('admin-panel.course-list')->withData($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjectsDataSet =  Subject::all ('id','name')->toArray();
        
        //dump($ttt = base64_encode('contentArr.inputUrl.ee.inputUrl'));
        //dd(base64_decode($ttt));



        $teacherService = new TeacherService();
        $allTeachers = $teacherService->getAllTeachers();
        $teachersDataSet = $allTeachers->map(function ($teacher) {
            return collect($teacher->toArray())
                ->only(['id', 'full_name', 'email'])
                ->all();
        })->toArray();

        //dd($teachersDataSet);

        return view('admin-panel.course-add')->with([
            'teachers'       => $teachersDataSet,
            //'teachers'       => [],
            'subjects'       => $subjectsDataSet,
        ]);


        //return view('admin-panel.course-add');
        //return view('admin-panel.course-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */




    public function store(CourseStoreRequest $request)
    //public function store(Request $request)
    {
        //dd($request->all());
        //=============`todo - course section heading topics string how set ????        
        //=============`todo - client side val for course content
        //=============`todo - user input characters filetr

        //dd($dd);

        //dump(Session::all());
        //dump(Session::get('errors'));
        //dump(Session::get('errors')->courseCreate);
        //dump(Session::get('errors')->courseCreate->getMessages());dd();
        //dd();

        /*$courseContentErrMsgArr       = array();
        $courseContentLinkErrMsgArr     = array();
        $courseInfoErrMsgArr            = array();*/
        //dd(Session::get('errors'));

        //dd(Session::get('errors')->courseCreate->getMessages());

        if(null != Session::get('errors') && null != Session::get('errors')->courseCreate->getMessages()){
            $courseValErrors = $this->courseService->getCourseValidationErrors(Session::get('errors')->courseCreate->getMessages());
        }
        //dump($courseValErrors);


        /*
        foreach (Session::get('errors')->courseCreate->getMessages() as $errField => $valErrMsgArr):
            if(Str::startsWith($errField, 'contentArr.')){
                $sectionHeading = Str::of($errField)->explode('.')[1];

                foreach ($valErrMsgArr as $errMsg){

                    if(isset(Str::of($errField)->explode('.')[2])){
                        $linkIndex = Str::of($errField)->explode('.')[2];                        
                        if(!isset($courseContentLinkErrMsgArr[$sectionHeading][$linkIndex])){
                            $courseContentLinkErrMsgArr[$sectionHeading][$linkIndex] = $errMsg;
                        }else{
                            $courseContentLinkErrMsgArr[$sectionHeading][$linkIndex] .= ', '.$errMsg;
                        }
                    }else{
                        $courseContentErrMsgArr[$sectionHeading][] = $errMsg;
                    }
                }
            }else{
                $courseInfoErrMsgArr[$errField] = $valErrMsgArr;               
            }
        endforeach;
        */
        
        



        //dd();
        //dd(Session::get('errors')['courseCreate']);
        //dump($request->validator->fails());
        //dump($request->validator);
        //dump($request->isValidContentJson);
        //dd($request);

        //dd($request->get('contentArr.*'));
        
        //dump($request->get('contentArr'));
        //dump($request->get('contentArr')['ff'][0]['isFree']);
        //dd(gettype($request->get('contentArr')['ff'][0]['isFree']));
        //
        //dump('course-store');
        //dump($request->get('contentJson'));
        //dump(json_decode($request->get('contentJson')));
        //dd(collect(json_decode($request->get('contentJson'), true)));
        //dd($request->all());
        //dd($request);
        //dd(json_decode($request->get('contentJson'),true));

        try{
            //$this->authorize('createTeachers',User::class);            
            



            //dump($request->get('contentArr'));

            
            //$contentString = json_encode($request->get('contentArr'),JSON_THROW_ON_ERROR|JSON_UNESCAPED_LINE_TERMINATORS ,512);
            $contentString = array();
            foreach ($request->get('contentArr') as $key => $value) {
                $contentString[base64_decode($key)] = $value;
            }

            $topicsString = array();
            foreach ($request->get('topicsArr') as $key => $value) {
                $topicsString[$key] = base64_decode($value);
            }



            //$topicsString  = json_encode($request->get('topicsArr'),JSON_THROW_ON_ERROR,512);
            //$topicsString  = $request->get('topicsArr');
            
            //dump($contentString);
            //dump($topicsString);
            //dd();






            $validationErrMsg = ($request->isValidContentJson == false) ? 'Course content is not in valid format':'';

            if (isset($request->validator) && $request->validator->fails()) {
                $validationErrMsg .= ($validationErrMsg != '') ? ' and ':'';
                $validationErrMsg .= 'Form validation is failed';
            }

            if($validationErrMsg){
                $validationErrMsg .= ' !';
                throw new CustomException($validationErrMsg);
            }




            
            $file = $request->input('course-img');
            if(isset($file)){
                $fileUploadUtil = new FileUploadUtil();
                $destination    = $fileUploadUtil->upload($file,'courses/');
            }else{
                $destination =null;
            }
            

            
           
            $courseStatus = ($request->get('course_stat')=='published')? 'published': 'draft';
            




            $urlString  = UrlUtil::wordsToUrl($request->get('course-name'),15);
            $slug       = UrlUtil::generateCourseUrl($urlString);
            


            //$slug = SlugService::createSlug(Subject::class, 'slug', $urlString);

 



            //DB::enableQueryLog();

            Course::create([
                'name'                    => $request->get('course-name'),
                'subject_id'              => $request->get('subject'),
                'teacher_id'              => $request->get('teacher'),
                'heading_text'            => $request->get('course-heading'),
                'description'             => $request->get('course-description'),
                'duration'                => $request->get('video-duration'),
                'video_count'             => $request->get('video-count'),
                'author_share_percentage' => $request->get('author_share_percentage'),
                'price'                   => $request->get('course-price'),
                'status'                  => $courseStatus,
                'image'                   => $destination,
                'topics'                  => $topicsString, 
                'content'                 => $contentString,
                'slug'                    => $slug    
            ]);

            //dd($contentString);

            return redirect()->route('admin.course.create')->with([
                'message' => 'Course created successfully',
                'cls'     => 'flash-success',
                'msgTitle'=> 'Success',
            ]);

            //
            /*

            $user_teacher = Sentinel::registerAndActivate($teacher);
            $role_teacher = Sentinel::findRoleBySlug('teacher');
            $role_teacher->users()->attach($user_teacher);

            return redirect()->back()->with([
                'teacher_submit_message'  => 'Add Teacher success',
                'teacher_submit_message2' => $usernameMsg,
                //'teacher_submit_title'   => 'Student Registration submit page',
                'teacher_submit_cls'     => 'flash-success',
                'teacher_submit_msgTitle'=> 'Success',
            ]);
            */

        }catch(CustomException $e){

            /* when $courseContentLinkErrMsgArr send as a meessage bag error as following code
            ->withErrors($courseContentLinkErrMsgArr,'courseContentLinkErrMsgArr')
            then laravel automatically remove all duplicated message in one key element in array */

            return redirect()->back()
            ->withErrors($courseValErrors['contentErrMsgArr'],'contentErrMsgArr')            
            ->withErrors($courseValErrors['infoErrMsgArr'],'infoErrMsgArr')
            ->with([
                'message'               => $e->getMessage(),
                //'message'             => $e->getMessage(),         
                'cls'                   => 'flash-danger',
                'msgTitle'              => 'Error!',
                'contentLinksErrMsgArr' => $courseValErrors['contentLinksErrMsgArr']
            ]);

        }catch(AuthorizationException $e){
            return redirect()->back()->with([
                'message'  => 'You dont have Permissions to create Teachers !',
                //'message2' => $pwResetTxt,                
                'cls'     => 'flash-danger',
                'msgTitle'=> 'Permission Denied!',
                
            ]);

        }catch(\Exception $e){

            dump($e->getMessage());dd('tt');
            return redirect()->back()->with([
                'message'  => 'Add Teacher Failed!',
                //'message'  => $e->getMessage(),
                //'message2' => $pwResetTxt,
                'cls'     => 'flash-danger',
                'msgTitle'=> 'Error!',

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
        //dd('fgfg');
        //$course = Course::find($id);
        //dump($course->content);
        //dump($course->topics);
        //dd();


        try{

            if(!filter_var($id, FILTER_VALIDATE_INT)){
                //dd('Invalid id');
                throw new CustomException('Invalid id');
            }
            $course = Course::find($id);
            //dd($course);
            //dump($course->content);
            //dump(json_encode($course->content,512));
            //dd();


            // $string = preg_replace("/\r\n+/", " ", $course->content);
            // dump($string);



            // $json = utf8_encode($string);
            // dump('json1');
            // dump($json);
            // dump('=============');
            // $json = json_decode($json);
            // dump('json2');
            // dump($json);
            // dump('=============');




            //$contentArr = json_decode($course->content, true, 512, JSON_THROW_ON_ERROR);
            //dd($contentArr);

            //var_dump($course->content);
            //dd();
            if($course == null){
                throw new ModelNotFoundException;                
            }           
            

        }catch(CustomException $e){
            session()->flash('message',$e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            unset($course);       

        }catch(\Exception $e){
            session()->flash('message','Course does not exist!');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!'); 
            unset($course);           
        }

        return view('admin-panel.course-view')->with([
            'course' => $course??null
        ]);        
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
                //dd('Invalid id');
                throw new CustomException('Invalid id');
            }
            




            $course = Course::find($id);
            //dd($course);
            //dump($course->content);
            //dump(json_encode($course->content,512));
            //dd();
            //$courseContent = json_encode(null,512);
            $courseContent = json_encode($course->content,512);
            //dd($courseContent);
            
            //dump($a1 = json_decode(null, true, 512));            
            //dump(json_encode($a1,512));



            //dump(json_encode('',512));
            //dump(json_encode('',512));
            // $string = preg_replace("/\r\n+/", " ", $course->content);
            // dump($string);



            // $json = utf8_encode($string);
            // dump('json1');
            // dump($json);
            // dump('=============');
            // $json = json_decode($json);
            // dump('json2');
            // dump($json);
            // dump('=============');




            //$contentArr = json_decode($course->content, true, 512, JSON_THROW_ON_ERROR);
            //dd($contentArr);

            //var_dump($course->content);
            //dd();
            if($course == null){
                throw new ModelNotFoundException;                
            }else{
                 
                $subjectsDataSet =  Subject::all ('id','name')->toArray();               

                $teacherService = new TeacherService();
                $allTeachers = $teacherService->getAllTeachers();
                $teachersDataSet = $allTeachers->map(function ($teacher) {
                    return collect($teacher->toArray())
                        ->only(['id', 'full_name', 'email'])
                        ->all();
                })->toArray();



                /*
                dump($course);
                dump($courseContent);
                dump($teachersDataSet);
                dump($subjectsDataSet);
                dd();
                */

                return view('admin-panel.course-edit')->with([
                    'course'            => $course,
                    'courseContent'     => $courseContent,
                    'teachers'          => $teachersDataSet,
                    //'teachers'        => [],
                    'subjects'          => $subjectsDataSet,

                ]); 

            }          
            

        }catch(CustomException $e){
            session()->flash('message',$e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('admin-panel.course-edit');       

        }catch(\Exception $e){
            session()->flash('message','Course does not exist!');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!'); 
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
    //public function update(Request $request, $id)
    {
        
        //dd($id);

        ///////////////
        try{
            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }
            $course = Course::find($id);
            //dd(Session::get('errors')->courseUpdate->getMessages());

            if(null != Session::get('errors') && null != Session::get('errors')->courseUpdate->getMessages()){
                $courseValErrors = $this->courseService->getCourseValidationErrors(Session::get('errors')->courseUpdate->getMessages());
            }



            $validationErrMsg = ($request->isValidContentJson == false) ? 'Course content is not in valid format':'';

            if (isset($request->validator) && $request->validator->fails()) {
                $validationErrMsg .= ($validationErrMsg != '') ? ' and ':'';
                $validationErrMsg .= 'Form validation is failed';
            }

            if($validationErrMsg){
                $validationErrMsg .= ' !';
                throw new CustomException($validationErrMsg);
            }




            

            
            //--------------$this->authorize('update',$course);
            if ($course) {

                $course_name = $request->get('course-name');
                $courseCount = Course::where('id', '!=', $id)->where('name', '=', $course_name)->count();

                if($courseCount == 0) {
                    
                    /* upload image if have one */
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

            

            



                    $course->name                    = $request->get('course-name');
                    $course->subject_id              = $request->get('subject');
                    $course->teacher_id              = $request->get('teacher');
                    $course->heading_text            = $request->get('course-heading');
                    $course->description             = $request->get('course-description');
                    $course->duration                = $request->get('video-duration');
                    $course->video_count             = $request->get('video-count');
                    $course->author_share_percentage = $request->get('author_share_percentage');
                    $course->price                   = $request->get('course-price');
                    $course->status                  = ($request->get('course_stat')=='published')?'published': 'draft';
                    $course->image                   = $imgDest;
                    

                    $topicsString = array();
                    foreach ($request->get('topicsArr') as $key => $value) {
                        $topicsString[$key] = base64_decode($value);
                    }
                    $course->topics                  = $topicsString;
                    





                    $contentString = array();
                    foreach ($request->get('contentArr') as $key => $value) {
                        $contentString[base64_decode($key)] = $value;
                    }
                    $course->content                 = $contentString;                
                    
                    




                    $course->save();
                    
                    

















                    return redirect()->route('admin.course.index')->with([
                        'message' => 'Course updated successfully',
                        'cls'     => 'flash-success',
                        'msgTitle'=> 'Success',
                    ]);

                }else{
                    throw new CustomException('Course name already exists!',[
                        'cls'     => 'flash-warning',
                        'msgTitle'=> 'Warning!',
                    ]);
                }

            } else {
                throw new CustomException('Course does not exist!',[
                    'cls'     => 'flash-warning',
                    'msgTitle'=> 'Warning!',
                ]);
            }

        }catch(CustomException $e){


            /* when $courseContentLinkErrMsgArr send as a meessage bag error as following code
            ->withErrors($courseContentLinkErrMsgArr,'courseContentLinkErrMsgArr')
            then laravel automatically remove all duplicated message in one key element in array */

            return redirect()->back()
            ->withErrors($courseValErrors['contentErrMsgArr'],'contentErrMsgArr')            
            ->withErrors($courseValErrors['infoErrMsgArr'],'infoErrMsgArr')
            ->with([
                'message'               => $e->getMessage(),
                //'message'             => $e->getMessage(),         
                'cls'                   => 'flash-danger',
                'msgTitle'              => 'Error!',
                'contentLinksErrMsgArr' => $courseValErrors['contentLinksErrMsgArr']
            ]);


            
        }catch(AuthorizationException $e){
            return redirect()->route('admin.course.index')->with([
                'message'     => 'You dont have Permissions to update the course!',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with([
                'message'  => 'Course update failed!',
                'cls'     => 'flash-danger',
                'msgTitle'=> 'Error !',
            ]);
        }
        ////////////
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
            $course = Course::find($id);
            if ($course) {

                $course->delete();
                return redirect(route('admin.course.index'))->with([
                    'message'  => 'successfully deleted the course',
                    'cls'     => 'flash-success',
                    'msgTitle'=> 'Success!',
                ]);

            } else {
                throw new CustomException('Course does not exist!',[
                    'cls'     => 'flash-warning',
                    'msgTitle'=> 'Warning!',
                ]);

            }
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

            $course = Course::find($request->courseId);

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

            $course = Course::find($request->courseId);
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
