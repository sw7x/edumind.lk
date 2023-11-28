<?php
namespace App\DataTransferObjects;

use App\DataTransferObjects\RoleDto;
use App\DataTransferObjects\AbstractDto;


class UserDto extends AbstractDto{

    //public read only
    private   string   $fullName;
    private   string   $email;
    private   string   $phone;
    private   string   $username;
    private   bool     $status;    
    
    private   ?int     $id;
    //private   ?string  $uuid;
    private   ?string  $profilePic;
    private   ?string  $gender;
    private   ?int     $dobYear;
    private   ?string  $profileText;
    private   ?string  $eduQualifications;
    private   ?bool    $isActivated;
    private   array    $cartItems;

    private   ?RoleDto $roleDto;


    public function __construct(        
        string   $fullName,
        string   $email,
        string   $phone,
        string   $username,
        bool     $status,        
        
        ?int     $id                = null,
        //?string  $uuid              = null,
        ?string  $profilePic        = null,
        ?string  $gender            = null,
        ?int     $dobYear           = null,
        ?string  $profileText       = null,
        ?string  $eduQualifications = null,
        ?bool    $isActivated       = null,
        array    $cartItems         = [],

        ?RoleDto $roleDto           = null
    ) {        
        $this->fullName             = $fullName;
        $this->email                = $email;     
        $this->phone                = $phone;
        $this->username             = $username;
        $this->status               = $status;     
        
        $this->id                   = $id;
        //$this->uuid                 = $uuid;
        $this->profilePic           = $profilePic;
        $this->gender               = $gender;
        $this->dobYear              = $dobYear;        
        $this->profileText          = $profileText;     
        $this->eduQualifications    = $eduQualifications;
        $this->isActivated          = $isActivated;
        $this->cartItems           = $cartItems;
        
        $this->roleDto              = $roleDto;
    }
    

    public function getId() : ?int {
        return $this->id;
    }
    
    /*public function getUuid() : ?string {
        return $this->uuid;
    }*/

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

    public function getGender() : ?string {
        return $this->gender;
    }
        
    public function getStatus() : bool {
        return $this->status;
    }
    
    public function getDobYear() : ?int {
        return $this->dobYear;
    }
        
    public function getEduQualifications() : ?string {
        return $this->eduQualifications;
    }

    public function getProfileText() : ?string {
        return $this->profileText;
    }    

    public function getIsActivated() : ?bool {
        return $this->isActivated;
    }    

    public function getCartItems() : array {
        return $this->cartItems;
    }

    public function getRoleDto() : ?RoleDto {
        return $this->roleDto;
    }


    public function toArray() : array {

        $cartItemsArr = [];
        if(!empty($this->cartItems)){
            foreach ($this->cartItems as $cartItem) {
                $cartItemsArr[] = $cartItem->toArray();
            }
        }

        return [
            'id'                => $this->id,
            //'uuid'              => $this->uuid,
            'fullName'          => $this->fullName,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'username'          => $this->username,
            'profilePic'        => $this->profilePic,          
            'gender'            => $this->gender,
            'status'            => $this->status,
            'dobYear'           => $this->dobYear,
            'profileText'       => $this->profileText,
            'eduQualifications' => $this->eduQualifications,
            'isActivated'       => $this->isActivated,
            'cartItemsArr'      => $cartItemsArr,

            'roleArr'           => $this->roleDto ? $this->roleDto->toArray() : null,
            'roleId'            => $this->roleDto ? $this->roleDto->getId() : null,
        ];
    }
}