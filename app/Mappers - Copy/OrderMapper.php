<?php


namespace App\Mappers;

use App\Mappers\Mapper;
use App\Mappers\SubjectMapper;
use App\Mappers\UserMapper;





class OrderMapper  extends Mapper{
    	    
	protected $mapper = [

        /*  ENTITY  <===_convet_to_===>  DTO  */
        self::ENTITY_MAP => [
            ['id',              '<=>',     'id'],
            ['uuid',            '<=>',     'uuid'],
            ['checkout_date',   '<=>',     'checkoutDate'],
            
            //['invoice_arr',   '<=>',     'invoiceDTO'],
            
            ['enrollments_arr', '<=>',     'enrollments'],
                    
            '__ARRAY__' => [
                [
                    "invoice_arr",     '<=>',   "invoiceDto",    SubjectMapper::mapper['ENTITY_MAP']
                ],
                [
                    "student_arr",    '<=>',   "customerDto",   UserMapper::mapper['ENTITY_MAP']
                ]
            ]
        ]

    ];         


}