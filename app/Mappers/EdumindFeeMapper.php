<?php

namespace App\Mappers;

use App\Mappers\Mapper;


class EdumindFeeMapper extends Mapper{
    

    public const mapper = [

        /*  DB Record  <===_convet_to_===>  ENTITY  */
        self::DATABSE_MAP => [
            ['id', 		 '<=>',      'id'],
            ['uuid',     '<=>',      'uuid'],
            ['amount',   '<=>',      'amount'],
            ['date',     '<=>',      'date']
        ],
        
        /*  DTO  <===_convet_to_===>  Array(from frontend)  */
        self::POST_MAP => [
            ['id',       '<=>',      'id'],
            ['uuid',     '<=>',      'uuid'],
            ['amount',   '<=>',      'amount'],
            ['date',     '<=>',      'date']    
        ],
    ];



    
}
