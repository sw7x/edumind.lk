<?php
namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Repositories\CourseSelectionRepository;
use App\Repositories\CourseRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\ContactUsRepository;

use App\Models\Role as RoleModel;
use App\Models\User as UserModel;
use App\Models\TempBillingInfo as TempBillingInfoModel;
use App\Models\Course as CourseModel;
use App\Models\Subject as SubjectModel;
use App\Models\ContactUs as ContactUsModel;


use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\IGetDataRepository;
use App\Mappers\UserMapper;
use Illuminate\Database\Eloquent\Collection;
use Sentinel;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository implements IGetDataRepository{

    public function __construct(){
        parent::__construct(UserModel::make());
    }

    /**
    * @param array $columns
    * @param array $relations
    * @return Collection
    */
    public function all(array $columns = ['*'], array $relations = []): Collection{

        return  $this->model->withoutGlobalScope('active')
                    ->with($relations)
                    ->withCount($relations)
                    ->orderBy('id')
                    ->get($columns);
    }

    /**
    * @param array $columns
    * @param array $relations
    * @return Collection
    */
    public function allWithGlobalScope(array $columns = ['*'], array $relations = []): Collection{
        return parent::all($columns, $relations);
    }





    /**
    * Find model by id.
    *
    * @param int $modelId
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return UserModel
    */
    public function findById(
        int $modelId,
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ) : ?UserModel{

        $result =   $this->model->withoutGlobalScope('active')
                        ->select($columns)->with($relations)->find($modelId);

        if ($result) {
            $result->append($appends);
        }
        return $result;
    }


    /**
    * Find model by id.
    *
    * @param int $modelId
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return UserModel
    */
    public function findByIdWithGlobalScope(
        int $modelId,
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ) : ?UserModel{
        return parent::findById($modelId, $columns, $relations, $appends);
    }


    /**
    * Find models by ids.
    *
    * @param array $modelIds
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return Collection
    */
    public function findManyByIds(
        array $modelIds     = [],
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ): ?Collection {

        return  $this->model->withoutGlobalScope('active')
                    ->select($columns)->with($relations)->find($modelIds)->append($appends);
    }


    /**
    * Find models by ids.
    *
    * @param array $modelIds
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return Collection
    */
    public function findManyByIdsWithGlobalScope(
        array $modelIds     = [],
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ): ?Collection {
        return parent::findManyByIds($modelIds, $columns, $relations, $appends);
    }



    public function findUserByEmail(String $email) : ?UserModel{
        return $this->model->withoutGlobalScope('active')->where('email',$email)->first();
    }
    public function findUserCountByEmail(String $email) : int{
        return $this->model->withoutGlobalScope('active')->where('email',$email)->count();
    }
    public function findAvailableUserByEmail(String $email) : ?UserModel{
        return $this->model->where('email',$email)->first();
    }


    public function findUserByUsername(String $username) : ?UserModel{
        return $this->model->withoutGlobalScope('active')->where('username',$username)->first();
    }
    public function findUserCountByUsername(String $username) : int{
        return $this->model->withoutGlobalScope('active')->where('username',$username)->count();
    }
    public function findAvailableUserByUsername(String $username) : ?UserModel{
        return $this->model->where('username',$username)->first();
    }


    public function findDuplicateCountByName(string $fullName, int $id) : int {
        return $this->model->withoutGlobalScope('active')->where('id', '!=', $id)->where('full_name', '=', $fullName)->count();
    }


    public function findDataArrById(int $userId): array {
        $userRec = $this->findById($userId);
            
        if(is_null($userRec)) return [];

        $tempuserArr = $userRec->toArray();
        $userArr     = $tempuserArr;

        //$userArr['is_activated'] = $userRec->isactivated();

        unset($userArr['created_at']);
        unset($userArr['updated_at']);
        unset($userArr['last_login']);

        if($userArr['roles']){
            foreach ($userArr['roles'] as $key => $roleArr) {
                unset($userArr['roles'][$key]['permissions']);
                unset($userArr['roles'][$key]['pivot']);
                unset($userArr['roles'][$key]['created_at']);
                unset($userArr['roles'][$key]['updated_at']);
            }
            $userArr['role_arr'] = $userArr['roles'][0];
        }else{
            $userArr['role_arr'] = [];
        }

        unset($userArr['roles']);

        if(isset($userArr['role_arr']['name']) && $userArr['role_arr']['name'] == RoleModel::STUDENT){
            $userArr['cart_items_arr'] = (new CourseSelectionRepository())->cartItemsByStudentId($userId);
        }

        return $userArr;
    }


    public function findDataArrIncludingTrashedById(int $userId): array {
        $userRec = $this->findByIdIncludingTrashed($userId);

        if(is_null($userRec)) return [];

        $tempuserArr = $userRec->toArray();
        $userArr     = $tempuserArr;

        //$userArr['is_activated'] = $userRec->isactivated();

        unset($userArr['created_at']);
        unset($userArr['updated_at']);
        unset($userArr['last_login']);

        if($userArr['roles']){
            foreach ($userArr['roles'] as $key => $roleArr) {
                unset($userArr['roles'][$key]['permissions']);
                unset($userArr['roles'][$key]['pivot']);
                unset($userArr['roles'][$key]['created_at']);
                unset($userArr['roles'][$key]['updated_at']);
            }
            $userArr['role_arr'] = $userArr['roles'][0];
        }else{
            $userArr['role_arr'] = [];
        }

        unset($userArr['roles']);

        if(isset($userArr['role_arr']['name']) && $userArr['role_arr']['name'] == RoleModel::STUDENT){
            $userArr['cart_items_arr'] = (new CourseSelectionRepository())->cartItemsByStudentId($userId);
        }

        return $userArr;
    }

    public function findDtoDataById(int $userId): array {
        $data = $this->findDataArrIncludingTrashedById($userId);
        return UserMapper::dbRecConvertToEntityArr($data);
    }


    public function findAllTeachers(): Collection {
        $teachers   =   Sentinel::findRoleBySlug(RoleModel::TEACHER)->users()
                            ->withoutGlobalScope('active')
                            ->with('roles')
                            ->orderBy('id')
                            ->get();
        return $teachers;
    }

    public function findAllStudents(): Collection {
        $students   =   Sentinel::findRoleBySlug(RoleModel::STUDENT)->users()
                            ->withoutGlobalScope('active')
                            ->with('roles')
                            ->orderBy('id')
                            ->get();
        return $students;
    }

    public function findAllMarketers(): Collection {
        $marketers  =   Sentinel::findRoleBySlug(RoleModel::MARKETER)->users()
                            ->withoutGlobalScope('active')
                            ->with('roles')
                            ->orderBy('id')
                            ->get();
        return $marketers;
    }

    public function findAllEditors(): Collection {
        $editors    =   Sentinel::findRoleBySlug(RoleModel::EDITOR)->users()
                            ->withoutGlobalScope('active')
                            ->with('roles')
                            ->orderBy('id')
                            ->get();
        return $editors;
    }

    public function findAllAvailableTeachers(): Collection {
        $teachers   =   Sentinel::findRoleBySlug(RoleModel::TEACHER)->users()
                            ->with('roles')
                            ->orderBy('id')
                            ->get();
        return $teachers;
    }

    public function findAllAvailableStudents(): Collection {
        $students   =   Sentinel::findRoleBySlug(RoleModel::STUDENT)->users()
                            ->with('roles')
                            ->orderBy('id')
                            ->get();
        return $students;
    }

    public function findAllAvailableMarketers(): Collection {
        $marketers  =   Sentinel::findRoleBySlug(RoleModel::MARKETER)->users()
                            ->with('roles')
                            ->orderBy('id')
                            ->get();
        return $marketers;
    }

    public function findAllAvailableEditors(): Collection {
        $editors    =   Sentinel::findRoleBySlug(RoleModel::EDITOR)->users()
                            ->with('roles')
                            ->orderBy('id')
                            ->get();
        return $editors;
    }

    
    public function findAllTrashedTeachers(): Collection {
        $teachers   =   Sentinel::findRoleBySlug(RoleModel::TEACHER)->users()
                            ->onlyTrashed()
                            ->withoutGlobalScope('active')
                            ->with('roles')
                            ->orderBy('id')
                            ->get();
        return $teachers;
    }

    public function findAllTrashedStudents(): Collection {
        $students   =   Sentinel::findRoleBySlug(RoleModel::STUDENT)->users()
                            ->onlyTrashed()
                            ->withoutGlobalScope('active')
                            ->with('roles')
                            ->orderBy('id')
                            ->get();
        return $students;
    }

    public function findAllTrashedMarketers(): Collection {
        $marketers  =   Sentinel::findRoleBySlug(RoleModel::MARKETER)->users()
                            ->onlyTrashed()
                            ->withoutGlobalScope('active')
                            ->with('roles')
                            ->orderBy('id')
                            ->get();
        return $marketers;
    }

    public function findAllTrashedEditors(): Collection {
        $editors    =   Sentinel::findRoleBySlug(RoleModel::EDITOR)->users()
                            ->onlyTrashed()
                            ->withoutGlobalScope('active')
                            ->with('roles')
                            ->orderBy('id')
                            ->get();
        return $editors;
    }




    public function findAvailableTeacherById(int $teacherId): Collection {
        $teacher    =   Sentinel::findRoleBySlug(RoleModel::TEACHER)->users()
                            ->with('roles')
                            ->where('id', $teacherId)
                            ->orderBy('id')
                            ->get();
        return $teacher;
    }

    public function findAvailableStudentById(int $studentId): Collection {
        $student    =   Sentinel::findRoleBySlug(RoleModel::STUDENT)->users()
                            ->with('roles')
                            ->where('id', $studentId)
                            ->orderBy('id')
                            ->get();
        return $student;
    }

    public function findAvailableMarketerById(int $marketerId): Collection {
        $marketer   =   Sentinel::findRoleBySlug(RoleModel::MARKETER)->users()
                            ->with('roles')
                            ->where('id', $marketerId)
                            ->orderBy('id')
                            ->get();
        return $marketer;
    }

    public function findAvailableEditorById(int $editorId): Collection {
        $editor =   Sentinel::findRoleBySlug(RoleModel::EDITOR)->users()
                        ->with('roles')
                        ->where('id', $editorId)
                        ->orderBy('id')
                        ->get();
        return $editor;
    }









    public function getUnApprovedTeachers(): Collection {
        $unApprovedTeacher  =   Sentinel::findRoleBySlug(RoleModel::TEACHER)
                                    ->users()
                                    ->withoutGlobalScope('active')
                                    ->with('roles')
                                    ->where('users.status','0')
                                    //->where('users.email','carroll.cydney@example.com')
                                    ->orderBy('id')
                                    ->get();
        return $unApprovedTeacher;
    }

    public function getPopularTeachers(int $courseCount): ?Collection {
        $popularTeachers    =   $this->model
                                    ->has('getTeachingCourses')
                                    ->withCount('getTeachingCourses')
                                    ->orderBy('get_teaching_courses_count', 'desc')
                                    ->skip(0)
                                    ->take($courseCount)
                                    ->get();
        //dump($popularTeachers);
        return $popularTeachers;
        /*
        $popularTeachers = User::withCount('enrolled_courses')->orderBy('enrolled_courses_count', 'desc')->skip(0)->take(8)->get();;
        dd($popularTeachers);
        */
    }


    /*
    public function deleteUser(User $userEntity){

        try{
            $userId = $userEntity->getId();
            $isDeleted = parent::deleteById($userId);

            if($isDeleted){
                return array('isDeleted' => true, 'id' => $userId);
            }else{
                throw new Exception("")
            }

        }catch (\PDOException $e) {
            return array('isDeleted' => false, 'id' => $userId);
        }catch (\Exception $e) {
            return array('isDeleted' => false, 'id' => $userId);
        }
    }

    public function deleteById($modelId){

        try{

            DB::beginTransaction ();

            $thread = $this->findById($modelId);
            if($thread !== null){
                $thread->categories()->detach();

                //delete all posts belong to thread
                $postRepository = new PostRepository();
                foreach ($thread->posts as $post){
                    $isPostDelete = $postRepository->deleteById($post->id);
                    if(!$isPostDelete) throw new Exception("");
                }

                //finally delete thread
                $isThreadDelete = parent::deleteById($modelId);
                if(!$isThreadDelete) throw new Exception("");
            }

            DB::commit();
            return array('isDelete' =>true,'id'=>$modelId);

        }catch (\PDOException $e) {
            DB::rollBack();
            return array('isDelete' =>false,'id'=>$modelId);
        }catch (\Exception $e) {
            DB::rollBack();
            return array('isDeleted' => false, 'id' => $modelId);
        }
    }
    */

    
    /**
    * Find trashed model by id.
    *
    * @param int $modelId
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return CourseModel
    */
    public function findByIdIncludingTrashed(
        int $modelId,
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ) : ?UserModel{
        
        $result =   $this->model->withTrashed()->withoutGlobalScope('active')
                        ->select($columns)
                        ->with($relations)
                        ->withCount($relations)
                        ->find($modelId);

        if ($result) {
            $result->append($appends);
        }
        return $result;
    }



    


    public function hasRelatedChildRecords(UserModel $userRec):bool{
        $courseSelRecCount       =   $userRec->course_selections->count();
        $couponRecCount          =   $userRec->coupons->count();
        //$courseRecCount          =   $userRec->getTeachingCourses->count();
        //$subjectRecCount         =   $userRec->subjects->count();
        //$contactMessageRecCount  =   $userRec->getContactMessages->count();
        //$tempBillingInfoRecCount =   $userRec->tempBillingInfoRecs->count();

        return ($courseSelRecCount == 0 && $couponRecCount == 0);       
        
    }

    /**
    * Permanently delete model by id.
    *
    * @param int $modelId
    * @return bool
    */
    public function permanentlyDeleteById(int $modelId): bool{
       
        $isPermanentlyDeleted = false;
        DB::beginTransaction();
        try {

            $userRec = $this->findTrashedById($modelId);
            if(is_null($userRec))
                throw new CustomException('User record does not exist!');

            //disconnect all courses that the user record associated           
            $courseRepository   = new CourseRepository();
            $createdCourses     = $courseRepository->getAllCoursesByTeacherIncludingTrashed($userRec);
            $createdCourses->each(function (CourseModel $record, int $key)  use ($courseRepository){
                $record->update(['teacher_id' => null]);
            });


            //disconnect all subjects that the user record associated           
            $subjectRepository  = new SubjectRepository();
            $createdSubjects    = $subjectRepository->getAllSubjectsByUserIncludingTrashed($userRec);
            $createdSubjects->each(function (SubjectModel $record, int $key)  use ($subjectRepository){
                $record->update(['author_id' => null]);
            });


            //disconnect all contact_us messages that the user record associated           
            $contactUsRepository = new ContactUsRepository();
            $postedMessages      = $contactUsRepository->getAllContactMessagesUser($userRec);
            $postedMessages->each(function (ContactUsModel $record, int $key)  use ($contactUsRepository){
                $record->update(['user_id' => null]);
            });

            
            //disconnect all temp_billing_info table records that the user record associated          
            $tempBillingInfoRecs = $userRec->tempBillingInfoRecs;
            $tempBillingInfoRecs->each(function (TempBillingInfoModel $record, int $key){
                $record->update(['user_id' => null]);
            });


            $userRec->permanentlyDelete();

            DB::commit();

            $isPermanentlyDeleted = true;

        } catch (\Exception $e) {
            $isPermanentlyDeleted = false;

            //throw $e;
            
            // Handle transaction failure
            DB::rollBack();
        }

        return $isPermanentlyDeleted;
        //return $this->findTrashedById($modelId)->permanentlyDelete();
    }


    /**
    * Get all trashed models.
    *
    * @return Collection
    */
    public function allTrashed(): Collection{

        return $this->model->withoutGlobalScope('active')->onlyTrashed()->get();
    }

    /**
    * Find trashed model by id.
    *
    * @param int $modelId
    * @return UserModel
    */
    public function findTrashedById(int $modelId): ?UserModel{
        
        return $this->model->withoutGlobalScope('active')->withTrashed()->find($modelId);
    }

    /**
    * Find only trashed model by id.
    *
    * @param int $modelId
    * @return UserModel
    */
    public function findOnlyTrashedById(int $modelId): ?UserModel{
        
        return $this->model->withoutGlobalScope('active')->onlyTrashed()->find($modelId);
    }
}


