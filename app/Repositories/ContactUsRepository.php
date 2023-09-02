<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\ContactUs as ContactUsModel;

use App\Repositories\Interfaces\IGetDtoDataRepository;
use App\Mappers\ContactUsMapper;


class ContactUsRepository extends BaseRepository implements IGetDtoDataRepository{
    
    public function __construct(){
        parent::__construct(ContactUsModel::make());        
    }
    
    public function findDataArrById(int $contactUsMsgId): array {

        $contactUsMsgRec    = $this->findById($contactUsMsgId);   
        if(is_null($contactUsMsgRec)) return [];

        $contactUsMsgArr = $contactUsMsgRec->toArray();
        $userId  = $contactUsMsgArr['user_id'];
                
        //unset($contactUsMsgArr['user_id']);
        unset($contactUsMsgArr['created_at']);
        unset($contactUsMsgArr['updated_at']);
        unset($contactUsMsgArr['deleted_at']);
        
        $userDataArr = ($userId) ? (new UserRepository())->findDataArrById($userId) : [];
        $contactUsMsgArr['user_arr'] =  $userDataArr;
        return $contactUsMsgArr;
    }

    public function findDtoDataById(int $contactUsMsgId): array {
        $data = $this->findDataArrById($contactUsMsgId);
        return ContactUsMapper::dbRecConvertToEntityArr($data);
    }
      

}
