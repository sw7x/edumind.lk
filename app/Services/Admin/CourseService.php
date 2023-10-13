<?php

namespace App\Services\Admin;

use App\Repositories\CourseRepository;
use App\Models\Course as CourseModel;
use App\Builders\CourseBuilder;
use App\DataTransferObjects\Factories\CourseDtoFactory;
use App\Mappers\CourseMapper;
use App\Domain\Course as CourseEntity;
use App\DataTransferObjects\CourseDto;
use App\Domain\Factories\CourseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Utils\UrlUtil;
use App\Utils\FileUploadUtil;
use Illuminate\Support\Str;

//use App\Models\User as UserModel;
//use App\Builders\UserBuilder;
//use Illuminate\Support\Facades\Gate;
//use App\DataTransferObjects\Factories\UserDtoFactory;
//use App\Mappers\UserMapper;
//use App\Domain\Users\User as UserEntity;
//use App\DataTransferObjects\UserDto;
//use App\Domain\Factories\UserFactory;
//use App\Repositories\UserRepository;
//use Sentinel;

class CourseService
{

    private CourseRepository $courseRepository;

    function __construct(CourseRepository $courseRepository){
        $this->courseRepository = $courseRepository;
    }

    public function loadAllCourses() : array {
        $courses    = $this->courseRepository->all();

        $coursesDtoArr = array();
        $courses->each(function (CourseModel $record, int $key) use (&$coursesDtoArr){
            $tempArr = array();
            $tempArr['dto']         = CourseBuilder::buildDto($record->toArray());
            $tempArr['updatedAt']   = $record->updated_at;

            $coursesDtoArr[]        = $tempArr;
        });

        return $coursesDtoArr;
    }

    public function findDbRec(int $id) : ?array {
        $dbRec  =   $this->courseRepository->findById($id);
        $dto    =   $dbRec ? CourseBuilder::buildDto($dbRec->toArray()) : null;

        return array(
            'dbRec' => $dbRec,
            'dto'   => $dto
        );
    }

    public function updateStatus(int $courseId, string $status) : bool {
        $updateInfo = ['status'=> $status];
        return $this->courseRepository->update($courseId, $updateInfo);
    }

    public function checkIsCourseEmpty(CourseModel $courseDbRec) : bool {
       $courseEntity = CourseBuilder::buildEntity($courseDbRec->toArray());
       return  $courseEntity->isEmpty();
    }

    public function deleteDbRec(CourseModel $courseDbRec) : bool {
        return $this->courseRepository->deleteById($courseDbRec->id);
    }


    /*
        if course content is in correct format then send it to view
        to recive as old values
    */
    public function validateCourseContentForDb(Request $request) : array {

        if($request->isValidContentJson === true){
            $contentString = array();
            foreach ($request->input('contentArr') as $key => $value) {
                $contentString[base64_decode($key)] = $value;
            }

            $topicsString = array();
            foreach ($request->input('topicsArr') as $key => $value) {
                $topicsString[$key] = base64_decode($value);
            }

            $validationErrMsg = '';
            $contentInputStr  = json_encode($contentString, 512);

        }else{
            $validationErrMsg = 'Course content is not in valid format';
            $contentInputStr  = '{}';
            $topicsString     = '';
            $contentString    = '';
        }


        return array(
            'topicsString'      => $topicsString,
            'contentString'     => $contentString,
            'validationErrMsg'  => $validationErrMsg,
            'contentInputStr'   => $contentInputStr
        );
    }


    public function getCourseValidationErrors(array $validationErrorsArr) : array {

        $contentLinksErrMsgArr    = array();
        $contentErrMsgArr         = array();
        $infoErrMsgArr            = array();

        //dd($validationErrorsArr);

        foreach ($validationErrorsArr as $errField => $valErrMsgArr){
            if(Str::startsWith($errField, 'contentArr.')){

                $sectionHeading = Str::of($errField)->explode('.')[1];
                foreach ($valErrMsgArr as $errMsg){
                    if(isset(Str::of($errField)->explode('.')[2])){
                        $linkIndex = Str::of($errField)->explode('.')[2];

                        if(!isset($contentLinksErrMsgArr[$sectionHeading][$linkIndex])){
                            $contentLinksErrMsgArr[$sectionHeading][$linkIndex] = $errMsg;
                        }else{
                            $contentLinksErrMsgArr[$sectionHeading][$linkIndex] .= ', '.$errMsg;
                        }

                    }else{
                        $contentErrMsgArr[$sectionHeading][] = $errMsg;
                    }
                }
            }else{
                $infoErrMsgArr[$errField] = $valErrMsgArr;
            }
        }

        return array(
            'contentLinksMsg' => $contentLinksErrMsgArr,
            'contentMsg'      => $contentErrMsgArr,
            'infoMsg'         => $infoErrMsgArr
        );
    }


    public function saveDbRec(Request $request) : CourseModel {

        $courseCount       = $this->courseRepository->findByName($request->get('course-name'))->count();
        if ($courseCount > 0)
            throw new CustomException('Course name already exists!');

        /* image upload */
        $file        = $request->input('course-img');
        $destination = isset($file) ? (new FileUploadUtil())->upload($file,'courses/') : null;


        // set duration text for insert into database
        $hours      = $request->get('course-duration-hours');
        $minutes    = $request->get('course-duration-minutes');
        $duration   = $this->prepareCourseDurationText($hours, $minutes);

        $defaultAuthorSharePercentage   =   CourseModel::AUTHOR_SHARE_PERCENTAGE_DEFAULT ?? 60.00;

        $request->merge([
            'name'                    => $request->get('course-name'),
            'subject_id'              => $request->get('subject'),
            'creator_id'              => $request->get('teacher'),
            'heading_text'            => $request->get('course-heading'),
            'description'             => $request->get('course-description'),
            'duration'                => $duration,
            'video_count'             => $request->get('video-count'),
            'author_share_percentage' => ($request->get('course-price') == 0) ? $defaultAuthorSharePercentage : $request->get('author_share_percentage'),
            'price'                   => $request->get('course-price'),
            'status'                  => ($request->get('course_stat') == CourseModel::PUBLISHED) ? CourseModel::PUBLISHED : CourseModel::DRAFT,
            'image'                   => $destination,
            'topics'                  => $request->input('topicsString'),
            'content'                 => $request->input('contentString'),
            'slug'                    => UrlUtil::generateCourseShortUrl($request->get('course-name'))
        ]);

        $courseDto     = CourseDtoFactory::fromRequest($request);
        $payloadArr    = $this->dtoToDbRecArr($courseDto);
        unset($payloadArr['uuid']);
        unset($payloadArr['subject_arr']);
        unset($payloadArr['creator_arr']);
        return $this->courseRepository->create($payloadArr);
    }



    public function prepareCourseDurationText(string $hours, string $minutes) : string {
        $duration  = (!$hours)?'0 Hours : ':(($hours ==1)?'1 Hour : ':$hours.' Hours : ');
        $duration .= (!$minutes)?'0 Minutes':(($minutes ==1)?'1 Minute':$minutes.' Minutes');
        return $duration;
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

        $defaultAuthorSharePercentage   =   CourseModel::AUTHOR_SHARE_PERCENTAGE_DEFAULT ?? 60.00;

        $request->merge([
            'name'                    => $request->get('course-name'),
            'subject_id'              => $request->get('subject'),
            'creator_id'              => $request->get('teacher'),
            'heading_text'            => $request->get('course-heading'),
            'description'             => $request->get('course-description'),
            'duration'                => $duration,
            'video_count'             => $request->get('video-count'),
            'author_share_percentage' => ($request->get('course-price') == 0) ? $defaultAuthorSharePercentage : $request->get('author_share_percentage'),
            'price'                   => $request->get('course-price'),
            'status'                  => ($request->get('course_stat') == CourseModel::PUBLISHED) ? CourseModel::PUBLISHED : CourseModel::DRAFT,
            'image'                   => $imgDest,
            'topics'                  => $request->input('topicsString'),
            'content'                 => $request->input('contentString'),
            'slug'                    => UrlUtil::generateCourseShortUrl($request->get('course-name'))
        ]);

        $courseDto     = CourseDtoFactory::fromRequest($request);
        $payloadArr    = $this->dtoToDbRecArr($courseDto);
        unset($payloadArr['id']);
        unset($payloadArr['uuid']);
        unset($payloadArr['subject_arr']);
        unset($payloadArr['creator_arr']);
        unset($payloadArr['slug']);
        return $this->courseRepository->update($coursrRecId, $payloadArr);
    }


    public function entityToDbRecArr(CourseEntity $course) : array {
        $courseEntityArr   = $course->toArray();
        $payloadArr         = CourseMapper::entityConvertToDbArr($courseEntityArr);
        return $payloadArr;
    }

    public function dtoToDbRecArr(CourseDto $courseDto) : array {
        $courseEntity   = (new CourseFactory())->createObjTree($courseDto->toArray());
        $payloadArr     = $this->entityToDbRecArr($courseEntity);
        return $payloadArr;
    }

}
