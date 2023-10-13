<?php

namespace App\SharedServices;

use App\Exceptions\CustomException;
use App\Models\User as UserModel;
use App\Models\Role as RoleModel;
use App\Mappers\UserMapper;
use App\Domain\Users\User as UserEntity;
use App\DataTransferObjects\UserDto;
use App\Domain\Factories\UserFactory;


class UserSharedService
{  

    public function getRoleByUser(UserModel $userRec) : string {
        $userRoles  = optional($userRec)->roles();
        $roleArr    = optional($userRoles)->first();
        $userRole   = optional($roleArr)->slug;
        return $userRole;
    }
    

    public function checkUserHaveValidRole(UserModel $userRec) : bool {
        $userRole   = $this->getRoleByUser($userRec);
        $allRoles   = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER, RoleModel::STUDENT];
        return in_array($userRole, $allRoles);
    }

    
    public function isAllowed(UserModel $userRec, array $allowedRoles) : bool {
        $userRole   = $this->getRoleByUser($userRec);
        return in_array($userRole, $allowedRoles);
    }



    public function entityToDbRecArr(UserEntity $user) : array {
        $userEntityArr   = $user->toArray();
        $payloadArr         = UserMapper::entityConvertToDbArr($userEntityArr);
        unset($payloadArr['creator_arr']);
        return $payloadArr;
    }

    public function dtoToDbRecArr(UserDto $userDto) : array {
        $userEntity  = (new UserFactory())->createObjTree($userDto->toArray());
        $payloadArr     = $this->entityToDbRecArr($userEntity);
        return $payloadArr;
    }
    
}

