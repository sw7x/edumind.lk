<?php

namespace App\DataTransferObjects\AbstractDataTransferObject;



abstract class AbstractDataTransferObject
{

    public function __construct(array $parameters = [])
    {
        $class = new ReflectionClass(static::class);

        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $reflectionProperty){
            $property = $reflectionProperty->getName();
            $this->{$property} = $parameters[$property];
        }
    }


    abstract public function toArray();

}

