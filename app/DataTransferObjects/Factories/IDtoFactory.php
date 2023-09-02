<?php

namespace App\DataTransferObjects\Factories;

use Illuminate\Http\Request;
use App\DataTransferObjects\IDto;

interface IDtoFactory{
    
    public static function fromArray(array $data) : ?IDto;
    public static function fromRequest(Request $request) : ?IDto;
    //public static function canCreate(array $data) : bool;

}