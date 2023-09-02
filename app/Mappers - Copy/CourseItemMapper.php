<?php


namespace App\Mappers;


use App\Mappers\Mapper;

use App\Mappers\CourseMapper;
use App\Mappers\CouponMapper;




class CourseItemMapper extends Mapper{
    




    public const mapper = [

        /*  DB Record  <===_convet_to_===>  ENTITY  */
        self::DATABSE_MAP => [
            ['id',                        '<=>',     'id'],
            ['uuid',                      '<=>',     'uuid'],
            ['cart_added_date',           '<=>',     'cartAddedDate'],
            ['is_checkout',               '<=>',     'isCheckout'],
            ['edumind_amount',            '<=>',     'edumindAmount'],
            ['author_amount',             '<=>',     'authorAmount'],
            ['discount_amount',           '<=>',     'discountAmount'],
            ['revised_price',             '<=>',     'revisedPrice'],
            ['edumind_lose_amount',       '<=>',     'edumindLoseAmount'],
            ['beneficiary_earn_amount',   '<=>',     'beneficiaryEarnAmount'],

            ['course_id',                 '<=>',     'courseId'],
            
            ['used_coupon_code',          '<=>',     'usedCouponCode'],
            
            ['student_id',                '=>',     'studentId'],

            '__ARRAY__' => [
                [
                    "course_arr",      	'<=>',   "courseArr",    CourseMapper::mapper['DATABSE_MAP']
                ],
                [
                    "used_coupon_arr", 	'<=>',   "usedCouponArr",    CouponMapper::mapper['DATABSE_MAP']
                ],                
				[
                    "student_arr", 		'<=>',   "studentArr",    CouponMapper::mapper['DATABSE_MAP']
                ]
            ]
        ], 
        
        

        /*  ENTITY  <===_convet_to_===>  DTO  */
        self::ENTITY_MAP => [
            ['id',                        '<=>',        'id'],
            ['uuid',                      '<=>',        'uuid'],
            ['cart_added_date',           '<=>',        'cartAddedDate'],
            ['is_checkout',               '<=>',        'isCheckout'],
            ['-edumind_amount',           '<=>',        'edumindAmount'],
            ['-author_amount',            '<=>',        'authorAmount'],
            ['-discount_amount',          '<=>',        'discountAmount'],
            ['-revised_price',            '<=>',        'revisedPrice'],
            ['-edumind_lose_amount',     '<=>',        'edumindLoseAmount'],
            ['-beneficiary_earn_amount', '<=>',        'beneficiaryEarnAmount'],
            
            //'course'                    => 'courseDTO',course_id
            //'couponCode'                => 'couponCodeDTO',  used_coupon_code

            '__ARRAY__' => [
                [
                    "course_arr",      '<=>',   "courseDto",    CourseMapper::mapper['ENTITY_MAP']
                ],
                [
                    "used_coupon_arr", '<=>',   "couponCodeDto",    CouponMapper::mapper['ENTITY_MAP']
                ]
            ]
        ],
        

        /*  DTO  <===_convet_to_===>  Array(from frontend)  */
        self::POST_MAP => [
            ['id',                          '<=>',       'id'],
            ['uuid',                        '<=>',       'uuid'],
            ['cartAddedDate',             	'<=>',       'cart_added_date'],
            ['isCheckout',                 	'<=>',       'is_checkout'],
            ['edumindAmount',              	'<=>',       'edumind_amount'],
            ['authorAmount',               	'<=>',       'author_amount'],
            ['discountAmount',             	'<=>',       'discount_amount'],
            ['revisedPrice',               	'<=>',       'revised_price '],
            ['edumindLoseAmount',         	'<=>',       'edumind_lose_amount'],
            ['beneficiaryEarnAmount',     	'<=>',       'beneficiary_earn_amount'],
            
            ['courseId',                   	'<=>',       'course'],

            ['usedCouponCode',            	'<=>',       'coupon_code'],
            
            ['studentId',                 	'<=>',       'student'],

            '__ARRAY__' => [
                [
                    "courseArr",      '<=>',   "course_arr",    CourseMapper::mapper['POST_MAP']
                ],
                [
                    "usedCouponArr", '<=>',   "used_coupon_arr",    CouponMapper::mapper['POST_MAP']
                ],
                [
                    "studentArr", '<=>',   "student_arr",    CouponMapper::mapper['POST_MAP']
                ]
            ]
        ],


    ];

}