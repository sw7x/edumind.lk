<?php

namespace App\Services\Admin;

use App\Repositories\UserRepository;
use App\Models\User as UserModel;
use App\Builders\UserBuilder;
use Illuminate\Support\Facades\Gate;
use App\DataTransferObjects\Factories\UserDtoFactory;
use App\Mappers\UserMapper;

use App\Domain\Users\User as UserEntity;

use App\DataTransferObjects\UserDto;
use App\Domain\Factories\UserFactory;

use Illuminate\Http\Request;
use App\Common\Utils\FileUploadUtil;
use Sentinel;
use App\Exceptions\CustomException;
use App\Models\Role as RoleModel;
use App\DataTransformers\Database\UserDataTransformer;
use App\Common\Utils\UrlUtil;


class UserService
{

    private UserRepository $userRepository;

    function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function loadAllUserRecs() : array {
        $teachers    = $this->userRepository->findAllTeachers();
        $students    = $this->userRepository->findAllStudents();
        $marketers   = $this->userRepository->findAllMarketers();
        $editors     = $this->userRepository->findAllEditors();

        //dump($teachers->isEmpty());dump($students);dump($marketers);dump($editors);dd();

        $teachersDtoArr = array();
        $teachers->each(function (UserModel $record, int $key) use (&$teachersDtoArr){
            $teachersDtoArr[]  =   UserDataTransformer::buildDto($record->toArray());
        });

        $studentsDtoArr = array();
        $students->each(function (UserModel $record, int $key) use (&$studentsDtoArr){
            $studentsDtoArr[]  =   UserDataTransformer::buildDto($record->toArray());
        });

        $marketersDtoArr = array();
        $marketers->each(function (UserModel $record, int $key) use (&$marketersDtoArr){
            $marketersDtoArr[]  =   UserDataTransformer::buildDto($record->toArray());
        });

        $editorsDtoArr = array();
        $editors->each(function (UserModel $record, int $key) use (&$editorsDtoArr){
            $editorsDtoArr[]  =   UserDataTransformer::buildDto($record->toArray());
        });

        //dump($teachersDtoArr);dump($studentsDtoArr);dump($marketersDtoArr);dump($editorsDtoArr);dd();

        return array(
            'teachersDtoArr'    => $teachersDtoArr,
            'canViewteachers'   => Gate::allows('view', $teachers->first()),

            'studentsDtoArr'    => $studentsDtoArr,
            'canViewstudents'   => Gate::allows('view', $students->first()),

            'marketersDtoArr'   => $marketersDtoArr,
            'canViewmarketers'  => Gate::allows('view', $marketers->first()),

            'editorsDtoArr'     => $editorsDtoArr,
            'canVieweditors'    => Gate::allows('view', $editors->first()),
        );
    }


    public function saveDbRec(Request $request) : SubjectModel {
        $subjectCount       = $this->subjectRepository->findByName($request->get('name'))->count();

        if ($subjectCount > 0)
            throw new CustomException('Subject name already exists!');

        $file       = $request->input('image');
        $imgDest    = (isset($file))? (new FileUploadUtil())->upload($file,'subjects/') : null;

        $urlString  = UrlUtil::wordsToUrl($request->name,15);
        $slug       = UrlUtil::generateSubjectUrl($urlString);

        $request->merge([
            "creator_id" => Sentinel::getUser()->id,
            'slug'       => $slug,
            'image'      => $imgDest
        ]);

        $subjectDto     = SubjectDtoFactory::fromRequest($request);
        $payloadArr     = UserDataTransformer::dtoToDbRecArr($subjectDto);
        return $this->subjectRepository->create($payloadArr);
    }


    public function updateDbRec(Request $request, SubjectModel $subjectDbRec) : bool {

        $isNameExists   =   $this->subjectRepository->findDuplicateCountByName(
                                $request->get('name'),
                                $subjectDbRec->id
                            );
        if($isNameExists)
            throw new CustomException('Subject name already exists!');

        $file           = $request->input('image');

        if(!isset($file)){
            // remove image and submit update
            $imgDest = null;
        }else{
            /*  input filed hidden_file_add_count value equals 0 when initially filpond loads image
                it means no change to previously upload image and submit edit form    */
            if( $request->hidden_file_add_count == 0){
                $defaultImgPath = asset('images/default-images/subject.png');
                $imgUrl         = $request->hidden_subject_img_url;

                if($imgUrl == $defaultImgPath){
                    $imgDest = null;
                }else{
                    $imgDest = str_replace(asset('storage'), '/', $imgUrl);
                    $imgDest = ltrim($imgDest, '/');
                }

            }else{
                // previously image is uploaded and now change the image and upload
                //todo delete prviously uploaded image
                $fileUploadUtil = new FileUploadUtil();
                $imgDest        = $fileUploadUtil->upload($file,'subjects/');
            }
        }

        $request->merge(['image'      => $imgDest]);
        $subjectDto = SubjectDtoFactory::fromRequest($request);
        $payloadArr = UserDataTransformer::dtoToDbRecArr($subjectDto);
        unset($payloadArr['id']);
        unset($payloadArr['uuid']);
        unset($payloadArr['slug']);
        unset($payloadArr['author_id']);

        return $subjectDbRec->update($payloadArr);
    }



    public function deleteDbRec(UserModel $userDbRec) : bool {
        //return $subjectDbRec->delete();
        return $this->userRepository->deleteById($userDbRec->id);
    }

    public function findUnApprovedTeachers() : array {
        $unApprovedTeachers = $this->userRepository->getUnApprovedTeachers();

        $unApprovedTeachersArr = array();
        $unApprovedTeachers->each(function (UserModel $record, int $key) use (&$unApprovedTeachersArr){
            $unApprovedTeachersArr[]  =   UserDataTransformer::buildDto($record->toArray());
        });

        return $unApprovedTeachersArr;
    }

    public function updateStatus(int $userRecId, int $status) : bool {
        $teacherUpdateInfo  = ['status'=> $status];
        return $this->userRepository->update($userRecId, $teacherUpdateInfo);
    }





    public function findDbRec(int $id) : ?array {
        $dbRec  =   $this->userRepository->findById($id);
        $dto    =   $dbRec ? UserDataTransformer::buildDto($dbRec->toArray()) : null;

        return array(
            'dbRec' => $dbRec,
            'dto'   => $dto
        );
    }



    public function loadLoggedInUserData() : array {
        $user = Sentinel::getUser();
        if(is_null($user))
            throw new CustomException('Access denied');

        return array(
            'dto'   =>  UserDataTransformer::buildDto($user->toArray()),
            'dbRec' =>  $user,
        );
    }


    public function generateUniqueUsername($username){

        $username = cleanUsernameString($username);
        if(strlen($username)>15)
            $username = substr($username, 0, 15);

        $uname = $username;
        do {
            if(is_null($this->userRepository->findUserByUsername($uname))){
                $x = 0;
            }else{
                $uname = $username.rand(1000,9999);
                //$uname = $username.rand(1,9);
                $x = 1;
            }
            //var_dump ($uname);
            //var_dump ($x);
        } while ($x == 1);
        return $uname;
    }


    public function saveTeacherRec(Request $request) : array {
        $file           = $request->input('teacher_profile_img');
        $destination    = isset($file) ? (new FileUploadUtil())->upload($file,'users/teachers/') : null;

        $status = ($request->get('teacher_stat')=='enable') ? true : false;
        //DB::enableQueryLog();

        $username    = $this->generateUniqueUsername($request->get('teacher_uname'));
        $usernameMsg = ($username != $request->get('teacher_uname'))?"Given username is already there, ∴ system updated username to {$username}":'';

        $teacher = [
            'full_name'         => $request->get('teacher_name'),
            'email'             => $request->get('teacher_email'),
            'password'          => $request->get('teacher_password'),
            'phone'             => $request->get('teacher_phone'),
            'username'          => $username,
            'edu_qualifications'=> $request->get('teacher_edu_details'),
            'gender'            => $request->get('teacher_gender'),
            'dob_year'          => $request->get('teacher_birth_year'),
            'status'            => $status,
            'profile_pic'       => $destination
        ];

        $user_teacher = Sentinel::registerAndActivate($teacher);
        $role_teacher = Sentinel::findRoleBySlug(RoleModel::TEACHER);
        $role_teacher->users()->attach($user_teacher);
        return array('usernameMsg' => $usernameMsg);
    }



    public function saveStudentRec(Request $request) : array {
        $status = ($request->get('student_stat')=='enable') ? true : false;

        $username    = $this->generateUniqueUsername($request->get('stud_uname'));
        $usernameMsg = ($username != $request->get('stud_uname'))?"Given username is already there, ∴ system updated username to {$username}":'';

        $student = [
                'full_name'         => $request->get('stud_name'),
                'email'             => $request->get('stud_email'),
                'password'          => $request->get('stud_password'),
                'phone'             => $request->get('stud_phone'),
                'username'          => $username,
                'profile_text'      => $request->get('stud_details'),
                'gender'            => $request->get('stud_gender'),
                'dob_year'          => $request->get('stud_birth_year'),
                'status'            => $status,
                'profile_pic'       => null,
            ];

        $user_stud = Sentinel::registerAndActivate($student);
        $role_stud = Sentinel::findRoleBySlug(RoleModel::STUDENT);
        $role_stud->users()->attach($user_stud);
        return array('usernameMsg' => $usernameMsg);
    }


    public function saveMarketerRec(Request $request) : array {
        $status = ($request->get('marketer_stat')=='enable') ? true : false;

        $username    = $this->generateUniqueUsername($request->get('marketer-uname'));
        $usernameMsg = ($username != $request->get('marketer_uname'))?"Given username is already there, ∴ system updated username to {$username}":'';

        $marketer = [
            'full_name'         => $request->get('marketer_name'),
            'email'             => $request->get('marketer_email'),
            'password'          => $request->get('marketer_password'),
            'phone'             => $request->get('marketer_phone'),
            'username'          => $username,
            'gender'            => $request->get('marketer_gender'),
            'status'            => $status,
            'profile_pic'       => null
        ];

        $user_marketer = Sentinel::registerAndActivate($marketer);
        $role_marketer = Sentinel::findRoleBySlug(RoleModel::MARKETER);
        $role_marketer->users()->attach($user_marketer);
        return array('usernameMsg' => $usernameMsg);
    }


    public function saveEditorRec(Request $request) : array {
        $status = ($request->get('editor_stat')=='enable') ? true : false;

        $username    = $this->generateUniqueUsername($request->get('editor-uname'));
        $usernameMsg = ($username != $request->get('editor_uname'))?"Given username is already there, ∴ system updated username to {$username}":'';

        $editor = [
            'full_name'         => $request->get('editor_name'),
            'email'             => $request->get('editor_email'),
            'password'          => $request->get('editor_password'),
            'phone'             => $request->get('editor_phone'),
            'username'          => $username,
            'gender'            => $request->get('editor_gender'),
            'status'            => $status,
            'profile_pic'       => null,
        ];

        $user_editor = Sentinel::registerAndActivate($editor);
        $role_editor = Sentinel::findRoleBySlug(RoleModel::EDITOR);
        $role_editor->users()->attach($user_editor);
        return array('usernameMsg' => $usernameMsg);
    }






    public function updateTeacherRec(Request $request, UserModel $userDbRec) : bool {
        $userId         = $userDbRec->id;
        $teacherName    = $request->get('teacher_name');

        $isNameExists   =   $this->userRepository->findDuplicateCountByName($teacherName, $userId);
        if($isNameExists)
            throw new CustomException('Name already exists!');

        $file = $request->input('teacher_profile_img');
        if(!isset($file)){
            // remove image and submit update
            $imgDest = null;
        }else{
            /*  input filed hidden_file_add_count value equals 0 when initially filpond loads image
                it means no change to previously upload image and submit edit form    */
            if( $request->teacher_img_add_count == 0){

                $defaultImgPath = asset('images/default-images/teacher.png');
                $imgUrl         = $request->teacher_img_url;

                if($imgUrl == $defaultImgPath){
                    $imgDest = null;
                }else{
                    $imgDest = str_replace(asset('storage'), '/', $imgUrl);
                    $imgDest = ltrim($imgDest, '/');
                }

            }else{
                // previously image is uploaded and now change the image and upload
                //todo delete prviously uploaded image
                $fileUploadUtil = new FileUploadUtil();
                $imgDest        = $fileUploadUtil->upload($file,'users/teachers/');
            }
        }

        //todo -future-send email
        if($request->teacher_reset_pw_stat == 'on')
            Sentinel::update($user, array('password' => env('APP_DEFAULT_USER_PASSWORD')));

        $request->merge([
            'full_name'            => $request->input('teacher_name'),
            'email'                => $userDbRec->email,
            'username'             => $userDbRec->username,
            'phone'                => $request->input('teacher_phone'),
            'status'               => ($request->get('teacher_stat') == 'enable') ? true : false,

            'gender'               => $request->input('teacher_gender'),
            'dob_year'             => $request->input('teacher_birth_year'),
            'edu_qualifications'   => $request->input('teacher_edu_details'),
            'role_id'              => Sentinel::findRoleBySlug(RoleModel::TEACHER)->id,
            'profile_pic'          => $imgDest
        ]);

        $userDto         = UserDtoFactory::fromRequest($request);
        $userEntity      = (new UserFactory())->createObjTree($userDto->toArray());
        $userEntityArr   = $userEntity->toArray();
        $payloadArr      = UserMapper::entityConvertToDbArr($userEntityArr);

        //dd($payloadArr);
        unset($payloadArr['id']);
        unset($payloadArr['uuid']);
        unset($payloadArr['is_activated']);
        unset($payloadArr['username']);
        unset($payloadArr['email']);
        unset($payloadArr['role_arr']);
        unset($payloadArr['role_id']);
        //return $userDbRec->update($payloadArr);
        return $this->userRepository->update($userId, $payloadArr);
    }


    public function updateStudentRec(Request $request, UserModel $userDbRec) : bool {
        $userId         = $userDbRec->id;
        $studentName    = $request->get('stud_name');

        $isNameExists   =   $this->userRepository->findDuplicateCountByName($studentName, $userId);
        if($isNameExists)
            throw new CustomException('Name already exists!');

        //todo -future-send email
        if($request->stud_reset_pw_stat == 'on')
            Sentinel::update($user, array('password' => env('APP_DEFAULT_USER_PASSWORD')));

        $request->merge([
            //'id'          => $request->input('stud_id'),
            'full_name'     => $request->input('stud_name'),
            'email'         => $userDbRec->email,
            'username'      => $userDbRec->username,
            'phone'         => $request->input('stud_phone'),
            'status'        => ($request->get('stud_stat') == 'enable') ? true : false,

            'gender'        => $request->input('stud_gender'),
            'dob_year'      => $request->input('stud_birth_year'),
            'profile_text'  => $request->input('stud_details'),
            'role_id'       => Sentinel::findRoleBySlug(RoleModel::STUDENT)->id
        ]);

        $userDto         = UserDtoFactory::fromRequest($request);
        $userEntity      = (new UserFactory())->createObjTree($userDto->toArray());
        $userEntityArr   = $userEntity->toArray();
        $payloadArr      = UserMapper::entityConvertToDbArr($userEntityArr);

        //dd($payloadArr);
        unset($payloadArr['id']);
        unset($payloadArr['uuid']);
        unset($payloadArr['is_activated']);
        unset($payloadArr['username']);
        unset($payloadArr['email']);
        unset($payloadArr['role_arr']);
        unset($payloadArr['role_id']);
        unset($payloadArr['profile_pic']);
        //return $userDbRec->update($payloadArr);
        return $this->userRepository->update($userId, $payloadArr);
    }


    public function updateMarketerRec(Request $request, UserModel $userDbRec) : bool {
        $userId         = $userDbRec->id;
        $teacherName    = $request->get('marketer_name');

        $isNameExists   =   $this->userRepository->findDuplicateCountByName($teacherName, $userId);
        if($isNameExists)
            throw new CustomException('Name already exists!');

        //todo -future-send email
        if($request->marketer_reset_pw_stat == 'on')
            Sentinel::update($user, array('password' => env('APP_DEFAULT_USER_PASSWORD')));

        $request->merge([
            'full_name' => $request->input('marketer_name'),
            'email'     => $userDbRec->email,
            'username'  => $userDbRec->username,
            'phone'     => $request->input('marketer_phone'),
            'status'    => ($request->get('marketer_stat') == 'enable') ? true : false,

            'gender'    => $request->input('marketer_gender'),
            'role_id'   => Sentinel::findRoleBySlug(RoleModel::MARKETER)->id
        ]);

        $userDto         = UserDtoFactory::fromRequest($request);
        $userEntity      = (new UserFactory())->createObjTree($userDto->toArray());
        $userEntityArr   = $userEntity->toArray();
        $payloadArr      = UserMapper::entityConvertToDbArr($userEntityArr);

        //dd($payloadArr);
        unset($payloadArr['id']);
        unset($payloadArr['uuid']);
        unset($payloadArr['is_activated']);
        unset($payloadArr['username']);
        unset($payloadArr['email']);
        unset($payloadArr['role_arr']);
        unset($payloadArr['role_id']);
        unset($payloadArr['profile_pic']);
        //return $userDbRec->update($payloadArr);
        return $this->userRepository->update($userId, $payloadArr);
    }

    public function updateEditorRec(Request $request, UserModel $userDbRec) : bool {
        $userId         = $userDbRec->id;
        $teacherName    = $request->get('editor_name');

        $isNameExists   =   $this->userRepository->findDuplicateCountByName($teacherName, $userId);
        if($isNameExists)
            throw new CustomException('Name already exists!');

        //todo -future-send email
        if($request->editor_reset_pw_stat == 'on')
            Sentinel::update($user, array('password' => env('APP_DEFAULT_USER_PASSWORD')));

        $request->merge([
            'full_name' => $request->input('editor_name'),
            'email'     => $userDbRec->email,
            'username'  => $userDbRec->username,
            'phone'     => $request->input('editor_phone'),
            'status'    => ($request->get('editor_stat') == 'enable') ? true : false,

            'gender'    => $request->input('editor_gender'),
            'role_id'   => Sentinel::findRoleBySlug(RoleModel::EDITOR)->id,
        ]);

        $userDto         = UserDtoFactory::fromRequest($request);
        $userEntity      = (new UserFactory())->createObjTree($userDto->toArray());
        $userEntityArr   = $userEntity->toArray();
        $payloadArr      = UserMapper::entityConvertToDbArr($userEntityArr);

        //dd($payloadArr);
        unset($payloadArr['id']);
        unset($payloadArr['uuid']);
        unset($payloadArr['is_activated']);
        unset($payloadArr['username']);
        unset($payloadArr['email']);
        unset($payloadArr['role_arr']);
        unset($payloadArr['role_id']);
        unset($payloadArr['profile_pic']);
        //return $userDbRec->update($payloadArr);
        return $this->userRepository->update($userId, $payloadArr);
    }





    /*public function entityToDbRecArr(UserEntity $user) : array {
        $userEntityArr   = $user->toArray();
        $payloadArr         = UserMapper::entityConvertToDbArr($userEntityArr);
        unset($payloadArr['creator_arr']);
        return $payloadArr;
    }

    public function dtoToDbRecArr(UserDto $userDto) : array {
        $userEntity  = (new UserFactory())->createObjTree($userDto->toArray());
        $payloadArr     = $this->entityToDbRecArr($userEntity);
        return $payloadArr;
    }*/


}





