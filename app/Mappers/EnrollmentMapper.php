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


	public const mapper = [

        /*  DB Record  <===_convet_to_===>  ENTITY  */
        self::DATABSE_MAP => [
            ['id', 			        '<=>',      'id'],
            ['uuid', 			    '<=>',      'uuid'],
            ['is_complete', 	    '<=>',      'isComplete'],
            ['complete_date',       '<=>',      'completeDate'],
            ['rating',              '<=>',      'rating'],

            ['course_item_id',      '<=>',      'courseItemId'],
            
            ['student_id',          '<=>',      'studentId'],            
            
            '__ARRAY__' => [
                [   
                    "course_item_arr",      '<=>',   "courseItemArr",    CourseItemMapper::mapper['DATABSE_MAP']
                ],
                [
                    "student_arr",          '<=>',   "studentArr",    UserMapper::mapper['DATABSE_MAP']
                ],
                [
                    "",                     '<=',    "authorFeeArr",    AuthorFeeMapper::mapper['DATABSE_MAP']
                ],
                [
                    "",                     '<=',    "commissionFeeArr",    CommissionFeeMapper::mapper['DATABSE_MAP']
                ],
                [
                    "",                     '<=',    "edumindFeeArr",    EdumindFeeMapper::mapper['DATABSE_MAP']
                ]
            ],
            
        ],
        

        /*  DTO  <===_convet_to_===>  Array(from frontend)  */
        self::POST_MAP => [
            ['id', 			        '<=>',      'id'],
            ['uuid', 			    '<=>',      'uuid'],
            ['isComplete', 	    	'<=>',      'is_complete'],
            ['completeDate',       	'<=>',      'complete_date'],
            ['rating',              '<=>',      'rating'],

            ['courseItemId', 		'<=>',      'courseItem'],
            ['courseItemId',        '<=',       'course_item_id'],
                    
            ['studentId',          	'<=>',      'student'],
            ['studentId',           '<=',       'student_id'],
           
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