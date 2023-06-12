<?php

namespace App\Repositories\Eloquent_impl;

use App\Repositories\CourseRepositoryInterface;
use App\Repositories\Eloquent_impl\BaseRepository;
use App\Models\User;
use App\Models\Course as CourseModel;
use App\Domain\Course as CourseEntity;

class CourseRepository extends BaseRepository implements CourseRepositoryInterface
{
    /*
    const DATABSE_MAP = 'DATABASE_MAP';
    const POST_MAP = 'POST_MAP';
    const VALIDATION_MAP = 'VALIDATION_MAP';
    */

    protected $model;
    private $mapper = [

        // database columns  => entity object attributes
        Mapper::DATABSE_MAP => [
            'notification_category_id'      => 'id',
            'name'                          => 'name',
            'description'                   => 'description',
            'notification_category_image'   => 'categoryImage',
            'is_allowed_to_disable'         => 'isAllowedToDisable',
            'uuid'                          => 'uuid'            
        ],

        // keys of dto (when in array format)  => entity object attributes
        Mapper::POST_MAP => [
            'id'            => 'id',
            'name'          => 'name',
            'description'   => 'description',
            'categoryImage' => 'categoryImage',
            'statusId'      => 'statusId',
            'uuid'          => 'uuid',            
        ],              
    ];
    
    public function __construct(User $model){
        $this->model = $model;
    }

    // $payload = $courseDtoArr
    public function create(array $payload){
        try
        {
            if (!isset($payload)) {
                throw new Exception("Invalid request data found");
            }

            $courseEntityDataArr = $this->filterAndMapKeysByMapperValues(Mapper::POST_MAP, $payload);
            $courseEntity = $this->hydrateCourseData($courseEntityDataArr);

            $dbStructuredDataSet = $this->getDbStructuredEntityData(Mapper::DATABSE_MAP, $courseEntity);
            unset($dbStructuredDataSet['hh']);
            unset($dbStructuredDataSet['gg']);


            $isInserted = parent::create($dbStructuredDataSet);

            if($isInserted){
                return array('isInserted' => true,'id' => $modelId);
            }else{
                throw new Exception("");
            }            

        }catch (\PDOException $e) {
            return array('isInserted' => false, 'id' => $modelId);
        }catch (\Exception $e) {
            return array('isInserted' => false, 'id' => $modelId);
        }
    }

    public function update(int $modelId, array $payload){        
        try
        {            
            if (!isset($payload)) {
                throw new Exception("Invalid request data found");
            }

            $courseEntityDataArr = $this->filterAndMapKeysByMapperValues(Mapper::POST_MAP, $payload);
            $courseEntity = $this->hydrateCourseData($courseEntityDataArr);

            $dbStructuredDataSet = $this->getDbStructuredEntityData(Mapper::DATABSE_MAP, $courseEntity);
            unset($dbStructuredDataSet['hh']);
            unset($dbStructuredDataSet['gg']);

            $isUpdated = parent::update($modelId, $dbStructuredDataSet);
            
            if($isUpdated){
                return array('isUpdated' => true, 'id' => $modelId);
            }else{
                throw new Exception("");
            }            

        }catch (\PDOException $e) {
            return array('isUpdated' => false, 'id' => $modelId);
        }catch (\Exception $e) {
            return array('isUpdated' => false, 'id' => $modelId);
        }
    }

    
    public function deleteById($modelId){

        try{

            $isDeleted = parent::deleteById($modelId);
            
            if($isDeleted){
                return array('isDeleted' => true, 'id' => $modelId);
            }else{
                throw new Exception("")
            }

        }catch (\PDOException $e) {
            return array('isDeleted' => false, 'id' => $modelId);
        }catch (\Exception $e) {
            return array('isDeleted' => false, 'id' => $modelId);
        }
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


    private function hydrateCourseData(array $courseData, CourseEntity $courseEntity = null)
    {
        if ($courseEntity == null) {
            $courseEntity = new CourseEntity();
        }

        if (!isset($courseData['id']) || $courseData['id'] == null) {
            $courseData['uuid'] = str_replace('-', '', UUID::v4());
        }

        if (isset($courseData['uuid'])) {
            $courseEntity->setUuid($courseData['uuid']);
        }

        
        if (isset($courseData['id'])) {
            $courseEntity->setId($courseData['id']);
        }

        if (!isset($courseData['id']) || $courseData['id'] == null) {
            $course['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($courseData['uuid'])) {
            $courseEntity->setUuid($courseData['uuid']);
        }
        
        if (isset($courseData['name'])) {
            $courseEntity->setName($courseData['name']);
        }

        if (isset($courseData['description'])) {
            $courseEntity->setDescription($courseData['description']);
        }

        if (isset($courseData['image'])) {
            $courseEntity->setImage($courseData['image']);
        }

        if (isset($courseData['status'])) {
            $courseEntity->setStatus($courseData['status']);
        }

        if (isset($courseData['headingText'])) {
            $courseEntity->setHeadingText($courseData['headingText']);
        }        

        if (isset($courseData['topics'])) {
            $courseEntity->setTopics($courseData['topics']);
        }        

        if (isset($courseData['content'])) {
            $courseEntity->setContent($courseData['content']);
        }        

        if (isset($courseData['slug'])) {
            $courseEntity->setSlug($courseData['slug']);
        }        

        if (isset($courseData['setAuthorSharePercentage'])) {
            $courseEntity->setAuthorSharePercentage($courseData['setAuthorSharePercentage']);
        }        

        if (isset($courseData['price'])) {
            $courseEntity->setPrice($courseData['price']);
        }

        if (isset($courseData['videoCount'])) {
            $courseEntity->setVideoCount($courseData['videoCount']);
        }        

        if (isset($courseData['duration'])) {
            $courseEntity->setDuration($courseData['duration']);
        }

        return $courseEntity;
    }

    private function filterAndMapKeysByMapper($map, $courseDataArr)
    {
        $data = [];
        $mapper = $this->mapper[$map];

        foreach ($courseData as $key => $value) {

            if (isset($mapper[$key])) {
                $data[$mapper[$key]] = $value;
            }
        }

        return $data;
    } 
    
    private function filterAndMapKeysByMapperValues($map, $courseDataArr)
    {
        $data = [];
        $mapper = $this->mapper[$map];

        foreach ($courseObj as $key => $value) {

            if ($mapKey = array_search($key,$mapper)) {
                $data[$mapKey] = $value;
            }
        }

        return $data;
    }

    public function getDbStructuredEntityData(CourseEntity $CourseEntity)
    {
        $dbStructuredDataSet = [];
        $dbMapper = $this->mapper[Mapper::DATABSE_MAP];

        $courseData = $CourseEntity->toArray();

        foreach ($courseData as $key => $value) {
            $column = array_search($key, $dbMapper);

            if ($column) {
                $dbStructuredDataSet[$column] = $courseData[$key];
            }
        }
        return $dbStructuredDataSet;
    }

    public function getEntityStructuredDbData(CourseModel $CourseModel)
    {        
        return $this->filterAndMapKeysByMapperValues(Mapper::DATABSE_MAP, $CourseModel->toArray());    
    }

    public function findUserByEmail($email){
        return $model->where('email',$email)->first();
    }
} 