<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\EditorStoreRequest;
use App\Http\Requests\Admin\EditorUpdateRequest;
use App\Http\Requests\Admin\MarketerStoreRequest;
use App\Http\Requests\Admin\MarketerUpdateRequest;
use App\Http\Requests\Admin\StudentStoreRequest;
use App\Http\Requests\Admin\StudentUpdateRequest;
use App\Http\Requests\Admin\TeacherStoreRequest;
use App\Http\Requests\Admin\TeacherUpdateRequest;
use App\Models\Subject;
use App\Models\User;
use App\Services\UserService;
use App\Utils\FileUploadUtil;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


use Sentinel;


class UserController extends Controller
{

    // todo user role
    // todo reg activate

    private $userService;

    public function __construct(UserService $userService){

        $this->userService = $userService;

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers   =   Sentinel::findRoleBySlug('teacher')->users()->with('roles')->orderBy('id')->get();
        $students   =   Sentinel::findRoleBySlug('student')->users()->with('roles')->get();
        $marketers  =   Sentinel::findRoleBySlug('marketer')->users()->with('roles')->get();
        $editors    =   Sentinel::findRoleBySlug('editor')->users()->with('roles')->get();


        //dd(Sentinel::findRoleBySlug('teacher')->users()->with('roles')->get());

        //$teachers->each(function($item, $key) {

           // var_dump($item->id);
            //var_dump($item->roles[0]->name);
            //dd($item->roles[0]->getRoleSlug());
            //dd($item->getUserRoles()[0]->slug);
            //dd($item->activations[0]->completed);
            //var_dump($item->activations);
          //  var_dump($item->isactivated());
            //$item->isactivated();

        //});

        //dd($teachers);

        return view('admin-panel.user-manage')->with([
            'teachers'   => $teachers,
            'students'   => $students,
            'marketers'  => $marketers,
            'editors'    => $editors,
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-panel.user-add');
    }



    public function storeTeacher(TeacherStoreRequest $request){
        //dd($request->all());

        try{

            $username = $this->userService->generateUniqueUsername($request->get('teacher-uname'));
            $usernameMsg = ($username==$request->get('teacher-uname'))?'':"Given username is already there, ∴ system updated username to {$username}";

            if (isset($request->validator) && $request->validator->fails()) {
                throw new CustomException('Form validation failed');
            }

            $file = $request->input('teacher_profile_img');
            if(isset($file)){
                $fileUploadUtil = new FileUploadUtil();
                $destination    = $fileUploadUtil->upload($file,'users/teachers/');
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

            return redirect()->back()
                ->with([
                    'teacher_submit_message'  => 'Add Teacher success',
                    'teacher_submit_message2' => $usernameMsg,
                    //'teacher_submit_title'   => 'Student Registration submit page',
                    'teacher_submit_cls'     => 'flash-success',
                    'teacher_submit_msgTitle'=> 'Success',

                ]);

        }catch(CustomException $e){
            return redirect()->back()
                ->with([
                    'teacher_submit_message'  => $e->getMessage(),
                    //'teacher_submit_message2' => $pwResetTxt,
                    //'teacher_submit_title'   => 'Student Registration submit page',
                    'teacher_submit_cls'     => 'flash-danger',
                    'teacher_submit_msgTitle'=> 'Error !',
                ]);

        }catch(\Exception $e){
            return redirect()->back()
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

            $username = $this->userService->generateUniqueUsername($request->get('stud-uname'));
            $usernameMsg = ($username==$request->get('stud-uname'))?'':"Given username is already there, ∴ system updated username to {$username}";


            if (isset($request->validator) && $request->validator->fails()) {
                throw new CustomException('Form validation failed');
            }

            $status = ($request->get('student_stat')=='enable')? True: False;

            $student = [
                'full_name'         => $request->get('stud-name'),
                'email'             => $request->get('stud-email'),
                'password'          => $request->get('stud-password'),
                'phone'             => $request->get('stud-phone'),
                'username'          => $username,
                'profile_text'      => $request->get('stud_details'),
                'gender'            => $request->get('stud-gender'),
                'dob_year'          => $request->get('stud_birth_year'),
                'status'            => $status,
                'profile_pic'       => null,
            ];

            $user_stud = Sentinel::registerAndActivate($student);
            $role_stud = Sentinel::findRoleBySlug('student');
            $role_stud->users()->attach($user_stud);

            return redirect(route('admin.user.create', []). '#tab-add-students')
                ->with([
                    'student_submit_message'  => 'Add Student success',
                    'student_submit_message2' => $usernameMsg,
                    //'student_submit_title'   => 'Student Registration submit page',
                    'student_submit_cls'     => 'flash-success',
                    'student_submit_msgTitle'=> 'Success',
                ]);

        }catch(CustomException $e){

            return redirect(route('admin.user.create', []). '#tab-add-students')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'student_submit_message'  => $e->getMessage(),
                    //'student_submit_message2' => $pwResetTxt,
                    //'student_submit_title'   => 'Student Registration submit page',
                    'student_submit_cls'     => 'flash-danger',
                    'student_submit_msgTitle'=> 'Error !',
                ]);

        }catch(\Exception $e){
            return redirect(route('admin.user.create', []). '#tab-add-students')
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
            $username = $this->userService->generateUniqueUsername($request->get('marketer-uname'));
            $usernameMsg = ($username==$request->get('marketer-uname'))?'':"Given username is already there, ∴ system updated username to {$username}";


            if (isset($request->validator) && $request->validator->fails()) {
                throw new CustomException('Form validation failed');
            }

            $status = ($request->get('marketer_stat')=='enable')? True: False;

            $marketer = [
                'full_name'         => $request->get('marketer-name'),
                'email'             => $request->get('marketer-email'),
                'password'          => $request->get('marketer-password'),
                'phone'             => $request->get('marketer-phone'),
                'username'          => $username,
                'gender'            => $request->get('marketer-gender'),
                'status'            => $status,
                'profile_pic'       => null,

            ];

            $user_marketer = Sentinel::registerAndActivate($marketer);
            $role_marketer = Sentinel::findRoleBySlug('marketer');
            $role_marketer->users()->attach($user_marketer);

            return redirect(route('admin.user.create', []). '#tab-add-marketers')
                ->with([
                    'marketer_submit_message'  => 'Add Marketer success',
                    'marketer_submit_cls'     => 'flash-success',
                    'marketer_submit_msgTitle'=> 'Success',
                    'marketer_submit_message2'  => $usernameMsg
                ]);

        }catch(CustomException $e){

            return redirect(route('admin.user.create', []). '#tab-add-marketers')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'marketer_submit_message'  => $e->getMessage(),
                    'marketer_submit_cls'     => 'flash-danger',
                    'marketer_submit_msgTitle'=> 'Error !',
                ]);

        }catch(\Exception $e){
            return redirect(route('admin.user.create', []). '#tab-add-marketers')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'marketer_submit_message'  => 'Add Marketer Failed !',
                    'marketer_submit_cls'     => 'flash-danger',
                    'marketer_submit_msgTitle'=> 'Error !',
                ]);
        }
    }


    public function storeEditor(EditorStoreRequest $request){
        //dd($request->all());
        try{
            $username = $this->userService->generateUniqueUsername($request->get('editor-uname'));
            $usernameMsg = ($username==$request->get('editor-uname'))?'':"Given username is already there, ∴ system updated username to {$username}";

            if (isset($request->validator) && $request->validator->fails()) {
                throw new CustomException('Form validation failed');
            }

            $status = ($request->get('marketer_stat')=='enable')? True: False;
            $editor = [
                'full_name'         => $request->get('editor-name'),
                'email'             => $request->get('editor-email'),
                'password'          => $request->get('editor-password'),
                'phone'             => $request->get('editor-phone'),
                'username'          => $username,
                'gender'            => $request->get('editor-gender'),
                'status'            => $status,
                'profile_pic'       => null,

            ];

            $user_editor = Sentinel::registerAndActivate($editor);
            $role_editor = Sentinel::findRoleBySlug('editor');
            $role_editor->users()->attach($user_editor);

            return redirect(route('admin.user.create', []). '#tab-add-editor')
                ->with([
                    'editor_submit_message'  => 'Add editor success',
                    'editor_submit_cls'     => 'flash-success',
                    'editor_submit_msgTitle'=> 'Success',
                ]);

        }catch(CustomException $e){

            return redirect(route('admin.user.create', []). '#tab-add-editor')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'editor_submit_message'     => $e->getMessage(),
                    'editor_submit_cls'         => 'flash-danger',
                    'editor_submit_msgTitle'    => 'Error !',
                    'editor_submit_message2'    => $usernameMsg,
                ]);

        }catch(\Exception $e){
            return redirect(route('admin.user.create', []). '#tab-add-editor')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'editor_submit_message'  => 'Add editor Failed !',
                    'editor_submit_cls'     => 'flash-danger',
                    'editor_submit_msgTitle'=> 'Error !',
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
            $user = Sentinel::findById($id);
            // dd($user);
            if($user != null){
                $role = isset($user->getUserRoles()[0]->name) ? $user->getUserRoles()[0]->name : null;
                return view('admin-panel.user-view')->with([
                    'userData'   => $user,
                    'userType'   => $role,
                ]);
            }else{
                throw new ModelNotFoundException;
            }
        }catch(CustomException $e){

            return view('admin-panel.user-view')->with([
                'view_user_message'     => $e->getMessage(),
                'view_user_cls'         => 'flash-danger',
                'view_user_msgTitle'    => 'Error !',
            ]);

        }catch(\Exception $e){
            return view('admin-panel.user-view')->with([
                'view_user_message'     => 'User does not exist!',
                'view_user_cls'         => 'flash-danger',
                'view_user_msgTitle'    => 'Error !',
            ]);
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
            $user = User::find($id);
            $userRole = null;
            if ($user) {

                $userRole = $user->getAllUserRoles()[0]->name;
                if(!$userRole){
                    throw new CustomException('User have no role!',[
                        'cls'     => 'flash-warning',
                        'msgTitle'=> 'Warning!',
                    ]);
                }

                //dd($user);
                return view('admin-panel.user-edit')->with([
                    'userData'   => $user,
                    'userType'   => $userRole,
                ]);

            } else {

                throw new CustomException('User does not exist!',[
                    'cls'     => 'flash-warning',
                    'msgTitle'=> 'Warning!',
                ]);

            }
        }catch(CustomException $e){

            $exData = $e->getData();
            //dd($e->getData());
            return view('admin-panel.user-view')->with([
                'view_user_message'     => $e->getMessage(),
                'view_user_cls'         => $exData['cls'] ?? "flash-danger",
                'view_user_msgTitle'    => $exData['msgTitle']  ?? 'Error !',
            ]);

        }catch(\Exception $e){
            return view('admin-panel.user-view')->with([
                'view_user_message'     => 'User delete failed!',
                'view_user_cls'         => 'flash-danger',
                'view_user_msgTitle'    => 'Error !',
            ]);
        }




    }


    public function updateTeacher(TeacherUpdateRequest $request, $id){
        //dd($request->all());
        try{

            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }

            $user = User::find($id);

            if ($user) {

                $file = $request->input('teacher_profile_img');
                if(!isset($file)){  //no image upload
                    //todo delete prev image when update image path
                    // when teacher_img_add_count < 1 then delete prev image

                    $imgDest = null;
                }else{

                    //input filed with name = teacher_img_add_count vale equals 0 when initially filpond loads image
                    if( $request->teacher_img_add_count == 0){

                        // previously no image now new image is uploaded and submit form
                        if($request->teacher_img_url == null){

                            $fileUploadUtil = new FileUploadUtil();
                            $imgDest        = $fileUploadUtil->upload($file,'users/teachers/');

                        }else{
                            // no change to previously upload image and submit edit form
                            $imgDest = $request->teacher_img_url;
                        }

                    }else{
                        // previously image is uploaded and now change the image and upload
                        //todo delete prviously uploaded image

                        $fileUploadUtil = new FileUploadUtil();
                        $imgDest        = $fileUploadUtil->upload($file,'users/teachers/');
                    }
                }


                $status = ($request->get('teacher_stat')=='enable')? True: False;

                $teacherUpdateInfo = [
                    'full_name'         => $request->get('teacher-name'),
                    'phone'             => $request->get('teacher-phone'),
                    'edu_qualifications'=> $request->get('teacher_edu_details'),
                    'gender'            => $request->get('teacher-gender'),
                    'dob_year'          => $request->get('teacher_birth_year'),
                    'status'            => $status,
                    'profile_pic'       => $imgDest,//
                ];
                User::where('id',$id)->update($teacherUpdateInfo);


                //todo -future-send email
                //Pa$$w0rd
                if($request->teacher_reset_pw_stat == 'on'){
                    Sentinel::update($user, array('password' => 'qwerty123'));
                }

                return redirect()->route('admin.user.index')
                    ->with([
                        'message'  => 'Teacher update success',
                        'cls'     => 'flash-success',
                        'msgTitle'=> 'Success',
                    ]);
            } else {
                throw new CustomException('User does not exist!',[
                    'cls'     => 'flash-warning',
                    'msgTitle'=> 'Warning!',
                ]);
            }

        }catch(CustomException $e){

            return redirect()->back()
                ->with([
                    'user_edit_message'  => $e->getMessage(),
                    'user_edit_cls'     => 'flash-danger',
                    'user_edit_msgTitle'=> 'Error !',
                ]);
        }catch(\Exception $e){
            return redirect()->back()
                ->with([
                    'user_edit_message'  => 'Add User Failed !',
                    'user_edit_cls'     => 'flash-danger',
                    'user_edit_msgTitle'=> 'Error !',
                ]);
        }

    }


    public function updateStudent(StudentUpdateRequest $request, $id){

        try{

            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }

            $user = User::find($id);

            if ($user) {
                $status = ($request->get('stud_stat')=='enable')? True: False;
                $studentUpdateInfo = [
                    'full_name'         => $request->get('stud-name'),
                    'phone'             => $request->get('stud-phone'),
                    'profile_text'      => $request->get('stud_details'),
                    'gender'            => $request->get('stud-gender'),
                    'dob_year'          => $request->get('stud_birth_year'),
                    'status'            => $status,
                ];
                User::where('id',$id)->update($studentUpdateInfo);

                //todo -future-send email
                //Pa$$w0rd
                if($request->stud_reset_pw_stat == 'on'){
                    Sentinel::update($user, array('password' => 'qwerty123'));
                }

                return redirect()->route('admin.user.index')
                    ->with([
                        'message' => 'Student update success',
                        'cls'     => 'flash-success',
                        'msgTitle'=> 'Success',
                    ]);
            } else {
                throw new CustomException('User does not exist!',[
                    'cls'     => 'flash-warning',
                    'msgTitle'=> 'Warning!',
                ]);
            }

        }catch(CustomException $e){
            return redirect()->back()
                ->with([
                    'user_edit_message'  => $e->getMessage(),
                    'user_edit_cls'     => 'flash-danger',
                    'user_edit_msgTitle'=> 'Error !',
                ]);
        }catch(\Exception $e){
            return redirect()->back()
                ->with([
                    'user_edit_message'  => 'User update Failed!',
                    'user_edit_cls'     => 'flash-danger',
                    'user_edit_msgTitle'=> 'Error !',
                ]);
        }
    }


    public function updateMarketer(MarketerUpdateRequest $request, $id){
        try{

            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }

            $user = User::find($id);

            if ($user) {

                $status = ($request->get('marketer_stat')=='enable')? True: False;

                $marketerUpdateInfo = [
                    'full_name'         => $request->get('marketer-name'),
                    'phone'             => $request->get('marketer-phone'),
                    'gender'            => $request->get('marketer-gender'),
                    'status'            => $status,
                ];
                User::where('id',$id)->update($marketerUpdateInfo);


                //todo -future-send email
                //Pa$$w0rd
                if($request->marketer_reset_pw_stat == 'on'){
                    Sentinel::update($user, array('password' => 'qwerty123'));
                }

                return redirect()->route('admin.user.index')
                    ->with([
                        'message'  => 'Marketer update success',
                        'cls'     => 'flash-success',
                        'msgTitle'=> 'Success',
                    ]);
            } else {
                throw new CustomException('User does not exist!',[
                    'cls'     => 'flash-warning',
                    'msgTitle'=> 'Warning!',
                ]);
            }

        }catch(CustomException $e){

            return redirect()->back()
                ->with([
                    'user_edit_message'  => $e->getMessage(),
                    'user_edit_cls'     => 'flash-danger',
                    'user_edit_msgTitle'=> 'Error !',
                ]);
        }catch(\Exception $e){
            return redirect()->back()
                ->with([
                    'user_edit_message'  => 'User update Failed!',
                    'user_edit_cls'     => 'flash-danger',
                    'user_edit_msgTitle'=> 'Error !',
                ]);
        }
    }


    public function updateEditor(EditorUpdateRequest $request, $id){
        try{

            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }

            $user = User::find($id);

            if ($user) {

                $status = ($request->get('editor_stat')=='enable')? True: False;

                $editorUpdateInfo = [
                    'full_name'         => $request->get('editor-name'),
                    'phone'             => $request->get('editor-phone'),
                    'gender'            => $request->get('editor-gender'),
                    'status'            => $status,
                ];
                User::where('id',$id)->update($editorUpdateInfo);


                //todo -future-send email
                //Pa$$w0rd
                if($request->editor_reset_pw_stat == 'on'){
                    Sentinel::update($user, array('password' => 'qwerty123'));
                }

                return redirect()->route('admin.user.index')
                    ->with([
                        'message'  => 'Editor update success',
                        'cls'     => 'flash-success',
                        'msgTitle'=> 'Success',
                    ]);
            } else {
                throw new CustomException('User does not exist!',[
                    'cls'     => 'flash-warning',
                    'msgTitle'=> 'Warning!',
                ]);
            }

        }catch(CustomException $e){

            return redirect()->back()
                ->with([
                    'user_edit_message'  => $e->getMessage(),
                    'user_edit_cls'     => 'flash-danger',
                    'user_edit_msgTitle'=> 'Error !',
                ]);
        }catch(\Exception $e){
            return redirect()->back()
                ->with([
                    'user_edit_message'  => 'User update Failed!',
                    'user_edit_cls'     => 'flash-danger',
                    'user_edit_msgTitle'=> 'Error !',
                ]);
        }
    }

    public function changeStatus(Request $request){

        try{

            if(!filter_var($request->userId, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id - User status update failed');
            }

            $user = User::find($request->userId);
            if ($user) {
                $status = (int)$request->status;
                $teacherUpdateInfo = ['status'=> $status];
                User::where('id',$request->userId)->update($teacherUpdateInfo);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //dd($id);
        //dd($request->userType);
        //todo delete image

        try{

            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }
            $user = User::find($id);
            if ($user) {
                $user->delete();

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

                return redirect(route($redirectRoute, []). $hash)
                    ->with([
                        'message'  => 'successfully deleted the user record',
                        //'message2' => $pwResetTxt,
                        //'title'   => 'Student Registration submit page',
                        'cls'     => 'flash-success',
                        'msgTitle'=> 'Success!',
                    ]);

            } else {

                throw new CustomException('User does not exist!',[
                    'cls'     => 'flash-warning',
                    'msgTitle'=> 'Warning!',
                ]);

            }
        }catch(CustomException $e){

            $exData = $e->getData();
            //dd($e->getData());
            return view('admin-panel.user-view')->with([
                'view_user_message'     => $e->getMessage(),
                'view_user_cls'         => $exData['cls'] ?? "flash-danger",
                'view_user_msgTitle'    => $exData['msgTitle']  ?? 'Error !',
            ]);

        }catch(\Exception $e){
            return view('admin-panel.user-view')->with([
                //'view_user_message'     => 'User delete failed!',
                'view_user_message'     => $e->getMessage(),
                'view_user_cls'         => 'flash-danger',
                'view_user_msgTitle'    => 'Error !',
            ]);
        }

    }




    public function viewUnApprovedTeachersList()
    {
        

        $unApprovedTeachers   =   Sentinel::findRoleBySlug('teacher')
                        ->users()
                        ->with('roles')
                        ->where('users.status','0')
                        //->where('users.email','carroll.cydney@example.com')
                        ->orderBy('id')
                        ->get();      

        //dd($teachers);
        
        return view('admin-panel.user-approve-teachers')->with([
            'teachers'   => $unApprovedTeachers,
        ]);
    }


    public function viewUnApprovedTeacher($id)
    {
        
        try{

            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }
            $user = Sentinel::findById($id);
            // dd($user);
            if($user != null){
                $role = isset($user->getUserRoles()[0]->name) ? $user->getUserRoles()[0]->name : null;
                
                //dd($user->status);
                if($role != 'teacher'){
                    throw new CustomException("Invalid User");                    
                }
                //todo
                if($user->status == true){
                    //throw new CustomException("Account already activated");   
                }

                return view('admin-panel.teacher.approve-account')->with([
                    'userData'   => $user,
                    'userType'   => $role,
                ]);
            }else{
                throw new ModelNotFoundException;
            }
        }catch(CustomException $e){

            return view('admin-panel.teacher.approve-account')->with([
                'view_user_message'     => $e->getMessage(),
                'view_user_cls'         => 'flash-danger',
                'view_user_msgTitle'    => 'Error !',
            ]);

        }catch(\Exception $e){
            return view('admin-panel.teacher.approve-account')->with([
                'view_user_message'     => 'Error',
                //'view_user_message'     => $e->getMessage(),
                'view_user_cls'         => 'flash-danger',
                'view_user_msgTitle'    => 'Error !',
            ]);
        }

    }





    public function changesApprove()
    {
        return view('admin-panel.user-changes-approve');
    }




}