<?php

namespace App\DataTransferObjects;

//use Illuminate\Http\Request;

interface IDto{
    public function toArray() : array;
    public function toJson() : String;
    //public static function fromArray(array $data) : ?self;
    //public static function fromRequest(Request $request) : ?self;
    //public static function canCreate(array $data) : bool;
}