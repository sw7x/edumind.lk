<?php


namespace App\Domain;



class Subject{

	private $id;
	private $uuid;
	private $name;
	private $description
	private $image
	private $slug
	private $status

    /* associations */
    protected Teacher $author;
	
	public function getAuthor(){
        return $this->author;
    }

    public function setAuthor(Teacher $author){
        $this->author = $author;
    }


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

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function getImage(){
        return $this->image;
    }

    public function setImage($image){
        $this->image = $image;
    }

    public function getSlug(){
        return $this->slug;
    }

    public function setSlug($slug){
        $this->slug = $slug;
    }

    public function getStatus(){
        return $this->status;
    }

    public function setStatus($status){
        $this->status = $status;
    }

    public function toArray()
    {
        return [
            'id' 			=> $this->id,
            'uuid' 			=> $this->uuid;
            'name' 			=> $this->name,
            'description' 	=> $this->description,
            'image' 		=> $this->image,           
            'slug' 			=> $this->slug,           
            'status' 		=> $this->status,
            
            'author' 		=> $this->author->toArray()
        ];
    }
}









