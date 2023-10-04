<?php


namespace App\Mappers;

use App\Mappers\Mapper;
use App\Mappers\UserMapper;

class CommissionMapper extends Mapper{
    
	   
    public const mapper = [

        /*  DB Record  <--- convet_to ---  ENTITY toArray Output
            DB Record  --- convet_to --->  ENTITY Factory Input  */
        self::DATABSE_MAP => [
            ['id',              '<=>',      'id'],
            ['uuid',            '<=>',      'uuid'],
            ['image',           '<=>',      'image'],
            ['paid_amount',     '<=>',      'paidAmount'],
            ['paid_date',       '<=>',      'paidDate'],
            ['remarks',         '<=>',      'remarks'],
            ['from_date',       '<=>',      'fromDate'],
            ['to_date',         '<=>',      'toDate'],      
            
            ['fees',            '=>',       'fees'],
   
            ['beneficiary_id',  '=>',       'beneficiaryId'],

            '__ARRAY__' => [
                [
                    "beneficiary_arr",     '=>',   "beneficiaryArr",    UserMapper::mapper['DATABSE_MAP']
                ]
            ]
        ],
        

        /*  DTO Factory Input   <--- convet_to ---  Array(from frontend)
            DTO toArray Output  --- convet_to --->  Array(from frontend)  */ 
        self::POST_MAP => [
            ['id',                  '<=>',      'id'],
            ['uuid',                '<=>',      'uuid'],
            ['image',               '<=>',      'image'],
            ['paidAmount',          '<=>',      'paid_amount'],
            ['paidDate',            '<=>',      'paid_date'],
            ['remarks',             '<=>',      'remarks'],
            ['fromDate',            '<=>',      'from_date'],
            ['toDate',              '<=>',      'to_date'],       
            
            ['fees',                '=>',       'fees'],            
            
            ['beneficiaryId',      	'<=>',      'beneficiary'],
            ['beneficiaryId',       '<=',       'beneficiary_id'],
            
            '__ARRAY__' => [
                [
                    "beneficiaryArr",     '=>',   "beneficiary_arr",    UserMapper::mapper['POST_MAP']
                ]
            ]
        ],

    ];




}

