<?php


namespace App\Domain\Hydrators;

use Ramsey\Uuid\Uuid;
use App\Domain\Role as RoleEntity;
use App\Domain\Hydrators\IHydrator;
use App\Domain\IEntity;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;

class RoleHydrator implements IHydrator {
    

	public static function hydrateData(array $roleData, ?IEntity $roleEntity = null): RoleEntity {
        if(is_null($roleEntity)){
            throw new MissingArgumentDomainException("Missing parameter: RoleEntity is required.");
        }
        
        if(!$roleEntity instanceof RoleEntity){
            throw new InvalidArgumentDomainException("provided object must be instance of RoleEntity class");
        }

        if (!isset($roleData['id']) || $roleData['id'] == null) {
            $roleData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($roleData['uuid']) && $roleEntity->getUuid() === null) {
            $roleEntity->setUuid($roleData['uuid']);
        }        

        if (isset($roleData['id']) && $roleEntity->getId() === null) {
            $roleEntity->setId($roleData['id']);
        }

        if (isset($roleData['slug'])) {
            $roleEntity->setSlug($roleData['slug']);
        }        

        return $roleEntity;
    }
    
}




