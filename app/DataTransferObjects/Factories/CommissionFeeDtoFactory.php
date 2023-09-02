<?php

namespace App\DataTransferObjects\Factories;


//use Ramsey\Uuid\Uuid;
//use App\Domain\Exceptions\InvalidArgumentException;
//use App\Domain\Types\UserTypesEnum;
//use App\Domain\Factories\IFactory;

use App\Repositories\UserRepository;
use App\DataTransferObjects\UserDto;
use App\DataTransferObjects\Factories\AbstractDtoFactory;

use Illuminate\Http\Request;
use App\DataTransferObjects\CommissionFeeDto;
use App\DataTransferObjects\Exceptions\MissingArgumentDtoException;
use App\DataTransferObjects\Exceptions\InvalidArgumentDtoException;



class CommissionFeeDtoFactory extends AbstractDtoFactory{
    
    public static function fromArray(array $data) : ?CommissionFeeDto {        
        if(!isset($data['amount']))
            throw new MissingArgumentDtoException('CommissionFeeDto create failed due to missing amount parameter');
        
        return new CommissionFeeDto(
            $data['amount'],                    
            $data['id'] ?? null,                      
        );        
    }
    
    
    public static function fromRequest(Request $request) : ?CommissionFeeDto {        
        if($request->input('amount') === null )
            throw new MissingArgumentDtoException('CommissionFeeDto create failed due to missing amount parameter');

        return new CommissionFeeDto(
            $request->input('amount'),
            $request->input('id') ?? null,
        );        
    }

}