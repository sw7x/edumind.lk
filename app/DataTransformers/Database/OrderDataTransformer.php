<?php

namespace App\DataTransformers\Database;

use App\Domain\Order as OrderEntity;

use App\DataTransferObjects\OrderDto;
use App\DataTransferObjects\Factories\OrderDtoFactory;
use App\Mappers\OrderMapper;
use App\Domain\Factories\OrderFactory;


class OrderDataTransformer{

	public static function buildDto(array $orderData) : OrderDto {        
        
        $orderEntity 	= self::buildEntity($orderData);
        $orderDto    	= OrderDtoFactory::fromArray($orderEntity->toArray());
		return $orderDto;
	}

	public static function buildEntity(array $orderData) : OrderEntity {
 
		$orderEntityArr = OrderMapper::dbRecConvertToEntityArr($orderData);
        $orderEntity    = (new OrderFactory())->createObjTree($orderEntityArr);
        return $orderEntity;
    }
} 	



