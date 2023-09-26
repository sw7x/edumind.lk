<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Models\Course;

use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

use App\Http\Requests\Admin\Course\CourseStoreRequest;
use App\Http\Requests\Admin\Course\CourseUpdateRequest;
use Illuminate\Support\Facades\Session;

use App\Services\Admin\CourseService as AdminCourseService;
use App\Services\Admin\TeacherService as AdminTeacherService;
use App\Services\Admin\SubjectService as AdminSubjectService;
use App\View\DataTransformers\Admin\CourseDataTransformer as AdminCourseDataTransformer;
use Illuminate\Support\Arr;

//use Illuminate\Database\Eloquent\ModelNotFoundException;
//use App\Models\Subject;
//use App\Models\User;
//use App\Services\TeacherService;
//use App\Services\UserService;
//use App\Utils\FileUploadUtil;
//use App\Utils\UrlUtil;
//use Illuminate\Support\Str;


class CourseController extends Controller
{
    private AdminCourseService  $adminCourseService;
    private AdminTeacherService $adminTeacherService;
    private AdminSubjectService $adminSubjectService;

    public function __construct(
        AdminCourseService $adminCourseService,
        AdminTeacherService $adminTeacherService,
        AdminSubjectService $adminSubjectService
    ){
        $this->adminCourseService  = $adminCourseService;
        $this->adminTeacherService = $adminTeacherService;
        $this->adminSubjectService = $adminSubjectService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $this->authorize('viewAny',Course::class);

            $courses = $this->adminCourseService->loadAllCourses();

            $courseArr = AdminCourseDataTransformer::prepareCourseListData($courses);
            return view('admin-panel.course-list')->withData($courseArr);

        }catch(CustomException $e){
            session()->flash('message',$e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('admin-panel.course-list');

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
            return view('admin-panel.course-list');

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

            $this->authorize('create',Course::class);

            $teachersData = $this->adminTeacherService->loadAllAvailableTeachers();
            $subjectsData = $this->adminSubjectService->loadAllAvailableSubjects();

            $teachersArr = AdminCourseDataTransformer::prepareUserListData($teachersData);
            $subjectsArr = AdminCourseDataTransformer::prepareSubjectListData($subjectsData);

            return view('admin-panel.course-add')->with([
                'teachers'       => $teachersArr,
                //'teachers'       => [],
                'subjects'       => $subjectsArr,
                //'subjects'       => [],
            ]);

        }catch(CustomException $e){
            //dd($e->getMessage());
            session()->flash('message',  $e->getMessage());
            session()->flash('cls',      'flash-danger');
            session()->flash('msgTitle', 'Error!');
            return view('admin-panel.course-add');

        }catch(AuthorizationException $e){
            return redirect(route('admin.course.index'))->with([
                'message'   =>'You dont have Permissions to create courses',
                'cls'       =>'flash-danger',
                'msgTitle'  =>'Permission Denied!'
            ]);

        }catch(\Exception $e){
            //dd($e->getMessage());
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
    public function store(CourseStoreRequest $request){

        //dd($request->all());
        try{

            $this->authorize('create',Course::class);

            $dbValidCourseContent   = $this->adminCourseService->validateCourseContentForDb($request);
            $request->merge(Arr::only($dbValidCourseContent, ['contentInputStr', 'topicsString', 'contentString']));


            /* creating validation errors for view*/
            $errors = Session::get('errors');
            $courseValErrors = null;
            if (!is_null($errors) && !is_null($errors->courseCreate))
                $courseValErrors = $this->adminCourseService->getCourseValidationErrors($errors->courseCreate->getMessages());


            /* if have validation errors create text to display*/
            $valErrMsg = $dbValidCourseContent['validationErrMsg'];
            if ( isset($request->validator) && $request->validator->fails())
                $valErrMsg  .= (($valErrMsg != '') ? ' and ' : '') . 'Form validation is failed';

            if($valErrMsg)
                throw new CustomException($valErrMsg . ' !');

            $isSaved = $this->adminCourseService->saveDbRec($request);
            if (!$isSaved)
                throw new CustomException("Course create failed");

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
                ->withErrors($courseValErrors['contentMsg'] ?? [],'contentErrMsgArr')
                ->withErrors($courseValErrors['infoMsg'] ?? [],'infoErrMsgArr')
                ->withInput($request->input())
                ->with([
                    'message'               => $e->getMessage(),
                    //'message'             => $e->getMessage(),
                    'cls'                   => 'flash-danger',
                    'msgTitle'              => 'Error!',
                    'contentLinksErrMsgArr' => $courseValErrors['contentLinksMsg'] ?? []
                ]);

        }catch(AuthorizationException $e){
            return redirect(route('admin.course.create'))
                ->with([
                    'message'       => 'You dont have Permissions to create Teachers !',
                    //'message2'    => $pwResetTxt,
                    'cls'           => 'flash-danger',
                    'msgTitle'      => 'Permission Denied!'
                ]);

        }catch(\Exception $e){
            /* when $courseContentLinkErrMsgArr send as a meessage bag error as following code
            ->withErrors($courseContentLinkErrMsgArr,'courseContentLinkErrMsgArr')
            then laravel automatically remove all duplicated message in one key element in array */

            return redirect(route('admin.course.create'))
                ->withErrors($courseValErrors['contentMsg'] ?? [], 'contentErrMsgArr')
                ->withErrors($courseValErrors['infoMsg'] ?? [], 'infoErrMsgArr')
                ->withInput($request->input())
                ->with([
                    //'message'  => 'Add Teacher Failed!',
                    'message'  => $e->getMessage(),
                    //'message2' => $pwResetTxt,
                    'cls'     => 'flash-danger',
                    'msgTitle'=> 'Error!',
                    'contentLinksErrMsgArr' => $courseValErrors['contentLinksMsg'] ?? []
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
            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');

            $courseData = $this->adminCourseService->findDbRec($id);

            $this->authorize('view',$courseData['dbRec']); //todo

            if(is_null($courseData['dbRec']))
                throw new CustomException('Course does not found');

            $courseContent      = $courseData['dto']->getContent();
            $courseContentVal   = $this->adminCourseService->validateCourseContent($courseContent);

            $courseDataArr   = array();
            $courseDataArr[] = $courseData;
            $courseArr       = AdminCourseDataTransformer::prepareCourseListData($courseDataArr);
            //dd($courseArr);

            return view('admin-panel.course-view')->with([
                'course'                 => reset($courseArr),
                'courseContent'          => $courseContentVal['data'],
                'courseContentInvFormat' => $courseContentVal['isInvFormat'],
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
            session()->flash('message',$e->getMessage());
            //session()->flash('message','Course does not exist!');
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
            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');

            $courseData = $this->adminCourseService->findDbRec($id);

            $this->authorize('update',$courseData['dbRec']); //todo

            if(is_null($courseData['dbRec']))
                throw new CustomException('Course does not found');

            //to display course content
            $courseContent          = $courseData['dto']->getContent();
            $validatedCourseContent = $this->adminCourseService->validateCourseContent($courseContent);
            $courseContentStr       = json_encode($validatedCourseContent['data'], 512);


            // load teachers dropdown data
            $teachersData   = $this->adminTeacherService->loadAllAvailableTeachers();
            $teachersArr    = AdminCourseDataTransformer::prepareUserListData($teachersData);


            // load subjects dropdown data
            $subjectsData   = $this->adminSubjectService->loadAllAvailableSubjects();
            $subjectsArr    = AdminCourseDataTransformer::prepareSubjectListData($subjectsData);


            //course data
            $courseDataArr   = array();
            $courseDataArr[] = $courseData;
            $courseArr       = AdminCourseDataTransformer::prepareCourseListData($courseDataArr);

            return view('admin-panel.course-edit')->with([
                'course'        => reset($courseArr),
                'courseContent' => $courseContentStr,
                'teachers'      => $teachersArr,
                //'teachers'    => [],
                'subjects'      => $subjectsArr
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
            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');

            $courseData = $this->adminCourseService->findDbRec($id);
            if(is_null($courseData['dbRec']))
                throw new CustomException('Course does not exist!');

            $this->authorize('create', $courseData['dbRec']);

            $dbValidCourseContent   = $this->adminCourseService->validateCourseContentForDb($request);
            $request->merge(Arr::only($dbValidCourseContent, ['contentInputStr', 'topicsString', 'contentString']));


            /* creating validation eroors for view*/
            $errors = Session::get('errors');
            $courseValErrors = null;
            if (!is_null($errors) && !is_null($errors->courseCreate))
                $courseValErrors = $this->adminCourseService->getCourseValidationErrors($errors->courseCreate->getMessages());


            /* if have validation errors create text to display */
            $valErrMsg = $dbValidCourseContent['validationErrMsg'];
            if ( isset($request->validator) && $request->validator->fails())
                $valErrMsg  .= (($valErrMsg != '') ? ' and ': '') . 'Form validation has failed';


            if($valErrMsg)
                throw new CustomException($valErrMsg . ' !');


            $isSaved = $this->adminCourseService->updateDbRec($request, $courseData['dbRec']);
            if (!$isSaved)
                throw new CustomException("Course create failed");

            return redirect()->route('admin.course.create')->with([
                'message' => 'Course created successfully',
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
                ->withErrors($courseValErrors['contentMsg'] ?? [], 'contentErrMsgArr')
                ->withErrors($courseValErrors['infoMsg'] ?? [], 'infoErrMsgArr')
                ->withInput($request->input())
                ->with([
                    'message'               => $e->getMessage(),
                    //'message'             => $e->getMessage(),
                    'cls'                   => 'flash-danger',
                    'msgTitle'              => 'Error!',
                    'contentLinksErrMsgArr' => $courseValErrors['contentLinksMsg'] ?? []
                ]);

        }catch(AuthorizationException $e){
            return redirect()->route('admin.course.index')
                ->with([
                    'message'     => 'You dont have Permissions to update the course!',
                    'cls'         => 'flash-danger',
                    'msgTitle'    => 'Permission Denied !',
                ]);

        }catch(\Exception $e){
            //dd($e->getMessage());
            return redirect(route('admin.course.edit',$id))
                ->withErrors($courseValErrors['contentMsg'] ?? [], 'contentErrMsgArr')
                ->withErrors($courseValErrors['infoMsg'] ?? [], 'infoErrMsgArr')
                ->withInput($request->input())
                ->with([
                    'message'               => 'Course update failed!',
                    //'message'             => $e->getMessage(),
                    //'message2'            => $pwResetTxt,
                    'cls'                   => 'flash-danger',
                    'msgTitle'              => 'Error!',
                    'contentLinksErrMsgArr' => $courseValErrors['contentLinksMsg'] ?? []
                ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try{
            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');

            $courseData = $this->adminSubjectService->findDbRec($id);
            if(is_null($courseData['dbRec']))
                throw new CustomException('Course does not exist!');

            $this->authorize('delete', $courseData['dbRec']);

            $isDelete = $this->adminCourseService->deleteDbRec($courseData['dbRec']);
            if (!$isDelete)
                throw new CustomException("Course delete failed");

            return redirect(route('admin.course.index'))->with([
                'message'  => 'successfully deleted the course',
                'cls'      => 'flash-success',
                'msgTitle' => 'Success!',
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
            $courseId = $request->input('courseId');
            if(!filter_var($courseId, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid Course id');

            $courseData = $this->adminCourseService->findDbRec($courseId);

            if(is_null($courseData['dbRec']))
                throw new CustomException("Course does not exist!");

            //$this->authorize('delete', $courseData['dbRec']);

            $isEmpty = $this->adminCourseService->checkIsCourseEmpty($courseData['dbRec']);

            return response()->json([
                'message'  => $isEmpty,
                'status' => 'success',
            ]);

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
    public function courseContent(){
        return view('admin-panel.course-content');
    }
    */


    public function addCourseCopy(){
        return view('admin-panel.course-add-copy');
    }


    public function changeStatus(Request $request){

        try{
            $courseId = $request->input('courseId');
            if(!filter_var($courseId, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id - User status update failed');

            $courseData = $this->adminCourseService->findDbRec($courseId);

            if(is_null($courseData['dbRec']))
                throw new CustomException("Course does not exist!");

            $this->authorize('changeStatus',$courseData['dbRec']);

            $status = $request->input('status');

            $isUpdated = $this->adminCourseService->updateStatus($courseId, $status);
            if(!$isUpdated)
                throw new CustomException("Course status update failed!");

            return response()->json([
                'message'   => 'User status update success',
                'status'    => 'success',
            ]);

        }catch(CustomException $e){
            return response()->json([
                'message'   => $e->getMessage(),
                'status'    => 'error',
            ]);

        }catch(AuthorizationException $e){
            return response()->json([
                'message'   => 'You dont have Permissions to change the status of the course!',
                'status'    => 'error',
            ]);
        }catch(\Exception $e){
            return response()->json([
                'message'   => $e->getMessage(),
                //'message'  => 'User status update failed!',
                'status'    => 'error',
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
