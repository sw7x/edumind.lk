<?php


namespace App\Domain\Hydrators;

use Ramsey\Uuid\Uuid;

use App\Domain\Subject as SubjectEntity;

use App\Domain\Hydrators\IHydrator;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\IEntity;


//class SubjectHydrator {
class SubjectHydrator implements IHydrator {
    
    public static function hydrateData(array $subjectData, ?IEntity $subjectEntity = null): SubjectEntity {
        if(is_null($subjectEntity)){
            throw new MissingArgumentDomainException("Missing parameter: SubjectEntity is required.");
        }        

        if(!$subjectEntity instanceof SubjectEntity){
            throw new InvalidArgumentDomainException("provided object must be instance of SubjectEntity class");
        }

        if (!isset($subjectData['id']) || $subjectData['id'] == null) {
            $subjectData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($subjectData['uuid']) && $subjectEntity->getUuid() === null) {
            $subjectEntity->setUuid($subjectData['uuid']);
        }        

        if (isset($subjectData['id']) && $subjectEntity->getId() === null) {
            $subjectEntity->setId($subjectData['id']);
        }

        if (isset($subjectData['description'])) {
            $subjectEntity->setDescription($subjectData['description']);
        }

        if (isset($subjectData['image'])) {
            $subjectEntity->setImage($subjectData['image']);
        }

        if (isset($subjectData['slug'])) {
            $subjectEntity->setSlug($subjectData['slug']);
        }

        if (isset($subjectData['status'])) {
            $subjectEntity->setStatus($subjectData['status']);
        }

        return $subjectEntity;
    }

}
