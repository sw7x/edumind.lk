<?php

namespace App\Repositories;


use App\Repositories\BaseRepository;
use App\Models\CourseThread as CourseThreadModel;
use App\Repositories\Interfaces\IGetDtoDataRepository;


class CourseThreadRepository extends BaseRepository implements IGetDtoDataRepository{   
	
    public function __construct(){
        parent::__construct(CourseThreadModel::make());        
    }
    
    public function findDataArrById(int $modelId) : array {

    } 
}
