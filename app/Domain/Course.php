<?php
namespace App\Domain;

use App\Domain\Subject as SubjectEntity;
use App\Domain\Users\User as UserEntity;
use App\Domain\Interfaces\IEntity;
use App\Domain\Entity;
use App\Domain\ValueObjects\PercentageVO;
use App\Domain\ValueObjects\AmountVO;
use App\Domain\Exceptions\AttributeAlreadySetDomainException;
use App\Domain\Exceptions\DomainException;

class Course extends Entity
{

    private ?int           $id                     = null;
    private ?string        $uuid                   = null;
    private string         $name;
    private ?string        $description            = null;
    private ?string        $image                  = null;
    private ?string        $headingText            = null;
    private ?array         $topics                 = null;
    private ?array         $content                = null;
    private ?string        $slug                   = null;
    private ?PercentageVO  $authorSharePercentage  = null;
    private AmountVO       $price;
    private ?int           $videoCount             = null;
    private ?string        $duration               = null;
    private ?string        $status                 = null;    

    

    /* associations */
    private   ?SubjectEntity      $subject       = null;
    //private TeacherUserEntity   $author        = null;
    private   ?UserEntity         $author        = null;
    //private CourseThreadEntity  $courseThread  = null;



    public function __construct(string $name, AmountVO $price){
        $this->name     = $name;
        $this->price    = $price;

    }




    // Getters
    public function getId() : ?int {
        return $this->id;
    }

    public function getUuid() : ?string {
        return $this->uuid;
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

    public function getAuthorSharePercentage() : ?PercentageVO {
        return $this->authorSharePercentage;
    }

    public function getPrice() : AmountVO {
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

    public function getSubject() : ?SubjectEntity {
        return $this->subject;
    } 
    public function getAuthor() : ?UserEntity {
        return $this->author;
    }
    
    /*     
    public function getCourseThread() : ?CourseThreadEntity {
        return $this->courseThread;
    } 
    */




    // Setters
    final public function setId(int $id) : void {
        if ($this->id !== null) {
            throw new AttributeAlreadySetDomainException('id attribute already been set and cannot be changed.');
        }
        $this->id  = $id;
    }
        
    final public function setUuid(string $uuid) : void {
        if ($this->uuid !== null) {
            throw new AttributeAlreadySetDomainException('uuid attribute has already been set and cannot be changed.');
        }
        $this->uuid = $uuid;
    }
    
    public function setDescription(string $description) : void {
        $this->description = $description;
    }
    
    public function setImage(string $image) : void {
        $this->image = $image;
    }
    
    public function setHeadingText(string $headingText) : void {
        $this->headingText = $headingText;
    }
    
    public function setTopics(array $topics) : void {
        $this->topics = $topics;
    }
    
    public function setContent(array $content) : void {
        $this->content = $content;
    }
    
    public function setSlug(string $slug) : void {
        $this->slug = $slug;
    }
    
    public function setAuthorSharePercentage(PercentageVO $authorSharePercentage) : void {
        $this->authorSharePercentage = $authorSharePercentage;
    }
    
    public function setVideoCount(int $videoCount) : void {
        if($videoCount < 0){  throw new DomainException("video Count cannot be negative");  }
        $this->videoCount = $videoCount;
    }
    
    public function setDuration(string $duration) : void {
        $this->duration = $duration;
    }
    
    public function setStatus(string $status) : void {
        $this->status = $status;
    }

    public function setSubject(SubjectEntity $subject) : void {
        $this->subject = $subject;
    }

    public function setAuthor(UserEntity $techer) : void {
    //public function setAuthor(TeacherUserEntity $techer){
        $this->author = $techer;
    } 

    /*     
    public function setCourseThread(CourseThreadEntity $courseThread) : void {
        $this->courseThread = $courseThread;
    }
    */



    // toArray method
    public function toArray() : array {
        return [
            'id'                    => $this->id,
            'uuid'                  => $this->uuid,
            'name'                  => $this->name,
            'description'           => $this->description,
            'image'                 => $this->image,
            'headingText'           => $this->headingText,
            'topics'                => $this->topics,
            'content'               => $this->content,
            'slug'                  => $this->slug,
            'authorSharePercentage' => $this->authorSharePercentage ? $this->authorSharePercentage->getValue() : null,
            'price'                 => $this->price->getValue(),
            'videoCount'            => $this->videoCount,
            'duration'              => $this->duration,
            'status'                => $this->status,
            
            'subjectArr'            => $this->subject ? $this->subject->toArray() : null,
            'subjectId'             => $this->subject ? $this->subject->getId()   : null,

            'creatorArr'             => $this->author  ? $this->author->toArray()  : null,
            'creatorId'              => $this->author  ? $this->author->getId()    : null,
            
            //'courseThreadObj'     => $this->courseThread ? $this->courseThread->toArray() : []
        ];
    }

    


    public function edumindSharePercentage() : PercentageVO {
        return new PercentageVO(100 - $this->authorSharePercentage->getValue());
    }


    public function isEmpty() : bool {       
        //dd($this->topics);
        if(!$this->content){
            return true;
        }else{
            return empty($this->content);
        }        
    }

    
    public function getLinkCount() : int {
        $courseLinkCount = 0;
        foreach($this->content as $arr){
            $courseLinkCount += count($arr);
        }
        return $courseLinkCount;
    }


    public function getVideoSectionId(int $vid) : int {
        //dd($this->content);
        $sectionId = -1;
        $videoId = 0;
        $result = -1;

        foreach($this->content as $val){
            $sectionId++;
            foreach($val as $arr){
                $videoId++;
                if($videoId == $vid){
                    //return $sectionId;
                    $result = $sectionId;
                }
            }
        }

        return $result;
        //dump("vid - {$vid} === section- {$result}");
    }

    /* 
    public function getLastUpdatedTime(){
        return Carbon::parse($this->updated_at)->diffForHumans();
    }

    public function getCreatedTime(){
        return Carbon::parse($this->created_at)->diffForHumans();
    }    
    */

    public function makePublish() : void {
        $this->status = true;  
    }
    public function makeDraft() : void {
        $this->status = false;         
    }

    /*
    public function approve(){

    }
    public function unapprove(){

    }
    */

    public function checkEdumindCanEarn(int $discountPrecentage, int $commissionPrecentage) : bool {
        $coursePrice            = $this->price;
        $discountPrecentageVO   = new PercentageVO((float)$discountPrecentage);
        $commissionPrecentageVO = new PercentageVO((float)$commissionPrecentage);

        //$edumindAmount      = $coursePrice * ((100 - $this->author_share_percentage)/100);
        $edumindAmount        = $coursePrice->multiply(1 - $this->authorSharePercentage->asFraction());

        //$discountAmount     = ($coursePrice * ($discountPrecentage/100));
        $discountAmount       = $coursePrice->multiply($discountPrecentageVO->asFraction());
        
        //$edumindLoseAmount  = ($discountAmount/100) * (100 + $commissionPrecentage);
        $edumindLoseAmount    = $discountAmount->multiply(1 + $commissionPrecentageVO->asFraction());
        
        //return ($edumindAmount - $edumindLoseAmount);
        return $edumindAmount->isHigher($edumindLoseAmount);
    }



    


}



