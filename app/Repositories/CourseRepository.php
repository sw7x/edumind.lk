<?php


namespace App\Repositories;



//subject_id 	
//teacher_id	







//created_at
//updated_at 	
//deleted_at 




class CourseRepository
{
    
	private function hydrateCourseData(array $courseData, Course $course = null)
    {
    	if ($course == null) {
    		$course = new Course();
    	}

    	if (!isset($courseData['id']) || $courseData['id'] == null) {
    		$courseData['uuid'] = str_replace('-', '', UUID::v4());
    	}

    	if (isset($courseData['uuid'])) {
    		$course->setUuid($courseData['uuid']);
    	}

    	
        if (isset($courseData['id'])) {
    		$course->setId($courseData['id']);
    	}

        if (!isset($courseData['id']) || $courseData['id'] == null) {
            $course['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($courseData['uuid'])) {
            $course->setUuid($courseData['uuid']);
        }
        
        if (isset($courseData['name'])) {
    		$course->setName($courseData['name']);
    	}

    	if (isset($courseData['description'])) {
    		$course->setDescription($courseData['description']);
    	}

    	if (isset($courseData['image'])) {
    		$course->setImage($courseData['image']);
    	}

    	if (isset($courseData['status'])) {
    		$course->setStatus($courseData['status']);
    	}

    	if (isset($courseData['headingText'])) {
    		$course->setHeadingText($courseData['headingText']);
    	}        

    	if (isset($courseData['topics'])) {
    		$course->setTopics($courseData['topics']);
    	}        

    	if (isset($courseData['content'])) {
    		$course->setContent($courseData['content']);
    	}        

    	if (isset($courseData['slug'])) {
    		$course->setSlug($courseData['slug']);
    	}        

    	if (isset($courseData['setAuthorSharePercentage'])) {
    		$course->setAuthorSharePercentage($courseData['setAuthorSharePercentage']);
    	}        

    	if (isset($courseData['price'])) {
    		$course->setPrice($courseData['price']);
    	}

    	if (isset($courseData['videoCount'])) {
    		$course->setVideoCount($courseData['videoCount']);
    	}        

    	if (isset($courseData['duration'])) {
    		$course->setDuration($courseData['duration']);
    	}

    	return $course;
    }


}
