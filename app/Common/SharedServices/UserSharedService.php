<?php

namespace App\Common\SharedServices;

use App\Exceptions\CustomException;

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

}

