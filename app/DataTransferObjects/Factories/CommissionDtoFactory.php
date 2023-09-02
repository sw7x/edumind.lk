<?php
namespace App\DataTransferObjects\Factories;


use App\DataTransferObjects\Factories\AbstractDtoFactory;


use App\DataTransferObjects\CommissionDto;
use Illuminate\Http\Request;
use App\DataTransferObjects\Factories\UserDtoFactory;
use App\DataTransferObjects\Factories\CommissionFeeDtoFactory;
use App\Repositories\CommissionRepository;
use App\DataTransferObjects\Exceptions\MissingArgumentDtoException;
use \DateTime;
use App\Mappers\UserMapper;
use App\Mappers\CommissionFeeMapper;

class CommissionDtoFactory extends AbstractDtoFactory{

        
    public static function fromArray(array $data) : ?CommissionDto {        
        if(!isset($data['image']))
            throw new MissingArgumentDtoException('CommissionDto create failed due to missing image parameter');

        if(!isset($data['paidAmount']))
            throw new MissingArgumentDtoException('CommissionDto create failed due to missing paidAmount parameter');

        if(!isset($data['paidDate']))
            throw new MissingArgumentDtoException('CommissionDto create failed due to missing paidDate parameter');

        if(!isset($data['fromDate']))
            throw new MissingArgumentDtoException('CommissionDto create failed due to missing fromDate parameter');

        if(!isset($data['toDate']))
            throw new MissingArgumentDtoException('CommissionDto create failed due to missing toDate parameter');

        if( !isset($data['beneficiaryArr']) && !isset($data['beneficiaryId']) )
            throw new MissingArgumentDtoException('CommissionDto create failed due to missing both beneficiaryArr and beneficiaryId parameters');

        $commissionFeesArr = [];
        if (isset($data['fees']) && !empty($data['fees'])) {
            foreach ($data['fees'] as $commissionFee) {
                $commissionFeesArr[] = CommissionFeeDtoFactory::fromArray($commissionFee);
            }
        }                       
        
        $beneficiaryDTO =   (isset($data['beneficiaryArr']) && !empty($data['beneficiaryArr'])) ? 
                                UserDtoFactory::fromArray($data['beneficiaryArr']) : 
                                (new UserDtoFactory())->createDtoById($data['beneficiaryId']);
        
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


        return new CommissionDto(
            $beneficiaryDTO,
            
            $data['id'] ?? null,
            //$data['uuid'] ?? null,
            $data['image'] ?? null,             
            $data['paidAmount'] ?? null,
            $paidDateString,
            $data['remarks'] ?? null,             
            $fromDateString,
            $toDateString,
            $commissionFeesArr
        );        
    }

    
    
    public static function fromRequest(Request $request) : ?CommissionDto {        
        if(is_null($request->input('image')))
            throw new MissingArgumentDtoException('CommissionDto create failed due to missing image parameter');

        if(is_null($request->input('paid_amount')))
            throw new MissingArgumentDtoException('CommissionDto create failed due to missing paid_amount parameter');
        
        if(is_null($request->input('paid_date')))
            throw new MissingArgumentDtoException('CommissionDto create failed due to missing paid_date parameter');
        
        if(is_null($request->input('from_date')))
            throw new MissingArgumentDtoException('CommissionDto create failed due to missing from_date parameter');
        
        if(is_null($request->input('to_date')))
            throw new MissingArgumentDtoException('CommissionDto create failed due to missing to_date parameter');

        if( 
            ($request->input('beneficiary_id') == null) && 
            ($request->input('beneficiary_arr') === null || empty($request->input('beneficiary_arr')))
        ){
            throw new MissingArgumentDtoException('CommissionDto create failed due to missing both beneficiary_arr and beneficiary_id parameters');
        }


        $commissionFeesArr = [];            
        if ($request->input('fees') != null && !empty($request->input('fees'))) {
            foreach ($request->input('fees') as $commissionFee) {
                $commissionFeeDataArr      = CommissionFeeMapper::arrConvertToDtoArr($commissionFee);
                $commissionFeesArr[]       = CommissionFeeDtoFactory::fromArray($commissionFeeDataArr);
            }
        }
    
        if (!is_null($request->input('beneficiary_id'))) {
            $beneficiaryDTO     = (new UserDtoFactory())->createDtoById($request->input('beneficiary_id'));
        }else{
            $beneficiaryArr     = UserMapper::arrConvertToDtoArr($request->input('beneficiary_arr'));
            $beneficiaryDTO     = UserDtoFactory::fromArray($beneficiaryArr);
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



        return new CommissionDto(
            $beneficiaryDTO,
            
            $request->input('id') ?? null,
            //$request->input('uuid') ?? null,
            $request->input('image'),            
            $request->input('paid_amount'),
            $paidDateString,
            $request->input('remarks') ?? null,
            $fromDateString,
            $toDateString,         
            $commissionFeesArr
        );            
    }
    

    public function createDtoById(int $commissionRecId) : ?CommissionDto {
        $data            = (new CommissionRepository())->findDtoDataById($commissionRecId);
        //dd($data);
        $commissionDto = (!empty($data))? self::fromArray($data): null;
        return $commissionDto;
    }


}


