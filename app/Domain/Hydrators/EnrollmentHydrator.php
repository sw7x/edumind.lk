<?php

namespace App\Domain\Hydrators;

use Ramsey\Uuid\Uuid;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\Hydrators\IHydrator;
use App\Domain\IEntity;
use App\Domain\ValueObjects\DateTimeVO;
use \DateTime;

use App\Domain\AbstractEnrollment as AbstractEnrollmentEntity;
use App\Domain\Enrollments\FreeEnrollment as FreeEnrollmentEntity;
use App\Domain\Enrollments\PaidEnrollment as PaidEnrollmentEntity;


//class EnrollmentFactory {
class EnrollmentHydrator implements IHydrator {
    

    public static function hydrateData(array $enrollmentData, ?IEntity $enrollmentEntity = null): AbstractEnrollmentEntity {

        if(is_null($enrollmentEntity)){
            throw new MissingArgumentDomainException("Missing parameter: Entity is required.");
        }
        
        if(!$enrollmentEntity instanceof AbstractEnrollmentEntity){
            throw new InvalidArgumentDomainException("provided object must be instance of FreeEnrollmentEntity or  PaidEnrollmentEntity class");
        }

        if (!isset($enrollmentData['id']) || $enrollmentData['id'] == null) {
            $enrollmentData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($enrollmentData['uuid']) && $enrollmentEntity->getUuid() === null) {
            $enrollmentEntity->setUuid($enrollmentData['uuid']);
        }

        if (isset($enrollmentData['id']) && $enrollmentEntity->getId() === null) {
            $enrollmentEntity->setId($enrollmentData['id']);
        }


        if (isset($enrollmentData['is_complete'])) {
            $enrollmentEntity->setIsComplete($enrollmentData['is_complete']);
        }


        if (isset($enrollmentData['complete_date'])) {
            $enrollmentEntity->setCompleteDate(
                new DateTimeVO(
                    new DateTime($enrollmentData['complete_date'])    
                )
            );
        }


        if (isset($enrollmentData['rating'])) {
            $enrollmentEntity->setRating($enrollmentData['rating']);
        }        

        if (isset($enrollmentData['course_messages'])) {
            $enrollmentEntity->setCourseMessages([]);
        }

        return $enrollmentEntity;
    }

}
