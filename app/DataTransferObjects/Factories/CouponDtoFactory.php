<?php

namespace App\DataTransferObjects\Factories;

use App\DataTransferObjects\Factories\AbstractDtoFactory;
use Illuminate\Http\Request;

use App\DataTransferObjects\Factories\CourseDtoFactory;
use App\DataTransferObjects\Factories\UserDtoFactory;

use App\DataTransferObjects\CouponCodeDto;

use App\Repositories\CouponRepository;
use App\DataTransferObjects\Exceptions\MissingArgumentDtoException;
use App\Mappers\CourseMapper;
use App\Mappers\UserMapper;

class CouponDtoFactory extends AbstractDtoFactory
{
    
	public static function fromArray(array $data) : ?CouponCodeDto {        
        if(!isset($data['code']))
            throw new MissingArgumentDtoException('CouponCodeDto create failed due to missing code parameter');

        if(!isset($data['discountPercentage']))
            throw new MissingArgumentDtoException('CouponCodeDto create failed due to missing discountPercentage parameter');
            
        $courseDTO      =   (isset($data['assignedCourseArr']) && !empty($data['assignedCourseArr'])) ?
                                CourseDtoFactory::fromArray($data['assignedCourseArr']) : 
                                (isset($data['ccCourseId']) ? 
                                    (new CourseDtoFactory())->createDtoById($data['assignedCourseId']) : 
                                    null 
                                );

        $beneficiaryDTO =   (isset($data['beneficiaryArr']) && !empty($data['beneficiaryArr'])) ?
                                UserDtoFactory::fromArray($data['beneficiaryArr']) :
                                (isset($data['beneficiaryId']) ? 
                                    (new UserDtoFactory())->createDtoById($data['beneficiaryId']) : 
                                    null
                                );

        return new CouponCodeDto(
            $courseDTO,
            $data['code'],  
            $data['discountPercentage'],              
            
            //$data['uuid'] ?? null,  
            $data['commisionPercentageFromDiscount'] ?? null,  
            $data['totalCount'] ?? null,  
            $data['usedCount'] ?? null,              
            $data['isEnabled'] ?? null,  
            
            $beneficiaryDTO                
        );

    }
    
    
    public static function fromRequest(Request $request) : ?CouponCodeDto {        
        if($request->input('code') == null )
            throw new MissingArgumentDtoException('CouponCodeDto create failed due to missing code parameter');

        if($request->input('discount_percentage') === null )
            throw new MissingArgumentDtoException('CouponCodeDto create failed due to missing discount_percentage parameter');
            
        $courseDTO = null;
        if($request->has('assigned_course_id') && $request->filled('assigned_course_id')){
            $courseDTO = (new CourseDtoFactory())->createDtoById($request->input('assigned_course_id'));
        }elseif (
            $request->has('assigned_course_arr') && 
            $request->filled('assigned_course_arr') &&
            !empty($request->input('assigned_course_arr'))
        ) {
            $assignedCourseArr  = CourseMapper::arrConvertToDtoArr($request->input('assigned_course_arr'));
            $courseDTO          = CourseDtoFactory::fromArray($assignedCourseArr);
        }


        $beneficiaryDTO = null;
        if($request->has('beneficiary_id') && $request->filled('beneficiary_id')){
            $beneficiaryDTO = (new UserDtoFactory())->createDtoById($request->input('beneficiary_id'));
        }elseif (
            $request->has('beneficiary_arr') && 
            $request->filled('beneficiary_arr') && 
            !empty($request->input('beneficiary_arr'))
        ) {
            $beneficiaryArr = UserMapper::arrConvertToDtoArr($request->input('beneficiary_arr'));
            $beneficiaryDTO = UserDtoFactory::fromArray($beneficiaryArr);
        }

        return new CouponCodeDto(
            $courseDTO,
            $request->input('code'),
            $request->input('discount_percentage'),            

            //$request->input('uuid') ?? null,
            $request->input('commision_percentage_from_discount') ?? null,
            $request->input('total_count') ?? null,
            $request->input('used_count') ?? null,            
            $request->input('is_enabled') ?? null,                
            
            $beneficiaryDTO
        );        
    }
    
    public function createDtoByCode(string $code): ?CouponCodeDto {
        $data           = (new CouponRepository())->findDtoDataByCode($code);
        //dd($data);
        $couponCodeDto  = (!empty($data))? self::fromArray($data): null;
        return $couponCodeDto;
    }

    

}
