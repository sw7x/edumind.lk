<?php

abstract class AbstractUser
{
    private $id;
    private $uuid;
    private $fullName;
    private $email;
    private $phone;
    private $username;////
    private $profilePic;
    private $gender;  
    private $status;



    public function __construct(        
        $fullName,
        $email,
        $phone,
        $username,
        $status
    ) {        
        $this->fullName = $fullName;
        $this->email = $email;
        $this->phone = $phone;
        $this->username = $username;     
        $this->status = $status;
    }



    /* associations */
    protected Role $role;
	
	public function getRole(){
        return $this->role;
    }

    public function setRole(Role $role){
        $this->role = $role;
    }
   
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    


    public function getFullName()
    {
        return $this->fullName;
    }

    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    public function getEmail()
    {
        return $this->email;
    }

	/*    
	public function setEmail($email)
    {
        $this->email = $email;
    }
    */

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

	public function getUsername()
    {
        return $this->username;
    }
	/*
	public function setUsername($username)
    {
        $this->username = $username;
    }
    */

    public function getProfilePic()
    {
        return $this->profilePic;
    }

    public function setProfilePic($profilePic)
    {
        $this->profilePic = $profilePic;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }
    
    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }



    public function approve(){
        $this->status = TRUE;
    }    

    public function unApprove(){
        $this->status = FALSE;
    }



    abstract public function toArray();
}