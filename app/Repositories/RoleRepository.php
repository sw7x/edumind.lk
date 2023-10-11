<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

use App\Models\Role as RoleModel;
use App\Repositories\Interfaces\IGetDataRepository;
use App\Mappers\RoleMapper;

class RoleRepository extends BaseRepository implements IGetDataRepository{
    
	public function __construct(){
        parent::__construct(RoleModel::make());        
    }
    
    public function findDataArrById(int $roleId): array{
        $roleRec = $this->findById($roleId);
        if(is_null($roleRec)) return [];

        $roleArr = $roleRec->toArray();
        
        unset($roleArr['created_at']);
        unset($roleArr['updated_at']);
        unset($roleArr['permissions']);
        return $roleArr;
    }    

    public function findDtoDataById(int $roleId): array {
        $data = $this->findDataArrById($roleId);
        return RoleMapper::dbRecConvertToEntityArr($data);
    }
    
}
