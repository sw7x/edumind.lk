<?php


namespace App\DataTransferObjects\Factories;

//use Ramsey\Uuid\Uuid;
//use App\Domain\Factories\IFactory;
//use App\Domain\Exceptions\InvalidArgumentException;

use App\Repositories\SubjectRepository;
use App\DataTransferObjects\SubjectDto;
use App\DataTransferObjects\Factories\AbstractDtoFactory;
use Illuminate\Http\Request;
use App\DataTransferObjects\Exceptions\MissingArgumentDtoException;
use App\Mappers\UserMapper;


//class SubjectDtoFactory{
class SubjectDtoFactory extends AbstractDtoFactory{
    
    
    //----> creator_arr, author_id
    public static function fromArray(array $data): ?SubjectDto {        
        if(!isset($data['name']))
            throw new MissingArgumentDtoException('SubjectDto create failed due to missing name parameter'); 
		//dump($data);
        //dump('999');
        
        $authorDTO  =   (isset($data['creatorArr']) && !empty($data['creatorArr'])) ? 
                            UserDtoFactory::fromArray($data['creatorArr']) : 
                            (isset($data['creatorId']) ? 
                                (new UserDtoFactory())->createDtoById($data['creatorId']) : 
                                null 
                            );
        
        return new SubjectDto(
            $data['name'], 
            $data['id']          ?? null,
            //$data['uuid']      ?? null,  
            $data['description'] ?? null,
            $data['image']       ?? null,                      
            $data['slug']        ?? null, 
            $data['status']      ?? null, 

            $authorDTO                   
        );               
    }
    

    
    public static function fromRequest(Request $request) : ?SubjectDto {
        if($request->input('name') == null )
            throw new MissingArgumentDtoException('SubjectDto create failed due to missing name parameter'); 
        
        $authorDTO = null;
        if($request->has('creator_id') && $request->filled('creator_id')){
            $authorDTO = (new UserDtoFactory())->createDtoById($request->input('creator_id'));
        }elseif (
            $request->has('creator_arr') && 
            $request->filled('creator_arr') && 
            !empty($request->input('creator_arr'))
        ) {
            $creatorArr     = UserMapper::arrConvertToDtoArr($request->input('creator_arr'));
            $authorDTO      = UserDtoFactory::fromArray($creatorArr);
        }

        return new SubjectDto(
            $request->input('name'),
            $request->input('id') ?? null,
            $request->input('description') ?? null,
            $request->input('image') ?? null,
            $request->input('slug') ?? null,
            $request->input('status') ?? null,

            $authorDTO
        );        
    }

    public function createDtoById(int $subjectId): ?SubjectDto {
        $data       = (new SubjectRepository())->findDtoDataById($subjectId);
        $subjectDTO = (!empty($data))? self::fromArray($data): null;
        return $subjectDTO;
    }

}
