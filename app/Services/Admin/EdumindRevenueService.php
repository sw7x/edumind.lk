<?php

namespace App\Services\Admin;

/*
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
use App\Domain\Factories\CourseFactory;
use App\Domain\Factories\CouponFactory;
use App\Domain\Factories\CourseItemFactory;
use App\Domain\Factories\EnrollmentFactory;
use App\Domain\Factories\OrderFactory;
use App\Domain\Factories\UserFactory;
use App\Mappers\EnrollmentMapper;
use App\DataTransferObjects\Factories\EnrollmentDtoFactory;
use App\DataTransferObjects\Factories\UserDtoFactory;
*/

use App\Repositories\EnrollmentRepository;
use App\Repositories\InvoiceRepository;
use App\Domain\Factories\InvoiceFactory;
use App\Mappers\InvoiceMapper;
use App\Builders\EnrollmentBuilder;
use App\DataTransferObjects\Factories\InvoiceDtoFactory;

class EdumindRevenueService
{

    function __construct(){

    }

    public function loadEarnings(){

        $enrollmentDataArr11      = (new EnrollmentRepository())->findDataArrById(17);
        //dump($enrollmentDataArr11);

        //TODO - add pagination

        // load all paid enrollments
        $enrollmentsRecArr = (new EnrollmentRepository())->paidAll([
            //'*',
            'teacherRec.full_name as teacherName',
            'enrollments.*',
            'invoices.checkout_date as checkoutDate',
            'invoices.id as invoiceId'
        ]);
        //dump($enrollmentsRecArr);

        $edumindRevenueArr = array();
        foreach ($enrollmentsRecArr as $enrollmentRec) {
            $enrollmentDto          = EnrollmentBuilder::buildDto($enrollmentRec->toArray());

            $invoiceId              = $enrollmentRec['invoiceId'];
            $invoiceDataArr         = (new InvoiceRepository())->findDataArrById($invoiceId);
            $invoiceEntityDataArr   = InvoiceMapper::dbRecConvertToEntityArr($invoiceDataArr);
            $invoiceEntity          = (new InvoiceFactory())->createObjTree($invoiceEntityDataArr);
            $invoiceDto             = InvoiceDtoFactory::fromArray($invoiceEntity->toArray());
            ////dump($invoiceDto);


            $edumindRevenueArr[]    =   array(
                                            'invoiceDto'    =>  $invoiceDto,
                                            'enrollmentDto' =>  $enrollmentDto
                                        );

            /*
                $enrollmentEntity->getId(),

                edumind Earn Amount- number_format((float)$edumindFeeEntity->getAmount()->getValue(), 2, '.', ''),

                invoice Id - $invoiceId,

                enrolled Date Time - $enrolledDateTime,

                coupon Code - $ccCode,

                discount Percentage - $discountPercentage,

                course name - $courseEntity->getName(),

                teacher Name - $teacherName,

                course Price - number_format((float)$courseEntity->getPrice()->getValue(), 2, '.', ''),

                student name - $studentEntity->getFullName(),

                edumind Share From Course Price - $courseEntity->edumindSharePercentage()->getValue(),

                edumind Earn Amount From Course Price - number_format((float)$courseItemEntity->getEdumindAmount()->getValue(), 2, '.', ''),

                discount Amount - number_format((float)$courseItemEntity->calcDiscount()->getValue(), 2, '.', ''),

                beneficiary Percentage From Discount - (isset($couponEntity))? $couponEntity->getCommisionPercentageFromDiscount() : null,

                edumind Percentage From Discount - (isset($couponEntity))? $couponEntity->edumindPercentageFromDiscount() : null,

                getBeneficiary Earn Amount - number_format((float)$commissionFeeEntity->getAmount()->getValue(), 2, '.', ''),

                Edumind Loose Amount - number_format((float)$courseItemEntity->getEdumindLooseAmount()->getValue(), 2, '.', '')

            */

        }
        //dd('k');
        //dd($edumindRevenueArr);
        return $edumindRevenueArr;

    }



}






//service only methods - not in entity
    //view all (edumind) earnings
    //view course wise (edumind) earnings
    //view teacher wise (edumind) earnings


//methods - also in entity
