<?php

namespace App\DataTransferObjects\Factories;

use App\DataTransferObjects\Factories\InvoiceDtoFactory;
use App\DataTransferObjects\Factories\UserDtoFactory;
use App\DataTransferObjects\Factories\AbstractDtoFactory;
use Illuminate\Http\Request;
use App\DataTransferObjects\Factories\EnrollmentDtoFactory;
use App\DataTransferObjects\OrderDto;

use App\Repositories\OrderRepository;
use App\DataTransferObjects\Exceptions\MissingArgumentDtoException;
use App\DataTransferObjects\Exceptions\InvalidArgumentDtoException;

use App\Mappers\UserMapper;
use App\Mappers\InvoiceMapper;
use App\Mappers\EnrollmentMapper;
use \DateTime;

class OrderDtoFactory extends AbstractDtoFactory
{
    
    //-------->enrollments_arr array
    //-------->student_id, student_arr array
	//-------->invoice_id, invoice_arr array

    public static function fromArray(array $data): ?OrderDto{

        if( !isset($data['enrollmentsArr']) )
            throw new MissingArgumentDtoException('OrderDto create failed due to missing enrollmentsArr parameter');        

        if( empty($data['enrollmentsArr']) )
            throw new InvalidArgumentDtoException('OrderDto create failed due to empty enrollmentsArr parameter'); 

        if( !isset($data['studentId']) && !isset($data['studentArr']) )
            throw new MissingArgumentDtoException('OrderDto create failed due to missing both studentArr and studentId parameters');

        $enrollments = [];
        foreach ($data['enrollmentsArr'] as $enrollmentData) {
            $enrollmentDataArr  = EnrollmentMapper::dbRecConvertToEntityArr($enrollmentData,false);
            $enrollments[]      = EnrollmentDtoFactory::fromArray($enrollmentDataArr);
        }

        $customerDto    =   (isset($data['studentArr']) && !empty($data['studentArr'])) ? 
                                (UserDtoFactory::fromArray($data['studentArr'])) : 
                                (new UserDtoFactory())->createDtoById($data['studentId']);
        
        $invoiceDto     =   (isset($data['invoiceArr']) && !empty($data['studentArr'])) ?
                                InvoiceDtoFactory::fromArray($data['invoiceArr']) : 
                                (isset($data['invoiceId']) ? 
                                    (new InvoiceDtoFactory())->createDtoById($data['invoiceId']) : 
                                    null 
                                );
        
        if(isset($data['checkoutDate'])){
            if ( DateTime::createFromFormat("Y-m-d H:i:s", $data['checkoutDate']) )
                $checkoutDateString     = (new DateTime($data['checkoutDate']))->format("Y-m-d");

            if ( DateTime::createFromFormat("Y-m-d", $data['checkoutDate']) )
                $checkoutDateString     = $data['checkoutDate'];
        }                    

        return new OrderDto(                               
            $enrollments,          
            $customerDto,

            $checkoutDateString ?? null,                
            $data['id'] ?? null,
            //$data['uuid'] ?? null,               
            $invoiceDto
        );        
    }

    
    public static function fromRequest(Request $request): ?OrderDto {
        if( ($request->input('enrollments_arr') === null) )
            throw new MissingArgumentDtoException('OrderDto create failed due to missing enrollments_arr parameter'); 
        
        if( empty($request->input('enrollments_arr')) )
            throw new InvalidArgumentDtoException('OrderDto create failed due to empty enrollmentsArr parameter');

        if( 
            ( $request->input('student_id')  == null) && 
            ( $request->input('student_arr') === null || empty($request->input('student_arr')) ) 
        ){
            throw new MissingArgumentDtoException('OrderDto create failed due to missing both student_arr and student_id parameters');
        }

        $enrollments = [];
        foreach ($request->input('enrollments_arr') as $enrollmentData) {
            $enrollmentDataArr = EnrollmentMapper::arrConvertToDtoArr($enrollmentData);
            $enrollments[]     = EnrollmentDtoFactory::fromArray($enrollmentDataArr);
        }          
        
        
        if($request->has('student_id') && $request->filled('student_id')){
            $customerDto    = (new UserDtoFactory())->createDtoById($request->input('student_id'));
        }else{
            $studentArr     = UserMapper::arrConvertToDtoArr($request->input('student_arr'));
            $customerDto    = UserDtoFactory::fromArray($studentArr);
        }


        $invoiceDto = null;        
        if($request->has('invoice_id') && $request->filled('invoice_id')){
            $invoiceDto = (new InvoiceDtoFactory())->createDtoById($request->input('invoice_id'));
        }elseif (
            $request->has('invoice_arr') && 
            $request->filled('invoice_arr') && 
            !empty($request->input('invoice_arr'))
        ) {
            $invoiceArr     = InvoiceMapper::arrConvertToDtoArr($request->input('invoice_arr'));
            $invoiceDto     = InvoiceDtoFactory::fromArray($invoiceArr);             
        }
        

        if($request->has('checkout_date') && $request->filled('checkout_date')){
            if ( DateTime::createFromFormat("Y-m-d H:i:s", $request->input('checkout_date')) )
                $checkoutDateString     = (new DateTime($request->input('checkout_date')))->format("Y-m-d");

            if ( DateTime::createFromFormat("Y-m-d", $request->input('checkout_date')) )
                $checkoutDateString     = $request->input('checkout_date');
        }


        return new OrderDto(
            $enrollments,
            $customerDto,

            $checkoutDateString ?? null,
            $request->input('invoice_id') ?? null,
            //$request->input('uuid') ?? '',
            $invoiceDto
        );   
    }


    public function createDtoById(int $invoiceId): ?OrderDto {
        $data       = (new OrderRepository())->findDtoDataById($invoiceId);
        //dump($data);        
        //$data       = (new OrderRepository())->findDtoDataById($invoiceId);
        //dump($data);
        $orderDto   = (!empty($data))? self::fromArray($data): null;
        return $orderDto;
    }


}