<?php


namespace App\Domain;



class ContactUsMessage{
	public $name;
	public function __construct($name) {
		$this->name = $name;
	}
}



id 
full_name
email 
phone 
subject
message
user_id ==> FK


created_at 
updated_at
//deleted_at