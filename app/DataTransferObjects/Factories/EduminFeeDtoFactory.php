<?php

namespace App\DataTransferObjects\Factories;


//use Ramsey\Uuid\Uuid;
//use App\Domain\Exceptions\InvalidArgumentException;
//use App\Domain\Types\UserTypesEnum;
//use App\Domain\Factories\IFactory;

//use App\Repositories\UserRepository;
//use App\DataTransferObjects\UserDto;
use App\DataTransferObjects\Factories\AbstractDtoFactory;

use Illuminate\Http\Request;
use App\DataTransferObjects\EdumindFeeDto;
use App\DataTransferObjects\Exceptions\MissingArgumentDtoException;


class EduminFeeDtoFactory extends AbstractDtoFactory{
    
    public static function fromArray(array $data) : ?EdumindFeeDto {        
        if(!isset($data['amount']))
            throw new MissingArgumentDtoException('EdumindFeeDto create failed due to missing amount parameter');        
        
        return new EdumindFeeDto(
            $data['amount'],
            $data['id'] ?? null,                      
            $data['date'] ?? null,                    
        );        
    }
    
    public static function fromRequest(Request $request) : ?EdumindFeeDto {        
        if($request->input('amount') === null )
            throw new MissingArgumentDtoException('EdumindFeeDto create failed due to missing amount parameter');      
        
        return new EdumindFeeDto(
            $request->input('amount'),
            $request->input('id') ?? null,
            $request->input('date') ?? null
        );        
    }

}