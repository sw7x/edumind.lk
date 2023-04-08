<?php


namespace App\Repositories;
use App\Models\Contact_us;

class ContactUsRepository
{
    

    public function add($contactInfoArr){
        return Contact_us::create($contactInfoArr);         
    }


}
