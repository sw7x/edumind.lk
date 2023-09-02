<?php

namespace App\DataTransferObjects\Factories;

use App\DataTransferObjects\Factories\IDtoFactory;
use Illuminate\Http\Request;
use App\DataTransferObjects\IDto;


abstract class AbstractDtoFactory implements IDtoFactory
{    
    abstract public static function fromArray(array $data) : ?IDto;
    abstract public static function fromRequest(Request $request) : ?IDto; 
    
    /*
    public static function canCreate(array $data) : bool {

        //public static $requiredKeys = ['author || author_id || fgfgf'];
        //public static $requiredKeys = ['author && $author_id'];

        $requiredKeys = static::$requiredKeys;
        $keysExist = true;
        foreach ($requiredKeys as $key) {            
            if (!array_key_exists($key, $data)) {
                $keysExist = false;
                break;
            }
        }
        return $keysExist;
    }
    */ 
}