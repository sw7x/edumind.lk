<?php

namespace App\Common\SharedServices;

use App\Exceptions\CustomException;
use App\Models\User as UserModel;
use App\Models\Role as RoleModel;


class UserSharedService
{  

    private array $allRoles   = [
        RoleModel::ADMIN, 
        RoleModel::EDITOR, 
        RoleModel::MARKETER, 
        RoleModel::TEACHER, 
        RoleModel::STUDENT
    ];


    public function getRoleByUser(?UserModel $userRec) : ?string {
        $userRoles  = optional($userRec)->roles();
        $roleArr    = optional($userRoles)->first();
        $userRole   = optional($roleArr)->slug;
        return $userRole;
    }
    

    public function checkUserHaveValidRole(UserModel $userRec) : bool {
        $userRole   = $this->getRoleByUser($userRec);
        return in_array($userRole, $this->allRoles);
    }

    
    public function isAllowed(UserModel $userRec, array $allowedRoles) : bool {
        $userRole   = $this->getRoleByUser($userRec);
        return in_array($userRole, $allowedRoles);
    }    

    public function hasRole(UserModel $userRec, string $role) : bool {
        $userRole   = $this->getRoleByUser($userRec);
        return ($userRole === $role);
    }


    public function getUserInfoArr(?UserModel $userRec) : array {
        $userArr = (is_null($userRec)) ? [] : $userRec->toArray();
        return $userArr;
    }  

    

}

