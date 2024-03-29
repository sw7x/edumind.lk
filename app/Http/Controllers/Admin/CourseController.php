<?php
namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Models\Course as CourseModel;
use App\Models\Role as RoleModel;
use Sentinel;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

use App\Http\Requests\Admin\Course\CourseStoreRequest;
use App\Http\Requests\Admin\Course\CourseUpdateRequest;
use Illuminate\Support\Facades\Session;

use App\Services\Admin\CourseService as AdminCourseService;
use App\Services\Admin\TeacherService as AdminTeacherService;
use App\Services\Admin\SubjectService as AdminSubjectService;
use App\View\DataFormatters\Admin\CourseDataFormatter as AdminCourseDataFormatter;
use Illuminate\Support\Arr;
use App\Common\SharedServices\CourseSharedService;
use App\Common\Utils\AlertDataUtil;

use App\Permissions\Abilities\CourseAbilities;
use App\Permissions\Traits\PermissionCheck;

class CourseController extends Controller
{
    
    use PermissionCheck;

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


    public function index(){
        $this->hasPermission(CourseAbilities::ADMIN_PANEL_VIEW_COURSE_LIST);

        $courses = $this->adminCourseService->loadAllCourses();
        $courseArr = AdminCourseDataFormatter::prepareCourseListData($courses);
        return view('admin-panel.course-list')->withData($courseArr);
    }


    public function create(){
        $this->hasPermission(CourseAbilities::CREATE_COURSES);

        $teachersData = $this->adminTeacherService->loadAllAvailableTeachers();
        $subjectsData = $this->adminSubjectService->loadAllAvailableSubjects();

        $teachersArr = AdminCourseDataFormatter::prepareUserListData($teachersData);
        $subjectsArr = AdminCourseDataFormatter::prepareSubjectListData($subjectsData);

        return view('admin-panel.course-add')->with([
            'teachers'       => $teachersArr,
            //'teachers'       => [],
            'subjects'       => $subjectsArr,
            //'subjects'       => [],
        ]);
    }


    public function store(CourseStoreRequest $request){
        try{
            $this->hasPermission(CourseAbilities::CREATE_COURSES);

            $dbValidCourseContent   = $this->adminCourseService->validateCourseContentForDb($request);
            $request->merge(Arr::only($dbValidCourseContent, ['contentInputStr', 'topicsString', 'contentString']));

            /* creating validation errors for view*/
            $errors = Session::get('errors');
            $courseValErrors = null;
            if (!is_null($errors) && !is_null($errors->courseCreate))
                $courseValErrors = $this->adminCourseService->getCourseValidationErrors($errors->courseCreate->getMessages());

            /* if have validation errors create text to display*/
            $valErrMsg = $dbValidCourseContent['validationErrMsg'];
            if (isset($request->validator) && $request->validator->fails())
                $valErrMsg  .= (($valErrMsg != '') ? ' and ' : '') . 'Form validation is failed';

            if($valErrMsg)
                throw new CustomException($valErrMsg . ' !');
            
            $isSaved = $this->adminCourseService->saveDbRec($request);
            if (!$isSaved)
                abort(500, "Course create failed due to server error !");

            return redirect()->route('admin.courses.create')
                ->with(AlertDataUtil::success('Course created successfully'));

        }catch(\Throwable $ex){
            /* when $courseContentLinkErrMsgArr send as a meessage bag error as following code
            ->withErrors($courseContentLinkErrMsgArr,'courseContentLinkErrMsgArr')
            then laravel automatically remove all duplicated message in one key element in array */

            $msg = ($ex instanceof CustomException) ? $ex->getMessage() : 'Course create failed !';
            //$msg =  $ex->getMessage();

            return redirect(route('admin.courses.create'))
                ->withErrors($courseValErrors['contentMsg'] ?? [],'contentErrMsgArr')
                ->withErrors($courseValErrors['infoMsg'] ?? [],'infoErrMsgArr')
                ->withInput($request->input())
                ->with(
                    AlertDataUtil::error($msg,
                        ['contentLinksErrMsgArr' => $courseValErrors['contentLinksMsg'] ?? []
                    ])
                );
        }

    }


    public function show($id){
        if(!filter_var($id, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid id');

        $courseData = $this->adminCourseService->findDbRecIncludingTrashed($id);

        $this->hasPermission(CourseAbilities::ADMIN_PANEL_VIEW_COURSE, $courseData['dbRec']);

        if(is_null($courseData['dbRec']))
            throw new CustomException('Course does not found');

        $courseContent      = $courseData['dto']->getContent();
        $courseContentVal   = (new CourseSharedService())->validateCourseContent($courseContent);

        $courseDataArr   = array();
        $courseDataArr[] = $courseData;
        $courseArr       = AdminCourseDataFormatter::prepareCourseListData($courseDataArr);
        //dd($courseArr);
        return view('admin-panel.course-view')->with([
            'course'                 => reset($courseArr),
            'courseContent'          => $courseContentVal['data'],
            'courseContentInvFormat' => $courseContentVal['isInvFormat'],
        ]);

    }


    public function edit($id){
        if(!filter_var($id, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid id');
        
        $courseData = $this->adminCourseService->findDbRec($id);

        $this->hasPermission(CourseAbilities::EDIT_COURSE, $courseData['dbRec']);

        if(is_null($courseData['dbRec']))
            throw new CustomException('Course does not found');

        //to display course content
        $courseContent          = $courseData['dto']->getContent();
        $validatedCourseContent =  (new CourseSharedService())->validateCourseContent($courseContent);
        $courseContentStr       = json_encode($validatedCourseContent['data'], 512);


        // load teachers dropdown data
        $teachersData   = $this->adminTeacherService->loadAllAvailableTeachers();
        $teachersArr    = AdminCourseDataFormatter::prepareUserListData($teachersData);


        // load subjects dropdown data
        $subjectsData   = $this->adminSubjectService->loadAllAvailableSubjects();
        $subjectsArr    = AdminCourseDataFormatter::prepareSubjectListData($subjectsData);


        //course data
        $courseDataArr   = array();
        $courseDataArr[] = $courseData;
        $courseArr       = AdminCourseDataFormatter::prepareCourseListData($courseDataArr);

        return view('admin-panel.course-edit')->with([
            'course'        => reset($courseArr),
            'courseContent' => $courseContentStr,
            'teachers'      => $teachersArr,
            //'teachers'    => [],
            'subjects'      => $subjectsArr
        ]);

    }


    public function update(CourseUpdateRequest $request, $id){
        try{

            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');

            $courseData = $this->adminCourseService->findDbRec($id);
            if(is_null($courseData['dbRec']))
                throw new CustomException('Course does not exist!');

            $this->hasPermission(CourseAbilities::EDIT_COURSE, $courseData['dbRec']);

            $dbValidCourseContent   = $this->adminCourseService->validateCourseContentForDb($request);
            $request->merge(Arr::only($dbValidCourseContent, ['contentInputStr', 'topicsString', 'contentString']));

            /* creating validation eroors for view*/
            $errors = Session::get('errors');
            $courseValErrors = null;
            if (!is_null($errors) && !is_null($errors->courseUpdate))
                $courseValErrors = $this->adminCourseService->getCourseValidationErrors($errors->courseUpdate->getMessages());

            /* if have validation errors create text to display */
            $valErrMsg = $dbValidCourseContent['validationErrMsg'];
            if ( isset($request->validator) && $request->validator->fails())
                $valErrMsg  .= (($valErrMsg != '') ? ' and ': '') . 'Form validation has failed';

            if($valErrMsg)
                throw new CustomException($valErrMsg . ' !');
            
            $isSaved = $this->adminCourseService->updateDbRec($request, $courseData['dbRec']);
            if (!$isSaved)
                abort(500, "Course update failed due to server error !");

            return redirect()->route('admin.courses.index')
                ->with(AlertDataUtil::success('Course created successfully'));

        }catch(\Throwable $ex){
            /* when $courseContentLinkErrMsgArr send as a meessage bag error as following code
            ->withErrors($courseContentLinkErrMsgArr,'courseContentLinkErrMsgArr')
            then laravel automatically remove all duplicated message in one key element in array */

            $msg = ($ex instanceof CustomException) ? $ex->getMessage() : 'Course update failed !';
            return redirect(route('admin.courses.edit', $id))
                ->withErrors($courseValErrors['contentMsg'] ?? [], 'contentErrMsgArr')
                ->withErrors($courseValErrors['infoMsg'] ?? [], 'infoErrMsgArr')
                ->withInput($request->input())
                ->with(
                    AlertDataUtil::error($ex->getMessage(),[
                        'contentLinksErrMsgArr' => $courseValErrors['contentLinksMsg'] ?? []
                    ])
                );
        }

    }

    public function destroy(int $id){
        if(!filter_var($id, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid id');

        $courseData = $this->adminCourseService->findDbRec($id);
        if(is_null($courseData['dbRec']))
            throw new CustomException('Course does not exist!');

        $this->hasPermission(CourseAbilities::DELETE_SINGLE_COURSE, $courseData['dbRec']);

        $isDelete = $this->adminCourseService->deleteDbRec($courseData['dbRec']);
        if (!$isDelete)
            abort(500, "Course delete failed due to server error !");

        return redirect(route('admin.courses.index'))
            ->with(AlertDataUtil::success('successfully deleted the course'));
    }

    public function permanentlyDelete(int $id){      
        if(!filter_var($id, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid id');

        $courseData = $this->adminCourseService->findDbRecIncludingTrashed($id);
        if(is_null($courseData['dbRec']))
            throw new CustomException('Course does not exist!');
        
        $this->hasPermission(CourseAbilities::DELETE_SINGLE_COURSE, $courseData['dbRec']);

        if(!$courseData['dbRec']->trashed())
            return redirect()->route('admin.courses.trashed')
                ->with(AlertDataUtil::warning('Not a trashed course record, therefore cannot delete permanently'));

        $isPermDel = $this->adminCourseService->permanentlyDeleteDbRec($courseData['dbRec']);
        if(!$isPermDel)
            abort(500, "Failed to permanently delete course record from database!");
            
        return redirect()->route('admin.courses.trashed')
                ->with(AlertDataUtil::success('Course permanently delete  successfully'));
    }

    public function viewTrashedList(){
        $this->hasPermission(CourseAbilities::DELETE_COURSES);        
        $coursesData     = $this->adminCourseService->loadAllTrashedDbRecs();
        $filteredDataArr = AdminCourseDataFormatter::prepareCourseListData($coursesData);
        return view ('admin-panel.course-list-trashed')->withData($filteredDataArr);
    }

    public function restoreRec(int $id){
        if(!filter_var($id, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid id');

        $courseData = $this->adminCourseService->findDbRecIncludingTrashed($id);
        if(is_null($courseData['dbRec']))
            abort(404,'Course does not exist!');
        
        $this->hasPermission(CourseAbilities::DELETE_SINGLE_COURSE, $courseData['dbRec']);
        
        if(!$courseData['dbRec']->trashed())
            return redirect()->route('admin.courses.trashed')
                ->with(AlertDataUtil::warning('Not a trashed course record'));

        $isRestored = $this->adminCourseService->restoreDbRec($id);
        if(!$isRestored)
            abort(500,'Failed to restore course!');

        return redirect()->route('admin.courses.trashed')
                ->with(AlertDataUtil::success('Course restored successfully'));        
    }




    
    public function checkEmpty(Request $request){
        try{
            $courseId = $request->input('courseId');
            if(!filter_var($courseId, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid Course id');

            $courseData = $this->adminCourseService->findDbRecIncludingTrashed($courseId);

            if(is_null($courseData['dbRec']))
                throw new CustomException("Course does not exist!");

            $isEmpty = $this->adminCourseService->checkIsCourseEmpty($courseData['dbRec']);

            return response()->json(['status' => 'success', 'isEmpty' => $isEmpty, 'message' => '']);

        }catch(\Throwable $ex){
            $msg = ($ex instanceof CustomException) ? $ex->getMessage() : 'Course status check failed!';
            return response()->json(['status' => 'error', 'message' => $msg]);
        }

    }

    public function changeStatus(Request $request){

        try{
            $courseId = $request->input('courseId');
            if(!filter_var($courseId, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id - User status update failed');

            $courseData = $this->adminCourseService->findDbRec($courseId);

            if(is_null($courseData['dbRec']))
                throw new CustomException("Course does not exist!");

            $this->hasPermission(CourseAbilities::CHANGE_COURSE_STATUS, $courseData['dbRec']);

            $status = $request->input('status');

            $isUpdated = $this->adminCourseService->updateStatus($courseId, $status);
            if(!$isUpdated)
                abort(500, "Course status update failed due to server error !");

            return response()->json(['status' => 'success', 'message' => 'User status update success']);

        }catch(\Throwable $ex){
            $msg = ($ex instanceof CustomException) ? $ex->getMessage() : 'Course status update failed !';
            return response()->json(['status' => 'error', 'message' => $msg]);
        }
    }

    //check course record have linked with records in course_selection, coupons tables
    public function checkCanDelete(Request $request){
        try{
            $courseId = $request->input('courseId');
            if(!filter_var($courseId, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid Course id');

            $courseData = $this->adminCourseService->findDbRecIncludingTrashed($courseId);

            if(is_null($courseData['dbRec']))
                throw new CustomException("Course does not exist!");

            $canDelete = $this->adminCourseService->checkCourseCanDelete($courseData['dbRec']);

            return response()->json(['status' => 'success', 'canDelete' => $canDelete, 'message' => '']);

        }catch(\Throwable $ex){
            $msg = ($ex instanceof CustomException) ? $ex->getMessage() : 'Course status check failed!';
            return response()->json(['status' => 'error', 'message' => $msg]);
        }

    }





    public function viewCourseEnrollmentList(){
        if(!Sentinel::check())
            abort(403);

        $user            = Sentinel::getUser();
        $allRoles        = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER, RoleModel::STUDENT];
        $currentUserRole = optional($user->roles()->first())->name;
        if(!in_array($currentUserRole, $allRoles))
            abort(403);


        // redirect users that have TEACHER, STUDENT roles
        $allowedRoles   = [RoleModel::ADMIN];
        if(!in_array($currentUserRole, $allowedRoles))
            abort(404);

        $data = CourseModel::orderBy('id')->get();
        return view('admin-panel.admin.course-enrollments')->withData($data);
    }

    public function viewCourseCompleteList(){

        if(!Sentinel::check())
            abort(403);

        $user            = Sentinel::getUser();
        $allRoles        = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER, RoleModel::STUDENT];
        $currentUserRole = optional($user->roles()->first())->name;
        if(!in_array($currentUserRole, $allRoles))
            abort(403);


        // redirect users that have TEACHER, STUDENT roles
        $allowedRoles   = [RoleModel::ADMIN];
        if(!in_array($currentUserRole, $allowedRoles))
            abort(404);

        $data = CourseModel::orderBy('id')->get();
        return view('admin-panel.admin.course-completions')->withData($data);
    }

}