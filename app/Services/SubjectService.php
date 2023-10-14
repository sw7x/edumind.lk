<?php
namespace App\Services;

use App\Models\Subject as SubjectModel;
use App\Models\Course as CourseModel;

use App\Repositories\SubjectRepository;

use Sentinel;
use App\Exceptions\CustomException;
use App\Utils\ColorUtil;


/*
use App\Repositories\UserRepository;
use App\Repositories\CourseRepository;

use App\Mappers\SubjectMapper;
use App\Mappers\UserMapper;
use App\Mappers\CourseMapper;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Utils\FileUploadUtil;
use App\Utils\UrlUtil;

use App\Domain\Subject as SubjectEntity;

use App\DataTransferObjects\SubjectDto;
use App\DataTransferObjects\Factories\CourseDtoFactory;
use App\DataTransferObjects\Factories\SubjectDtoFactory;
use App\Domain\Factories\SubjectFactory;
use App\Domain\Factories\CourseFactory;
*/

use App\DataTransformers\Database\CourseDataTransformer;
use App\DataTransformers\Database\SubjectDataTransformer;

class SubjectService
{

    private $subjectRepository;

    function __construct(SubjectRepository $subjectRepository){
        $this->subjectRepository = $subjectRepository;
    }




    public function loadAllSubjects() : array {
        $allRecs = $this->subjectRepository->allWithGlobalScope();

        $dataArr = array();
        $allRecs->each(function (SubjectModel $record, int $key) use (&$dataArr){
            $dataArr[] = SubjectDataTransformer::buildDto($record->toArray());
        });
        return $dataArr;
    }


    public function loadSubjectDataByUrl(string $url) : array {
        $subjectRec    = SubjectModel::where('slug', $url)->first();
        if(!$subjectRec)
            abort(404,'Subject does not exist or disabled');

        $subjectCourses = SubjectModel::where('slug', $url)->first()->courses;

        $subjectDto     = SubjectDataTransformer::buildDto($subjectRec->toArray());

        $coursesDtoArr  = array();
        $subjectCourses->each(function (CourseModel $record, int $key) use (&$coursesDtoArr){
            $coursesDtoArr[] = CourseDataTransformer::buildDto($record->toArray());
        });

        $bannerColors = ColorUtil::generateBannerColors($subjectRec->image);

        return array(
            'dto'              => $subjectDto,
            'dbRec'            => $subjectRec,
            'coursesDtoArr'    => $coursesDtoArr,
            'bgColor'          => $bannerColors['bgColor'],
            'txtColor'         => $bannerColors['txtColor']
        );
    }


    public function findDbRec(int $id) : ?array {
        $dbRec  =   $this->subjectRepository->findById($id);
        $dto    =   $dbRec ? SubjectDataTransformer::buildDto($dbRec->toArray()) : null;

        return array(
            'dbRec' => $dbRec,
            'dto'   => $dto
        );
    }













}





//service only methods - not in entity
    //loadPopularSubjects()
    //view all subjects
    //add
    //edit
    //delete
    //viewSingle
    //view subject all courses
    //view subject course count



