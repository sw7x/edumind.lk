<?php
namespace App\Domain;

interface IEntity
{
    //public function getUuId(): string;
    //public function setUuId(string $id): void;
    
    public function toArray(): array;
    
    public function isSameInstance(?IEntity $object): bool;
    public function isEquals(?IEntity $object): bool;
    public function isExactSame(?IEntity $object): bool;

}