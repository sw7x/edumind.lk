<?php


namespace App\Mappers;

use App\Mappers\Mapper;
//use App\Mappers\InvoiceMapper;
//use App\Mappers\UserMapper;





class OrderMapper extends Mapper{
    
	public const  mapper = [	    
	
        
        /*  DB Record  <--- convet_to ---  ENTITY toArray Output
            DB Record  --- convet_to --->  ENTITY Factory Input  */        
        self::DATABSE_MAP => [
            ['id',              '<=>',     	'id'],
            ['uuid',            '<=>',     	'uuid'],
            ['checkout_date',   '<=>',     	'checkoutDate'],            
			['student_id', 		'<=>', 		'studentId'],
			['invoice_id', 		'<=>', 		'invoiceId'],
            ['enrollments_arr', '<=>',     	'enrollmentsArr'],
                                            
            '__ARRAY__' => [
                [
                    "invoice_arr",     	'<=>',   "invoiceArr",    	InvoiceMapper::mapper['DATABSE_MAP']
                ],
                [
                    "student_arr",    	'<=>',   "studentArr",   	UserMapper::mapper['DATABSE_MAP']
                ]
            ]
        ],
		
        
        /*  DTO Factory Input   <--- convet_to ---  Array(from frontend)
            DTO toArray Output  --- convet_to --->  Array(from frontend)  */ 
		self::POST_MAP => [
            ['id',              '=>',     	'id'],
            ['uuid',            '=>',     	'uuid'],
            ['checkoutDate',    '=>',     	'checkout_date'],            
			['studentId', 		'=>', 		'student_id'],
			['invoiceId', 		'=>', 		'invoice_id'],
            ['enrollmentsArr',  '=>',     	'enrollments_arr'],
                   
            '__ARRAY__' => [
                [
                    "invoiceArr",     	'=>',   "invoice_arr",    	InvoiceMapper::mapper['POST_MAP']
                ],
                [
                    "studentArr",    	'=>',   "student_arr",   	UserMapper::mapper['POST_MAP']
                ]
            ]
        ],
		
		
		
		
		
		

    ];         


}


