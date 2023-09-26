<?php

namespace App\DataTransferObjects;


use App\DataTransferObjects\AbstractDto;

use App\DataTransferObjects\SubjectDto;
use App\DataTransferObjects\UserDto;

//dto have no id

class CourseDto extends AbstractDto{
    

    //public read only 
    private string      $name;
    private float       $price;
    
    private ?int        $id;
    //private ?string   $uuid;
    private ?string     $description;
    private ?string     $image;
    private ?string     $headingText;
    private ?array      $topics;
    private ?array      $content;
    private ?string     $slug;
    private ?float      $authorSharePercentage;
    private ?int        $videoCount;
    private ?string     $duration;
    private ?string     $status;

    private ?SubjectDto $subjectDto;
    private ?UserDto    $authorDto;


    public function __construct(
        string      $name,
        float       $price,
        
        ?int        $id                      = null,
        //?string   $uuid                    = null,
        ?string     $description             = null,
        ?string     $image                   = null,
        ?string     $headingText             = null,
        ?array      $topics                  = null,
        ?array      $content                 = null,
        ?string     $slug                    = null,
        ?float      $author_share_percentage = null,
        ?int        $video_count             = null,
        ?string     $duration                = null,
        ?string     $status                  = null,

        ?SubjectDto $subjectDto              = null,
        ?UserDto    $authorDto               = null
    ) {
        $this->name                          = $name;
        $this->price                         = $price;
        
        $this->id                            = $id;
        //$this->uuid                        = $uuid,
        $this->description                   = $description;
        $this->image                         = $image;
        $this->headingText                   = $headingText;
        $this->topics                        = $topics;
        $this->content                       = $content;
        $this->slug                          = $slug;
        $this->authorSharePercentage         = $author_share_percentage;
        $this->videoCount                    = $video_count;
        $this->duration                      = $duration;
        $this->status                        = $status;  

        $this->subjectDto                    = $subjectDto;
        $this->authorDto                     = $authorDto;
    }



    //GETTERS
    public function getId() : ?int {
        return $this->id;
    }

    public function getName() : string {
        return $this->name;
    }

    public function getDescription() : ?string {
        return $this->description;
    }

    public function getImage() : ?string {
        return $this->image;
    }

    public function getHeadingText() : ?string {
        return $this->headingText;
    }

    public function getTopics() : ?array {
        return $this->topics;
    }

    public function getContent() : ?array {
        return $this->content;
    }

    public function getSlug() : ?string {
        return $this->slug;
    }

    public function getAuthorSharePercentage() : ?float {
        return $this->authorSharePercentage;
    }
    
    public function getEdumindSharePercentage() : ?float {
        return (float)(100 - $this->authorSharePercentage);
    }

    public function getPrice() : float {
        return $this->price;
    }

    public function getVideoCount() : ?int {
        return $this->videoCount;
    }

    public function getDuration() : ?string {
        return $this->duration;
    }

    public function getStatus() : ?string {
        return $this->status;
    }


    public function getSubjectDto() : ?SubjectDto {
        return $this->subjectDto;
    }    

    public function getAuthorDto() : ?UserDto {
        return $this->authorDto;
    }


    // Transformation method
    public function toArray() : array {
        
        return [
			'id' 					  => $this->id,
			'name' 					  => $this->name,
			'description' 			  => $this->description,
			'image' 				  => $this->image,
			'headingText' 			  => $this->headingText,
			'topics' 				  => $this->topics,
			'content' 				  => $this->content,
			'slug' 					  => $this->slug,
			'authorSharePercentage'   => $this->authorSharePercentage,
			'price' 				  => $this->price,
			'videoCount' 			  => $this->videoCount,
			'duration' 				  => $this->duration,
			'status' 				  => $this->status,
            
            'subjectArr'              => $this->subjectDto ? $this->subjectDto->toArray() : null,
            'subjectId'               => $this->subjectDto ? $this->subjectDto->getId() : null,

            'creatorArr'              => $this->authorDto ? $this->authorDto->toArray() : null,
            'creatorId'               => $this->authorDto ? $this->authorDto->getId() : null,
        ];
    }

    /*
    public static function fromAppRequest(Request $request){}
    public static function fromApiRequest(Request $request){}
    */

}









