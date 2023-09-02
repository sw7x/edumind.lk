<?php

namespace App\DataTransferObjects\Factories;


//use Ramsey\Uuid\Uuid;
//use App\Domain\Exceptions\InvalidArgumentException;
//use App\Domain\Types\UserTypesEnum;
//use App\Domain\Factories\IFactory;

use App\Repositories\UserRepository;
use App\DataTransferObjects\UserDto;
//use App\DataTransferObjects\RoleDto;
use App\DataTransferObjects\Factories\AbstractDtoFactory;
use App\DataTransferObjects\Factories\RoleDtoFactory;

use Illuminate\Http\Request;
use App\DataTransferObjects\Exceptions\MissingArgumentDtoException;
use App\Mappers\RoleMapper;

class UserDtoFactory extends AbstractDtoFactory{
//class UserDtoFactory{
    
    
    public static function fromArray(array $data) : ?UserDto {        
        //dd($data);
        
        $requiredKeys = ['fullName', 'email', 'phone', 'username', 'status'];
        foreach ($requiredKeys as $key) {
            if (!isset($data[$key])) { 
                throw new MissingArgumentDtoException('UserDto create failed due to missing '.$key.' parameter');
            }
        }
		
		$roleDTO    =   (isset($data['roleArr']) && !empty($data['roleArr'])) ? 
                            RoleDtoFactory::fromArray($data['roleArr']) : 
                            (isset($data['roleId']) ? 
                                (new RoleDtoFactory())->createDtoById($data['roleId']) : 
                                null 
                            );

        return new UserDTO(
            $data['fullName'],            
            $data['email'],                 
            $data['phone'],               
            $data['username'],            
            $data['status'],

            $data['id']?? null,                    
            //$data['uuid']?? null,                
            $data['profilePic']?? null,          
            $data['gender']?? null,             
            $data['dobYear']?? null,                  
            $data['profileText']?? null,            
            $data['eduQualifications']?? null,
            
            $roleDTO                   
        );        
    }

    
    public static function fromRequest(Request $request) : ?UserDto {        
        $inputKeys = ['full_name', 'email', 'phone', 'username', 'status'];
        foreach ($inputKeys as $key) {
            if ($request->input($key) == null) { 
                throw new MissingArgumentDtoException('UserDto create failed due to missing '.$key.' parameter');
            }
        }        

        $roleDTO = null;
        if($request->has('role_id') && $request->filled('role_id')){
            $roleDTO = (new RoleDtoFactory())->createDtoById($request->input('role_id'));
        }elseif (
            $request->has('role_arr') && 
            $request->filled('role_arr') && 
            !empty($request->input('role_arr'))
        ) {
            $roleArr = RoleMapper::arrConvertToDtoArr($request->input('role_arr'));
            $roleDTO = RoleDtoFactory::fromArray($roleArr);
        }


        return new UserDTO(
            $request->input('full_name'),
            $request->input('email'),            
            $request->input('phone'),
            $request->input('username'),
            $request->input('status'),
            
            $request->input('id') ?? null,
            //$request->input('uuid') ?? null,
            $request->input('profile_pic') ?? null,
            $request->input('gender') ?? null,            
            $request->input('dob_year') ?? null,
            $request->input('profile_text') ?? null,
            $request->input('edu_qualifications') ?? null,

            $roleDTO         
        );            
    }

    public function createDtoById(int $userId): ?UserDto {
        $data       = (new UserRepository())->findDtoDataById($userId); 
        $data                   = arrKeysSnakeToCamel($data);       
        $userDTO = self::fromArray($data);
        return $userDTO;
    }

}


