<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

use App\Models\Invoice as InvoiceModel;
use App\Repositories\Interfaces\IGetDataRepository;
use App\Mappers\InvoiceMapper;

class InvoiceRepository extends BaseRepository implements IGetDataRepository{
    
	public function __construct(){
        parent::__construct(InvoiceModel::make());        
    }
    
    public function findDataArrById($invoiceId): array{
        
        try {
            
            $invoiceRec = $this->findById($invoiceId);
            
            if(is_null($invoiceRec)) return [];

            $invoiceArr = $invoiceRec->toArray();
            
            unset($invoiceArr['created_at']);
            unset($invoiceArr['updated_at']);
            unset($invoiceArr['deleted_at']);  

            $invoiceArr['billing_info'] = $invoiceArr['billing_info'];            
            
        } catch (\JsonException $exception) {  
            $invoiceArr['billing_info'] = [];
        }
        return $invoiceArr;
    }
    
    
    public function findDtoDataById(int $invoiceId): array {
        $data = $this->findDataArrById($invoiceId);
        return InvoiceMapper::dbRecConvertToEntityArr($data);
    }
    

}
