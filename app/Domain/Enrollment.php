<?php


namespace App\Domain;



class Enrollment{
	public $name;
	public function __construct($name) {
		$this->name = $name;
	}
}



id 
cart_added_date 
//is_checkout = true
course_id ==> FK
student_id ==> FK
//deleted_at 