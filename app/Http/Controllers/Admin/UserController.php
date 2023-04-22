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
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Collection;

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
        try{

            $this->authorize('viewAny',User::class);            
            $teachers   =   Sentinel::findRoleBySlug('teacher')->users()->withoutGlobalScope('active')->with('roles')->orderBy('id')->get();
            $students   =   Sentinel::findRoleBySlug('student')->users()->withoutGlobalScope('active')->with('roles')->get();
            $marketers  =   Sentinel::findRoleBySlug('marketer')->users()->withoutGlobalScope('active')->with('roles')->get();
            $editors    =   Sentinel::findRoleBySlug('editor')->users()->withoutGlobalScope('active')->with('roles')->get();  
            

            //$teachers1   =   Sentinel::findRoleBySlug('teacher')->users()->with('roles')->orderBy('id')->get();
            
            //dd($teachers->first());

            //dd($teachers);
            return view('admin-panel.user-list')->with([
                'teachers'   => $teachers,
                //'teachers1'   => $teachers1,
                'students'   => $students,
                'marketers'  => $marketers,
                'editors'    => $editors,
            ]);

        }catch(AuthorizationException $e){           
            return redirect(route('admin.dashboard'))->with([
                'message'   =>'You dont have Permissions view all users',
                'cls'       =>'flash-danger',
                'msgTitle'  =>'Permission Denied!'
            ]);

        }catch(\Exception $e){
            //dd($e);        
            session()->flash('message','Failed to show all users');
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('admin-panel.user-list');
        }



        //dd(Sentinel::findRoleBySlug('teacher')->users()->with('roles')->get());    
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {        
        //session(['key' => 'value']);
        //dd(session('key'));
        try{
            $this->authorize('create',User::class);            
            return view('admin-panel.user-add');           

        }catch(AuthorizationException $e){
            return redirect(route('admin.user.index'))->with([
                'message'   =>'You dont have Permissions to create users',
                'cls'       =>'flash-danger',
                'msgTitle'  =>'Permission Denied!'
            ]);

        }catch(\Exception $e){
            session()->flash('message',  'Failed to show user add form');
            session()->flash('cls',      'flash-danger');
            session()->flash('msgTitle', 'Error!');
            return view('admin-panel.user-add');
        }
    }



    public function storeTeacher(TeacherStoreRequest $request){
        //dd($request->all());
        //username

        try{

            throw new \Exception('Form validation failed');

            $this->authorize('createTeachers',User::class);
            $username    = $this->userService->generateUniqueUsername($request->get('teacher-uname'));
            $usernameMsg = ($username != $request->get('teacher-uname'))?"Given username is already there, ∴ system updated username to {$username}":'';

            if (isset($request->validator) && $request->validator->fails()) {
                throw new CustomException('Form validation failed',[
                    'cls'     => 'flash-danger',
                    'msgTitle'=> 'Error!',
                ]);
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

            return redirect(route('admin.user.create'))->with([            
                'teacher_submit_message'  => 'Add Teacher success',
                'teacher_submit_message2' => $usernameMsg,
                //'teacher_submit_title'   => 'Student Registration submit page',
                'teacher_submit_cls'     => 'flash-success',
                'teacher_submit_msgTitle'=> 'Success',
            ]);

        }catch(CustomException $e){
            return redirect(route('admin.user.create'))
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
            return redirect(route('admin.user.create').'#tab-teachers')
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
            return redirect(route('admin.user.create'))
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
            $username = $this->userService->generateUniqueUsername($request->get('stud-uname'));
            $usernameMsg = ($username != $request->get('stud-uname'))?"Given username is already there, ∴ system updated username to {$username}":'';


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

            return redirect(route('admin.user.create', []). '#tab-students')
                ->with([
                    'student_submit_message'  => 'Add Student success',
                    'student_submit_message2' => $usernameMsg,
                    //'student_submit_title'   => 'Student Registration submit page',
                    'student_submit_cls'     => 'flash-success',
                    'student_submit_msgTitle'=> 'Success',
                ]);

        }catch(CustomException $e){

            return redirect(route('admin.user.create', []). '#tab-students')
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

            return redirect(route('admin.user.create', []). '#tab-students')
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
            return redirect(route('admin.user.create', []). '#tab-students')
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
            $username = $this->userService->generateUniqueUsername($request->get('marketer-uname'));
            $usernameMsg = ($username != $request->get('marketer-uname'))?"Given username is already there, ∴ system updated username to {$username}":'';


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

            return redirect(route('admin.user.create', []). '#tab-marketers')
                ->with([
                    'marketer_submit_message'  => 'Add Marketer success',
                    'marketer_submit_cls'     => 'flash-success',
                    'marketer_submit_msgTitle'=> 'Success',
                    'marketer_submit_message2'  => $usernameMsg
                ]);

        }catch(CustomException $e){

            return redirect(route('admin.user.create', []). '#tab-marketers')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'marketer_submit_message'  => $e->getMessage(),
                    'marketer_submit_cls'     => 'flash-danger',
                    'marketer_submit_msgTitle'=> 'Error !',
                ]);

        }catch(AuthorizationException $e){
            return redirect(route('admin.user.create', []). '#tab-marketers')
            //return redirect(url()->previous().'#tab-marketers')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'marketer_submit_message'  => 'You dont have Permissions to create marketers !',
                    //'marketer_submit_message2' => $pwResetTxt,
                    //'marketer_submit_title'   => 'Student Registration submit page',
                    'marketer_submit_cls'     => 'flash-danger',
                    'marketer_submit_msgTitle'=> 'Permission Denied !',
                ]);

        }catch(\Exception $e){
            return redirect(route('admin.user.create', []). '#tab-marketers')
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
            $this->authorize('createEditors',User::class);
            $username = $this->userService->generateUniqueUsername($request->get('editor-uname'));
            $usernameMsg = ($username != $request->get('editor-uname'))?"Given username is already there, ∴ system updated username to {$username}":'';

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

            return redirect(route('admin.user.create', []). '#tab-editor')
                ->with([
                    'editor_submit_message'  => 'Add editor success',
                    'editor_submit_cls'     => 'flash-success',
                    'editor_submit_msgTitle'=> 'Success',
                ]);

        }catch(CustomException $e){

            return redirect(route('admin.user.create', []). '#tab-editor')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'editor_submit_message'     => $e->getMessage(),
                    'editor_submit_cls'         => 'flash-danger',
                    'editor_submit_msgTitle'    => 'Error !',                    
                ]);

        }catch(AuthorizationException $e){
            return redirect(route('admin.user.create', []). '#tab-editor')
            //return redirect(url()->previous().'#tab-editor')
                ->withErrors($request->validator)
                ->withInput()
                ->with([
                    'editor_submit_message'  => 'You dont have Permissions to create editors !',
                    //'editor_submit_message2' => $pwResetTxt,
                    //'editor_submit_title'   => 'Student Registration submit page',
                    'editor_submit_cls'     => 'flash-danger',
                    'editor_submit_msgTitle'=> 'Permission Denied !',
                ]);

        }catch(\Exception $e){
            return redirect(route('admin.user.create', []). '#tab-editor')
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
            
            //$user = Sentinel::findById($id);
            $user = User::withoutGlobalScope('active')->find($id);

            $this->authorize('view',$user);
            
            if($user != null){
                $role = $user->roles()->first()->slug;
                return view('admin-panel.user-view')->with([
                    'userData'   => $user,
                    'userType'   => $role,
                ]);
            }else{
                throw new ModelNotFoundException;
            }
        }catch(CustomException $e){
            session()->flash('view_user_message',$e->getMessage());
            session()->flash('view_user_cls','flash-danger');
            session()->flash('view_user_msgTitle','Error!');
            return view('admin-panel.user-view');

        }catch(AuthorizationException $e){
            return redirect(route('admin.user.index'))->with([            
                'message'     => 'You dont have Permissions to view the user !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);
            
        }catch(\Exception $e){
            session()->flash('view_user_message','User does not exist');
            //session()->flash('view_user_message',$e->getMessage());
            session()->flash('view_user_cls','flash-danger');
            session()->flash('view_user_msgTitle','Error!');
            return view('admin-panel.user-view');

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
            $user = User::withoutGlobalScope('active')->find($id);

            $this->authorize('update',$user);
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
            session()->flash('user_edit_message',$e->getMessage());
            session()->flash('user_edit_cls',$exData['cls'] ?? "flash-danger");
            session()->flash('user_edit_msgTitle', $exData['msgTitle']  ?? 'Error !');
            return view('admin-panel.user-view');            

        }catch(AuthorizationException $e){
            return redirect(route('admin.user.index'))->with([            
                'message'     => 'You dont have Permissions to edit the user',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);

        }
        catch(\Exception $e){
            session()->flash('user_edit_message','User edit failed');
            session()->flash('user_edit_cls','flash-danger');
            session()->flash('user_edit_msgTitle','Error!');
            return view('admin-panel.user-view');

        }

    }

    public function updateTeacher(TeacherUpdateRequest $request, $id){
        
        try{

            if(!filter_var($id, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }
            
            if (isset($request->validator) && $request->validator->fails()) {
                throw new CustomException('Form validation failed');
            }

            $user = User::withoutGlobalScope('active')->find($id);

            $this->authorize('updateTeachers',$user);
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
                User::withoutGlobalScope('active')->where('id',$id)->update($teacherUpdateInfo);

                //todo -future-send email
                if($request->teacher_reset_pw_stat == 'on'){
                    Sentinel::update($user, array('password' => 'Pa$$w0rd!'));
                }

                return redirect()->route('admin.user.index')->with([
                    'message' => 'Teacher update success',
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
            return redirect()->back()->with([
                'user_edit_message'  => $e->getMessage(),
                'user_edit_cls'     => 'flash-danger',
                'user_edit_msgTitle'=> 'Error !',
            ]);

        }catch(AuthorizationException $e){
            return redirect(route('admin.user.index'))->with([
            //return redirect()->back()->with([
                'user_edit_message'     => 'You dont have Permissions to update teacher user accounts !',
                'user_edit_cls'         => 'flash-danger',
                'user_edit_msgTitle'    => 'Permission Denied !',
            ]);

        }catch(\Exception $e){
            return redirect()->back()->with([
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

            if (isset($request->validator) && $request->validator->fails()) {
                throw new CustomException('Form validation failed');
            }
            
            $user = User::withoutGlobalScope('active')->find($id);

            $this->authorize('updateStudents',$user);
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
                
                User::withoutGlobalScope('active')->where('id',$id)->update($studentUpdateInfo);

                //todo -future-send email
                if($request->stud_reset_pw_stat == 'on'){
                    Sentinel::update($user, array('password' => 'Pa$$w0rd!'));
                }

                return redirect()->route('admin.user.index')->with([
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
            return redirect()->back()->with([
                'user_edit_message'  => $e->getMessage(),
                'user_edit_cls'     => 'flash-danger',
                'user_edit_msgTitle'=> 'Error !',
            ]);
        }catch(AuthorizationException $e){
            return redirect(route('admin.user.index'))->with([
            //return redirect()->back()->with([
                'user_edit_message'     => 'You dont have Permissions to update student user accounts !',
                'user_edit_cls'         => 'flash-danger',
                'user_edit_msgTitle'    => 'Permission Denied !',
            ]);            
        }catch(\Exception $e){
            return redirect()->back()->with([
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

            if (isset($request->validator) && $request->validator->fails()) {
                throw new CustomException('Form validation failed');
            }
            
            $user = User::withoutGlobalScope('active')->find($id);

            $this->authorize('updateMarketers',$user);
            if ($user) {

                $status = ($request->get('marketer_stat')=='enable')? True: False;

                $marketerUpdateInfo = [
                    'full_name'         => $request->get('marketer-name'),
                    'phone'             => $request->get('marketer-phone'),
                    'gender'            => $request->get('marketer-gender'),
                    'status'            => $status,
                ];
                User::withoutGlobalScope('active')->where('id',$id)->update($marketerUpdateInfo);


                //todo -future-send email
                if($request->marketer_reset_pw_stat == 'on'){
                    Sentinel::update($user, array('password' => 'Pa$$w0rd!'));
                }

                return redirect()->route('admin.user.index')->with([
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
            return redirect()->back()->with([
                'user_edit_message'  => $e->getMessage(),
                'user_edit_cls'     => 'flash-danger',
                'user_edit_msgTitle'=> 'Error !',
            ]);
        }catch(AuthorizationException $e){
            return redirect(route('admin.user.index'))->with([
            //return redirect()->back()->with([
                'user_edit_message'     => 'You dont have Permissions to update marketer user accounts !',
                'user_edit_cls'         => 'flash-danger',
                'user_edit_msgTitle'    => 'Permission Denied !',
            ]);            
        }catch(\Exception $e){
            return redirect()->back()->with([
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

            if (isset($request->validator) && $request->validator->fails()) {
                throw new CustomException('Form validation failed');
            }

            $user = User::withoutGlobalScope('active')->find($id);

            $this->authorize('updateEditors',$user);
            if ($user) {

                $status = ($request->get('editor_stat')=='enable')? True: False;

                $editorUpdateInfo = [
                    'full_name'         => $request->get('editor-name'),
                    'phone'             => $request->get('editor-phone'),
                    'gender'            => $request->get('editor-gender'),
                    'status'            => $status,
                ];
                
                User::withoutGlobalScope('active')->where('id',$id)->update($editorUpdateInfo);

                //todo -future-send email
                if($request->editor_reset_pw_stat == 'on'){
                    Sentinel::update($user, array('password' => 'Pa$$w0rd!'));
                }

                return redirect()->route('admin.user.index')->with([
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
            return redirect()->back()->with([
                'user_edit_message'  => $e->getMessage(),
                'user_edit_cls'     => 'flash-danger',
                'user_edit_msgTitle'=> 'Error !',
            ]);

        }catch(AuthorizationException $e){
            return redirect(route('admin.user.index'))->with([
            //return redirect()->back()->with([
                'user_edit_message'     => 'You dont have Permissions to update editor user accounts !',
                'user_edit_cls'         => 'flash-danger',
                'user_edit_msgTitle'    => 'Permission Denied !',
            ]); 

        }catch(\Exception $e){
            return redirect()->back()->with([
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

            $user = User::withoutGlobalScope('active')->find($request->userId);

            $this->authorize('changeUserStatus',$user);
            if ($user) {
                $status = (int)$request->status;
                $teacherUpdateInfo = ['status'=> $status];
                
                User::withoutGlobalScope('active')->where('id',$request->userId)->update($teacherUpdateInfo);

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
                'message'=> 'You dont have Permissions to update user status !',
                'status' => 'error',
                'msgTitle'=> 'Permission Denied !'
            ]);
        }
        catch(\Exception $e){
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
            
            $user = User::withoutGlobalScope('active')->find($id);
            
            $this->authorize('delete',$user);
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

                return redirect(route($redirectRoute, []). $hash)->with([
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
            return redirect()->back()->with([
                'message'     => $e->getMessage(),
                'cls'         => $exData['cls'] ?? "flash-danger",
                'msgTitle'    => $exData['msgTitle']  ?? 'Error !',
            ]);

        }catch(AuthorizationException $e){
            return redirect(route('admin.user.index'))->with([
            //return redirect()->back()->with([
                'message'     => 'You dont have Permissions to delete the user !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with([
                //'view_user_message'     => 'User delete failed!',
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }

    }




    public function viewUnApprovedTeachersList()
    {      
        $unApprovedTeachers   =   Sentinel::findRoleBySlug('teacher')
                        ->users()
                        ->withoutGlobalScope('active')
                        ->with('roles')
                        ->where('users.status','0')
                        //->where('users.email','carroll.cydney@example.com')
                        ->orderBy('id')
                        ->get();      

        //dd($unApprovedTeachers);
        
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
            //$user = Sentinel::findById($id);
            $user = User::withoutGlobalScope('active')->find($id);

            //dd($user);
            if($user != null){
                $role = $user->roles()->first()->slug;
                
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
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
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

    public function changesApprove()
    {
        return view('admin-panel.user-changes-approve');
    }




}
