<?php

namespace App\Mappers;

use App\Mappers\Mapper;


use App\Mappers\CourseItemMapper;
use App\Mappers\UserMapper;


use App\Mappers\AuthorFeeMapper;
use App\Mappers\CommissionFeeMapper;
use App\Mappers\EdumindFeeMapper;



class EnrollmentMapper extends Mapper{
    

    //fk==> course_selection_id
    //fk==> invoice_id
    //fk==> salary_id
    //fk==> commission_id 


	protected const mapper = [

        /*  DB Record  <===_convet_to_===>  ENTITY  */
        self::DATABSE_MAP => [
            ['id', 			        '<=>',      'id'],
            ['uuid', 			    '<=>',      'uuid'],
            ['is_complete', 	    '<=>',      'isComplete'],
            ['complete_date',       '<=>',      'completeDate'],
            ['rating',              '<=>',      'rating'],

            ['course_selection_id', '<=>',      'courseItemId'],
            
            //['student_id',        '<=>',      'student'],
            ['',                    '<=>',      'student'],
            
            ['',                    '<=>',      'courseMessages'],

            '__ARRAY__' => [
                [
                    "",     '<=>',   "courseItemObj",    CourseItemMapper::mapper['DATABSE_MAP']
                ],
                [
                    "",     '<=>',   "studentObj",    UserMapper::mapper['DATABSE_MAP']
                ],
                [
                    "",     '<=>',   "authorFeeObj",    AuthorFeeMapper::mapper['DATABSE_MAP']
                ],
                [
                    "",     '<=>',   "commissionFeeObj",    CommissionFeeMapper::mapper['DATABSE_MAP']
                ],
                [
                    "",     '<=>',   "edumindFeeObj",    EdumindFeeMapper::mapper['DATABSE_MAP']
                ]
            ],
            
        ],
        

        /*  ENTITY  <===_convet_to_===>  DTO  */
        self::ENTITY_MAP => [
            ['id', 			     '<=>',     'id'],
            ['uuid', 			 '<=>',     'uuid'],
            ['isComplete', 	 '<=>',     'is_complete'],
            ['completeDate', 	 '<=>',     'complete_date'],
            ['rating',           '<=>',     'rating'],            

            /*
            'courseItem'     => 'courseItemDTO',course_selection_id
            'student'        => 'studentDTO',student_id
            
            'authorFee'      => 'authorFeeDTO',
            'commissionFee'  => 'commissionFeeDTO',
            'edumindFee'     => 'edumindFeeDTO',
            */

            '__ARRAY__' => [
                [
                    "course_item_arr",     '<=>',   "courseItemDto",    CourseItemMapper::mapper['ENTITY_MAP']
                ],
                [
                    "student_arr",         '<=>',   "studentDto",    UserMapper::mapper['ENTITY_MAP']
                ],
                [
                    "-author_fee_arr",     '<=>',   "authorFeeDto",    AuthorFeeMapper::mapper['ENTITY_MAP']
                ],
                [
                    "-commission_fee_arr", '<=>',   "commissionFeeDto",    CommissionFeeMapper::mapper['ENTITY_MAP']
                ],
                [
                    "-edumind_fee_arr",    '<=>',   "edumindFeeDto",    EdumindFeeMapper::mapper['ENTITY_MAP']
                ]
            ],
        ],



        /*  ENTITY  <===_convet_to_===>  DTO  
        self::ENTITY_MAP => [
            ['id',               '<=>',     'id'],
            ['uuid',             '<=>',     'uuid'],
            ['is_complete',      '<=>',     'isComplete'],
            ['complete_date',    '<=>',     'completeDate'],
            ['rating',           '<=>',     'rating'],            

           
            //'courseItem'     => 'courseItemDTO',course_selection_id
            //'student'        => 'studentDTO',student_id
            
            //'authorFee'      => 'authorFeeDTO',
            //'commissionFee'  => 'commissionFeeDTO',
            //'edumindFee'     => 'edumindFeeDTO',
            //

            '__ARRAY__' => [
                [
                    "course_item_arr",     '<=>',   "courseItemDto",    CourseItemMapper::mapper['ENTITY_MAP']
                ],
                [
                    "student_arr",         '<=>',   "studentDto",    UserMapper::mapper['ENTITY_MAP']
                ],
                [
                    "-author_fee_arr",     '<=>',   "authorFeeDto",    AuthorFeeMapper::mapper['ENTITY_MAP']
                ],
                [
                    "-commission_fee_arr", '<=>',   "commissionFeeDto",    CommissionFeeMapper::mapper['ENTITY_MAP']
                ],
                [
                    "-edumind_fee_arr",    '<=>',   "edumindFeeDto",    EdumindFeeMapper::mapper['ENTITY_MAP']
                ]
            ],
        ],
        */
        

        /*  DTO  <===_convet_to_===>  Array(from frontend)  */
        self::POST_MAP => [
            ['id', 			        '<=>',      'id'],
            ['uuid', 			    '<=>',      'uuid'],
            ['isComplete', 	    	'<=>',      'is_complete'],
            ['completeDate',       	'<=>',      'complete_date'],
            ['rating',              '<=>',      'rating'],

            ['courseItemId', 		'<=>',      'courseItem'],
                    
            ['studentId',          	'<=>',      'student'],
           
            '__ARRAY__' => [
                [
                    "courseItemArr",	'<=>',   "course_item_arr",    CourseItemMapper::mapper['POST_MAP']
                ],
                [
                    "studentArr",       '<=>',   "student_arr",    UserMapper::mapper['POST_MAP']
                ]                
            ],
        ],






    ];

    




    
}