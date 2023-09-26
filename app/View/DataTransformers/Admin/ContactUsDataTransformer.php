<?php 

namespace App\View\DataTransformers\Admin;


use Carbon\Carbon;


class ContactUsDataTransformer{
    
    public static function prepareData(array $contactUsDtoArr) : array {
        $arr = array();
        
        foreach ($contactUsDtoArr as $contactUsDto) {
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

            $arr[] = $tempArr;
        }
        return $arr;
    }
    


}




