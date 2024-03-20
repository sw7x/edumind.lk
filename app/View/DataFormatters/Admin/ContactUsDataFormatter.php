<?php 

namespace App\View\DataFormatters\Admin;


use Carbon\Carbon;


class ContactUsDataFormatter{
    
    public static function prepareData(array $contactUsDataArr) : array {
        $arr = array();

        foreach ($contactUsDataArr as $contactUsDataItem) {
            $contactUsDto   = $contactUsDataItem['dto'];

            $tempArr        = $contactUsDto->toArray();
            $creator        = $contactUsDto->getCreatorDto();
            $createdAt      = $contactUsDto->getCreatedAt();

            $roleName = null;
            if($creator && $creator->getRoleDto())
                $roleName    = $creator->getRoleDto() ? $creator->getRoleDto()->getName() : null;                   
                        

            $tempArr['userStat']     = $creator ? $creator->getStatus() : null;
            $tempArr['profilePic']   = $creator ? $creator->getProfilePic() : null;
            $tempArr['roleName']     = $roleName;
                        
            $tempArr['createdAt']    = $createdAt;
            $tempArr['createdAtAgo'] = Carbon::parse($createdAt)->diffForHumans();

            $tempArr['userArr']['isTrashed'] = isset($contactUsDataItem['dbRec']->user) ? $contactUsDataItem['dbRec']->user->trashed() : null;

            $arr[] = $tempArr;
        }
        
        return $arr;
    }
    


}




