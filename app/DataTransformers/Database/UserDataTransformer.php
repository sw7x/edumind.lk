<?php

namespace App\DataTransformers\Database;

use App\Domain\Users\User as UserEntity;

use App\DataTransferObjects\UserDto;
use App\DataTransferObjects\Factories\UserDtoFactory;
use App\Mappers\UserMapper;
use App\Domain\Factories\UserFactory;

//use App\Repositories\UserRepository;

class UserDataTransformer{

	public static function buildDto(array $userRecData) : UserDto {

        $userEntity = self::buildEntity($userRecData);
        $userDto    = UserDtoFactory::fromArray($userEntity->toArray());
		return $userDto;

	}

	public static function buildEntity(array $userRecData) : UserEntity {
        if(!isset($userRecData['role_arr'])){

        	if($userRecData['roles'] && $userRecData['roles'][0]){
        		$roleArr 	= 	array(
				        			"id" 	=> $userRecData['roles'][0]['id'],
				        			"uuid" 	=> $userRecData['roles'][0]['uuid'],
				        			"slug" 	=> $userRecData['roles'][0]['slug'],
				        			"name" 	=> $userRecData['roles'][0]['name'],
				        		);
        	}else{
        		$roleArr = [];
        	}

			$userRecData['role_arr'] = $roleArr;

        }

        //dd($userRecData);
        $userEntityArr 	= UserMapper::dbRecConvertToEntityArr($userRecData);
        $userEntity      = (new UserFactory())->createObjTree($userEntityArr);
        return $userEntity;

	}
    

    public static function entityToDbRecArr(UserEntity $user) : array {
        $userEntityArr   = $user->toArray();
        $payloadArr      = UserMapper::entityConvertToDbArr($userEntityArr);
        unset($payloadArr['creator_arr']);
        return $payloadArr;
    }


    public static function dtoToDbRecArr(UserDto $userDto) : array {
        $userEntity  = (new UserFactory())->createObjTree($userDto->toArray());
        $payloadArr     = self::entityToDbRecArr($userEntity);
        return $payloadArr;
    }

}


/*
	$rr = (new UserRepository())->findDataArrById(11);
	dd($rr);

	$teachers   =   Sentinel::findRoleBySlug('teacher')->users()->withoutGlobalScope('active')->with('roles')->orderBy('id')->get();
	$teachers1 = $teachers->first();
	dump($teachers1);
	dd($teachers1->toArray());

	$user11 = UserModel::withoutGlobalScope('active')->find(12);
	dump($user11);
	dd($user11->toArray());

*/



