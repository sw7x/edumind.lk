<?php 

namespace App\View\DataTransformers\Admin;


use Carbon\Carbon;

class CouponCodeDataTransformer{
    
    public static function prepareCouponData(array $couponCodeDataArr) : array {
        //dd($userDto);
        $arr    =   array();

        $ccDto      = $couponCodeDataArr['dto'];
        $ccDbRec    = $couponCodeDataArr['dbRec'];

        $arr                = $ccDto->toArray();
        
        
        $arr['courseName']  = optional($ccDto->getCourseDto())->getName();  

        if(isset($ccDbRec->created_at)){
            $createdAt           = $ccDbRec->created_at;
            $arr['createdAt']    = $createdAt->format('Y/m/d H:i');
            $arr['createdDate']  = $createdAt->format('Y/m/d');
            $arr['createdAtAgo'] = $createdAt->diffForHumans();
        }

        
        return $arr;
    }


}



?>





