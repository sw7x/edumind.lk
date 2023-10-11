<?php

namespace App\Repositories\Interfaces;

interface IGetDataRepository{
    
    public function findDataArrById(int $id): array;

    public function findDtoDataById(int $id): array;
}
