<?php


namespace App\Repositories;

//use App\Domain\Exceptions\InvalidArgumentException;

use App\Models\Invoice as InvoiceModel;


//get all orders of a student
use App\Repositories\UserRepository;
use App\Repositories\CourseItemRepository;
use App\Repositories\Interfaces\IGetDataRepository;


class OrderRepository implements IGetDataRepository{
    
    
    public function allOrders(): array {		

		$orderJoinQuery = 	InvoiceModel::join('enrollments', 'invoices.id', '=', 'enrollments.invoice_id')
								->join('course_selections', 'enrollments.course_selection_id', '=', 'course_selections.id')
								->join('courses', 'course_selections.course_id', '=', 'courses.id')
								->join('users', 'course_selections.student_id', '=', 'users.id')
								->leftJoin('coupons', 'course_selections.used_coupon_code', '=', 'coupons.code')
								->orderBy('invoices.checkout_date','desc')
								->orderBy('enrollments.updated_at','desc');
				
		$orders = 	$orderJoinQuery->get([
						'invoices.id as invoice_id',
						'courses.id as course_id',
						'users.id as student_id',						
						'course_selections.id as course_selection_id',						
						'coupons.code',
						'enrollments.*'
					]);


				
		$ordersArr 			= $orders->toArray();
		$invoiceIdArr 		= array_values(array_unique(array_column($ordersArr, 'invoice_id')));
		
		$filArr 	  		= array();
		$formattedOrderArr 	= array();
		foreach ($invoiceIdArr as $val) {
			$filArr[$val] = array_filter($ordersArr, function ($record) use ($val){
				return $record['invoice_id'] == $val;
			});
			$formattedOrderArr[$val] = array_values($filArr[$val]);
		}
		
		// manually cast 'is_complete' attribute to boolean
		foreach ($formattedOrderArr as $invoiceKey => $invoiceArr) {
			foreach ($invoiceArr as $arrkey => $invoiceItem) {
				$changeval = $formattedOrderArr[$invoiceKey][$arrkey]['is_complete'];
				$changeval = ($changeval === 1 || $changeval === 0) ? (bool) $changeval : $changeval;
				$formattedOrderArr[$invoiceKey][$arrkey]['is_complete'] = $changeval;
			}
		}
		return $formattedOrderArr;		
	}


	public function allOrdersDtoData(): array {

		$orderArr = $this->allOrders();
		$formattedOrderArr = array();
		foreach ($orderArr as $key => $value) {		
			$tempArr = $this->formatOrderData($value);
			$formattedOrderArr[$key] = $tempArr[$key];
		}
		return $formattedOrderArr;
	}

	public function findDataArrById(int $invoiceId): array{
				
		$allOrders 		= $this->allOrders();
		//dump($allOrders);
		$data 			= array_key_exists($invoiceId, $allOrders)? $allOrders[$invoiceId] : [];
		//dump('data - ');
		//dd($data);
		$formatOrder  	= $this->formatOrderData2($data);
		//dump('formatOrder - ');
		//dump($formatOrder);
		return $formatOrder[$invoiceId] ?? [];		
	}
    
    public function findDtoDataById(int $invoiceId): array {
        $data = $this->findDataArrById($invoiceId);
        return arrKeysSnakeToCamel($data);
        //return UserMapper::dbRecConvertToEntityArr($data);
    }






	private function formatOrderData2(array $dataArr = []) : array {
  		
  		//dd($dataArr);
  		if(empty($dataArr)) return [];
  		$orderId 	= $dataArr[0]['invoice_id'];
  		$userId 	= $dataArr[0]['student_id'];
  		
  		$customerDataArr 	= ($userId) ? (new UserRepository())->findDataArrById($userId) : [];
  		$invoiceDataArr 	= ($orderId)? (new InvoiceRepository())->findDataArrById($orderId) : [];

    	$orderData = array(
    		"invoice_arr" => $invoiceDataArr,
    		"student_arr" => $customerDataArr,
    	);

    	$enrollmentsArr = array();
		$courseItemArr  = array();
    	foreach ($dataArr as $value) {
    		
    		$courseDataArr  	= ($value['course_id']) ? (new CourseRepository())->findDataArrById($value['course_id']) : [];
    		$couponDataArr  	= ($value['code']) ? (new CouponRepository())->findDataArrByCode($value['code']) : [];
			//$courseSelectionDataArr = ($value['course_selection_id']) ? (new CourseSelectionRepository())->findById($value['course_selection_id']) : [];
    		$studentDataArr 	= ($value['student_id']) ? (new UserRepository())->findDataArrById($value['student_id']) : [];
    		
    		$couseItemDataArr 	= ($value['course_selection_id']) ? (new CourseItemRepository())->findDataArrById($value['course_selection_id']) : [];

    		
    		$enrollmentsArr[] = array(
    			//'assigned_course' 		=> $courseDataArr,
    			//'coupon'   				=> $couponDataArr,
    			//"cart_added_date" 		=> $courseSelectionDataArr['cart_added_date'],
      			//"discount_amount" 		=> $courseSelectionDataArr['revised_price'],
      			//"cours_revised_price" 	=> $courseSelectionDataArr['discount_amount']

      			'id' 					=> $value['id'],
				'uuid' 					=> $value['uuid'],
      			'is_complete' 			=> $value['is_complete'],
      			'complete_date' 		=> $value['complete_date'],
      			'rating' 				=> $value['rating'],
      			"invoice_id" 			=> $value['invoice_id'],
  				"salary_id" 			=> $value['salary_id'],
  				"commission_id" 		=> $value['commission_id'],
				
				'course_selection_id' 	=> $value['course_selection_id'],
      			
      			//'order' 				=> $value['rating'],
      			'course_item_arr' 		=> $couseItemDataArr,
      			
      			'student_id' 			=> $value['student_id'],
      			'student_arr' 			=> $studentDataArr
      		);


    		/*$courseItemArr[] = array(
    			'id' 						=> $courseSelectionDataArr['id'],
				'cart_added_date' 			=> $courseSelectionDataArr['cart_added_date'],
				'is_checkout' 				=> $courseSelectionDataArr['is_checkout'],
				'edumind_amount' 			=> $courseSelectionDataArr['edumind_amount'],
				'author_amount'				=> $courseSelectionDataArr['author_amount'],
				'discount_amount' 			=> $courseSelectionDataArr['discount_amount'],
				'revised_price'				=> $courseSelectionDataArr['revised_price'],
				'edumind_lose_amount'		=> $courseSelectionDataArr['edumind_lose_amount'],
				'beneficiary_earn_amount'	=> $courseSelectionDataArr['beneficiary_earn_amount'],
				      			
				'course' 				=> $courseDataArr,
				'used_coupon'   		=> $couponDataArr,
				'student'				=> $studentDataArr
			);*/
    	}

    	$orderData['enrollments_arr'] 	= $enrollmentsArr;
    	$orderData['student_id']    	= $userId;
    	$orderData['invoice_id']    	= $orderId;
    	$orderData['checkout_date'] 	= $invoiceDataArr['checkout_date'];
    	//$orderData['courseItems'] 	= $courseItemArr;
    	return array( $orderId => $orderData);
    }

}


