<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\User as UserModel;
use App\Models\Course as CourseModel;

//use Illuminate\Database\Eloquent\Model;

use App\Repositories\Interfaces\IGetDtoDataRepository;
use App\Mappers\CourseMapper;

class CourseRepository extends BaseRepository implements IGetDtoDataRepository{
    
    
    public function __construct(){
        parent::__construct(CourseModel::make());        
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
    
    public function findDataArrById(int $courseId): array{

        $courseRec    = $this->findById($courseId);   //dd($courseRec);
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
        //dd($courseArr);
        
        $creatorDataArr = ($teacherId) ? (new UserRepository())->findDataArrById($teacherId) : [];
        $courseArr['creator_arr'] =  $creatorDataArr;

        $subjectDataArr = ($subjectId) ? (new subjectRepository())->findDataArrById($subjectId) : [];
        $courseArr['subject_arr'] =  $subjectDataArr;

        //dd($courseArr);       
        return $courseArr;
    }

    public function findDtoDataById(int $courseId): array {
        $data = $this->findDataArrById($courseId);
        return CourseMapper::dbRecConvertToEntityArr($data);
    }
     

    
} 