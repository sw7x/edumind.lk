<?php

namespace App\DataTransferObjects\Factories;

//use Ramsey\Uuid\Uuid;


use App\DataTransferObjects\Factories\AbstractDtoFactory;
use App\DataTransferObjects\EnrollmentDto;
use Illuminate\Http\Request;
use App\DataTransferObjects\Factories\UserDtoFactory;
use App\DataTransferObjects\Factories\CourseItemDtoFactory;
use App\Repositories\EnrollmentRepository;


use App\DataTransferObjects\Factories\AuthorFeeDtoFactory;
use App\DataTransferObjects\Factories\CommissionFeeDtoFactory;
use App\DataTransferObjects\Factories\EduminFeeDtoFactory;

use App\DataTransferObjects\Exceptions\MissingArgumentDtoException;

use App\Mappers\CourseItemMapper;
use App\Mappers\UserMapper;
use \DateTime;




class EnrollmentDtoFactory extends AbstractDtoFactory
{
    
    
    
    //-------->course_selection_id, courseItemArr array
    //-------->student_id,studentArr array





    // From Array Method
    public static function fromArray(array $data): ?EnrollmentDto { 
        if( !isset($data['courseItemId']) && !isset($data['courseItemArr']) )
            throw new MissingArgumentDtoException('EnrollmentDto create failed due to missing both courseItemId and courseItemArr parameters');

        if( !isset($data['studentId']) && !isset($data['studentArr']) )
            throw new MissingArgumentDtoException('EnrollmentDto create failed due to missing both studentId and studentArr parameters');
    
        
        $courseItemDTO  =   (isset($data['courseItemArr']) && !empty($data['courseItemArr'])) ?
                                CourseItemDtoFactory::fromArray($data['courseItemArr']) :
                                (new CourseItemDtoFactory())->createDtoById($data['courseItemId']);
                       
        $studentDTO =   (isset($data['studentArr']) && !empty($data['studentArr'])) ?
                                UserDtoFactory::fromArray($data['studentArr']) :
                                (new UserDtoFactory())->createDtoById($data['studentId']);
        
        $authorFee          = $courseItemDTO->getAuthorAmount();
        $authorFeeDTO       = AuthorFeeDtoFactory::fromArray(array('amount'=> $authorFee));        
        
        $commissionFee      = $courseItemDTO->getBeneficiaryEarnAmount();
        $commissionFeeDTO   = CommissionFeeDtoFactory::fromArray(array('amount'=> $commissionFee));
        
        $edumindFee         = $courseItemDTO->edumindEarnTotalAmount();
        $edumindFeeDTO      = EduminFeeDtoFactory::fromArray(array('amount'=> $edumindFee));
        
        
        if(isset($data['completeDate'])){
            if ( DateTime::createFromFormat("Y-m-d H:i:s", $data['completeDate']) )
                $completeDateStr    = (new DateTime($data['completeDate']))->format("Y-m-d");

            if ( DateTime::createFromFormat("Y-m-d", $data['completeDate']) )
                $completeDateStr    = $data['completeDate'];
        } 


        $dto = new EnrollmentDto(
            $courseItemDTO,
            $studentDTO,

            $data['id'] ?? null,
            //$data['uuid'] ?? null,
            $data['isComplete'] ?? null,               
            $completeDateStr ?? null,                
            $data['rating'] ?? null,
                            
            $authorFeeDTO,
            $commissionFeeDTO,
            $edumindFeeDTO
        );   
        //dd($dto);
        return $dto;           
    }

    public static function fromRequest(Request $request): ?EnrollmentDto{            
        if( 
            ( $request->input('course_item_id')  == null ) && 
            ( $request->input('course_item_arr') === null || empty($request->input('course_item_arr')) )
        ){
            throw new MissingArgumentDtoException('EnrollmentDto create failed due to missing both course_selection_id and course_item_arr parameters');
        }
    
        if( 
            ($request->input('student_id')  == null) && 
            ($request->input('student_arr') === null || empty($request->input('student_arr')) )
        ){
            throw new MissingArgumentDtoException('EnrollmentDto create failed due to missing both student_id and student_arr parameters');
        }
        
        
        if ($request->has('course_item_id') && $request->filled('course_item_id')) {          
            $courseItemDTO = (new CourseItemDtoFactory())->createDtoById($request->input('course_item_id'));
        }else{
            $courseItemArr  = CourseItemMapper::arrConvertToDtoArr($request->input('course_item_arr'));
            $courseItemDTO  = CourseItemDtoFactory::fromArray($courseItemArr); 
        }
            

        if ($request->has('student_id') && $request->filled('student_id')) {           
            $studentDTO = (new UserDtoFactory())->createDtoById($request->input('student_id'));
        }else{
            $studentArr     = UserMapper::arrConvertToDtoArr($request->input('student_arr'));
            $studentDTO     = UserDtoFactory::fromArray($studentArr);
        }
        
        $authorFee          = $courseItemDTO->getAuthorAmount();
        $authorFeeDTO       = AuthorFeeDtoFactory::fromArray(array('amount'=> $authorFee));        
        
        $commissionFee      = $courseItemDTO->getBeneficiaryEarnAmount();
        $commissionFeeDTO   = CommissionFeeDtoFactory::fromArray(array('amount'=> $commissionFee));
        
        $edumindFee         = $courseItemDTO->edumindEarnTotalAmount();
        $edumindFeeDTO      = EduminFeeDtoFactory::fromArray(array('amount'=> $edumindFee));
            

        if($request->has('complete_date') && $request->filled('complete_date')){
            if ( DateTime::createFromFormat("Y-m-d H:i:s", $request->input('complete_date')) )
                $completeDateStr     = (new DateTime($request->input('complete_date')))->format("Y-m-d");

            if ( DateTime::createFromFormat("Y-m-d", $request->input('complete_date')) )
                $completeDateStr     = $request->input('complete_date');
        }

        return new EnrollmentDto(
            $courseItemDTO,
            $studentDTO,

            $request->input('id') ?? null,
            //$request->input('uuid') ?? null,
            $request->input('is_complete') ?? null,               
            $completeDateStr ?? null,                
            $request->input('rating') ?? null,
                            
            $authorFeeDTO,
            $commissionFeeDTO,
            $edumindFeeDTO
        );        
    }    

    public function createDtoById(int $enrollmentId): ?EnrollmentDto {
        //$data          = (new EnrollmentRepository())->findDtoAllDataById($enrollmentId);        
        $data          = (new EnrollmentRepository())->findDtoDataById($enrollmentId);
        $enrollmentDto = (!empty($data))? self::fromArray($data): null;
        return $enrollmentDto;
    }

}