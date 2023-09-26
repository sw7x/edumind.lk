<?php


namespace App\Domain\Users;



use App\Domain\AbstractUser as AbstractUserEntity;
use App\Domain\Users\User as UserEntity;



class TeacherUser extends UserEntity {
    
    private int     $dobYear;
    private ?string $eduQualifications;
    
    public function __construct(        
        string $fullName,
        string $email,
        string $phone,
        string $username,
        bool   $status,
        int    $dobYear
    ){        
        parent::__construct(
            $fullName,
            $email,
            $phone,
            $username,
            $status
        );
        $this->dobYear = $dobYear;
    }


    public function getDobYear() : int {
        return $this->dobYear;
    }

    public function getEduQualifications() : ?string {
        return $this->eduQualifications;
    }
    



    public function setDobYear(int $dobYear) : void {
        $this->dobYear = $dobYear;
    }

    public function setEduQualifications(string $eduQualifications) : void {
        $this->eduQualifications = $eduQualifications;
    }





    public function toArray() : array {
        return [
            'id'                => $this->id,
            'uuid'              => $this->uuid,
            'fullName'          => $this->fullName,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'username'          => $this->username,
            'profilePic'        => $this->profilePic,
            'eduQualifications' => $this->eduQualifications ?? null,
            'gender'            => $this->gender,
            'dobYear'           => $this->dobYear,
            'status'            => $this->status,
            'isActivated'       => $this->isActivated,
            
            'roleArr'           => $this->role ? $this->role->toArray() : null,
            'roleId'            => $this->role ? $this->role->getId()   : null,
        ];
    }

}



/*public function getCourseCount(){

    $userRole = $this->roles()->first()->slug;

    if($userRole == RoleModel::TEACHER){
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