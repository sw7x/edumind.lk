<?php
namespace App\Mappers;

use App\Mappers\Mapper;
use App\Mappers\RoleMapper;
use App\Mappers\CourseItemMapper;

class UserMapper extends Mapper{
    

	public const mapper = [

        /*  DB Record  <--- convet_to ---  ENTITY toArray Output
            DB Record  --- convet_to --->  ENTITY Factory Input  */
        self::DATABSE_MAP => [
            
            ['id',                 '<=>',     'id'],
            ['uuid',               '<=>',     'uuid'],
            ['full_name',          '<=>',     'fullName'],
            ['email',              '<=>',     'email'],
            ['phone',              '<=>',     'phone'],
            ['username',           '<=>',     'username'],
            ['profile_pic',        '<=>',     'profilePic'],
            ['edu_qualifications', '<=>',     'eduQualifications'],
            ['gender',             '<=>',     'gender'],
            ['dob_year',           '<=>',     'dobYear'],
            ['profile_text',   	   '<=>',     'profileText'],
            ['status',             '<=>',     'status'],

            ['role_id',            '=>',      'roleId'],
            ['is_activated',       '=>',      'isActivated'],
            ['cart_items_arr',     '=>',      'cartItemsArr'],


            '__ARRAY__' => [
                [
                    "role_arr",    '=>',       "roleArr",     RoleMapper::mapper['DATABSE_MAP']
                ]
            ],

            
        ],
        

        /*  DTO Factory Input   <--- convet_to ---  Array(from frontend)
            DTO toArray Output  --- convet_to --->  Array(from frontend)  */ 
        self::POST_MAP => [        
            ['id',                 	'<=>',     'id'],
            ['uuid',               	'<=>',     'uuid'],
            ['fullName',           	'<=>',     'full_name'],
            ['email',              	'<=>',     'email'],
            ['phone',              	'<=>',     'phone'],
            ['username',           	'<=>',     'username'],
            ['profilePic',        	'<=>',     'profile_pic'],
            ['eduQualifications', 	'<=>',     'edu_qualifications'],
            ['gender',             	'<=>',     'gender'],
            ['dobYear',           	'<=>',     'dob_year'],
            ['profileText',   	   	'<=>',     'profile_text'],
            ['status',             	'<=>',     'status'],
            
            ['roleId',            	'<=>',     'role'],
            ['roleId',              '<=',      'role_id'],
            
            '__ARRAY__' => [
                [
                    "roleArr",   '=>',   "role_arr",    RoleMapper::mapper['POST_MAP']
                ]
            ]
        ],

    ];






    

}



 
