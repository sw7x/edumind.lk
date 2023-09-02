<?php


namespace App\Mappers;


use App\Mappers\Mapper;

class InvoiceMapper extends Mapper{
    
	public const  mapper = [	    

        /*  DB Record  <===_convet_to_===>  ENTITY  */
        self::DATABSE_MAP => [
            ['id', 			    '<=>',     'id'],
            ['uuid', 	        '<=>',     'uuid'],
            ['checkout_date',   '<=>',     'checkoutDate'],
            ['billing_info', 	'<=>',     'billingInfo'],
            ['paid_amount',     '<=>',     'paidAmount'],
        ],
        

        /*  DTO  <===_convet_to_===>  Array(from frontend)  */
        self::POST_MAP => [
            ['id', 		         '<=>',       'id'],
            ['uuid', 		     '<=>',       'uuid'],
            ['checkoutDate',     '<=>',       'checkout_date'],
            ['billingInfo',      '<=>',       'billing_info'],
            ['paidAmount',       '<=>',       'paid_amount'],   
        ],


    ]; 		

}
