<?php


namespace App\Mappers;

use App\Mappers\Mapper;

class AuthorSalaryMapper  extends Mapper
{        
    
    public const mapper = [

        /*  DB Record  <--- convet_to ---  ENTITY toArray Output
            DB Record  --- convet_to --->  ENTITY Factory Input  */
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
            
            ['author_id',     '<=>',  'authorId'],
            
            '__ARRAY__' => [
                [
                    "author_arr",       '<=>',   "authorArr",    UserMapper::mapper['DATABSE_MAP']
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
            
            ['fees',                '<=>',      'fees'],            
            
            
            ['authorId',            '<=>',      'author'],
            ['authorId',            '<=',       'author_id'],
            

            '__ARRAY__' => [
                [
                    "authorArr",     '<=>',   "author_arr",    UserMapper::mapper['POST_MAP']
                ]
            ] 
        ],

    ];         

}



/*  DB Record  <--- convet_to ---  ENTITY toArray Output
            DB Record  --- convet_to --->  ENTITY Factory Input  */
/*  DTO Factory Input   <--- convet_to ---  Array(from frontend)
            DTO toArray Output  --- convet_to --->  Array(from frontend)  */
    