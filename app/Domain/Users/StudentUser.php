<?php


namespace App\Domain\Users;

use App\Domain\AbstractUser as AbstractUserEntity;
use App\Domain\Users\User as UserEntity;
use App\Domain\Cart as CartEntity;



use App\Domain\Exceptions\DomainException;





class StudentUser extends UserEntity {
	
	private int     $dobYear;
	private ?string $profileText;
    
    /* composition */
    private CartEntity $cart;


    public function __construct(        
        string  $fullName,
        string  $email,
        string  $phone,
        string  $username,
        bool    $status,

        int     $dobYear,
        ?string $profileText = null       
    ){        
        parent::__construct(
            $fullName,
            $email,
            $phone,
            $username,
            $status
        );
        $this->dobYear      = $dobYear;
        $this->profileText  = $profileText;
        $this->cart         = new CartEntity();
    }
    
    //GETTERS
    public function getDobYear() : int {
        return $this->dobYear;
    }
    
    public function getProfileText() : ?string {
        return $this->profileText;
    }

    public function getCart() : CartEntity {
        return $this->cart;
    }


    //SETTERS
    public function setDobYear(int $dobYear) : void {
        $this->dobYear = $dobYear;
    }

    public function setProfileText(string $profileText) : void {
        $this->profileText = $profileText;
    }



    //TO ARRAY METHOD
    public function toArray() : array {
        return [
            'id'            => $this->id,
            'uuid'          => $this->uuid,
            'fullName'      => $this->fullName,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'username'      => $this->username,
            'profilePic'    => $this->profilePic,            
            'gender'        => $this->gender,
            'dobYear'       => $this->dobYear,
            'profileText'   => $this->profileText,
            'status'        => $this->status,
            'isActivated'   => $this->isActivated,
            
            'roleArr'       => $this->role ? $this->role->toArray() : null,
            'roleId'        => $this->role ? $this->role->getId()   : null,

            'cartArr'       => $this->cart ? $this->cart->toArray() : null,
        ];
    }


    


    public function addToCart(CourseItem $courseItem) : void {
        $this->cart->addToCart($courseItem);
    }
    
    /* @return CourseItemEntity[] */
    public function getCartItems() : array {
        return $this->cart->getAllCourseItems();
    }


    //----- error --------
    public function freeCourseEnroll(CourseItem $courseItem) : Enrollment {
        $course = $courseItem->getCourse();        
        if($course->getPrice())
            throw new DomainException('Course is not free one');
        
        $enrollment = new Enrollment($courseItem,$this);        
        return $enrollment;
    }

    public function checkoutCart() : void {
        $this->cart->checkout($this);
    }


}
