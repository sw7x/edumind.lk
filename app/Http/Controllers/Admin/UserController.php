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

use App\Permissions\Abilities\UserManageAbilities;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Permissions\Traits\PermissionCheck;


class UserController extends Controller
{
    use PermissionCheck;

    // todo user role
    // todo reg activate

    private AdminUserService $adminUserService;

    public function __construct(AdminUserService $adminUserService){
        $this->adminUserService = $adminUserService;
    }


    public function index(){    
        $this->hasPermission(UserManageAbilities::ADMIN_PANEL_VIEW_USER_LIST);

        $userArr = $this->adminUserService->loadAllUserRecs();

        $teachers   = AdminUserDataFormatter::prepareUserListData($userArr['teachersDtoArr']);
        $students   = AdminUserDataFormatter::prepareUserListData($userArr['studentsDtoArr']);
        $marketers  = AdminUserDataFormatter::prepareUserListData($userArr['marketersDtoArr']);
        $editors    = AdminUserDataFormatter::prepareUserListData($userArr['editorsDtoArr']);
        
        return view('admin-panel.user-list')->with([
            'teachers'         => $teachers,
            'students'         => $students,
            'marketers'        => $marketers,
            'editors'          => $editors
        ]);
        
    }


    public function create(Request $request){
        $this->hasPermission(UserManageAbilities::VIEW_CREATE_PAGE);
        return view('admin-panel.user-add');    
    }


    public function storeTeacher(TeacherStoreRequest $request){
        $this->hasPermission(UserManageAbilities::CREATE_TEACHERS);
              
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
        $this->hasPermission(UserManageAbilities::CREATE_STUDENTS);

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
        $this->hasPermission(UserManageAbilities::CREATE_MARKETERS);

        try{
            $this->authorize('createMarketers', UserModel::class);

            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation failed');

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
        $this->hasPermission(UserManageAbilities::CREATE_EDITORS);

        try{
            $this->authorize('createEditors', UserModel::class);

            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation failed');

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


    public function show($id){        
        if(!filter_var($id, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid id');
                        
        $userData = $this->adminUserService->findDbRecIncludingTrashed($id);
        if(is_null($userData['dbRec']))
            throw new CustomException('User does not exist!');
        
        $this->hasPermission(UserManageAbilities::ADMIN_PANEL_VIEW_USER, $userData['dbRec']);

        $filteredUserData   = AdminUserDataFormatter::prepareUserData($userData);
        return view('admin-panel.user-view')->with(['userData' => $filteredUserData]);        
    }


    public function edit($id){       
        $this->hasPermission(UserManageAbilities::VIEW_EDIT_PAGE);
        
        if(!filter_var($id, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid id');

        $userData = $this->adminUserService->findDbRec($id);
        if(is_null($userData['dbRec']))
            throw new CustomException('User does not exist!');
        
        if(empty($userData['dbRec']->getAllUserRoles()))
            throw new CustomException('User have no role!');

        $filteredUserData = AdminUserDataFormatter::prepareUserData($userData);
        return view('admin-panel.user-edit')->with(['userData' => $filteredUserData]);        

    }

    
    public function updateTeacher(TeacherUpdateRequest $request, $id){       
        try{
            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');
            
            $this->hasPermission(UserManageAbilities::EDIT_TEACHERS);

            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation failed');

            $userData = $this->adminUserService->findDbRec($id);
            if(is_null($userData['dbRec']))
                throw new CustomException('User does not exist!');
            
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
            
            $this->hasPermission(UserManageAbilities::EDIT_STUDENTS);

            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation failed');

            $userData = $this->adminUserService->findDbRec($id);
            if(is_null($userData['dbRec']))
                throw new CustomException('User does not exist!');

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

            $this->hasPermission(UserManageAbilities::EDIT_MARKETERS);

            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation failed');

            $userData = $this->adminUserService->findDbRec($id);
            if(is_null($userData['dbRec']))
                throw new CustomException('User does not exist!');
            
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

            $this->hasPermission(UserManageAbilities::EDIT_EDITORS);

            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation failed');

            $userData = $this->adminUserService->findDbRec($id);
            if(is_null($userData['dbRec']))
                throw new CustomException('User does not exist!');

            $isUpdated = $this->adminUserService->updateEditorRec($request, $userData['dbRec']);
            if (!$isUpdated)
                abort(500, "Editor update failed due to server error !");

            return redirect()->route('admin.users.index')->with(AlertDataUtil::success('Editor update success'));

        }catch(CustomException $e){
            return redirect()->back()->with(AlertDataUtil::error($e->getMessage()));
        }
    }


    public function destroy(Request $request, $id){
        $this->hasPermission(UserManageAbilities::DELETE_USERS);

        //todo delete image
        switch ($request->userType) {
            case "teacher":
                $hash = '#tab-teachers';
                $redirectRoute = 'admin.users.index';
                break;
            case "approve.teacher":
                $hash = '#tab-teachers';
                $redirectRoute = 'admin.users.un-approved-teachers-list';
                break;
            case "student":
                $hash = '#tab-students';
                $redirectRoute = 'admin.users.index';
                break;
            case "marketer":
                $hash = '#tab-marketers';
                $redirectRoute = 'admin.users.index';
                break;
            case "editor":
                $hash = '#tab-editors';
                $redirectRoute = 'admin.users.index';
                break;
            default:
                $hash = '';
                $redirectRoute = 'admin.users.index';
        }

        if(!filter_var($id, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid id');

        $userData = $this->adminUserService->findDbRec($id);
        if(is_null($userData['dbRec']))
            throw new CustomException('User does not exist!');

        $isDelete = $this->adminUserService->deleteDbRec($userData['dbRec']);
        if (!$isDelete)
            abort(500, "User delete failed due to server error !");

        return  redirect(route($redirectRoute, []). $hash)
                    ->with(AlertDataUtil::success('successfully deleted the user record'));
    }
    


    public function permanentlyDelete(int $id){      
        if(!filter_var($id, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid id');

        $userData = $this->adminUserService->findDbRecIncludingTrashed($id);
        if(is_null($userData['dbRec']))
            throw new CustomException('User does not exist!');
        
        $this->hasPermission(UserManageAbilities::DELETE_USERS);

        if(!$userData['dbRec']->trashed())
            return redirect()->route('admin.users.trashed')
                ->with(AlertDataUtil::warning('Not a trashed user record, therefore cannot delete permanently'));

        $isPermDel = $this->adminUserService->permanentlyDeleteDbRec($userData['dbRec']);
        if(!$isPermDel)
            abort(500, "Failed to permanently delete user record from database!");
            
        return redirect()->route('admin.users.trashed')
                ->with(AlertDataUtil::success('Course permanently delete  successfully'));
    }

    public function viewTrashedList(){
        $this->hasPermission(UserManageAbilities::DELETE_USERS);      
        $usersData  = $this->adminUserService->loadAllTrashedDbRecs();
                
        $teachers   = AdminUserDataFormatter::prepareUserListData($usersData['teachersDtoArr']);
        $students   = AdminUserDataFormatter::prepareUserListData($usersData['studentsDtoArr']);
        $marketers  = AdminUserDataFormatter::prepareUserListData($usersData['marketersDtoArr']);
        $editors    = AdminUserDataFormatter::prepareUserListData($usersData['editorsDtoArr']);
    
        return view ('admin-panel.user-list-trashed')->with([
            'teachers'         => $teachers,
            'students'         => $students,
            'marketers'        => $marketers,
            'editors'          => $editors
        ]);
    }

    public function restoreRec(int $id){
        if(!filter_var($id, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid id');

        $userData = $this->adminUserService->findDbRecIncludingTrashed($id);
        if(is_null($userData['dbRec']))
            abort(404,'User does not exist!');
        
        $this->hasPermission(UserManageAbilities::DELETE_USERS);
        
        if(!$userData['dbRec']->trashed())
            return redirect()->route('admin.users.trashed')
                ->with(AlertDataUtil::warning('Not a trashed user record'));

        $isRestored = $this->adminUserService->restoreDbRec($id);
        if(!$isRestored)
            abort(500,'Failed to restore user!');

        return redirect()->route('admin.users.trashed')
                ->with(AlertDataUtil::success('User restored successfully'));        
    }
    
    public function changeStatus(Request $request){
        try{
            $this->hasPermission(UserManageAbilities::CHANGE_USERS_STATUS);
            
            if(!filter_var($request->userId, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id - User status update failed');

            $userData = $this->adminUserService->findDbRec($request->input('userId'));
            if(is_null($userData['dbRec']))
                throw new CustomException('User does not exist!');
            

            $status     = (int)$request->status;
            $isUpdated  = $this->adminUserService->updateStatus($userData['dbRec']->id, $status);
            if(!$isUpdated)
                abort(500, "User status update failed due to server error !");

            return response()->json(['status' => 'success', 'message'  => 'User status update success']);

        }catch(CustomException $e){
            return response()->json(['status' => 'error', 'message'  => $e->getMessage()]);

        }catch(\Exception $e){
            $msg = ($e instanceof HttpException) ? $e->getMessage() : 'User status update failed !';

            return response()->json([
                'status'    => 'error',
                'message'   => $msg,
                //'message' => $e->getMessage(),
            ]);
        }
    }

    
    //check course record have linked with records in course_selection, coupons tables
    public function checkCanDelete(Request $request){
        try{
            $userId = $request->input('userId');
            if(!filter_var($userId, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid user id');

            $userData = $this->adminUserService->findDbRecIncludingTrashed($userId);

            if(is_null($userData['dbRec']))
                throw new CustomException("User does not exist!");

            $canDelete = $this->adminUserService->checkCourseCanDelete($userData['dbRec']);

            return response()->json(['status' => 'success', 'canDelete' => $canDelete, 'message' => '']);

        }catch(\Throwable $ex){
            $msg = ($ex instanceof CustomException) ? $ex->getMessage() : 'User status check failed!';
            //$msg = $ex->getMessage();          
            return response()->json(['status' => 'error', 'message' => $msg]);
        }

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