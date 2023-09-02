<?php

namespace App\Repositories;

use App\Models\Subject as SubjectModel;

use App\Repositories\BaseRepository;
use App\Repositories\UserRepository;

use App\Repositories\Interfaces\IGetDtoDataRepository;
use App\Mappers\SubjectMapper;



class SubjectRepository extends BaseRepository implements IGetDtoDataRepository{
        
    public function __construct(){
        parent::__construct(SubjectModel::make()); 

    }   
    
    public function findDataArrById(int $subjectId): array{
        //dd($subjectId);
        $subjectRec    = $this->findById($subjectId); 
        if(is_null($subjectRec)) return [];

        $subjectArr = $subjectRec->toArray();
        $authorId   = $subjectArr['author_id'];
        $subjectArr['creator_id'] = $authorId;
		
        //unset($subjectArr['author_id']);
        unset($subjectArr['created_at']);
        unset($subjectArr['updated_at']);
        unset($subjectArr['deleted_at']);
    
        $creatorDataArr = ($authorId) ? (new UserRepository())->findDataArrById($authorId) : [];        
        $subjectArr['creator_arr'] =  $creatorDataArr;
        return $subjectArr;
    }  

    public function findDtoDataById(int $subjectId): array {
        $data = $this->findDataArrById($subjectId);
        return SubjectMapper::dbRecConvertToEntityArr($data);
    }
    

}
