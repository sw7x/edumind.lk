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
        //dd($subjects);


        $teacherService = new TeacherService();
        $allTeachers = $teacherService->getAllTeachers();
        $teachersDataSet = $allTeachers->map(function ($teacher) {
            return collect($teacher->toArray())
                ->only(['id', 'full_name', 'email'])
                ->all();
        });

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
        //dump(Session::all());
        //dump(Session::get('errors'));
        //dump(Session::get('errors')->courseCreate);
        //dump(Session::get('errors')->courseCreate->getMessages());dd();
        //dd();

        /*$courseContentErrMsgArr         = array();
        $courseContentLinkErrMsgArr     = array();
        $courseInfoErrMsgArr            = array();*/

        $courseValErrors = $this->courseService->getCourseValidationErrors(Session::get('errors')->courseCreate->getMessages());
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
       // dd($request);

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
            //$file = $request->input('course-img');
            //dd($file);


            $validationErrMsg = ($request->isValidContentJson == false) ? 'Course content is not in valid format':'';

            if (isset($request->validator) && $request->validator->fails()) {
                $validationErrMsg .= ($validationErrMsg != '') ? ' and ':'';
                $validationErrMsg .= 'Form validation is failed';
            }

            if($validationErrMsg){
                $validationErrMsg .= ' !';
                throw new CustomException($validationErrMsg);
            }




            /*
            
            if(isset($file)){
                $fileUploadUtil = new FileUploadUtil();
                $destination    = $fileUploadUtil->upload($file,'courses/');
            }else{
                $destination =null;
            }


            $status = ($request->get('teacher_stat')=='enable')? True: False;
            //DB::enableQueryLog();

            $teacher = [
                'full_name'         => $request->get('teacher-name'),
                'email'             => $request->get('teacher-email'),
                'password'          => $request->get('teacher-password'),
                'phone'             => $request->get('teacher-phone'),
                'username'          => $username,
                'edu_qualifications'=> $request->get('teacher_edu_details'),
                'gender'            => $request->get('teacher-gender'),
                'dob_year'          => $request->get('teacher_birth_year'),
                'status'            => $status,
                'profile_pic'       => $destination,

            ];

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
                'msgTitle'              => 'Error !',
                'contentLinksErrMsgArr' => $courseValErrors['contentLinksErrMsgArr']
            ]);

        }catch(AuthorizationException $e){
            return redirect()->back()->with([
                'message'  => 'You dont have Permissions to create Teachers !',
                //'message2' => $pwResetTxt,                
                'cls'     => 'flash-danger',
                'msgTitle'=> 'Permission Denied !',
                
            ]);

        }catch(\Exception $e){
            return redirect()->back()->with([
                'message'  => 'Add Teacher Failed !',
                //'message'  => $e->getMessage(),
                //'message2' => $pwResetTxt,
                'cls'     => 'flash-danger',
                'msgTitle'=> 'Error !',

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

        try{

            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }
            $course = Course::find($id);
            //var_dump($course->content);
            //dd();
            if($course != null){
                return view('admin-panel.course-view')->with(['course' => $course]);
            }else{
                throw new ModelNotFoundException;
            }
        }catch(CustomException $e){

            return view('admin-panel.course-view')->with([
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);

        }catch(\Exception $e){
            return view('admin-panel.course-view')->with([
                'message'     => 'Course does not exist!',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }

        return view('admin-panel.course-view');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $subjectsDataSet =  Subject::all ('id','name')->toArray();
        //dd($subjects);


        $teacherService = new TeacherService();
        $allTeachers = $teacherService->getAllTeachers();
        $teachersDataSet = $allTeachers->map(function ($teacher) {
            return collect($teacher->toArray())
                ->only(['id', 'full_name', 'email'])
                ->all();
        });

        //dd($teachersDataSet);

        return view('admin-panel.course-edit')->with([
            'teachers'       => $teachersDataSet,
            //'teachers'       => [],
            'subjects'       => $subjectsDataSet,
        ]);






        //dd('edit');
        return view('admin-panel.course-edit');
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
        //
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

                return redirect(route('admin.course.index'))
                    ->with([
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

            $exData = $e->getData();
            //dd($e->getData());
            return view('admin-panel.user-view')->with([
                'message'     => $e->getMessage(),
                'cls'         => $exData['cls'] ?? "flash-danger",
                'msgTitle'    => $exData['msgTitle']  ?? 'Error !',
            ]);

        }catch(\Exception $e){
            return view('admin-panel.user-view')->with([
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
                'message'  => 'Course status check failed!',
                'status' => 'error',
            ]);
        }
    }



    /*public function courseContent()
    {
        return view('admin-panel.course-content');
    }*/


    public function addCourseCopy()
    {
        return view('admin-panel.course-add-copy');
    }


    public function changeStatus(Request $request){
        dd('changeStatus');
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
