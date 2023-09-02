<?php

namespace App\Mappers;

use App\Mappers\Mapper;
use App\Mappers\SubjectMapper;
use App\Mappers\UserMapper;

class CourseMapper extends Mapper
{
    
    public const  mapper = [
    //public $mapper = [

        /*  DB Record  <===_convet_to_===>  ENTITY  */
        self::DATABSE_MAP => [           
        //self::DATABSE_ENTITY_MAP => [
            ["id",                        '<=>',     'id'],
            ['uuid',                      '<=>',     'uuid'],
            ["name",                      '<=>',     'name'],
            ["description",               '<=>',     'description'],
            ["image",                     '<=>',     'image'], 
            ["heading_text",              '<=>',     'headingText'],            
            ["topics",                    '<=>',     'topics'],
            ["content",                   '<=>',     'content'],
            ["slug",                      '<=>',     'slug'],  
            ["author_share_percentage",   '<=>',     'authorSharePercentage'], 
            ["price",                     '<=>',     'price'], 
            ["video_count",               '<=>',     'videoCount'],
            ["duration",                  '<=>',     'duration'],
            ["status",                    '<=>',     'status'], 

            ['subject_id',                '<=>',     'subjectId'],
            
            ['creator_id',                '<=>',     'creatorId'],
            
            '__ARRAY__' => [
                [
                    "subject_arr",      '<=>',   "subjectArr",    SubjectMapper::mapper['DATABSE_MAP'],
                ],                
                [
                    "creator_arr",      '<=>',   "creatorArr",    UserMapper::mapper['DATABSE_MAP']
                ]
            ]   
        ],
        

        /*  ENTITY  <===_convet_to_===>  DTO  */
        self::ENTITY_MAP => [
        //self::ENTITY_DTO_MAP => [
            ["id",                        '<=>',     'id'],
            ['uuid',                      '<=>',     'uuid'],
            ["name",                      '<=>',     'name'],
            ["description",               '<=>',     'description'],
            ["image",                     '<=>',     'image'], 
            ["heading_text",              '<=>',     'headingText'],
            ["topics",                    '<=>',     'topics'],
            ["content",                   '<=>',     'content'],
            ["slug",                      '<=>',     'slug'], 
            ["author_share_percentage",   '<=>',     'authorSharePercentage'], 
            ["price",                     '<=>',     'price'],
            ["video_count",               '<=>',     'videoCount'],
            ["duration",                  '<=>',     'duration'],
            ["status",                    '<=>',     'status'], 

            //['subject_id',                '<=>',     'subject_id'],
            //['teacher_id',                '<=>',     'teacher_id'],

            '__ARRAY__' => [
                [
                    "subject_arr",      '<=>',   "subjectDto",    SubjectMapper::mapper['ENTITY_MAP'],
                ],                
                [
                    "creator_arr",      '<=>',   "authorDto",    UserMapper::mapper['ENTITY_MAP']
                ]
            ]
        ],
        

        /*  DTO  <===_convet_to_===  Array(from frontend)  */        
        self::POST_MAP => [
        //self::DTO_ARRAY_MAP => [
            ["id",                        '<=>',        'id'],
            ['uuid',                      '<=>',        'uuid'],
            ["name",                      '<=>',        'name'],
            ["description",               '<=>',        'description'],
            ["image",                     '<=>',        'image'],
            ["headingText",               '<=>',        'heading_text'], 
            ["topics",                    '<=>',        'topics'],
            ["content",                   '<=>',        'content'],
            ["slug",                      '<=>',        'slug'],
            ["authorSharePercentage",     '<=>',        'author_share_percentage'], 
            ["price",                     '<=>',        'price'], 
            ["videoCount",                '<=>',        'video_count'],
            ["duration",                  '<=>',        'duration'],
            ["status",                    '<=>',        'status'], 

            ['subjectId',                 '<=>',        'subject'],
            
            ['teacherId',                 '<=>',        'teacher'],

            '__ARRAY__' => [
                [
                    "subjectArr",      '<=>',   "subject_arr",    SubjectMapper::mapper['POST_MAP'],
                ],                
                [
                    "creatorArr",      '<=>',   "creator_arr",    UserMapper::mapper['POST_MAP']
                ]
            ]
            
        ],


    ];

        
}






/*





    private $array2To1Mapping = [
        "xid"           => "id",
        'xuuid'         => 'uuid',
        "xname"         => 'name',
        "xdescription"  => 'description',
        

        'subjectEntity'     => [ SubjectMapper::class, SubjectMapper::ENTITY_MAP, 'mapToMapperValues'],
       
        [ SubjectMapper::class, SubjectMapper::ENTITY_MAP, 'mapToMapperKeys' ]  => 'subjectDto',         




        'subjectEntity'      => SubjectMapper::class,       
        SubjectMapper::class => 'subjectDto' 


        

        'subjectDtoMapping' => [
            'class' => SubjectMapper::class,
            'method' => 'mapToMapperKeys',
            'argument' => SubjectMapper::ENTITY_MAP,
        ],        

        'subjectEntityMapping' => [
            'class' => SubjectMapper::class,
            'method' => 'mapToMapperValues',
            'argument' => SubjectMapper::ENTITY_MAP,
        ],





        'assoc' = [
            'subjectEntity' =>  [
                SubjectMapper::class,
                SubjectMapper::ENTITY_MAP,
                'mapToMapperValues'
            ],

            'subjectDto' =>  [
                SubjectMapper::class,
                SubjectMapper::ENTITY_MAP,
                'mapToMapperKeys'
            ],
        ]




        'subjectEntity' =>  [
            SubjectMapper::class,
            SubjectMapper::ENTITY_MAP,
            'mapToMapperValues'
        ],

        'subjectDto' =>  [
            SubjectMapper::class,
            SubjectMapper::ENTITY_MAP,
            'mapToMapperKeys'
        ],

        
        [
            SubjectMapper::class, 
            'mapToMapperKeys',
            SubjectMapper::ENTITY_MAP
        ]   => 'subjectDto'









        'subjectEntity' => 'subjectDto'



        'subjectEntity => subjectDto' => [
            
            "xid"           => "id",
            'xuuid'         => 'uuid',
            "xname"         => 'name',
            "xdescription"  => 'description',
            "yimage"        => "image",
            "yslug"         => "slug",
            "ystatus"       => "status",
        ],
    ];


*/



