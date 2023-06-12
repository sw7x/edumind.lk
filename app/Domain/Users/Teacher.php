<?php


namespace App\Domain\Users;



use App\Domain\AbstractUser;




class Teacher extends AbstractUser {
    private $dobYear;
    private $eduQualifications;
    
    public function __construct(        
        $fullName,
        $email,
        $phone,
        $username,
        $status,
        $dobYear,
    ) {        
        parent::__construct(
            $fullName,
            $email,
            $phone,
            $username,
            $status
        );
        $this->dobYear = $dobYear;
    }


    /public function getDobYear()
    {
        return $this->dobYear;
    }

    public function setDobYear($dobYear)
    {
        $this->dobYear = $dobYear;
    }

    
    public function getEduQualifications()
    {
        return $this->eduQualifications;
    }

    public function setEduQualifications($eduQualifications)
    {
        $this->eduQualifications = $eduQualifications;
    }

    public function toArray(){
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'fullName' => $this->fullName,
            'email' => $this->email,
            'phone' => $this->phone,
            'username' => $this->username,
            'profilePic' => $this->profilePic,
            'eduQualifications' => $this->eduQualifications,
            'gender' => $this->gender,
            'dobYear' => $this->dobYear,
            'status' => $this->status,
        ];
    }

}



/*public function getCourseCount(){

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
}*/