<?php
namespace App\Domain;
use App\Domain\Entity;
use App\Domain\Role as RoleEntity;

abstract class AbstractUser extends Entity{
    
    protected ?int      $id   = null;
    protected ?string   $uuid = null;
    
    protected string    $fullName;
    protected string    $email;
    protected string    $phone;
    protected string    $username;
    protected bool      $status;
    
    protected ?string   $profilePic = null;
    protected ?string   $gender     = null;

    

    /* associations */
    protected ?RoleEntity $role = null;


    public function __construct(        
        string $fullName,
        string $email,
        string $phone,
        string $username,
        bool   $status
    ){        
        $this->fullName = $fullName;
        $this->email    = $email;
        $this->phone    = $phone;
        $this->username = $username;     
        $this->status   = $status;
    }
	

    //GETTERS
    public function getId() : ?int {
        return $this->id;
    }

    public function getUuid() : ?string {
        return $this->uuid;
    }
    
    public function getFullName() : string {
        return $this->fullName;
    }

    public function getEmail() : string {
        return $this->email;
    }
    
    public function getPhone() : string {
        return $this->phone;
    }
    
    public function getUsername() : string {
        return $this->username;
    }

    public function getProfilePic() : ?string {
        return $this->profilePic;
    }

    public function getGender() : ?string{
        return $this->gender;
    }

    public function getStatus() : bool {
        return $this->status;
    }


    public function getRole() : ?RoleEntity {
        return $this->role;
    }

    


    
    //SETTERS
    public function setId(int $id) : void {
        $this->id = $id;
    }
    public function setUuid(string $uuid) : void {
        $this->uuid = $uuid;
    }

    public function setProfilePic(string $profilePic) : void {
        $this->profilePic = $profilePic;
    }

    public function setGender(string $gender) : void {
        $this->gender = $gender;
    }

    public function setRole(RoleEntity $role) : void {
        $this->role = $role;
    }

    

    // toArray method
    abstract public function toArray() : array;



    

    public function approve() : void {
        $this->status = true;
    }    

    public function unApprove() : void {
        $this->status = false;
    }



    
}



