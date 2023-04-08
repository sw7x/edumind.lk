<?php


namespace App\Domain;



class Subject{
	public $name;
	public function __construct($name) {
		$this->name = $name;
	}
}



id
name
description
image
slug
status
author_id  ==> FK

created_at 
updated_at 
//deleted_at