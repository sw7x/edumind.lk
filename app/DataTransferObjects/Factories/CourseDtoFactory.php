<?php

namespace App\DataTransferObjects\Factories;

use App\DataTransferObjects\Factories\AbstractDtoFactory;

use App\DataTransferObjects\CourseDto;
use App\DataTransferObjects\Factories\SubjectDtoFactory;
use App\DataTransferObjects\Factories\UserDtoFactory;
use App\Repositories\CourseRepository;
use Illuminate\Http\Request;
use App\DataTransferObjects\Exceptions\MissingArgumentDtoException;
use App\Mappers\SubjectMapper;
use App\Mappers\UserMapper;

class CourseDtoFactory extends AbstractDtoFactory
{
    
    public static function fromArray(array $data) : ?CourseDto {                
        if(!isset($data['name']))
            throw new MissingArgumentDtoException('CourseDto create failed due to missing name parameter');
        
        if(!isset($data['price']))
            throw new MissingArgumentDtoException('CourseDto create failed due to missing price parameter');

        $subjectDto =   (isset($data['subjectArr']) && !empty($data['subjectArr'])) ? 
                            SubjectDtoFactory::fromArray($data['subjectArr']) : 
                            ( isset($data['subjectId']) ? 
                                (new SubjectDtoFactory())->createDtoById($data['subjectId']) : 
                                null 
                            );
              
        $authorDto  =   (isset($data['creatorArr']) && !empty($data['creatorArr'])) ? 
                            UserDtoFactory::fromArray($data['creatorArr']) : 
                            ( isset($data['creatorId']) ? 
                                (new UserDtoFactory())->createDtoById($data['creatorId']) : 
                                null 
                            );
        
        return new CourseDto(
            $data['name'],   
            $data['price'],

            $data['id'] ?? null,                    
            $data['description'] ?? null,             
            $data['image'] ?? null,                  
            $data['headingText'] ?? null,           
            $data['topics'] ?? null,                  
            $data['content'] ?? null,                 
            $data['slug'] ?? null,                   
            $data['authorSharePercentage'] ?? null,                   
            $data['videoCount'] ?? null,            
            $data['duration'] ?? null,               
            $data['status'] ?? null,

            $subjectDto,
            $authorDto
        );
            
    }



    public static function fromRequest(Request $request) : ?CourseDto {       
        if($request->input('name') == null )
            throw new MissingArgumentDtoException('CourseDto create failed due to missing name parameter');
        
        if($request->input('price') === null )
            throw new MissingArgumentDtoException('CourseDto create failed due to missing price parameter'); 

        $subjectDto = null;
        if($request->has('subject_id') && $request->filled('subject_id')){
            $subjectDto = (new SubjectDtoFactory())->createDtoById($request->input('subject_id'));
        }elseif (
            $request->has('subject_arr') && 
            $request->filled('subject_arr') &&
            !empty($request->input('subject_arr'))
        ) {            
            $subjectArr = SubjectMapper::arrConvertToDtoArr($request->input('subject_arr'));
            $subjectDto = SubjectDtoFactory::fromArray($subjectArr);
        }
        
        
        $authorDto = null;
        if($request->has('creator_id') && $request->filled('creator_id')){
            $authorDto = (new UserDtoFactory())->createDtoById($request->input('creator_id'));
        }elseif (
            $request->has('creator_arr') && 
            $request->filled('creator_arr') && 
            !empty($request->input('creator_arr'))
        ) {
            $creatorArr = UserMapper::arrConvertToDtoArr($request->input('creator_arr'));
            $authorDto = UserDtoFactory::fromArray($creatorArr);
        }

        return new CourseDto(
            $request->input('name'),
            $request->input('price'),
            
            $request->input('id') ?? null,
            $request->input('description') ?? null,
            $request->input('image') ?? null,
            $request->input('heading_text') ?? null,
            $request->input('topics') ?? null,
            $request->input('content') ?? null,
            $request->input('slug') ?? null,
            $request->input('author_share_percentage') ?? null,
            $request->input('video_count') ?? null,
            $request->input('duration') ?? null,
            $request->input('status') ?? null,

            $subjectDto,
            $authorDto
        );      
    }
    
    public function createDtoById(int $courseId): ?CourseDto {
        $data       = (new CourseRepository())->findDtoDataById($courseId);
        $courseDto  = (!empty($data))? self::fromArray($data): null;
        return $courseDto;
    }


    
} 