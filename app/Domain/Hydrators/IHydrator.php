<?php
namespace App\Domain\Hydrators;
use App\Domain\IEntity;
use App\Domain\Entity;



interface IHydrator {
    public static function hydrateData(array $dataArr, ?IEntity $entity = null): IEntity; 
}