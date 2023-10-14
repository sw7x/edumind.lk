<?php 

namespace App\View\DataFormatters\Admin;


use Carbon\Carbon;

class UserDataFormatter{
    
    public static function prepareUserListData(array $userDtoArr) : array {
        $arr = array();
        
        foreach ($userDtoArr as $userDto) {
            $tempArr    = $userDto->toArray();
            $arr[]      = $tempArr;
        }
        return $arr;
    }    

    
    public static function prepareUserData(array $userDataArr) : array {
        //dd($userDto);
        $userDto         = $userDataArr['dto'];
        $arr             = $userDto->toArray();
        $arr['userType'] = $userDto->getRoleDto() ? $userDto->getRoleDto()->getName() : null;
        
        $arr['lastLogin']       = $userDataArr['dbRec']->last_login;
        $arr['lastLoginTime']   = $userDataArr['dbRec']->getLastLoginTime();        
        return $arr;
    }
    
    public static function prepareUnApprovedTeachers(array $teachersArr) : array {
        $arr = array();
        
        foreach ($teachersArr as $teacherUserDtoArr) {
            $tempArr= $teacherUserDtoArr->toArray();
            $arr[]  = $tempArr;
        }
        return $arr;
    }

}



?>





