<?php


namespace App\Mappers;

use App\Mappers\Mapper;
use App\Mappers\UserMapper;



class SubjectMapper  extends Mapper{
    
   
	public const  mapper = [
    //public $mapper = [

        /*  DB Record  <===_convet_to_===>  ENTITY  */
        self::DATABSE_MAP => [
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
        

        /*  DTO  <===_convet_to_===>  Array(from frontend)  */
        self::POST_MAP => [
            ["id",                        '<=>',      'id'],
            ['uuid',                      '<=>',      'uuid'],
            ["name",                      '<=>',      'name'],
            ["description",               '<=>',      'description'],
            ["image",                     '<=>',      'image'], 
            ["slug",                      '<=>',      'slug'], 
            ["status",                    '<=>',      'status'],
            
            ['creatorId',                  '<=>',      'author'],
            ['creatorId',                  '<=>',      'author_id'],
            ['creatorId',                  '<=>',      'creator'],
            ['creatorId',                  '<=>',      'creator_id'],

            
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
