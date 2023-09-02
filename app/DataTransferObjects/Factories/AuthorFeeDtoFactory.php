<?php

namespace App\DataTransferObjects\Factories;


//use Ramsey\Uuid\Uuid;
//use App\Domain\Exceptions\InvalidArgumentException;
//use App\Domain\Types\UserTypesEnum;
//use App\Domain\Factories\IFactory;

use App\Repositories\UserRepository;
use App\DataTransferObjects\UserDto;
use App\DataTransferObjects\Factories\AbstractDtoFactory;

use App\DataTransferObjects\AuthorFeeDto;
use Illuminate\Http\Request;
use App\DataTransferObjects\Exceptions\MissingArgumentDtoException;
use App\DataTransferObjects\Exceptions\InvalidArgumentDtoException;

class AuthorFeeDtoFactory extends AbstractDtoFactory{
    
    public static function fromArray(array $data) : ?AuthorFeeDto {    
        if(!isset($data['amount']))
            throw new MissingArgumentDtoException('AuthorFeeDto create failed due to missing amount parameter');

        return new AuthorFeeDto(
            $data['amount'],                    
            $data['id'] ?? null,                      
        );        
    }
    
    public static function fromRequest(Request $request) : ?AuthorFeeDto {
        if($request->input('amount') === null )
            throw new MissingArgumentDtoException('AuthorFeeDto create failed due to missing amount parameter');        
        
        return new AuthorFeeDto(
            $request->input('amount'),
            $request->input('id') ?? null
        );        
    }
}