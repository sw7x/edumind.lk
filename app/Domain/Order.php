<?php


namespace App\Domain;



class Order{
	public $name;
	public function __construct($name) {
		$this->name = $name;
	}
}


