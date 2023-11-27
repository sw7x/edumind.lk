<?php 

namespace App\View\DataFormatters\Admin;


use Carbon\Carbon;

class UserDataFormatter{
    
    public static function prepareUserListData(array $userDataArr) : array {
        $arr = array();
        
        foreach ($userDataArr as $userData) {
            $tempArr = array();

            $tempArr['data']    = ($userData['dto'])->toArray();
            $tempArr['dbRec']   = $userData['dbRec'];

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





