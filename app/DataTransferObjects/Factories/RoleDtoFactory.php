<?php

namespace App\DataTransferObjects\Factories;


//use Ramsey\Uuid\Uuid;
//use App\Domain\Exceptions\InvalidArgumentException;
//use App\Domain\Types\UserTypesEnum;
//use App\Domain\Factories\IFactory;

//use App\Repositories\UserRepository;
//use App\DataTransferObjects\UserDto;
use App\DataTransferObjects\RoleDto;
use App\DataTransferObjects\Factories\AbstractDtoFactory;

use Illuminate\Http\Request;
use App\DataTransferObjects\Exceptions\MissingArgumentDtoException;
use App\Repositories\RoleRepository;



class RoleDtoFactory extends AbstractDtoFactory{
    
    public static function fromArray(array $data) : ?RoleDto {        
        if(!isset($data['name']))
            throw new MissingArgumentDtoException('RoleDto create failed due to missing name parameter');        
        
        return new RoleDto(
            $data['name'], 
            $data['id'] ?? null,                      
            $data['slug'] ?? null,                    
        );        
    }

    
    public static function fromRequest(Request $request) : ?RoleDto {        
        if($request->input('name') == null )
            throw new MissingArgumentDtoException('RoleDto create failed due to missing name parameter');   
        
        return new RoleDto(
            $request->input('name'),
            $request->input('id') ?? null,
            $request->input('slug') ?? null
        );
    }

    public function createDtoById(int $roleId): ?RoleDto {
        $data       = (new RoleRepository())->findDtoDataById($roleId);
        $roleDto    = self::fromArray($data);
        return $roleDto;
    }

}



