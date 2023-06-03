<?php


namespace App\Domain;



class Role{
	private $id;
	private $uuid;
	private $name;	
	private $slug;

	/*
	public function __construct($name) {
		$this->name = $name;
	}
	*/

	public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

	public function getUuid(){
        return $this->uuid;
    }

    public function setUuid($uuid){
        $this->uuid = $uuid;
    }



	public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getSlug(){
        return $this->slug;
    }

    public function setSlug($slug){
        $this->slug = $slug;
    }

    // toArray method
    public function toArray()
    {
        return [
            'id' 		=> $this->id,
            'uuid' 		=> $this->uuid,
            'name' 		=> $this->name,
 			'slug' 		=> $this->slug,         
        ];
    }
}





created_at
updated_at 