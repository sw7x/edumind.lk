<?php


namespace App\Domain\User;



use App\Domain\User;




class Teacher extends User {

}



public function getCourseCount(){

    $userRole = $this->roles()->first()->slug;

    if($userRole == Role::TEACHER){
        return($this->getTeachingCourses()->where('status', Course::PUBLISHED)->count());
    }else{
        return null;
    }
    //dump($this->roles()->first()->slug);
}


public function isCourseAuthor(Course $course){
    return ($this->id == $course->teacher->id);  
} 



public function isSubjectCreator(Subject $subject){        
        //dd(static::id);
        return ($this->id == $subject->creator->id);        
    }