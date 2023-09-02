<?php


namespace App\Mappers;

use App\Mappers\Mapper;

class RoleMapper  extends Mapper{
    
          
	
   	public const mapper = [

        /*  DB Record  <===_convet_to_===>  ENTITY  */
        self::DATABSE_MAP => [
            ['id', 		    '<=>',      'id'],
            ['uuid', 		'<=>',      'uuid'],
            ['name', 		'<=>',      'name'],
            ['slug', 		'<=>',      'slug'] 
        ],
        

        /*  ENTITY  <===_convet_to_===>  DTO  */
        self::ENTITY_MAP => [
            ['id',          '<=>',      'id'],
            ['uuid',        '<=>',      'uuid'],
            ['name',        '<=>',      'name'],
            ['slug',        '<=>',      'slug']           
        ],
        

        /*  DTO  <===_convet_to_===>  Array(from frontend)  */
        self::POST_MAP => [
            ['id',          '<=>',      'id'],
            ['uuid',        '<=>',      'uuid'],
            ['name',        '<=>',      'name'],
            ['slug',        '<=>',      'slug']           
        ],


    ];         

    
}




