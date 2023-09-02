<?php


namespace App\Domain\Factories;

use Ramsey\Uuid\Uuid;

use App\Domain\Role as RoleEntity;

use App\Domain\Factories\IFactory;
//use App\Domain\IEntity;
use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Types\RoleTypesEnum;


class RoleFactory implements IFactory {
    

	public function createObjTree(array $roleData): RoleEntity {
        if(!isset($roleData['name']))       
            throw new MissingArgumentDomainException("Missing name parameter for create Role entity");              
        
        
        //type validations      
        if(!is_string($roleData['name']) || ($roleData['name'] === ''))      
            throw new InvalidArgumentDomainException("Invalid name parameter to create Role entity");             
        
        if  (!in_array( 
                    $roleData['name'], 
                    [RoleTypesEnum::ADMIN, RoleTypesEnum::EDITOR, RoleTypesEnum::MARKETER, RoleTypesEnum::TEACHER, RoleTypesEnum::STUDENT]
                )
            ) {
            throw new InvalidArgumentDomainException('Invalid role name parameter for create Role entity');
        }
        
        $roleEntity = new RoleEntity($roleData['name']);
        
        if (!isset($roleData['id']) || $roleData['id'] == null) {
            $roleData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($roleData['uuid'])) {
            $roleEntity->setUuid($roleData['uuid']);
        }        

        if (isset($roleData['id'])) {
            $roleEntity->setId($roleData['id']);
        }

        if (isset($roleData['slug'])) {
            $roleEntity->setSlug($roleData['slug']);
        }        

        return $roleEntity;
    }

    public function createObj(array $roleData): RoleEntity {
        if(!isset($roleData['name']))        
            throw new MissingArgumentDomainException("Missing name parameter for create Role entity");              
        
        
        //type validations
        if(!is_string($roleData['name']) || ($roleData['name'] === ''))      
            throw new InvalidArgumentDomainException("Invalid name parameter to create Role entity");             
        
        if  (!in_array( 
                    $roleData['name'], 
                    [RoleTypesEnum::ADMIN, RoleTypesEnum::EDITOR, RoleTypesEnum::MARKETER, RoleTypesEnum::TEACHER, RoleTypesEnum::STUDENT]
                )
            ) {
            throw new InvalidArgumentDomainException('Invalid role name parameter for create Role entity');
        }

        $roleEntity = new RoleEntity($roleData['name']);

        if (!isset($roleData['id']) || $roleData['id'] == null) {
            $roleData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($roleData['uuid'])) {
            $roleEntity->setUuid($roleData['uuid']);
        }        

        if (isset($roleData['id'])) {
            $roleEntity->setId($roleData['id']);
        }

        if (isset($roleData['slug'])) {
            $roleEntity->setSlug($roleData['slug']);
        }        

        return $roleEntity;
    }

}




