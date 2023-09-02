<?php


namespace App\Mappers;

use App\Mappers\Mapper;

class AuthorSalaryMapper  extends Mapper
{        
    
    public const mapper = [

        /*  DB Record (source array to create entity) <===_convet_to_===>  ENTITY (Entity convert to Array) */
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
        

        /*  DTO (source array to create dto) <===_convet_to_===>  Array(from frontend)  */
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




    