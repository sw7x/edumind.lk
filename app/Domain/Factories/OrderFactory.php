<?php


namespace App\Domain\Factories;

use Ramsey\Uuid\Uuid;

use App\Domain\Exceptions\InvalidArgumentDomainException;
use App\Domain\Exceptions\MissingArgumentDomainException;


use App\Domain\Order as OrderEntity;

use App\Domain\Factories\UserFactory;
use App\Domain\Factories\EnrollmentFactory;
use App\Domain\Factories\IFactory;
//use App\Domain\IEntity;
use App\Domain\ValueObjects\DateTimeVO;
use \DateTime;
use App\Mappers\EnrollmentMapper;
       


//class OrderFactory {
class OrderFactory implements IFactory {

    // ------> studentArr,   student_id  
    // ------> invoiceArr, invoice_id
    // ------> enrollmentsArr
	public function createObjTree(array $orderData): OrderEntity {			
		if(!isset($orderData['enrollmentsArr']))      
            throw new MissingArgumentDomainException("Missing enrollmentsArr parameter for create Order entity");              
        
        if(!isset($orderData['studentArr']))        
            throw new MissingArgumentDomainException("Missing studentArr parameter for create Order entity");              
        
		
		$enrollmentsArr  =  $orderData['enrollmentsArr'];
        $studentArr      =  $orderData['studentArr'];
        
        if(!is_array($enrollmentsArr))       
            throw new InvalidArgumentDomainException("enrollmentsArr parameter is not in correct format for create CouponCode entity");              
        
        if(!is_array($studentArr) || empty($studentArr))      
            throw new InvalidArgumentDomainException("studentArr parameter is not in correct format for create CouponCode entity");              
        

        //dd($orderData['checkoutDate']);
        //type validations
        if(isset($orderData['checkoutDate'])){
			if ( !DateTime::createFromFormat("Y-m-d H:i:s", $orderData['checkoutDate']) && 
			     !DateTime::createFromFormat("Y-m-d", $orderData['checkoutDate'])
			){  throw new InvalidArgumentDomainException("Invalid checkoutDate parameter to create Order entity"); }
		}


        $enrollmentsEntityArr = array();
		foreach ($enrollmentsArr as $key => $enrollment) {
			$enrollmentDataArr      = EnrollmentMapper::dbRecConvertToEntityArr($enrollment,false);
			$enrollmentsEntityArr[] = (new EnrollmentFactory())->createObjTree($enrollmentDataArr);
		}
        
        
		$studentEntity  = (new UserFactory())->createObjTree($studentArr);
		$orderEntity 	= new OrderEntity($enrollmentsEntityArr, $studentEntity);
		
		//dd('___');	
		//dump($enrollmentsEntityArr);dd('enrollmentsEntityArr');	

		if (!isset($orderData['id']) || $orderData['id'] == null) {
			$orderData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
		}

		if (isset($orderData['uuid'])) {
			$orderEntity->setUuid($orderData['uuid']);
		}		

		if (isset($orderData['id'])) {
			$orderEntity->setId($orderData['id']);
		}

		if(isset($orderData['checkoutDate'])){
			if ( DateTime::createFromFormat("Y-m-d H:i:s", $orderData['checkoutDate']) )
				$checkoutDateString     = (new DateTime($orderData['checkoutDate']))->format("Y-m-d");

			if ( DateTime::createFromFormat("Y-m-d", $orderData['checkoutDate']) )
				$checkoutDateString     = $orderData['checkoutDate'];
			
			$orderEntity->setCheckOutDate(new DateTimeVO(new DateTime($checkoutDateString)));
		}
		
		if(is_array($orderData['invoiceArr']) && !empty($orderData['invoiceArr'])){            
			$orderEntity->createInvoice($orderData['invoiceArr']);
		}
		//dd();
		//dump($orderEntity);dd('orderEntity');

		return $orderEntity;

	}


	public function createObj(array $orderData): OrderEntity {	
		if(!isset($orderData['enrollmentsArr']))        
            throw new MissingArgumentDomainException("Missing enrollmentsArr parameter for create Order entity");              
        
        if(!isset($orderData['studentArr']))   
            throw new MissingArgumentDomainException("Missing studentArr parameter for create Order entity");              
        

		$enrollmentsArr  =  $orderData['enrollmentsArr'];
        $studentArr      =  $orderData['studentArr'];
        
        if(!is_array($enrollmentsArr))     
            throw new InvalidArgumentDomainException("enrollmentsArr parameter is not in correct format for create CouponCode entity");              
        
        if(!is_array($studentArr) || empty($studentArr))        
            throw new InvalidArgumentDomainException("studentArr parameter is not in correct format for create CouponCode entity");              
                
        

        //type validations
        if(isset($orderData['checkoutDate'])){
			if ( !DateTime::createFromFormat("Y-m-d H:i:s", $orderData['checkoutDate']) && 
			     !DateTime::createFromFormat("Y-m-d", $orderData['checkoutDate'])
			){  throw new InvalidArgumentDomainException("Invalid checkoutDate parameter to create Order entity"); }
		}
		

        $enrollmentsEntityArr = array();
        foreach ($enrollmentsArr as $key => $enrollment) {
        	$enrollmentsEntityArr[] = (new EnrollmentFactory())->createObj($enrollment);
        }
        
		$studentEntity  = (new UserFactory())->createObj($studentArr);		
		$orderEntity 	= new OrderEntity($enrollmentsEntityArr, $studentEntity);
		
		if (!isset($orderData['id']) || $orderData['id'] == null) {
			$orderData['uuid'] = str_replace('-', '', Uuid::uuid4()->toString());
		}

		if (isset($orderData['uuid'])) {
			$orderEntity->setUuid($orderData['uuid']);
		}		

		if (isset($orderData['id'])) {
			$orderEntity->setId($orderData['id']);
		}

		if(isset($orderData['checkoutDate'])){
			if ( DateTime::createFromFormat("Y-m-d H:i:s", $orderData['checkoutDate']) )
				$checkoutDateString     = (new DateTime($orderData['checkoutDate']))->format("Y-m-d");
			
			if ( DateTime::createFromFormat("Y-m-d", $orderData['checkoutDate']) )
				$checkoutDateString     = $orderData['checkoutDate'];
			
			$orderEntity->setCheckOutDate(new DateTimeVO(new DateTime($checkoutDateString)));
		}

		return $orderEntity;
	}


}
