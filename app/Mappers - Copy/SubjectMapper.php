<?php


namespace App\Mappers;

use App\Mappers\Mapper;

class SubjectMapper  extends Mapper{
    
   
	public const  mapper = [
    //public $mapper = [

        /*  DB Record  <===_convet_to_===>  ENTITY  */
        self::DATABSE_MAP => [
            'paidAmount'                    =>        'paid_amount',


            ["id",                        '<=>',      'id'],
            ['uuid',                      '<=>',      'uuid'],
            ["name",                      '<=>',      'name'],
            ["description",               '<=>',      'description'],
            ["image",                     '<=>',      'image'], 
            ["slug",                      '<=>',      'slug'], 
            ["status",                    '<=>',      'status'],            
            
            ['creator_id',                '<=>',      'creatorId'],

            '__ARRAY__' => [
                [
                    "creator_arr",     '<=>',   "creatorArr",    UserMapper::mapper['DATABSE_MAP']
                ]
            ] 
        ],
        

        /*  ENTITY  <===_convet_to_===>  DTO  */
        self::ENTITY_MAP => [
            ["id",                        '<=>',      'id'],
            ['uuid',                      '<=>',      'uuid'],
            ["name",                      '<=>',      'name'],
            ["description",               '<=>',      'description'],
            ["image",                     '<=>',      'image'], 
            ["slug",                      '<=>',      'slug'], 
            ["status",                    '<=>',      'status'],            
            
            '__ARRAY__' => [
                [
                    "creator_arr",     '<=>',   "authorDto",    UserMapper::mapper['ENTITY_MAP']
                ]
            ]              
        ],
        

        /*  DTO  <===_convet_to_===>  Array(from frontend)  */
        self::POST_MAP => [
            ["id",                        '<=>',      'id'],
            ['uuid',                      '<=>',      'uuid'],
            ["name",                      '<=>',      'name'],
            ["description",               '<=>',      'description'],
            ["image",                     '<=>',      'image'], 
            ["slug",                      '<=>',      'slug'], 
            ["status",                    '<=>',      'status'],
            
            ['authorId',                  '<=>',      'author'],
            ['creatorId',                 '<=>',      'creator'],

            
            '__ARRAY__' => [
                [
                    "creatorArr",     '<=>',   "creator_arr",    UserMapper::mapper['POST_MAP']
                ],
                [
                    "subjectArr",     '<=>',   "subject_arr",    UserMapper::mapper['POST_MAP']
                ]
            ]
        ],


    ];

}
