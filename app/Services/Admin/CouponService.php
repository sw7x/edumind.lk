<?php

namespace App\Services\Admin;

use App\Repositories\CouponRepository;
use Illuminate\Http\Request;
use App\Exceptions\CustomException;

use App\DataTransferObjects\CouponCodeDto;
use App\Models\Coupon as CouponModel;
use App\DataTransferObjects\Factories\CouponDtoFactory;
use App\Mappers\CouponMapper;
use App\Domain\Factories\CouponFactory;
use Sentinel;
use App\Repositories\CourseRepository;
use App\Repositories\UserRepository;
use App\Domain\CouponCode as CouponCodeEntity;
use App\Utils\UrlUtil;
use App\Utils\FileUploadUtil;
use App\DataTransferObjects\Factories\CourseDtoFactory;
use App\Models\Course as CourseModel;




//use App\Models\User as UserModel;
//use App\Builders\UserBuilder;
//use Illuminate\Support\Facades\Gate;
//use App\DataTransferObjects\Factories\UserDtoFactory;
//use App\Mappers\UserMapper;
//use App\Domain\Users\User as UserEntity;
//use App\DataTransferObjects\UserDto;
//use App\Domain\Factories\UserFactory;
//use App\Domain\Factories\CourseFactory;
//use App\Domain\Course as CourseEntity;
//use App\Mappers\CourseMapper;
//use Illuminate\Support\Arr;
//use Illuminate\Support\Str;


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
        $couponCount    =   $this->couponRepository->findByCode($request->get('cc-code'));
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


    /*    
    public function entityToDbRecArr(CouponCodeEntity $couponEntity) : array {
        $couponEntityArr   = $couponEntity->toArray();
        $payloadArr        = CouponMapper::entityConvertToDbArr($couponEntityArr);
        return $payloadArr;
    }

    public function dtoToDbRecArr(CouponCodeDto $couponDto) : array {
        $couponEntity   = (new CouponFactory())->createObjTree($couponDto->toArray());
        $payloadArr     = $this->entityToDbRecArr($couponEntity);
        return $payloadArr;
    }
    */




    /////////////////////////////////////////////////////////////////////////////

    public function loadAllCourses() : array {
        $courses    = $this->courseRepository->all();

        $coursesDtoArr = array();
        $courses->each(function (CourseModel $record, int $key) use (&$coursesDtoArr){
            $tempArr = array();
            $tempArr['dto']         = CourseDataTransformer::buildDto($record->toArray());
            $tempArr['updatedAt']   = $record->updated_at;

            $coursesDtoArr[]        = $tempArr;
        });

        return $coursesDtoArr;
    }


    public function updateStatus(int $courseId, string $status) : bool {
        $updateInfo = ['status'=> $status];
        return $this->courseRepository->update($courseId, $updateInfo);
    }

    public function checkIsCourseEmpty(CourseModel $courseDbRec) : bool {
       $courseEntity = CourseDataTransformer::buildEntity($courseDbRec->toArray());
       return  $courseEntity->isEmpty();
    }

    public function deleteDbRec(CourseModel $courseDbRec) : bool {
        return $this->courseRepository->deleteById($courseDbRec->id);
    }


    public function updateDbRec(Request $request, CourseModel $courseDbRec) : bool {

        $coursName      =   $request->get('course-name');
        $coursrRecId    =   $courseDbRec->id;
        $isNameExists   =   $this->courseRepository->findDuplicateCountByName($coursName, $coursrRecId);
        if ($isNameExists > 0)
            throw new CustomException('Course name already exists!');


        /* image upload */
        $file = $request->input('course-img');
        if(!isset($file)){
            // remove image and submit update
            $imgDest    =   null;
        }else{
            /*  input filed hidden_file_add_count value equals 0 when initially filpond loads image
                it means no change to previously upload image and submit edit form    */
            if( $request->hidden_file_add_count == 0){
                $defaultImgPath     =   asset('images/default-images/course.png');
                $imgUrl             =   $request->hidden_course_img_url;

                if($imgUrl == $defaultImgPath){
                    $imgDest    =   null;
                }else{
                    $imgDest    =   str_replace(asset('storage'), '/', $imgUrl);
                    $imgDest    =   ltrim($imgDest, '/');
                }

            }else{
                // previously image is uploaded and now change the image and upload
                //todo delete prviously uploaded image
                $imgDest        = (new FileUploadUtil())->upload($file,'courses/');
            }
        }


        // set duration text for insert into database
        $hours      = $request->get('course-duration-hours');
        $minutes    = $request->get('course-duration-minutes');
        $duration   = $this->prepareCourseDurationText($hours, $minutes);


        $request->merge([
            'name'                    => $request->get('course-name'),
            'subject_id'              => $request->get('subject'),
            'creator_id'              => $request->get('teacher'),
            'heading_text'            => $request->get('course-heading'),
            'description'             => $request->get('course-description'),
            'duration'                => $duration,
            'video_count'             => $request->get('video-count'),
            'author_share_percentage' => $request->get('author_share_percentage'),
            'price'                   => $request->get('course-price'),
            'status'                  => ($request->get('course_stat') == CourseModel::PUBLISHED) ? CourseModel::PUBLISHED : CourseModel::DRAFT,
            'image'                   => $imgDest,
            'topics'                  => $request->input('topicsString'),
            'content'                 => $request->input('contentString'),
            'slug'                    => UrlUtil::generateCourseShortUrl($request->get('course-name'))
        ]);

        $courseDto     = CourseDtoFactory::fromRequest($request);
        $payloadArr    = CouponCodeDataTransformer::dtoToDbRecArr($courseDto);
        unset($payloadArr['id']);
        unset($payloadArr['uuid']);
        unset($payloadArr['subject_arr']);
        unset($payloadArr['creator_arr']);
        unset($payloadArr['slug']);
        return $this->courseRepository->update($coursrRecId, $payloadArr);
    }




}
