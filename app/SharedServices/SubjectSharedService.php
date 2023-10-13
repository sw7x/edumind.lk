<?php

namespace App\SharedServices;

use App\Mappers\SubjectMapper;
use App\Domain\Factories\SubjectFactory;
use App\DataTransferObjects\SubjectDto;
use App\Exceptions\CustomException;
use App\Domain\Subject as SubjectEntity;


class SubjectSharedService
{

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
    
}

