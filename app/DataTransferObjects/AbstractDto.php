<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\IDto;
//use Illuminate\Http\Request;


abstract class AbstractDto implements IDto{
    
    //initialize the public properties of a child class by providing an associative array where the keys match the property names.
    /*
    public function __construct(array $parameters = []){
        $class = new ReflectionClass(static::class);

        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $reflectionProperty){
            $property = $reflectionProperty->getName();
            $this->{$property} = $parameters[$property];
        }
    }
    */

    abstract public function toArray(): array;   
    
    public function toJson(): string {
        return json_encode($this->toArray());
    }   
}