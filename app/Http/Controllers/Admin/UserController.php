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

use App\Services\Admin\UserService as AdminUserService;

use Sentinel;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\Role as RoleModel;



/*

use App\Common\Utils\FileUploadUtil;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Collection;
use App\Builders\UserBuilder;

use App\Repositories\UserRepository;
use App\Domain\Factories\UserFactory;
use App\Domain\Factories\OrderFactory;

use App\Mappers\UserMapper;
use App\Mappers\OrderMapper;

use App\Repositories\CourseItemRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\CouponRepository;
use App\Repositories\OrderRepository;
use App\Repositories\AuthorSalaryRepository;



use App\Builders\CourseItemBuilder;
use App\Builders\EnrollmentBuilder;
use App\Builders\CouponCodeBuilder;
use App\Builders\OrderBuilder;

use App\DataTransferObjects\Factories\OrderDtoFactory;
*/

class UserController extends Controller
{

    // todo user role
    // todo reg activate

    private AdminUserService $adminUserService;

    public function __construct(AdminUserService $adminUserService){
        $this->adminUserService = $adminUserService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        try{

            $this->authorize('viewAny',User::class);
            $userArr = $this->adminUserService->loadAllUserRecs();

            $teachers   = AdminUserDataFormatter::prepareUserListData($userArr['teachersDtoArr']);
            $students   = AdminUserDataFormatter::prepareUserListData($userArr['studentsDtoArr']);
            $marketers  = AdminUserDataFormatter::prepareUserListData($userArr['marketersDtoArr']);
            $editors    = AdminUserDataFormatter::prepareUserListData($userArr['editorsDtoArr']);

            //dd($teachers);
            return view('admin-panel.user-list')->with([
                'teachers'         => $teachers,
                'canViewteachers'  => $userArr['canViewteachers'],

                'students'         => $students,
                'canViewstudents'  => $userArr['canViewstudents'],

                'marketers'        => $marketers,
                'canViewmarketers' => $userArr['canViewmarketers'],

                'editors'          => $editors,
                'canVieweditors'   => $userArr['canVieweditors']
            ]);

        }catch(CustomException $e){
            session()->now('message',$e->getMessage());
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            return view('admin-panel.user-list');

        }catch(AuthorizationException $e){
            return redirect(route('admin.dashboard'))->with([
                'message'   =>'You dont have Permissions view all users',
                'cls'       =>'flash-danger',
                'msgTitle'  =>'Permission Denied!'
            ]);

        }catch(\Exception $e){
            //dd($e);
            //session()->now('message','Failed to show all users');
            session()->now('message',$e->getMessage());
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            return view('admin-panel.user-list');
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try{
            $this->authorize('create',User::class);
            return view('admin-panel.user-add');

        }catch(AuthorizationException $e){
            return redirect(route('admin.users.index'))->with([
                'message'   =>'You dont have Permissions to create users',
                'cls'       =>'flash-danger',
                'msgTitle'  =>'Permission Denied!'
            ]);

        }catch(\Exception $e){
            session()->now('message',  'Failed to show user add form');
            session()->now('cls',      'flash-danger');
            session()->now('msgTitle', 'Error!');
            return view('admin-panel.user-add');
        }
    }



    public function storeTeacher(TeacherStoreRequest $request){
        try{

            $this->authorize('createTeachers',User::class);

            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation failed');

            $result = $this->adminUserService->saveTeacherRec($request);

            return redirect(route('admin.users.create'))->with([
                'teacher_submit_message'  => 'Add Teacher success',
                'teacher_submit_message2' => $result['usernameMsg'],
                //'teacher_submit_title'   => 'Student Registration submit page',
                'teacher_submit_cls'     => 'flash-success',
                'teacher_submit_msgTitle'=> 'Success',
            ]);

        }catch(CustomException $e){
            return redirect(route('admin.users.create'))
            ->withErrors($request->validator)
            ->withInput()
            ->with([
                'teacher_submit_message'  => $e->getMessage(),
                //'teacher_submit_message2' => $pwResetTxt,
                //'teacher_submit_title'   => 'Student Registration submit page',
                'teacher_submit_cls'     => $e->getData('cls') ?? 'flash-danger',
                'teacher_submit_msgTitle'=> $e->getData('msgTitle') ?? 'Error !',
            ]);

        }catch(AuthorizationException $e){
            //return redirect(url()->previous().'#tab-teachers')->with([
            return redirect(route('admin.users.create').'#tab-teachers')
            ->withErrors($request->validator)
            ->withInput()
            ->with([
                'teacher_submit_message'  => 'You dont have Permissions to create Teachers !',
                //'teacher_submit_message2' => $pwResetTxt,
                //'teacher_submit_title'   => 'Student Registration submit page',
                'teacher_submit_cls'     => 'flash-danger',
                'teacher_submit_msgTitle'=> 'Permission Denied !',
            ]);

        }catch(\Exception $e){
            return redirect(route('admin.users.create'))
            ->withErrors($request->validator)
            ->withInput()
            ->with([
                'teacher_submit_message'  => 'Add Teacher Failed !',
                //'teacher_submit_message'  => $e->getMessage(),
                //'teacher_submit_message2' => $pwResetTxt,
                //'teacher_submit_title'   => 'Student Registration submit page',
                'teacher_submit_cls'     => 'flash-danger',
                'teacher_submit_msgTitle'=> 'Error !',
            ]);
        }
    }


    public function storeStudent(StudentStoreRequest $request){

        //dd($request->all());
        try{

            $this->authorize('createStudents',User::class);

            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation failed');

            $result = $this->adminUserService->saveStudentRec($request);

            return redirect(route('admin.users.create', []). '#tab-students')->with([
                'student_submit_message'    => 'Add Student success',
                'student_submit_message2'   => $result['usernameMsg'],
                //'student_submit_title'    => 'Student Registration submit page',
                'student_submit_cls'        => 'flash-success',
                'student_submit_msgTitle'   => 'Success',
            ]);

        }catch(CustomException $e){

            return redirect(route('admin.users.create', []). '#tab-students')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'student_submit_message'  => $e->getMessage(),
                    //'student_submit_message2' => $pwResetTxt,
                    //'student_submit_title'   => 'Student Registration submit page',
                    'student_submit_cls'     => 'flash-danger',
                    'student_submit_msgTitle'=> 'Error !',
                ]);

        }catch(AuthorizationException $e){

            return redirect(route('admin.users.create', []). '#tab-students')
            //return redirect(url()->previous().'#tab-students')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'student_submit_message'  => 'You dont have Permissions to create students !',
                    //'student_submit_message2' => $pwResetTxt,
                    //'student_submit_title'   => 'Student Registration submit page',
                    'student_submit_cls'     => 'flash-danger',
                    'student_submit_msgTitle'=> 'Permission Denied !',
                ]);

        }catch(\Exception $e){
            return redirect(route('admin.users.create', []). '#tab-students')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'student_submit_message'  => 'Add Student Failed !',
                    //'student_submit_message'  => $e->getMessage(),
                    //'student_submit_message2' => $pwResetTxt,
                    //'student_submit_title'   => 'Student Registration submit page',
                    'student_submit_cls'     => 'flash-danger',
                    'student_submit_msgTitle'=> 'Error !',
                ]);
        }

    }


    public function storeMarketer(MarketerStoreRequest $request){
        //dd($request->all());

        try{
            $this->authorize('createMarketers',User::class);

            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation failed');

            $result = $this->adminUserService->saveMarketerRec($request);

            return redirect(route('admin.users.create', []). '#tab-marketers')->with([
                'marketer_submit_message'   => 'Add Marketer success',
                'marketer_submit_cls'       => 'flash-success',
                'marketer_submit_msgTitle'  => 'Success',
                'marketer_submit_message2'  => $result['usernameMsg']
            ]);

        }catch(CustomException $e){

            return redirect(route('admin.users.create', []). '#tab-marketers')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'marketer_submit_message'   => $e->getMessage(),
                    'marketer_submit_cls'       => 'flash-danger',
                    'marketer_submit_msgTitle'  => 'Error !',
                ]);

        }catch(AuthorizationException $e){
            return redirect(route('admin.users.create', []). '#tab-marketers')
            //return redirect(url()->previous().'#tab-marketers')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'marketer_submit_message'   => 'You dont have Permissions to create marketers !',
                    //'marketer_submit_message2'=> $pwResetTxt,
                    //'marketer_submit_title'   => 'Student Registration submit page',
                    'marketer_submit_cls'       => 'flash-danger',
                    'marketer_submit_msgTitle'  => 'Permission Denied !',
                ]);

        }catch(\Exception $e){
            return redirect(route('admin.users.create', []). '#tab-marketers')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'marketer_submit_message'   => 'Add Marketer Failed !',
                    'marketer_submit_cls'       => 'flash-danger',
                    'marketer_submit_msgTitle'  => 'Error !',
                ]);
        }
    }


    public function storeEditor(EditorStoreRequest $request){
        //dd($request->all());
        try{
            $this->authorize('createEditors',User::class);

            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation failed');

            $result = $this->adminUserService->saveEditorRec($request);

            return redirect(route('admin.users.create', []). '#tab-editor')->with([
                'editor_submit_message'   => 'Add editor success',
                'editor_submit_cls'       => 'flash-success',
                'editor_submit_msgTitle'  => 'Success',
                'editor_submit_message2'  => $result['usernameMsg']
            ]);

        }catch(CustomException $e){

            return redirect(route('admin.users.create', []). '#tab-editor')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'editor_submit_message'     => $e->getMessage(),
                    'editor_submit_cls'         => 'flash-danger',
                    'editor_submit_msgTitle'    => 'Error !',
                ]);

        }catch(AuthorizationException $e){
            return redirect(route('admin.users.create', []). '#tab-editor')
            //return redirect(url()->previous().'#tab-editor')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'editor_submit_message'     => 'You dont have Permissions to create editors !',
                    //'editor_submit_message2'  => $pwResetTxt,
                    //'editor_submit_title'     => 'Student Registration submit page',
                    'editor_submit_cls'         => 'flash-danger',
                    'editor_submit_msgTitle'    => 'Permission Denied !',
                ]);

        }catch(\Exception $e){
            return redirect(route('admin.users.create', []). '#tab-editor')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'editor_submit_message'     => $e->getMessage(),
                    //'editor_submit_message'     => 'Add editor Failed !',
                    'editor_submit_cls'         => 'flash-danger',
                    'editor_submit_msgTitle'    => 'Error !',
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

            $userData = $this->adminUserService->findDbRec($id);
            if(is_null($userData['dbRec']))
                throw new CustomException('User does not exist!');

            $this->authorize('view', $userData['dbRec']);

            $filteredUserData   = AdminUserDataFormatter::prepareUserData($userData);

            return view('admin-panel.user-view')->with([
                'userData'   => $filteredUserData
            ]);

        }catch(CustomException $e){
            session()->now('view_user_message',$e->getMessage());
            session()->now('view_user_cls','flash-danger');
            session()->now('view_user_msgTitle','Error!');
            return view('admin-panel.user-view');

        }catch(AuthorizationException $e){
            return redirect(route('admin.users.index'))->with([
                'message'     => 'You dont have Permissions to view the user !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);

        }catch(\Exception $e){
            session()->now('view_user_message','User does not exist');
            //session()->now('view_user_message',$e->getMessage());
            session()->now('view_user_cls','flash-danger');
            session()->now('view_user_msgTitle','Error!');
            return view('admin-panel.user-view');

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        try{

            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');

            $userData = $this->adminUserService->findDbRec($id);
            if(is_null($userData['dbRec']))
                throw new CustomException('User does not exist!');

            $this->authorize('update', $userData['dbRec']);

            if(empty($userData['dbRec']->getAllUserRoles()))
                throw new CustomException('User have no role!');

            $filteredUserData = AdminUserDataFormatter::prepareUserData($userData);
            return view('admin-panel.user-edit')->with([
                'userData'   => $filteredUserData,
            ]);

        }catch(CustomException $e){
            //$exData = $e->getData();
            session()->now('message',$e->getMessage());
            session()->now('cls',$exData['cls'] ?? "flash-danger");
            session()->now('msgTitle', $exData['msgTitle']  ?? 'Error !');
            return view('admin-panel.user-edit');

        }catch(AuthorizationException $e){
            return redirect(route('admin.users.index'))->with([
                'message'     => 'You dont have Permissions to edit the user',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);

        }
        catch(\Exception $e){
            session()->now('message','User edit failed');
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            return view('admin-panel.user-edit');

        }

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

            $this->authorize('updateTeachers',$userData['dbRec']);

            $isUpdated = $this->adminUserService->updateTeacherRec($request, $userData['dbRec']);
            if (!$isUpdated)
                throw new CustomException("User update failed");


            return redirect()->route('admin.users.index')->with([
                'message' => 'Teacher update success',
                'cls'     => 'flash-success',
                'msgTitle'=> 'Success',
            ]);

        }catch(CustomException $e){
            //dd($e->getMessage());
            return redirect()->back()->with([
                'user_edit_message'  => $e->getMessage(),
                'user_edit_cls'     => 'flash-danger',
                'user_edit_msgTitle'=> 'Error !',
            ]);

        }catch(AuthorizationException $e){
            //dd($e->getMessage());
            return redirect(route('admin.users.index'))->with([
            //return redirect()->back()->with([
                'user_edit_message'     => 'You dont have Permissions to update teacher user accounts !',
                'user_edit_cls'         => 'flash-danger',
                'user_edit_msgTitle'    => 'Permission Denied !',
            ]);

        }catch(\Exception $e){
            //dd($e->getMessage());
            return redirect()->back()->with([
                'user_edit_message'  => 'Add User Failed !',
                'user_edit_cls'     => 'flash-danger',
                'user_edit_msgTitle'=> 'Error !',
            ]);

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

            $this->authorize('updateStudents',$userData['dbRec']);

            $isUpdated = $this->adminUserService->updateStudentRec($request, $userData['dbRec']);
            if (!$isUpdated)
                throw new CustomException("User update failed");

            return redirect()->route('admin.users.index')->with([
                'message' => 'Student update success',
                'cls'     => 'flash-success',
                'msgTitle'=> 'Success',
            ]);

        }catch(CustomException $e){
            //dd($e->getMessage());
            return redirect()->back()->with([
                'user_edit_message'  => $e->getMessage(),
                'user_edit_cls'     => 'flash-danger',
                'user_edit_msgTitle'=> 'Error !',
            ]);

        }catch(AuthorizationException $e){
            //dd($e->getMessage());
            return redirect(route('admin.users.index'))->with([
            //return redirect()->back()->with([
                'user_edit_message'     => 'You dont have Permissions to update student user accounts !',
                'user_edit_cls'         => 'flash-danger',
                'user_edit_msgTitle'    => 'Permission Denied !',
            ]);

        }catch(\Exception $e){
            //dd($e->getMessage());
            return redirect()->back()->with([
                'user_edit_message'  => 'User update Failed!',
                'user_edit_cls'     => 'flash-danger',
                'user_edit_msgTitle'=> 'Error !',
            ]);

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

            $this->authorize('updateMarketers',$userData['dbRec']);

            $isUpdated = $this->adminUserService->updateMarketerRec($request, $userData['dbRec']);
            if (!$isUpdated)
                throw new CustomException("User update failed");

            return redirect()->route('admin.users.index')->with([
                'message' => 'Student update success',
                'cls'     => 'flash-success',
                'msgTitle'=> 'Success',
            ]);

        }catch(CustomException $e){
            //dd($e->getMessage());
            return redirect()->back()->with([
                'user_edit_message'  => $e->getMessage(),
                'user_edit_cls'     => 'flash-danger',
                'user_edit_msgTitle'=> 'Error !',
            ]);

        }catch(AuthorizationException $e){
            //dd($e->getMessage());
            return redirect(route('admin.users.index'))->with([
            //return redirect()->back()->with([
                'user_edit_message'     => 'You dont have Permissions to update student user accounts !',
                'user_edit_cls'         => 'flash-danger',
                'user_edit_msgTitle'    => 'Permission Denied !',
            ]);

        }catch(\Exception $e){
            //dd($e->getMessage());
            return redirect()->back()->with([
                'user_edit_message'  => 'User update Failed!',
                'user_edit_cls'     => 'flash-danger',
                'user_edit_msgTitle'=> 'Error !',
            ]);

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

            $this->authorize('updateEditors',$userData['dbRec']);

            $isUpdated = $this->adminUserService->updateEditorRec($request, $userData['dbRec']);
            if (!$isUpdated)
                throw new CustomException("User update failed");

            return redirect()->route('admin.users.index')->with([
                'message'  => 'Editor update success',
                'cls'     => 'flash-success',
                'msgTitle'=> 'Success',
            ]);

        }catch(CustomException $e){
            //dd($e->getMessage());
            return redirect()->back()->with([
                'user_edit_message'  => $e->getMessage(),
                'user_edit_cls'     => 'flash-danger',
                'user_edit_msgTitle'=> 'Error !',
            ]);

        }catch(AuthorizationException $e){
            return redirect(route('admin.users.index'))->with([
            //return redirect()->back()->with([
                'user_edit_message'     => 'You dont have Permissions to update editor user accounts !',
                'user_edit_cls'         => 'flash-danger',
                'user_edit_msgTitle'    => 'Permission Denied !',
            ]);

        }catch(\Exception $e){
            //dd($e->getMessage());
            return redirect()->back()->with([
                'user_edit_message'  => 'User update Failed!',
                'user_edit_cls'     => 'flash-danger',
                'user_edit_msgTitle'=> 'Error !',
            ]);

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
                throw new CustomException('User status update failed!');

            return response()->json([
                'message'  => 'User status update success',
                'status' => 'success',
            ]);

        }catch(CustomException $e){
            return response()->json([
                'message'  => $e->getMessage(),
                'status' => 'error',
            ]);

        }catch(AuthorizationException $e){
            return response()->json([
                'message'=> 'You dont have Permissions to update user status !',
                'status' => 'error',
                'msgTitle'=> 'Permission Denied !'
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'message'  => $e->getMessage(),
                //'message'  => 'User status update failed!',
                'status' => 'error',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id){
        //todo delete image
        try{

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
                throw new CustomException('Invalid id',$eArr);

            $userData = $this->adminUserService->findDbRec($id);
            if(is_null($userData['dbRec']))
                throw new CustomException('User does not exist!',$eArr);

            $this->authorize('delete', $userData['dbRec']);

            $isDelete = $this->adminUserService->deleteDbRec($userData['dbRec']);
            if (!$isDelete)
                throw new CustomException("User delete failed",$eArr);

            return redirect(route($redirectRoute, []). $hash)->with([
                'message'   => 'successfully deleted the user record',
                'cls'       => 'flash-success',
                'msgTitle'  => 'Success!',
            ]);

        }catch(CustomException $e){
            return redirect(route('admin.users.index',[]).$hash)->with([
                'message'     => $e->getMessage(),
                'cls'         => "flash-danger",
                'msgTitle'    => 'Error !',
            ]);

        }catch(AuthorizationException $e){
            return redirect(route('admin.users.index'))->with([
                'message'     => 'You dont have Permissions to delete the user !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);
        }catch(\Exception $e){
            return redirect(route('admin.users.index',[]).$hash)->with([
                'message'     => 'User delete failed!',
                //'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }

    }




    public function viewUnApprovedTeachersList(){

        try{
            //todo
            //$this->authorize('delete', $userData['dbRec']);

            $unApprovedTeachers = $this->adminUserService->findUnApprovedTeachers();

            $teachersArr = AdminUserDataFormatter::prepareUnApprovedTeachers($unApprovedTeachers);
            return view('admin-panel.user-approve-teachers')->with([
                'teachers'   => $teachersArr,
            ]);

        }catch(CustomException $e){
            session()->now('message',$e->getMessage());
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            return view('admin-panel.user-approve-teachers');

        }catch(AuthorizationException $e){
            return redirect(route('admin.users.index'))->with([
                'message'     => 'You dont have Permissions to view the user !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);

        }catch(\Exception $e){
            session()->now('message','User does not exist');
            //session()->now('message',$e->getMessage());
            session()->now('cls','flash-danger');
            session()->now('msgTitle','Error!');
            return view('admin-panel.user-approve-teachers');

        }
    }


    public function viewUnApprovedTeacher($id){
        try{

            if(!filter_var($id, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');

            $userData = $this->adminUserService->findDbRec($id);
            if(is_null($userData['dbRec']))
                throw new CustomException('User does not exist!');

            //todo
            //$this->authorize('view', $userData['dbRec']);

            if(empty($userData['dbRec']->getAllUserRoles()))
                throw new CustomException('User have no role!');

            if($userData['dbRec']->roles()->first()->name != RoleModel::TEACHER)
                throw new CustomException("Invalid User");

            if($userData['dbRec']->status == true)
                throw new CustomException("Account already activated");

            $filteredUserData   = AdminUserDataFormatter::prepareUserData($userData);

            return view('admin-panel.teacher.approve-account')->with([
                'userData'   => $filteredUserData,
            ]);

        }catch(CustomException $e){
            return view('admin-panel.teacher.approve-account')->with([
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);

        }catch(AuthorizationException $e){
            return redirect(route('admin.users.index'))->with([
                'message'     => 'You dont have Permissions to view the user !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);

        }catch(\Exception $e){
            return view('admin-panel.teacher.approve-account')->with([
                'message'     => 'Error',
                //'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }
    }

    public function changesApprove(){
        return view('admin-panel.user-changes-approve');
    }




}



