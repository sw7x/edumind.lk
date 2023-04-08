<?php


namespace App\Domain;



class CartItem{
	public $name;
	public function __construct($name) {
		$this->name = $name;
	}
}



id 
cart_add_date 
//is_checkout = false
course_id ==> FK
student_id ==> FK
//deleted_at 