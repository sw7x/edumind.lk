<?php

namespace App\Services\Admin;

use App\Models\Subject as SubjectModel;
use App\Repositories\SubjectRepository;
use App\Mappers\SubjectMapper;
use App\Builders\SubjectBuilder;
use App\Domain\Factories\SubjectFactory;
use App\DataTransferObjects\Factories\SubjectDtoFactory;
use Illuminate\Http\Request;
use App\Common\Utils\FileUploadUtil;
use App\Common\Utils\UrlUtil;
use Sentinel;
use App\Exceptions\CustomException;
use App\DataTransformers\Database\SubjectDataTransformer;
//use App\Domain\Subject as SubjectEntity;
//use App\DataTransferObjects\SubjectDto;
//use Illuminate\Database\Eloquent\Collection;
//use App\Mappers\UserMapper;
//use App\Builders\CourseBuilder;
//use App\Repositories\UserRepository;


class SubjectService
{

    private SubjectRepository $subjectRepository;

    function __construct(SubjectRepository $subjectRepository){
        $this->subjectRepository        = $subjectRepository;
    }

    public function loadAllDbRecs() : array {
        $allRecs = $this->subjectRepository->all();

        $dataArr = array();
        $allRecs->each(function (SubjectModel $record, int $key) use (&$dataArr){
            $subjectDto     =   SubjectDataTransformer::buildDto($record->toArray());
            $dataArr[]      =   array(
                                    'data'  => SubjectDataTransformer::buildDto($record->toArray()),
                                    'dbRec' => $record
                                );
        });
        return $dataArr;
    }

    public function loadAllAvailableSubjects() : array {
        $allRecs = $this->subjectRepository->allWithGlobalScope();

        $dataArr = array();
        $allRecs->each(function (SubjectModel $record, int $key) use (&$dataArr){
            $subjectDto     =   SubjectDataTransformer::buildDto($record->toArray());
            $dataArr[]      =   array(
                                    'data'  => SubjectDataTransformer::buildDto($record->toArray()),
                                    'dbRec' => $record
                                );
        });
        return $dataArr;
    }


    public function saveDbRec(Request $request) : SubjectModel {
        $subjectCount = $this->subjectRepository->findByName($request->get('name'))->count();

        if ($subjectCount > 0)
            throw new CustomException('Subject name already exists!');

        $file       = $request->input('image');
        $imgDest    = (isset($file)) ? FileUploadUtil::upload($file,'subjects/') : null;

        $urlString  = UrlUtil::wordsToUrl($request->name,15);
        $slug       = UrlUtil::generateSubjectUrl($urlString);

        $request->merge([
            "creator_id" => Sentinel::getUser()->id,
            'slug'       => $slug,
            'image'      => $imgDest
        ]);

        $subjectDto         = SubjectDtoFactory::fromRequest($request);
        $subjectEntity      = (new SubjectFactory())->createObjTree($subjectDto->toArray());
        $subjectEntityArr   = $subjectEntity->toArray();
        $payloadArr         = SubjectMapper::entityConvertToDbArr($subjectEntityArr);
        unset($payloadArr['creator_arr']);
        return $this->subjectRepository->create($payloadArr);
    }


    public function updateDbRec(Request $request, SubjectModel $subjectDbRec) : bool {

        $subjectName    =   $request->get('name');
        $subjectRecId   =   $subjectDbRec->id;
        $isNameExists   =   $this->subjectRepository->findDuplicateCountByName($subjectName, $subjectRecId);
        if($isNameExists)
            throw new CustomException('Subject name already exists!');

        /* image upload */
        $file   =   $request->input('image');
        if(!isset($file)){
            // remove image and submit update
            $imgDest    =   null;
        }else{
            /*  input filed hidden_file_add_count value equals 0 when initially filpond loads image
                it means no change to previously upload image and submit edit form    */
            if( $request->hidden_file_add_count == 0){
                $defaultImgPath =   asset('images/default-images/subject.png');
                $imgUrl         =   $request->hidden_subject_img_url;

                if($imgUrl == $defaultImgPath){
                    $imgDest    =   null;
                }else{
                    $imgDest    =   str_replace(asset('storage'), '/', $imgUrl);
                    $imgDest    =   ltrim($imgDest, '/');
                }

            }else{
                // previously image is uploaded and now change the image and upload
                //todo delete prviously uploaded image
                $imgDest        =   FileUploadUtil::upload($file,'subjects/');
            }
        }

        $request->merge(['image'      => $imgDest]);

        $subjectDto         = SubjectDtoFactory::fromRequest($request);
        $subjectEntity      = (new SubjectFactory())->createObjTree($subjectDto->toArray());
        $subjectEntityArr   = $subjectEntity->toArray();
        $payloadArr         = SubjectMapper::entityConvertToDbArr($subjectEntityArr);
        unset($payloadArr['id']);
        unset($payloadArr['uuid']);
        unset($payloadArr['slug']);
        unset($payloadArr['author_id']);
        //return $subjectDbRec->update($payloadArr);
        return $this->subjectRepository->update($subjectRecId, $payloadArr);

    }


    public function deleteDbRec(SubjectModel $subjectDbRec) : bool {
        //return $subjectDbRec->delete();
        return $this->subjectRepository->deleteById($subjectDbRec->id);
        //todo delete image also
    }

    public function findDbRec(int $id) : ?array {
        $dbRec  =   $this->subjectRepository->findById($id);
        $dto    =   $dbRec ? SubjectDataTransformer::buildDto($dbRec->toArray()) : null;
        $entity =   $dbRec ? SubjectDataTransformer::buildEntity($dbRec->toArray()) : null;

        return array(
            'dbRec' => $dbRec,
            'dto'   => $dto
        );
    }





    /*
    public function entityToDbRecArr(SubjectEntity $subject) : array {
        $subjectEntityArr   = $subject->toArray();
        $payloadArr         = SubjectMapper::entityConvertToDbArr($subjectEntityArr);
        unset($payloadArr['creator_arr']);
        return $payloadArr;
    }

    public function dtoToDbRecArr(SubjectDto $subjectDto) : array {
        $subjectEntity  = (new SubjectFactory())->createObjTree($subjectDto->toArray());
        $payloadArr     = $this->entityToDbRecArr($subjectEntity);
        return $payloadArr;
    }
    */


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







