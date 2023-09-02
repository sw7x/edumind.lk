<?php

namespace App\Mappers;
use App\Mappers\Mapper;


class CommissionFeeMapper  extends Mapper{
            

    public const mapper = [

        /*  DB Record  <--- convet_to ---  ENTITY toArray Output
            DB Record  --- convet_to --->  ENTITY Factory Input  */
        self::DATABSE_MAP => [
            ['id',        '<=>',  'id'],
            ['uuid',      '<=>',  'uuid'],
            ['amount',    '<=>',  'amount']
        ],
        

        /*  ENTITY  <===_convet_to_===>  DTO  */
        self::ENTITY_MAP => [
            ['id',        '<=>',  'id'],
            ['uuid',      '<=>',  'uuid'],
            ['amount',    '<=>',  'amount']
        ],
        
        /*  DTO Factory Input   <--- convet_to ---  Array(from frontend)
            DTO toArray Output  --- convet_to --->  Array(from frontend)  */        
        self::POST_MAP => [
            ['id',        '<=>',  'id'],
            ['uuid',      '<=>',  'uuid'],
            ['amount',    '<=>',  'amount']
        ],

    ];



           

}
