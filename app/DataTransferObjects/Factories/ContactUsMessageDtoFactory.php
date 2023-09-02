<?php

namespace App\DataTransferObjects\Factories;

use App\DataTransferObjects\Factories\AbstractDtoFactory;
use App\DataTransferObjects\ContactUsMessageDto;
use Illuminate\Http\Request;

use App\Repositories\ContactUsRepository;
use App\DataTransferObjects\Factories\UserDtoFactory;
use App\DataTransferObjects\Exceptions\MissingArgumentDtoException;
use App\Mappers\UserMapper;


class ContactUsMessageDtoFactory extends AbstractDtoFactory
{
    
    public static function fromArray(array $data) : ?ContactUsMessageDto {   
        
        if(!isset($data['subject']))
            throw new MissingArgumentDtoException('ContactUsMessageDto create failed due to missing subject parameter');

        if(!isset($data['message']))
            throw new MissingArgumentDtoException('ContactUsMessageDto create failed due to missing message parameter');

        
        $creatorDTO = isset($data['userId']) ? 
                        (new UserDtoFactory())->createDtoById($data['userId']) : 
                        (isset($data['userArr']) && !empty($data['userArr']) ? 
                            UserDtoFactory::fromArray($data['userArr']) : 
                            null 
                        );
        
        //dump($creatorDTO);
        //dump($data);
        //echo 'creatorDTO<br><hr>';

        return new ContactUsMessageDto(
            $data['message'],
            $data['subject'],  

            $data['id'] ?? null,                      
            //$data['uuid'] ?? null,                    
            $data['fullName'] ?? null,             
            $data['email'] ?? null,                  
            $data['phone'] ?? null,        
            
            $creatorDTO
        );
    }
    
    
    public static function fromRequest(Request $request) : ?ContactUsMessageDto {  

        if($request->input('subject') == null )
            throw new MissingArgumentDtoException('ContactUsMessageDto create failed due to missing subject parameter');

        if($request->input('message') == null )
            throw new MissingArgumentDtoException('ContactUsMessageDto create failed due to missing message parameter');

        $creatorDTO = null;
        if($request->has('user_id') && $request->filled('user_id')){
            $creatorDTO = (new UserDtoFactory())->createDtoById($request->input('user_id'));
        }elseif (
            $request->has('user_arr') && 
            $request->filled('user_arr') && 
            !empty($request->input('user_arr'))
        ) {
            $userArr    = UserMapper::arrConvertToDtoArr($request->input('user_arr'));
            $creatorDTO = UserDtoFactory::fromArray($userArr);
        } 

        return new ContactUsMessageDto(
            $request->input('subject'),
            $request->input('message'),

            $request->input('id') ?? null,
            //$request->input('uuid') ?? null,
            $request->input('full_name') ?? null,
            $request->input('email') ?? null,
            $request->input('phone') ?? null,            

            $creatorDTO
        );
        
    }
    

    public function createDtoById(int $msgId) : ?ContactUsMessageDto {
        $data                   = (new ContactUsRepository())->findDtoDataById($msgId);
        $contactUsMessageDto    = (!empty($data))? self::fromArray($data): null;
        return $contactUsMessageDto;
    }

}


