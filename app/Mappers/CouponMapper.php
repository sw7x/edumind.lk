<?php

namespace App\Mappers;

use App\Mappers\Mapper;

use App\Mappers\CourseMapper;
use App\Mappers\UserMapper;



class CouponMapper extends Mapper
{ 
	
	public const mapper = [

        /*  DB Record  <===_convet_to_===>  ENTITY  */
        self::DATABSE_MAP => [
            ['code',                                              '<=>',        'code'],
            ['uuid',                                              '<=>',        'uuid'],
            ['discount_percentage',                               '<=>',        'discountPercentage'],
            ['beneficiary_commision_percentage_from_discount',    '<=>',        'commisionPercentageFromDiscount'],
            ['total_count',                                       '<=>',        'totalCount'],
            ['used_count',                                        '<=>',        'usedCount'],
            ['is_enabled',                                        '<=>',        'isEnabled'],

            ['assigned_course_id',                                '<=>',        'assignedCourseId'],
            
            ['beneficiary_id',                                    '<=>',        'beneficiaryId'],
            
            '__ARRAY__' => [
                [
                    "assigned_course_arr",  '=>',   "assignedCourseArr",    CourseMapper::mapper['DATABSE_MAP']
                ],
                [
                    "beneficiary_arr",      '=>',   "beneficiaryArr",    UserMapper::mapper['DATABSE_MAP']
                ]
            ]
        ],


        /*  DTO  <===_convet_to_===>  Array(from frontend)  */
        self::POST_MAP => [
            ['code',                            '<=>',  'code'],
            ['discountPercentage',              '<=>',  'discount_percentage'],
            ['totalCount',                      '<=>',  'total_count'],
            ['usedCount',                       '<=>',  'used_count'],
            ['isEnabled',                       '<=>',  'is_enabled'],
            ['commisionPercentageFromDiscount',	'<=>',  'beneficiary_commision_percentage_from_discount'],
            
            ['ccCourseId',                      '<=>',  'course'], 
            ['ccCourseId',                      '<=',   'course_id'], 
            ['ccCourseId',                      '<=',   'cc_course_id'],

			
            ['beneficiaryId',                   '<=>',  'beneficiary'],
            ['beneficiaryId',                   '<=',   'beneficiary_id'],
           

            '__ARRAY__' => [
                [
                    "assignedCourseArr",    '<=>',   "assigned_course_arr",    CourseMapper::mapper['POST_MAP']
                ],
                [
                    "beneficiaryArr",       '<=>',   "beneficiary_arr",    UserMapper::mapper['POST_MAP']
                ]
            ] 
        ],

    ];




}

