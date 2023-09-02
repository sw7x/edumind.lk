<?php

namespace App\DataTransferObjects\Factories;

//use Ramsey\Uuid\Uuid;

use App\Repositories\InvoiceRepository;
use App\DataTransferObjects\Factories\AbstractDtoFactory; 
use App\DataTransferObjects\InvoiceDto;
use Illuminate\Http\Request;
use \DateTime;

class InvoiceDtoFactory  extends AbstractDtoFactory
{
    
	public static function fromArray(array $data) : ?InvoiceDto {        
        
        if(isset($data['checkoutDate'])){
            if ( DateTime::createFromFormat("Y-m-d H:i:s", $data['checkoutDate']) )
                $checkoutDateString     = (new DateTime($data['checkoutDate']))->format("Y-m-d");

            if ( DateTime::createFromFormat("Y-m-d", $data['checkoutDate']) )
                $checkoutDateString     = $data['checkoutDate'];
        }  

        return new InvoiceDto(
            $data['id'] ?? null,                      
            $checkoutDateString ?? null,   
            $data['billingInfo'] ?? null,
            $data['paidAmount'] ?? null,                    
        );        
    }
    
    public static function fromRequest(Request $request) : ?InvoiceDto {        
        
        if($request->has('checkoutDate') && $request->filled('checkoutDate')){
            if ( DateTime::createFromFormat("Y-m-d H:i:s", $request->input('checkoutDate')) )
                $checkoutDateString     = (new DateTime($request->input('checkoutDate')))->format("Y-m-d");

            if ( DateTime::createFromFormat("Y-m-d", $request->input('checkoutDate')) )
                $checkoutDateString     = $request->input('checkoutDate');
        }

        return new InvoiceDto(
            $request->input('id') ?? null,
            $checkoutDateString ?? null,
            $request->input('billing_info') ?? null,
            $request->input('paid_amount') ?? null
        );        
    }


    public function createDtoById(int $invoiceId) : ?InvoiceDto {
        $data       = (new InvoiceRepository())->findDtoDataById($invoiceId);
        $invoiceDTO = (!empty($data))? self::fromArray($data): null;        
        return $invoiceDTO;
    }


}
