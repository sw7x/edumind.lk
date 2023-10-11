<?php

namespace App\Repositories;


use App\Repositories\BaseRepository;
use App\Models\CourseThread as CourseThreadModel;
use App\Repositories\Interfaces\IGetDataRepository;


class CourseThreadRepository extends BaseRepository implements IGetDataRepository{   
	
    public function __construct(){
        parent::__construct(CourseThreadModel::make());        
    }
    
    public function findDataArrById(int $modelId) : array {

    }

    public function findDtoDataById(int $modelId) : array {
        
    }
}
