<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\User as UserModel;
use App\Models\Course as CourseModel;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\IGetDtoDataRepository;
use App\Mappers\CourseMapper;

//use Illuminate\Database\Eloquent\Model;

class CourseRepository extends BaseRepository implements IGetDtoDataRepository{


    public function __construct(){
        parent::__construct(CourseModel::make());
    }

    /**
    * @param array $columns
    * @param array $relations
    * @return Collection
    */
    public function all(array $columns = ['*'], array $relations = []) : Collection {
        return  $this->model->withoutGlobalScope('published')
                    ->with($relations)
                    ->orderBy('id')
                    ->get($columns);
    }

    /**
    * @param array $columns
    * @param array $relations
    * @return Collection
    */
    public function allWithGlobalScope(array $columns = ['*'], array $relations = []) : Collection {
        return parent::all($columns, $relations, $relations);
    }





    /**
    * Find model by id.
    *
    * @param int $modelId
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return CourseModel
    */
    public function findById(
        int $modelId,
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ) : ?CourseModel {
        $result =   $this->model->withoutGlobalScope('published')->select($columns)->with($relations)->find($modelId);
        if ($result)
            $result->append($appends);
        
        return $result;
    }


    /**
    * Find model by id.
    *
    * @param int $modelId
    * @param array $columns
    * @param array $relations
    * @param array $appends
    * @return CourseModel
    */
    public function findByIdWithGlobalScope(
        int $modelId,
        array $columns      = ['*'],
        array $relations    = [],
        array $appends      = []
    ) : ?CourseModel {
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
    ) : ?Collection {
        return  $this->model->withoutGlobalScope('published')
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
    ) : ?Collection {
        return parent::findManyByIds($modelIds, $columns, $relations, $appends);
    }




    /*
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

    public function findDataArrById(int $courseId) : array {
        $courseRec    = $this->findById($courseId);
        if(is_null($courseRec)) return [];

        $courseArr               = $courseRec->toArray();
        $teacherId               = $courseArr['teacher_id'];
        $courseArr['creator_id'] = $teacherId;
        $subjectId               = $courseArr['subject_id'];

        //unset($courseArr['teacher_id']);
        //unset($courseArr['subject_id']);
        unset($courseArr['created_at']);
        unset($courseArr['updated_at']);
        unset($courseArr['deleted_at']);
        
        $creatorDataArr = ($teacherId) ? (new UserRepository())->findDataArrById($teacherId) : [];
        $courseArr['creator_arr'] =  $creatorDataArr;

        $subjectDataArr = ($subjectId) ? (new subjectRepository())->findDataArrById($subjectId) : [];
        $courseArr['subject_arr'] =  $subjectDataArr;

        return $courseArr;        
    }

    public function findDtoDataById(int $courseId) : array {
        $data = $this->findDataArrById($courseId);
        return CourseMapper::dbRecConvertToEntityArr($data);
    }

    public function getNewCourse(int $courseCount) : ?Collection {
        return $this->model->latest()->take($courseCount)->get();
    }

    public function getPopularCourses(int $courseCount) : ?Collection {
        return $this->model->orderBy('id', 'desc')->skip(0)->take($courseCount)->get();
        /*
            //  todo filter when rows have (course_id,student_id) duplicate values
            return Course::whereHas('students', function ($q) {
                $q->where('enrollments.status', 'enrolled')
                    ->orWhere('enrollments.status', 'completed');
            })->withCount(['students'=> function($query){
                $query->where('enrollments.status', 'enrolled')
                    ->orWhere('enrollments.status', 'completed');
            }])->orderBy('students_count', 'desc')->skip(0)->take(8)->get();
        */
    }



    public function getEnrolledCoursesByStudent(UserModel $student) : ?Collection {
        //dd('sss');
        $enrolledCourses =  $this->model->join('course_selections', function($join) use ($student){
                                $join->on('courses.id','=','course_selections.course_id')
                                    ->where('course_selections.student_id', '=', $student->id);
                            })
                            ->join('enrollments','course_selections.id','=','enrollments.course_selection_id')
                            ->get([
                                //'course_selections.student_id',
                                'enrollments.is_complete',
                                'courses.*'
                            ]);
                            //->toArray()
                            //->toSql();
        //dump($enrolledCourses->toSql());
        //dump($enrolledCourses->getBindings());
        //dd($enrolledCourses->get());

        return $enrolledCourses;





        /*
        return $student->course_selections()
            ->where('courses.status', Course::PUBLISHED)
            ->where(function($query) {
                $query->where('enrollments.status', 'enrolled')
                    ->orWhere('enrollments.status', 'completed');
            })->get();
        */
    }


    public function getPublishedCoursesByTeacher(UserModel $teacher) : ?Collection {
        return $teacher->getTeachingCourses()->get();
    }


    public function findByName(String $courseName) : ?Collection {
        return $this->model->withoutGlobalScope('published')->where('name', $courseName)->get();
    }

    public function findDuplicateCountByName(string $courseName, int $id) : int {
        return $this->model->withoutGlobalScope('published')->where('id', '!=', $id)->where('name', '=', $courseName)->count();
    }


    public function getAllPaidCourses() : Collection {
        return $this->model->where('price','!=','0.00')->get();
    }



}

