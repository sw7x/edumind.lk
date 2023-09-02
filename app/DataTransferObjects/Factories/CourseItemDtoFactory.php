<?php


namespace App\DataTransferObjects\Factories;

use App\DataTransferObjects\Factories\AbstractDtoFactory;
use Illuminate\Http\Request;
use App\DataTransferObjects\Factories\CourseDtoFactory;
use App\DataTransferObjects\Factories\CouponDtoFactory;

use App\DataTransferObjects\CourseItemDto;
use App\Repositories\CourseItemRepository;
use App\DataTransferObjects\Exceptions\MissingArgumentDtoException;

use App\Mappers\CourseMapper;
use App\Mappers\CouponMapper;
use App\Mappers\Mapper;
use \DateTime;

class CourseItemDtoFactory extends AbstractDtoFactory
{
    
    //-------->course_id,course array
    //-------->used_coupon_code,used_coupon_code array
    public static function fromArray(array $data) : ?CourseItemDto {        
        if(!isset($data['cartAddedDate']))
            throw new MissingArgumentDtoException('CourseItemDto create failed due to missing cartAddedDate parameter');
        
        if(!isset($data['isCheckout']))
            throw new MissingArgumentDtoException('CourseItemDto create failed due to missing isCheckout parameter');        
        
        if( !isset($data['courseId']) && !isset($data['courseArr']) )
            throw new MissingArgumentDtoException('CourseItemDto create failed due to missing both courseArr and courseId parameters');
        
        
        //dump('jj');dump(isset($data['usedCouponArr']));dd($data);
        $courseDTO  =   (isset($data['courseArr'])  && !empty($data['courseArr']))? 
                            CourseDtoFactory::fromArray($data['courseArr']) : 
                            (new CourseDtoFactory())->createDtoById($data['courseId']);
        
        
        $couponCodeDTO  =   (isset($data['usedCouponArr']) && !empty($data['usedCouponArr'])) ? 
                                CouponDtoFactory::fromArray($data['usedCouponArr']) : 
                                (isset($data['usedCouponCode']) ? 
                                    (new CouponDtoFactory())->createDtoByCode($data['usedCouponCode']) : 
                                    null
                                );

        if ( DateTime::createFromFormat("Y-m-d H:i:s", $data['cartAddedDate']) )
            $cartAddedDateString     = (new DateTime($data['cartAddedDate']))->format("Y-m-d");

        if ( DateTime::createFromFormat("Y-m-d", $data['cartAddedDate']) )
            $cartAddedDateString     = $data['cartAddedDate'];
                   


                            
        return new CourseItemDto(
            $courseDTO,
            $cartAddedDateString,
            $data['isCheckout'],

            $data['id'] ?? null,
            //$data['uuid'] ?? null,
            $data['discountAmount'] ?? null,
            $data['edumindLoseAmount'] ?? null,
            $data['revisedPrice'] ?? null,
            $data['edumindAmount'] ?? null,
            $data['beneficiaryEarnAmount'] ?? null,
            $data['authorAmount'] ?? null,

            $couponCodeDTO
        );       
    }


    
    public static function fromRequest(Request $request) : ?CourseItemDto {        

        if($request->input('cart_added_date') == null )
            throw new MissingArgumentDtoException('CourseItemDto create failed due to missing cart_added_date parameter');
        
        if($request->input('is_checkout') === null )
            throw new MissingArgumentDtoException('CourseItemDto create failed due to missing is_checkout parameter');
        
        if(   
            ($request->input('course_id')  == null)  &&
            ($request->input('course_arr') === null || empty($request->input('course_arr')) ) 
        ){
            throw new MissingArgumentDtoException('CourseItemDto create failed due to missing both course_arr and course_id parameters');
        }

        if($request->has('course_id') && $request->filled('course_id')){
            $courseDTO = (new CourseDtoFactory())->createDtoById($request->input('course_id'));
        }else {            
            $courseArr = $request->input('course_arr');            
            $courseArr = CourseMapper::arrConvertToDtoArr($courseArr);           
            $courseDTO = CourseDtoFactory::fromArray($courseArr);

        }
            
        
        $couponCodeDTO = null;
        if($request->has('used_coupon_code') && $request->filled('used_coupon_code')){
            $couponCodeDTO = (new CouponDtoFactory())->createDtoByCode($request->input('used_coupon_code'));
        }elseif (
            $request->has('used_coupon_arr') && 
            $request->filled('used_coupon_arr') &&
            !empty($request->input('used_coupon_arr'))
        ) {
            $usedCouponArr = CouponMapper::arrConvertToDtoArr($request->input('used_coupon_arr'));
            $couponCodeDTO = CouponDtoFactory::fromArray($usedCouponArr);dump('jjj');
        }


        if ( DateTime::createFromFormat("Y-m-d H:i:s", $request->input('cart_added_date')) )
            $cartAddedDateString     = (new DateTime($request->input('cart_added_date')))->format("Y-m-d");

        if ( DateTime::createFromFormat("Y-m-d", $request->input('cart_added_date')) )
            $cartAddedDateString     = $request->input('cart_added_date');
        
        
        return new CourseItemDto(
            $courseDTO,                
            $cartAddedDateString,                          
            $request->input('is_checkout'),

            $request->input('id') ?? null,
            //$request->input('uuid') ?? null,
            $request->input('discount_amount') ?? null,
            $request->input('edumind_lose_amount') ?? null,            
            $request->input('revised_price') ?? null,
            $request->input('edumind_amount') ?? null,
            $request->input('beneficiary_earn_amount') ?? null,
            $request->input('author_amount') ?? null,
                          
            $couponCodeDTO                
        );
    }

    

    public function createDtoById(int $courseItemId) : ?CourseItemDto {
        $data          = (new CourseItemRepository())->findDtoDataById($courseItemId);
        $courseItemDto = (!empty($data))? self::fromArray($data): null;
        return $courseItemDto;
    }


}
