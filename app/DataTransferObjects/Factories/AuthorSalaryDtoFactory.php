<?php

namespace App\DataTransferObjects\Factories;

//use App\DataTransferObjects\UserDto;
use App\DataTransferObjects\Factories\AbstractDtoFactory;
use App\DataTransferObjects\AuthorSalaryDto;

use App\DataTransferObjects\Factories\UserDtoFactory;
use Illuminate\Http\Request;
use App\Repositories\AuthorSalaryRepository;
use App\DataTransferObjects\AuthorFeeDto;
use App\DataTransferObjects\Factories\AuthorFeeDtoFactory;


//use App\DataTransferObjects\Exceptions\DtoInvalidArgumentException;
use App\DataTransferObjects\Exceptions\MissingArgumentDtoException;
use \DateTime;
use App\Mappers\UserMapper;
use App\Mappers\AuthorFeeMapper;


class AuthorSalaryDtoFactory extends AbstractDtoFactory{

    
    public static function fromArray(array $data) : ?AuthorSalaryDto {       
        if(!isset($data['image']))
            throw new MissingArgumentDtoException('AuthorSalaryDto create failed due to missing image parameter');

        if(!isset($data['paidAmount']))
            throw new MissingArgumentDtoException('AuthorSalaryDto create failed due to missing paidAmount parameter');

        if(!isset($data['paidDate']))
            throw new MissingArgumentDtoException('AuthorSalaryDto create failed due to missing paidDate parameter');

        if(!isset($data['fromDate']))
            throw new MissingArgumentDtoException('AuthorSalaryDto create failed due to missing fromDate parameter');

        if(!isset($data['toDate']))
            throw new MissingArgumentDtoException('AuthorSalaryDto create failed due to missing toDate parameter');

        if( !isset($data['authorArr']) && !isset($data['authorId']) )
            throw new MissingArgumentDtoException('AuthorSalaryDto create failed due to missing both authorArr and authorId parameters');
        
        
        $authorFeesArr = [];
        if (isset($data['fees']) && !empty($data['fees'])) {
            foreach ($data['fees'] as $authorFee) {
                $authorFeesArr[] = AuthorFeeDtoFactory::fromArray($authorFee);
            }
        }

        $authorDTO  =   (isset($data['authorArr']) && !empty($data['authorArr'])) ?
                            UserDtoFactory::fromArray($data['authorArr']) : 
                            (new UserDtoFactory())->createDtoById($data['authorId']);
        
        
        /*paidDate*/
        if ( DateTime::createFromFormat("Y-m-d H:i:s", $data['paidDate']) )
            $paidDateString   = (new DateTime($data['paidDate']))->format("Y-m-d");             
                
        if ( DateTime::createFromFormat("Y-m-d", $data['paidDate']) )
            $paidDateString = $data['paidDate'];
            
        
        /*fromDate*/
        if ( DateTime::createFromFormat("Y-m-d H:i:s", $data['fromDate']) )
            $fromDateString   = (new DateTime($data['fromDate']))->format("Y-m-d");             
                
        if ( DateTime::createFromFormat("Y-m-d", $data['fromDate']) )
            $fromDateString = $data['fromDate'];

        
        /*toDate*/
        if ( DateTime::createFromFormat("Y-m-d H:i:s", $data['toDate']) )
            $toDateString   = (new DateTime($data['toDate']))->format("Y-m-d");             
                
        if ( DateTime::createFromFormat("Y-m-d", $data['toDate']) )
            $toDateString = $data['toDate'];




        return new AuthorSalaryDto(
            $authorDTO,
            
            $data['id'] ?? null,
            //$data['uuid'] ?? null,
            $data['image'],             
            $data['paidAmount'],
            $paidDateString,
            $data['remarks'] ?? null,             
            $fromDateString,
            $toDateString,     
            $authorFeesArr
        );
    }



    public static function fromRequest(Request $request) : ?AuthorSalaryDto {                
        if(is_null($request->input('image')))
            throw new MissingArgumentDtoException('AuthorSalaryDto create failed due to missing image parameter');

        if(is_null($request->input('paid_amount')))
            throw new MissingArgumentDtoException('AuthorSalaryDto create failed due to missing paid_amount parameter');
        
        if(is_null($request->input('paid_date')))
            throw new MissingArgumentDtoException('AuthorSalaryDto create failed due to missing paid_date parameter');
        
        if(is_null($request->input('from_date')))
            throw new MissingArgumentDtoException('AuthorSalaryDto create failed due to missing from_date parameter');
        
        if(is_null($request->input('to_date')))
            throw new MissingArgumentDtoException('AuthorSalaryDto create failed due to missing to_date parameter');

        if( 
            ($request->input('author_id')  == null) && 
            ($request->input('author_arr') === null || empty($request->input('author_arr')))
        ){
            throw new MissingArgumentDtoException('AuthorSalaryDto create failed due to missing both author_arr and author_id parameters');
        }


        $authorFeesArr = [];
        if ($request->input('fees') != null && !empty($request->input('fees'))) {
            foreach ($request->input('fees') as $authorFee) {
                $authorFeesDataArr      = AuthorFeeMapper::arrConvertToDtoArr($authorFee);
                $authorFeesArr[]        = AuthorFeeDtoFactory::fromArray($authorFeesDataArr);
            }
        }


        if (!is_null($request->input('author_id'))) {
            $authorDTO     = (new UserDtoFactory())->createDtoById($request->input('author_id'));
        }else{
            $authorArr      = UserMapper::arrConvertToDtoArr($request->input('author_arr'));  
            $authorDTO      = UserDtoFactory::fromArray($authorArr);
            //$request      = new Request($authorArr);
            //$authorDTO    = UserDtoFactory::fromRequest($request);
        } 

        /*paidDate*/
        if ( DateTime::createFromFormat("Y-m-d H:i:s", $request->input('paid_date')) )
            $paidDateString     = (new DateTime($request->input('paid_date')))->format("Y-m-d");             
                
        if ( DateTime::createFromFormat("Y-m-d", $request->input('paid_date')) )
            $paidDateString     = $request->input('paid_date');
        

        /*fromDate*/
        if ( DateTime::createFromFormat("Y-m-d H:i:s", $request->input('from_date')) )
            $fromDateString     = (new DateTime($request->input('from_date')))->format("Y-m-d");             
                
        if ( DateTime::createFromFormat("Y-m-d", $request->input('from_date')) )
            $fromDateString     = $request->input('from_date');


        /*toDate*/
        if ( DateTime::createFromFormat("Y-m-d H:i:s", $request->input('to_date')) )
            $toDateString     = (new DateTime($request->input('to_date')))->format("Y-m-d");             
                
        if ( DateTime::createFromFormat("Y-m-d", $request->input('to_date')) )
            $toDateString     = $request->input('to_date');



        return new AuthorSalaryDto(
            $authorDTO,
            
            $request->input('id') ?? null,
            //$request->input('uuid') ?? null,
            $request->input('image'),            
            $request->input('paid_amount'),
            $paidDateString,
            $request->input('remarks') ?? null,            
            $fromDateString,
            $toDateString,                     
            $authorFeesArr
        );
    }


    public function createDtoById(int $authorSalaryId): ?AuthorSalaryDto {
        $data            = (new AuthorSalaryRepository())->findDtoDataById($authorSalaryId);
        $authorSalaryDto = (!empty($data))? self::fromArray($data): null;
        return $authorSalaryDto;
    }

}
