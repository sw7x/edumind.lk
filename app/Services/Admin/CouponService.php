<?php

namespace App\Services\Admin;

use Sentinel;
use Illuminate\Http\Request;

use App\Exceptions\CustomException;

use App\Models\Coupon as CouponModel;
use App\DataTransferObjects\Factories\CouponDtoFactory;
use App\Domain\CouponCode as CouponCodeEntity;
use App\Mappers\CouponMapper;
use App\Domain\Factories\CouponFactory;
use App\DataTransferObjects\CouponCodeDto;

use App\Repositories\CourseRepository;
use App\Repositories\UserRepository;
use App\Repositories\CouponRepository;

use App\DataTransformers\Database\CourseDataTransformer;
use App\DataTransformers\Database\CouponCodeDataTransformer;


class CouponService
{

    private CouponRepository $couponRepository;

    function __construct(CouponRepository $couponRepository){
        $this->couponRepository = $couponRepository;
    }

    public function createUniqueCode() : string {
        $code   =   '';
        do{
            $code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));

        }while(!is_null($this->couponRepository->findByCode($code)));
        return $code;
    }

    public function findDbRec(string $code) : ?array {
        $dbRec  =   $this->couponRepository->findByCode($code);
        $dto    =   $dbRec ? CouponCodeDataTransformer::buildDto($dbRec->toArray()) : null;

        return array(
            'dbRec' => $dbRec,
            'dto'   => $dto
        );
    }


    public function loadBeneficiaries(int $courseId) : array {
        $marketers  =   (new UserRepository())->findAllAvailableMarketers();

        if($courseId == 0){
            $teachers   =   (new UserRepository())->findAllAvailableTeachers();

        }else{
            $course = (new CourseRepository())->findById($courseId);
            if(is_null($course))
                throw new CustomException('Course not found in database');

            $authorId   =   optional($course->teacher)->id;
            $teachers   =   is_null($authorId) ? [] : (new UserRepository())->findAvailableTeacherById($authorId);
        }

        return array(
            'marketers'  =>  (!empty($marketers)) ? $marketers->pluck('full_name','id')->toArray() : [],
            'teachers'   =>  (!empty($teachers))  ? $teachers->pluck('full_name','id')->toArray()  : []
        );
    }


    public function saveCoupon(Request $request) : CouponModel {

        /* check already coupon code exists*/
        $couponCount = $this->couponRepository->findByCode($request->get('cc-code'));
        if (!is_null($couponCount))
            throw new CustomException('Coupon code already exists!');

        $status     =   ($request->get('ccode_stat') == 'enable') ? true : false;

        // if select any course then value = 0 , for mysql table insert convert it to null
        $courseId   =   ($request->get('course') == 0) ? null : $request->get('course');


        if($courseId){
            $courseRecData      =   (new CourseRepository())->findDataArrById($courseId);
            $courseEntity       =   CourseDataTransformer::buildEntity($courseRecData);

            $discountPercentage     =   $request->get('discount_percentage');
            $commisionPercentage    =   $request->get('beneficiary_share_percentage_from_discount');
            $canEdumindEarn         =   $courseEntity->checkEdumindCanEarn($discountPercentage, $commisionPercentage);

            if(!$canEdumindEarn){
                $msg  = 'Edumind recive no money from this discount rate. ';
                $msg .= 'pleae lower these rates discount precentage, Marketer/Teacher share precentage';
                throw new CustomException($msg);
            }
        }

        //throw new CustomException('msg');
        //dd($status);

        $request->merge([
            'code'                                  => $request->get('cc-code'),
            'discount_percentage'                   => $request->get('discount_percentage'),
            'commision_percentage_from_discount'    => $request->get('beneficiary_share_percentage_from_discount'),
            'total_count'                           => $request->get('cc-count'),
            'used_count'                            => 0,
            'is_enabled'                            => $status,
            'assigned_course_id'                    => $courseId,
            'beneficiary_id'                        => $request->get('beneficiary')
        ]);

        $couponDto     = CouponDtoFactory::fromRequest($request);
        $payloadArr    = CouponCodeDataTransformer::dtoToDbRecArr($couponDto);
        unset($payloadArr['uuid']);
        unset($payloadArr['assigned_course_arr']);
        unset($payloadArr['beneficiary_arr']);
        return $this->couponRepository->create($payloadArr);
    }

}