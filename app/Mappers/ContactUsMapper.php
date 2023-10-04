<?php

namespace App\Mappers;

use App\Mappers\Mapper;
use App\Mappers\UserMapper;




class ContactUsMapper extends Mapper
{
			
    public const mapper = [

        /*  DB Record  <--- convet_to ---  ENTITY toArray Output
            DB Record  --- convet_to --->  ENTITY Factory Input  */
        self::DATABSE_MAP => [
            
            ['id',          '<=>',        'id'],
            ['uuid',        '<=>',        'uuid'],
            ['full_name',   '<=>',        'fullName'],
            ['email',       '<=>',        'email'],
            ['phone',       '<=>',        'phone'],
            ['subject',     '<=>',        'subject'],
            ['message',     '<=>',        'message'],
            ['created_at',  '<=>',        'createdAt'],

            ['user_id',     '<=>',        'userId'],
            
            '__ARRAY__' => [
                [
                    "user_arr",     '=>',   "userArr",    UserMapper::mapper['DATABSE_MAP']
                ]
            ]
        ],
        

        /*  DTO Factory Input   <--- convet_to ---  Array(from frontend)
            DTO toArray Output  --- convet_to --->  Array(from frontend)  */
        self::POST_MAP => [
            ['id',         '<=>',       'id'],
            ['uuid',       '<=>',       'uuid'],
            ['fullName',   '<=>',       'full_name'],
            ['email',      '<=>',       'email'],
            ['phone',      '<=>',       'phone'],
            ['subject',    '<=>',       'subject'],
            ['message',    '<=>',       'message'],            
            
            ['userId',     '<=>',     	'user'],
            ['userId',     '<=',        'user_id'],
            
            ['createdAt',  '=>',        'created_at'],

            '__ARRAY__' => [
                [
                    "userArr",     '=>',    "user_arr",    UserMapper::mapper['POST_MAP']
                ]
            ]
        ],

    ];
    
}	
