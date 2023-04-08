<?php


namespace App\Services;


use App\Repositories\ContactUsRepository;

class ContactUsService
{
    private $contactUsRepository;
    
    public function __construct(ContactUsRepository $contactUsRepository) {
        $this->contactUsRepository = $contactUsRepository;
    }

    

    public function add($contactInfoArr){       
        $insertedResult = $this->contactUsRepository->add($contactInfoArr);

        if(!$insertedResult){
            throw new \PDOException('Failed to insert into database',500);
        }        
    }



   

    //sumit msg


    // view contact us messages - guest
    // view contact us messages - stud
    // view contact us messages - teacher
    // view contact us messages - other
}














