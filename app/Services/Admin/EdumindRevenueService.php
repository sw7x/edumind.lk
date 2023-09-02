<?php


namespace App\Services\Admin;
use App\Repositories\EnrollmentRepository;
use App\Repositories\CourseSelectionRepository;
use App\Repositories\CouponRepository;
use App\Repositories\CourseRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;

use App\Models\{
    Enrollment as EnrollmentModel,
    CourseSelection as CourseSelectionModel,
    User as UserModel,
    Course as CourseModel,
    Coupon as CouponModel,
    Invoice as InvoiceModel
};




use App\Domain\Enrollment as EnrollmentEntity;
use App\Domain\Users\Student as StudentEntity;
use App\Domain\Course as CourseEntity;
use App\Domain\CourseItem as CourseItemEntity;
use App\Domain\CouponCode as CouponCodeEntity;

use App\DataTransferObjects\EdumindRevenueDTO;


use App\Domain\Factories\CourseFactory;
use App\Domain\Factories\CouponFactory;
use App\Domain\Factories\CourseItemFactory;
use App\Domain\Factories\EnrollmentFactory;
use App\Domain\Factories\OrderFactory;
use App\Domain\Factories\UserFactory;

use App\Mappers\EnrollmentMapper;
use App\DataTransferObjects\Factories\EnrollmentDtoFactory;
use App\DataTransferObjects\Factories\UserDtoFactory;




class EdumindRevenueService
{
    
    function __construct(){
        
    }

    public function loadEarnings(){
        
        //$rr = (new UserDtoFactory())->createDtoById(12);
        //dd($rr);



        $enrollmentDataArr11      = (new EnrollmentRepository())->findDataArrById(17);
        dump($enrollmentDataArr11);        
        dump('enrollmentDataArr11');


        //TODO - add pagination

        // load all enrollments        
        $enrollmentsRecArr = (new EnrollmentRepository())->paidAll([
            //'*',
            'teacherRec.full_name as teacherName',
            'enrollments.*',
            'invoices.checkout_date as checkoutDate',
            //'invoices.id as invoiceId'        
        ]);

        dump($enrollmentsRecArr);

        dump('##########################');

        foreach ($enrollmentsRecArr as $enrollmentRec) {  
            
            //dump($enrollmentRec); 
            $enrollmentEntity   = (new EnrollmentFactory())->createObjTree($enrollmentRec->toArray());
            dump($enrollmentEntity);
            dump($enrollmentEntity->toArray());
            //$enrollmentDtoArr = EnrollmentMapper::entityConvertToDtoArr($enrollmentEntity->toArray());
            //dump($enrollmentDtoArr);

            $enrollmentDto   = EnrollmentDtoFactory::fromArray($enrollmentEntity->toArray());
            dump($enrollmentDto);
            dump('========================='); 
        }
        dd();
        //dd2($enrollmentsRecArr->map->only(['checkoutDate', 'updated_at', 'id'])->toArray());        
        
        $edumindRevenueDTOArr = array();
                     
        foreach ($enrollmentsRecArr as $enrollmentRec) {           
            //dd($enrollmentRec->id);
            
            $enrollmentDataArr      = (new EnrollmentRepository())->findDataArrById($enrollmentRec->id);

            //dd($enrollmentDataArr);
            $enrollmentEntity   = (new EnrollmentFactory())->createObj($enrollmentDataArr);
            
            $courseItemEntity   = $enrollmentEntity->getCourseItem();
            
            $ccCode = $enrollmentRec->courseSelection->used_coupon_code ?? null;
            if($ccCode){
                $ccDTO        = (new CouponRepository())->findDataArrByCode($ccCode);
                $couponEntity = (new CouponFactory())->createObj($ccDTO);
                $courseItemEntity->applyCouponCode($couponEntity);
            }
                        
            $courseEntity        = $enrollmentEntity->course();           
            $studentEntity       = $enrollmentEntity->getStudent();
            $edumindFeeEntity    = $enrollmentEntity->getEdumindFee();
            $commissionFeeEntity = $enrollmentEntity->getCommissionFee();
            

            $invoiceId           = $enrollmentRec->invoiceId ?? null;
            $enrolledDateTime    = $enrollmentRec->checkoutDate ?? null;
                            
            
            $beneficiaryShareFromDiscount = (isset($couponEntity))? $couponEntity->getCommisionPercentageFromDiscount() : null;
            $edumindShareFromDiscount     = (isset($couponEntity))? $couponEntity->edumindPercentageFromDiscount() : null;
            $ccCode                       = (isset($couponEntity))? $couponEntity->getCode() : '';
            $discountPercentage           = (isset($couponEntity))? $couponEntity->getDiscountPercentage() : null;
        

            $teacherName = $enrollmentRec->teacherName ?? '';
            //$teacherName = $enrollmentRec->courseAuthor->name ?? '';
            


/*
array(
    'invoiceId'          =>  $invoiceId,  
    'enrolledDateTime'   =>  $enrolledDateTime,    
    'teacherName'        =>  $teacherName,  

    'userDTO'            =>  $userDTO,
    'enrollmentDTO'      =>  $enrollmentDTO,
    'couponDTO'          =>  $couponDTO,
    'courseDTO'          =>  $courseDTO,
    'courseItemDTO'      =>  $courseItemDTO,
    'edumindFeeDTO'      =>  $edumindFeeDTO,
    'commissionFeeDTO'   =>  $commissionFeeDTO
)






// invoice Id ,   $invoiceId,   
// enrolled Date Time ,  $enrolledDateTime,    
// teacher Name , $teacherName,  


UserDTO
    // student name
    $studentEntity->getFullName(), 


enrollmentDTO
    // id   ---enrollmentEntity
    $enrollmentEntity->getId(),  
                

$couponDTO
    // coupon Code
    $ccCode,

    // discount Percentage
    $discountPercentage,

    // beneficiary Percentage From Discount
    $beneficiaryShareFromDiscount,  

    // edumind Percentage From Discount   
    $edumindShareFromDiscount,    

                
$courseDTO
    // course name              
    $courseEntity->getName(),

    // course Price
    number_format((float)$courseEntity->getPrice(), 2, '.', ''),    
    
    // edumind Share From Course Price
    $courseEntity->edumindSharePercentage(),    





edumindFeeDTO
    // edumind Earn Amount
    number_format((float)$edumindFeeEntity->getAmount(), 2, '.', ''), 


commissionFeeDTO
    // getBeneficiary Earn Amount
    number_format((float)$commissionFeeEntity->getAmount(), 2, '.', ''), 


                

    // coupon Code
    $ccCode,

    // discount Percentage
    $discountPercentage,

    // beneficiary Percentage From Discount
    $beneficiaryShareFromDiscount,  

    // edumind Percentage From Discount   
    $edumindShareFromDiscount, 





                enrollmentDTO->id,  // id
                
                edumindFeeDTO->amount // edumind Earn Amount
                                
                $invoiceId, // invoice Id                              
                
                $enrolledDateTime, // enrolled Date Time   
                                
                $couponDTO->code, //coupon Code
                
                $couponDTO->discountPercentage, // discount Percentage
                      
                $courseDTO->name, // course name    
                 
                $teacherName,  // teacher Name   
                
                $courseDTO->price // course Price

                UserDTO->fullName, // student name ---------------
                
                $courseDTO->edumindSharePercentage, // edumind Share From Course Price
                                 
                $courseItemDTO->edumindAmount,   // edumind Earn Amount From Course Price
                                
                $courseItemDTO->discount, // discount Amount                
                
                $couponDTO->beneficiaryShareFromDiscount   // beneficiary Percentage From Discount          
                                   
                $couponDTO->edumindShareFromDiscount,   // edumind Percentage From Discount           
                
                commissionFeeDTO->amount, // getBeneficiary Earn Amount
                                
                $courseItemDTO->edumindLooseAmount // Edumind Loose Amount




















*/  
            
            //dump($enrollmentDataArr);
            //$tty = EnrollmentMapper::DbRecConvertToEntityArr($enrollmentDataArr);
            //dd($tty);            

            dump($enrollmentRec);
            $tty = EnrollmentMapper::DbRecConvertToEntityArr($enrollmentRec);
            dd($tty);



            $enrollmentObj    =  (new EnrollmentFactory())->createObjTree($enrollmentDataArr);
            $enrollmentObjDataArr = $enrollmentObj->toArray();
            dd($enrollmentObjDataArr); 
            $data22    =  EnrollmentMapper::entityConvertToDtoArr($enrollmentObj);


            $dto = $data22;


            $dto1   =  new EdumindRevenueDTO(               
                
                // id
                $enrollmentEntity->getId(),  
                
                // edumind Earn Amount
                number_format((float)$edumindFeeEntity->getAmount()->getValue(), 2, '.', ''), 
                
                // invoice Id
                $invoiceId,//-----------------
                                
                // enrolled Date Time
                $enrolledDateTime,//-----------
                
                // coupon Code
                $ccCode,

                // discount Percentage
                $discountPercentage,

                // course name              
                $courseEntity->getName(),

                // teacher Name   
                $teacherName,
                
                // course Price
                number_format((float)$courseEntity->getPrice()->getValue(), 2, '.', ''),   
                
                // student name
                $studentEntity->getFullName(),  
                
                // edumind Share From Course Price
                $courseEntity->edumindSharePercentage()->getValue(),    
                
                // edumind Earn Amount From Course Price
                number_format((float)$courseItemEntity->getEdumindAmount()->getValue(), 2, '.', ''),    
                
                // discount Amount
                number_format((float)$courseItemEntity->calcDiscount()->getValue(), 2, '.', ''), 
                
                // beneficiary Percentage From Discount
                $beneficiaryShareFromDiscount,                
                
                // edumind Percentage From Discount   
                $edumindShareFromDiscount,               
                
                // getBeneficiary Earn Amount
                number_format((float)$commissionFeeEntity->getAmount()->getValue(), 2, '.', ''), 
                
                // Edumind Loose Amount
                number_format((float)$courseItemEntity->getEdumindLooseAmount()->getValue(), 2, '.', '')                
            );
            
            $edumindRevenueDTOArr[] = $dto;
            unset($couponEntity);             
        }        
        dd($edumindRevenueDTOArr);
        return $edumindRevenueDTOArr;
        
        
        /*
        foreach ($enrollmentsRecArr as $enrollmentRec) {           
            
            $enrollmentDTO        = (new EnrollmentRepository())->findDtoAllDataById($enrollmentRec->id);
            $enrollmentEntity   = (new EnrollmentFactory())->createObjTree($enrollmentDTO);
            
            $invoiceId          = $enrollmentRec->invoiceId ?? null;
            $enrolledDateTime   = $enrollmentRec->checkoutDate ?? null;

            $couponEntity = $enrollmentEntity->getCourseItem()->getCouponCode();
            
            $beneficiaryShareFromDiscount = ($couponEntity)? $couponEntity->getCommisionPercentageFromDiscount() : null;
            $edumindShareFromDiscount     = ($couponEntity)? $couponEntity->edumindPercentageFromDiscount() : null;
            $ccCode                       = ($couponEntity)? $couponEntity->getCode() : '';
            $discountPercentage           = ($couponEntity)? $couponEntity->getDiscountPercentage() : null;
            
                        
            $edumindRevenueDTOArr[] = new EdumindRevenueDTO(
                
                // id  
                $enrollmentEntity->getId(),
                
                //edumind Earn Amount
                number_format((float)$enrollmentEntity->getEdumindFee()->getAmount(), 2, '.', ''), 
                                
                // invoice Id
                $invoiceId,

                // enrolled Date Time
                $enrolledDateTime,           
               
                // coupon Code
                $ccCode, 
                                
                // discount Percentage
                $discountPercentage,                
                                
                // course name
                $enrollmentEntity->getCourseItem()->getCourse()->getName(),
                
                // teacher Name  
                $enrollmentEntity->getCourseItem()->getCourse()->getAuthor()->getFullName(),

                // course Price
                number_format((float)$enrollmentEntity->getCourseItem()->coursePrice(), 2, '.', ''),
                
                // student name
                $enrollmentEntity->getStudent()->getFullName(),
                
                //  edumind Share From Course Price
                $enrollmentEntity->getCourseItem()->getCourse()->edumindSharePercentage(),
                
                //  edumind Earn Amount From Course Price
                number_format((float)$enrollmentEntity->getCourseItem()->getEdumindAmount(), 2, '.', ''),
                
                //  discount Amount
                number_format((float)$enrollmentEntity->getCourseItem()->calcDiscount(), 2, '.', ''), 
                
                //  beneficiary Percentage From Discount
                $beneficiaryShareFromDiscount,                
                
                //  edumind Percentage From Discount 
                $edumindShareFromDiscount,                
                
                //  getBeneficiary Earn Amount
                number_format((float)$enrollmentEntity->getCommissionFee()->getAmount(), 2, '.', ''), 
                
                //  Edumind Loose Amount
                number_format((float)$enrollmentEntity->getCourseItem()->getEdumindLooseAmount(), 2, '.', '')                
            );

        }

        return $edumindRevenueDTOArr;
        */
    }



}


//service only methods - not in entity    
    //view all (edumind) earnings
    //view course wise (edumind) earnings
    //view teacher wise (edumind) earnings




//methods - also in entity
