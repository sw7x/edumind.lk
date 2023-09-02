<?php


namespace App\Mappers;

use App\Mappers\Mapper;

class RoleMapper  extends Mapper{
    
          
	
   	public const mapper = [

        /*  DB Record  <--- convet_to ---  ENTITY toArray Output
            DB Record  --- convet_to --->  ENTITY Factory Input  */
        self::DATABSE_MAP => [
            ['id', 		    '<=>',      'id'],
            ['uuid', 		'<=>',      'uuid'],
            ['name', 		'<=>',      'name'],
            ['slug', 		'<=>',      'slug'] 
        ],
        

        /*  DTO Factory Input   <--- convet_to ---  Array(from frontend)
            DTO toArray Output  --- convet_to --->  Array(from frontend)  */ 
        self::POST_MAP => [
            ['id',          '<=>',      'id'],
            ['uuid',        '<=>',      'uuid'],
            ['name',        '<=>',      'name'],
            ['slug',        '<=>',      'slug']           
        ],


    ];         

    
}




