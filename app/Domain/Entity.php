<?php

namespace App\Domain;

use App\Domain\IEntity;
use App\Domain\Exceptions\DomainException;


abstract class Entity implements IEntity{

	abstract public function toArray() : array;
    //public function toArray(): array;


    /* check is given entity and this same instance */
    public function isSameInstance(?IEntity $object): bool {
                        
        if ($object === null || $object === undefined) {
            return false;
        }        

        if (!is_object($object)) {
            return false;
        }

        /*if (!$object instanceof Entity) {
            return false;
        }*/

        if (!($object instanceof self)) {
            return false;
        }
        return ($this->getId == $object->getId());
    }




    public function isEquals(?IEntity $object): bool {
                        
        if(!$this->isSameInstance()){
            return false;
        }else{
            // equality comparison by comparing their properties
            return ($this == $object);
        }
        
    }


    public function isExactSame(?IEntity $object): bool {
        
        if(!$this->equals()){
            return false;
        }else{
            /*  checks for object identity, meaning it compares whether the two objects 
            are the exact same instance in memory.  */
            return ($this === $object);
        }
    }


    public static function ObjArrConvertToData(array $objArr): array {
        //return array("red", "green", "blue", "yellow");

        $tempArr = [];
        foreach ($objArr as $objArrItem) {
            if (!($objArrItem instanceof self)) {
                throw new DomainException('Array contains objects that are not Entities.');
            }
            $tempArr[] = $objArrItem->toArray();
        }
        return $tempArr;
        /**/
    }
    
}
