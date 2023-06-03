<?php

use App\Dto\CourseDto;
use Illuminate\Http\Request;

class CourseDto
{
    public $id;
    public $name;
    public $description;
    public $image;
    public $headingText;
    public $topics;
    public $content;
    public $slug;
    public $authorSharePercentage;
    public $price;
    public $videoCount;
    public $duration;
    public $status;

    public function __construct(
        $id,
        $name,
        $description,
        $image,
        $headingText,
        $topics,
        $content,
        $slug,
        $authorSharePercentage,
        $price,
        $videoCount,
        $duration,
        $status
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
        $this->headingText = $headingText;
        $this->topics = $topics;
        $this->content = $content;
        $this->slug = $slug;
        $this->authorSharePercentage = $authorSharePercentage;
        $this->price = $price;
        $this->videoCount = $videoCount;
        $this->duration = $duration;
        $this->status = $status;
    }

    /*public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getHeadingText()
    {
        return $this->headingText;
    }

    public function getTopics()
    {
        return $this->topics;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getAuthorSharePercentage()
    {
        return $this->authorSharePercentage;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getVideoCount()
    {
        return $this->videoCount;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getStatus()
    {
        return $this->status;
    }*/



    // Transformation method
    public function toArray()
    {
        return [
			'id' 					=> $this->id,
			'name' 					=> $this->name,
			'description' 			=> $this->description,
			'image' 				=> $this->image,
			'headingText' 			=> $this->headingText,
			'topics' 				=> $this->topics,
			'content' 				=> $this->content,
			'slug' 					=> $this->slug,
			'authorSharePercentage' => $this->authorSharePercentage,
			'price' 				=> $this->price,
			'videoCount' 			=> $this->videoCount,
			'duration' 				=> $this->duration,
			'status' 				=> $this->status,
            // ... convert other attributes to array
        ];
    }

    
    // Serialization method (JSON example)
    public function toJson()
    {
        return json_encode($this->toArray());
    }




    public static function fromAppRequest(Request $request)
    {
    	return new self(
	    	'id' 					: $request->validated($this->id),
			'name' 					: $request->validated($this->name),
			'description' 			: $request->validated($this->description),
			'image' 				: $request->validated($this->image),
			'headingText' 			: $request->validated($this->headingText),
			'topics' 				: $request->validated($this->topics),
			'content' 				: $request->validated($this->content),
			'slug' 					: $request->validated($this->slug),
			'authorSharePercentage' : $request->validated($this->authorSharePercentage),
			'price' 				: $request->validated($this->price),
			'videoCount' 			: $request->validated($this->videoCount),
			'duration' 				: $request->validated($this->duration),
			'status' 				: $request->validated($this->status),
	    );
    }    

    public static function fromApiRequest(Request $request)
    {
    	// code...
    }
}
