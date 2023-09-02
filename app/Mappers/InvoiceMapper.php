<?php


namespace App\Mappers;


use App\Mappers\Mapper;

class InvoiceMapper extends Mapper{
    
	public const  mapper = [	    

        /*  DB Record  <--- convet_to ---  ENTITY toArray Output
            DB Record  --- convet_to --->  ENTITY Factory Input  */
        self::DATABSE_MAP => [
            ['id', 			    '<=>',     'id'],
            ['uuid', 	        '<=>',     'uuid'],
            ['checkout_date',   '<=>',     'checkoutDate'],
            ['billing_info', 	'<=>',     'billingInfo'],
            ['paid_amount',     '<=>',     'paidAmount'],
        ],
        
        /*  DTO Factory Input   <--- convet_to ---  Array(from frontend)
            DTO toArray Output  --- convet_to --->  Array(from frontend)  */ 
        self::POST_MAP => [
            ['id', 		         '<=>',       'id'],
            ['uuid', 		     '<=>',       'uuid'],
            ['checkoutDate',     '<=>',       'checkout_date'],
            ['billingInfo',      '<=>',       'billing_info'],
            ['paidAmount',       '<=>',       'paid_amount'],   
        ],


    ]; 		

}
