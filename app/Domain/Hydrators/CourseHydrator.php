<?php

namespace App\Domain\Hydrators;

use Ramsey\Uuid\Uuid;

use App\Domain\Course as CourseEntity;


//use App\Domain\Hydrators\UserFactory;
//use App\Domain\Hydrators\SubjectFactory;

use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;

use App\Domain\Hydrators\IHydrator;
use App\Domain\IEntity;

use App\Domain\ValueObjects\PercentageVO;

//class CourseFactory
class CourseHydrator implements IHydrator {

    public static function hydrateData(array $courseData, ?IEntity $courseEntity = null): CourseEntity {

        if(is_null($courseEntity)){
            throw new MissingArgumentDomainException("Missing parameter: CourseEntity is required.");
        }

        if(!$courseEntity instanceof  CourseEntity){
            throw new InvalidArgumentDomainException("provided object must be instance of CourseEntity class");
        }

        if (!isset($courseData['id']) || $courseData['id'] == null) {
            $courseData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($courseData['uuid']) && $courseEntity->getUuid() === null) {
            $courseEntity->setUuid($courseData['uuid']);
        }

        if (isset($courseData['id']) && $courseEntity->getId() === null) {
            $courseEntity->setId($courseData['id']);
        }
        
        if (isset($courseData['description'])) {
            $courseEntity->setDescription($courseData['description']);
        }

        if (isset($courseData['image'])) {
            $courseEntity->setImage($courseData['image']);
        }

        if (isset($courseData['status'])) {
            $courseEntity->setStatus($courseData['status']);
        }

        if (isset($courseData['heading_text'])) {
            $courseEntity->setHeadingText($courseData['heading_text']);
        }        

        if (isset($courseData['topics'])) {
            $courseEntity->setTopics($courseData['topics']);
        }        

        if (isset($courseData['content'])) {
            $courseEntity->setContent($courseData['content']);
        }        

        if (isset($courseData['slug'])) {
            $courseEntity->setSlug($courseData['slug']);
        }        

        if (isset($courseData['author_share_percentage'])) {
            $courseEntity->setAuthorSharePercentage(
                new PercentageVO(
                    $courseData['author_share_percentage']
                )
            );
        }        

        if (isset($courseData['video_count'])) {
            $courseEntity->setVideoCount($courseData['video_count']);
        }        

        if (isset($courseData['duration'])) {
            $courseEntity->setDuration($courseData['duration']);
        }

        return $courseEntity;
    }
    
} 