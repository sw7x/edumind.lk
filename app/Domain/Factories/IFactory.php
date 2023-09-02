<?php
namespace App\Domain\Factories;
use App\Domain\IEntity;
use App\Domain\Entity;

use App\Domain\Course as CourseEntity;


interface IFactory {
    public function createObjTree(array $dataArr): IEntity;
    public function createObj(array $dataArr): IEntity;
}