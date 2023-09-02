<?php

namespace App\Repositories\Interfaces;

interface IGetDtoDataRepository{
    
    //findDtoTreeById
    //findDtoById  
    
    //public function findDtoAllDataById(int $id): array;
    //public function findDtoDataById(int $id): array;
	public function findDataArrById(int $id): array;

}
