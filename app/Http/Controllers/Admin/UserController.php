<?php
namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\EditorStoreRequest;
use App\Http\Requests\Admin\EditorUpdateRequest;
use App\Http\Requests\Admin\MarketerStoreRequest;
use App\Http\Requests\Admin\MarketerUpdateRequest;
use App\Http\Requests\Admin\StudentStoreRequest;
use App\Http\Requests\Admin\StudentUpdateRequest;
use App\Http\Requests\Admin\TeacherStoreRequest;
use App\Http\Requests\Admin\TeacherUpdateRequest;
use App\View\DataFormatters\Admin\UserDataFormatter as AdminUserDataFormatter;
use App\Common\Utils\AlertDataUtil;
use App\Services\Admin\UserService as AdminUserService;
use Sentinel;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\Role as RoleModel;
use App\Models\User as UserModel;


class UserController extends Controller
{
    // todo user role
    // todo reg activate

    private AdminUserService $adminUserService;

    public function __construct(AdminUserService $adminUserService){
        $this->adminUserService = $adminUserService;
    }


    public function index()
    {                            
        //You dont have Permissions view all users !
        $this->authorize('viewAny', UserModel::class);
        $userArr = $this->adminUserService->loadAllUserRecs();

        $teachers   = AdminUserDataFormatter::prepareUserListData($userArr['teachersDtoArr']);
        $students   = AdminUserDataFormatter::prepareUserListData($userArr['studentsDtoArr']);
        $marketers  = AdminUserDataFormatter::prepareUserListData($userArr['marketersDtoArr']);
        $editors    = AdminUserDataFormatter::prepareUserListData($userArr['editorsDtoArr']);

        return view('admin-panel.user-list')->with([
            'teachers'         => $teachers,
            'students'         => $students,
            'marketers'        => $marketers,
            'editors'          => $editors,
            
            'canViewteachers'  => $userArr['canViewteachers'],//-----
            'canViewstudents'  => $userArr['canViewstudents'],//------
            'canViewmarketers' => $userArr['canViewmarketers'],//----------
            'canVieweditors'   => $userArr['canVieweditors']//----------
        ]);
        
    }


    public function create(Request $request){
        // You dont have Permissions to create users
        $this->authorize('create', UserModel::class);
        return view('admin-panel.user-add');       
    }


    public function storeTeacher(TeacherStoreRequest $request){
        try{
            $this->authorize('createTeachers', UserModel::class);

            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation failed');
            
            //You dont have Permissions to create Teachers !
            $result = $this->adminUserService->saveTeacherRec($request);
            if(!$result)
                abort(500, "Add Teacher failed due to server error !");

            return redirect(route('admin.users.create'))->with([
                'teacher_add_message'   => 'Add Teacher success',
                'teacher_add_message2'  => $result['usernameMsg'],
                'teacher_add_cls'       => 'flash-success',
                'teacher_add_msgTitle'  => 'Success',
            ]);

        }catch(CustomException $e){
            return redirect(route('admin.users.create'))
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'teacher_add_message'    => $e->getMessage(),
                    //'teacher_add_message2' => '',
                    'teacher_add_cls'        => 'flash-danger',
                    'teacher_add_msgTitle'   => 'Error !',
                ]);

        }
    }


    public function storeStudent(StudentStoreRequest $request){
        try{

            $this->authorize('createStudents', UserModel::class);

            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation failed');

            //You dont have Permissions to create students !
            $result = $this->adminUserService->saveStudentRec($request);
            if(!$result)
                abort(500, "Add Student failed due to server error !");

            return redirect(route('admin.users.create', []). '#tab-students')->with([
                'student_add_message'    => 'Add Student success',
                'student_add_message2'   => $result['usernameMsg'],
                'student_add_cls'        => 'flash-success',
                'student_add_msgTitle'   => 'Success',
            ]);

        }catch(CustomException $e){
            return redirect(route('admin.users.create', []). '#tab-students')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'student_add_message'  => $e->getMessage(),
                    'student_add_cls'     => 'flash-danger',
                    'student_add_msgTitle'=> 'Error !',
                ]);
        }

    }


    public function storeMarketer(MarketerStoreRequest $request){
        try{
            $this->authorize('createMarketers', UserModel::class);

            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation failed');

            //You dont have Permissions to create marketers !
            $result = $this->adminUserService->saveMarketerRec($request);
            if(!$result)
                abort(500, "Add Marketer failed due to server error !");

            return redirect(route('admin.users.create', []). '#tab-marketers')->with([
                'marketer_add_message'   => 'Add Marketer success',
                'marketer_add_cls'       => 'flash-success',
                'marketer_add_msgTitle'  => 'Success',
                'marketer_add_message2'  => $result['usernameMsg']
            ]);

        }catch(CustomException $e){
            return redirect(route('admin.users.create', []). '#tab-marketers')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'marketer_add_message'   => $e->getMessage(),
                    'marketer_add_cls'       => 'flash-danger',
                    'marketer_add_msgTitle'  => 'Error !',
                ]);
        }
    }


    public function storeEditor(EditorStoreRequest $request){
        try{
            $this->authorize('createEditors', UserModel::class);

            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation failed');

            // You dont have Permissions to create editors !
            $result = $this->adminUserService->saveEditorRec($request);
            if(!$result)
                abort(500, "Add Editor failed due to server error !");

            return redirect(route('admin.users.create', []). '#tab-editor')->with([
                'editor_add_message'   => 'Add editor success',
                'editor_add_cls'       => 'flash-success',
                'editor_add_msgTitle'  => 'Success',
                'editor_add_message2'  => $result['usernameMsg']
            ]);

        }catch(CustomException $e){
            return redirect(route('admin.users.create', []). '#tab-editor')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'editor_add_message'     => $e->getMessage(),
                    'editor_add_cls'         => 'flash-danger',
                    'editor_add_msgTitle'    => 'Error !',
                ]);
        }

    }


    public function show($id)
    {
        if(!filter_var($id, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid id');
        
        $userData = $this->adminUserService->findDbRec($id);
        if(is_null($userData['dbRec']))
            throw new CustomException('User does not exist!');
        
        //You dont have Permissions to view the user !
        $this->authorize('view', $userData['dbRec']);

        $filteredUserData   = AdminUserDataFormatter::prepareUserData($userData);
        return view('admin-panel.user-view')->with(['userData' => $filteredUserData]);        
    }


    public function edit($id){        
        if(!filter_var($id, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid id');

        $userData = $this->adminUserService->findDbRec($id);
        if(is_null($userData['dbRec']))
            throw new CustomException('User does not exist!');

        // You dont have Permissions to edit the user !
        $this->authorize('update', $userData['dbRec']);

        if(empty($userData['dbRec']->getAllUserRoles()))
            throw new CustomException('User have no role!');

        $filteredUserData = AdminUserDataFormatter::prepareUserData($userData);
        return view('admin-panel.user-edit')->with(['userData' => $filteredUserData]);        

    }

    
    public function updateTeacher(TeacherUpdateRequest $request, $id){

        try{
            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');
            
            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation failed');

            $userData = $this->adminUserService->findDbRec($id);
            if(is_null($userData['dbRec']))
                throw new CustomException('User does not exist!');

            //You dont have Permissions to update teacher user accounts !
            $this->authorize('updateTeachers',$userData['dbRec']);

            $isUpdated = $this->adminUserService->updateTeacherRec($request, $userData['dbRec']);
            if (!$isUpdated)
                abort(500, "Teacher update failed due to server error !");

            return redirect()->route('admin.users.index')->with(AlertDataUtil::success('Teacher update success'));

        }catch(CustomException $e){
            return redirect()->back()->with(AlertDataUtil::error($e->getMessage()));
        }
    }


    public function updateStudent(StudentUpdateRequest $request, $id){
        try{
            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');
            
            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation failed');

            $userData = $this->adminUserService->findDbRec($id);
            if(is_null($userData['dbRec']))
                throw new CustomException('User does not exist!');

            //You dont have Permissions to update student user accounts !
            $this->authorize('updateStudents',$userData['dbRec']);

            $isUpdated = $this->adminUserService->updateStudentRec($request, $userData['dbRec']);
            if (!$isUpdated)
                abort(500, "Student update failed due to server error !");

            return redirect()->route('admin.users.index')->with(AlertDataUtil::success('Student update success'));

        }catch(CustomException $e){            
            return redirect()->back()->with(AlertDataUtil::error($e->getMessage()));
        }
    }


    public function updateMarketer(MarketerUpdateRequest $request, $id){
        try{
            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');

            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation failed');

            $userData = $this->adminUserService->findDbRec($id);
            if(is_null($userData['dbRec']))
                throw new CustomException('User does not exist!');

            //You dont have Permissions to update student user accounts !
            $this->authorize('updateMarketers',$userData['dbRec']);

            $isUpdated = $this->adminUserService->updateMarketerRec($request, $userData['dbRec']);
            if (!$isUpdated)
                abort(500, "Marketer update failed due to server error !");

            return redirect()->route('admin.users.index')->with(AlertDataUtil::success('Marketer update success'));

        }catch(CustomException $e){
            return redirect()->back()->with(AlertDataUtil::error($e->getMessage()));
        }
    }


    public function updateEditor(EditorUpdateRequest $request, $id){
        try{
            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');

            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation failed');

            $userData = $this->adminUserService->findDbRec($id);
            if(is_null($userData['dbRec']))
                throw new CustomException('User does not exist!');

            //You dont have Permissions to update editor user accounts !
            $this->authorize('updateEditors',$userData['dbRec']);

            $isUpdated = $this->adminUserService->updateEditorRec($request, $userData['dbRec']);
            if (!$isUpdated)
                abort(500, "Editor update failed due to server error !");

            return redirect()->route('admin.users.index')->with(AlertDataUtil::success('Editor update success'));

        }catch(CustomException $e){
            return redirect()->back()->with(AlertDataUtil::error($e->getMessage()));
        }
    }


    public function changeStatus(Request $request){

        try{

            if(!filter_var($request->userId, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id - User status update failed');

            $userData = $this->adminUserService->findDbRec($request->input('userId'));
            if(is_null($userData['dbRec']))
                throw new CustomException('User does not exist!');

            $this->authorize('changeUserStatus',$userData['dbRec']);

            $status     = (int)$request->status;
            $isUpdated  = $this->adminUserService->updateStatus($userData['dbRec']->id, $status);
            if(!$isUpdated)
                abort(500, "User status update failed due to server error !");

            return response()->json(['status' => 'success', 'message'  => 'User status update success']);

        }catch(CustomException $e){
            return response()->json(['status' => 'error', 'message'  => $e->getMessage()]);

        }catch(AuthorizationException $e){
            return response()->json(
                AlertDataUtil::error('You dont have Permissions to update user status !',[
                    'msgTitle' => 'Permission Denied!'
                ])
            );

        }
        catch(\Exception $e){
            return response()->json([
                'status'    => 'error',
                'message'   => 'User status update failed!',
                //'message' => $e->getMessage(),
            ]);
        }
    }

    public function destroy(Request $request, $id){
        //todo delete image
        switch ($request->userType) {
            case "teacher":
                $hash = '#tab-teachers';
                $redirectRoute = 'admin.user.index';
                break;
            case "approve.teacher":
                $hash = '#tab-teachers';
                $redirectRoute = 'admin.user.un-approved-teachers-list';
                break;
            case "student":
                $hash = '#tab-students';
                $redirectRoute = 'admin.user.index';
                break;
            case "marketer":
                $hash = '#tab-marketers';
                $redirectRoute = 'admin.user.index';
                break;
            case "editor":
                $hash = '#tab-editors';
                $redirectRoute = 'admin.user.index';
                break;
            default:
                $hash = '';
                $redirectRoute = 'admin.user.index';
        }

        if(!filter_var($id, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid id', $eArr);

        $userData = $this->adminUserService->findDbRec($id);
        if(is_null($userData['dbRec']))
            throw new CustomException('User does not exist!',$eArr);

        //You dont have Permissions to delete the user !
        $this->authorize('delete', $userData['dbRec']);

        $isDelete = $this->adminUserService->deleteDbRec($userData['dbRec']);
        if (!$isDelete)
            abort(500, "User delete failed due to server error !");

        return redirect(route($redirectRoute, []). $hash)
            ->with(AlertDataUtil::success('successfully deleted the user record'));
    }


    public function viewUnApprovedTeachersList(){
        //todo
        //You dont have Permissions to view the user !
        //$this->authorize('delete', $userData['dbRec']);

        $unApprovedTeachers = $this->adminUserService->findUnApprovedTeachers();

        $teachersArr = AdminUserDataFormatter::prepareUnApprovedTeachers($unApprovedTeachers);
        return view('admin-panel.user-approve-teachers')->with(['teachers' => $teachersArr]);        
    }


    public function viewUnApprovedTeacher($id){
        try{

            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');

            $userData = $this->adminUserService->findDbRec($id);
            if(is_null($userData['dbRec']))
                throw new CustomException('User does not exist!');

            //todo
            //You dont have Permissions to view the user !
            //$this->authorize('view', $userData['dbRec']);

            if(empty($userData['dbRec']->getAllUserRoles()))
                throw new CustomException('User have no role!');

            if($userData['dbRec']->roles()->first()->name != RoleModel::TEACHER)
                throw new CustomException("Invalid User");

            if($userData['dbRec']->status == true)
                throw new CustomException("Account already activated");

            $filteredUserData   = AdminUserDataFormatter::prepareUserData($userData);
            return view('admin-panel.teacher.approve-account')->with(['userData' => $filteredUserData]);

        }catch(CustomException $e){
            return view('admin-panel.teacher.approve-account')->with([AlertDataUtil::error($e->getMessage())]);
        }
    }

    public function changesApprove(){
        return view('admin-panel.user-changes-approve');
    }

}