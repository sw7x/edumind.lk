<?php


namespace App\Mappers;

use App\Mappers\Mapper;
use App\Mappers\UserMapper;

class CommissionMapper extends Mapper{
    
	   
    protected const mapper = [

        /*  DB Record  <===_convet_to_===>  ENTITY  */
        self::DATABSE_MAP => [
            ['id',            '<=>',  'id'],
            ['uuid',          '<=>',  'uuid'],
            ['image',         '<=>',  'image'],
            ['paid_amount',   '<=>',  'paidAmount'],
            ['paid_date',     '<=>',  'paidDate'],
            ['remarks',       '<=>',  'remarks'],
            ['from_date',     '<=>',  'fromDate'],
            ['to_date',       '<=>',  'toDate'],      
            
            ['fees',          '<=>',  'fees'],
   
            ['beneficiary_id',             '<=>',  'beneficiaryId'],

            '__ARRAY__' => [
                [
                    "beneficiary_arr",     '<=>',   "beneficiaryArr",    UserMapper::mapper['DATABSE_MAP']
                ]
            ]
        ],
        

        /*  ENTITY  <===_convet_to_===>  DTO  */
        self::ENTITY_MAP => [

            'id'            =>     'id',


            ['id',            '<=>',     'id'],
            ['uuid',          '<=>',     'uuid'],
            ['image',         '<=>',     'image'],
            ['paid_amount',   '<=>',     'paidAmount'],
            ['paid_date',     '<=>',     'paidDate'],
            ['remarks',       '<=>',     'remarks'],
            ['from_date',     '<=>',     'fromDate'],
            ['to_date',       '<=>',     'toDate'],       
            
            ['fees',          '<=>',     'commissionFeeDtoArr'],
            //'beneficiary'        <=> 'beneficiaryDTO',beneficiary_id

            '__ARRAY__' => [
                [
                    "beneficiary_arr",     '<=>',   "beneficiaryDto",    UserMapper::mapper['ENTITY_MAP']
                ]
            ]



        ],
        

        /*  DTO  <===_convet_to_===>  Array(from frontend)  */
        self::POST_MAP => [
            ['id',                  '<=>',      'id'],
            ['uuid',                '<=>',      'uuid'],
            ['image',               '<=>',      'image'],
            ['paidAmount',          '<=>',      'paid_amount'],
            ['paidDate',            '<=>',      'paid_date'],
            ['remarks',             '<=>',      'remarks'],
            ['fromDate',            '<=>',      'from_date'],
            ['toDate',              '<=>',      'to_date'],       
            
            ['fees',                '<=>',      'fees'],            
            
            ['beneficiaryId',      	'<=>',      'beneficiary'],
            
            '__ARRAY__' => [
                [
                    "beneficiaryArr",     '<=>',   "beneficiary_arr",    UserMapper::mapper['POST_MAP']
                ]
            ]
        ],

    ];




}

