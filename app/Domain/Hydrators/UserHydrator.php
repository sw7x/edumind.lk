<?php
namespace App\Domain\Hydrators;

use Ramsey\Uuid\Uuid;
use App\Domain\Role as RoleEntity;
use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;
use App\Domain\Hydrators\IHydrator;
use App\Domain\IEntity;
use App\Domain\Users\User as UserEntity;

//class UserHydrator {
class UserHydrator implements IHydrator {
    

    public static function hydrateData(
        array $userData, 
        ?IEntity $userEntity = null
    ): UserEntity {   
        if(is_null($userEntity)){
            throw new MissingArgumentDomainException("Missing parameter: userEntity is required.");
        }
        
        if(!$userEntity instanceof UserEntity){
            throw new InvalidArgumentDomainException("provided object must be instance of UserEntity class");
        }

        if (!isset($userData['id']) || $userData['id'] == null) {
            $userData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
        }

        if (isset($userData['uuid'])) {
            $userEntity->setUuid($userData['uuid']);
        }

        if (isset($userData['id'])) {
            $userEntity->setId($userData['id']);
        }

        if (isset($userData['profile_pic'])) {
            $userEntity->setProfilePic($userData['profile_pic']);
        }        

        if (isset($userData['gender'])) {
            $userEntity->setGender($userData['gender']);
        }

        if (isset($UserData['dob_year'])) {
            $userEntity->setDobYear($UserData['dob_year']);
        }        

        if (isset($UserData['profile_text'])) {
            $userEntity->setProfileText($UserData['profile_text']);
        }
        
        if (isset($UserData['edu_qualifications'])) {
            $userEntity->setEduQualifications($UserData['edu_qualifications']);
        }

        if(!empty($userData['roleArr']) && isset($userData['roleArr']['name'])){     
            $role = new RoleEntity($userData['roleArr']['name']);
            if(isset($userData['roleArr']['id']))  $role->setId($userData['roleArr']['id']);
            if(isset($userData['roleArr']['name'])) $role->setSlug($userData['roleArr']['slug']);
            $userEntity->setRole($role);
        }
                
        return $userEntity;
    }
}



 
