<?php

namespace App\Mappers;

use App\Domain\Course as CourseEntity;
use App\Models\Course as CourseModel;


use App\DataTransferObjects\AbstractDto;
use Illuminate\Database\Eloquent\Model;
use App\Domain\IEntity;
use App\Mappers\Exceptions\MapperException;

/* Array(from frontend) <===> DTO <===> ENTITY <===> DB Record */
class Mapper
{
    const DATABSE_MAP   = 'DATABSE_MAP';
    const ENTITY_MAP    = 'ENTITY_MAP';
    const POST_MAP      = 'POST_MAP';
    


   
    /*  DB Record  <===_convet_to_===>  ENTITY  */
    public static function entityConvertToDbArr(IEntity $entity) : array {        
        $dbMapper   = static::mapper[self::DATABSE_MAP];
        $entityDataArr = $entity->toArray();
        return static::mapToMapperKeys($dbMapper, $entityDataArr);
    }
    
    public static function dbRecConvertToEntityArr(array $modelDataArr) : array {        
    //public static function DbRecConvertToEntityArr(Model $model) : array {        
        $dbMapper     = static::mapper[self::DATABSE_MAP];              
        //$modelDataArr = $model->toArray();
        return static::mapToMapperValues($dbMapper, $modelDataArr);
    }    
    /*================================= */



    /*  ENTITY  <===_convet_to_===>  DTO  */
    public static function dtoConvertToEntityArr(array $dtoDataArr) : array {
    //public static function dtoConvertToEntityArr(AbstractDto $dto) : array {
        $entityMapper   = static::mapper[self::ENTITY_MAP];          
        //$dtoDataArr = $dto->toArray();
        //$dtoDataArr = $dto;
        return static::mapToMapperKeys($entityMapper, $dtoDataArr);
    }
        
    public static function entityConvertToDtoArr(array $entityDataArr) : array {        
    //public static function entityConvertToDtoArr(IEntity $entity) : array {        
        $entityMapper  = static::mapper[self::ENTITY_MAP];
        //$entityDataArr = $entity->toArray();
        return static::mapToMapperValues($entityMapper, $entityDataArr);
    }
    /*================================= */


    

    /*  DTO  <===_convet_to_===>  Array(from frontend)  */
    public static function arrConvertToDtoArr(array $arr) : array {
        $postMapper   = static::mapper[self::POST_MAP];             
        return static::mapToMapperKeys($postMapper, $arr);
    }

    public function dtoConvertToArr(array $dtoDataArr) : array {
    //public static function dtoConvertToArr(AbstractDataTransferObject $dto) : array {
        $postMapper   = static::mapper[self::POST_MAP];               
        //$dtoDataArr = $dto->toArray();
        return static::mapToMapperValues($postMapper, $dtoDataArr);
    }
    

    // change single array key
    final public static function changeArrKey(array $mapperArr, array $dataArr) : array {
        if(count($mapperArr) != 3)
            throw new MapperException("Provided mapper array is not in correct format");
        
        $selectedKey    = reset($mapperArr);
        $newKey         = end($mapperArr);
        $direction      = $mapperArr[1];
        
        if(!$selectedKey || !$newKey || ($mapperArr[1] != '=>'))
            throw new MapperException("Provided mapper array is not in correct format");
        
        foreach ($dataArr as $dataKey => $dataValue) {
            if($dataKey === '' || $dataValue ==='') continue;            
            
            if($selectedKey == $dataKey){
                $dataArr[$newKey] = $dataArr[$selectedKey];
                unset($dataArr[$selectedKey]);
                break;
            }            
        }
        return $dataArr;
    }

    
    // change multiple array keys
    final public static function changeMultipleArrKeys(array $mapperArr, array $dataArr) : array {
        foreach ($mapperArr as $mapperKey  => $mapperSubArr) {            
            if(!is_array($mapperSubArr))
                throw new MapperException("Provided mapper array is not in correct format");
            
            if(is_int($mapperKey)){
                $dataArr = static::changeArrKey($mapperSubArr, $dataArr);
            }
        }
        return $dataArr;
    }







    /*================================= */

    private static function mapToMapperValues(array $mapperArr, array $dataArr) : array {        
        $data = [];

        $mapperKeyValueItemsArr = array_filter($mapperArr, function ($item, $key) {
            return is_string($key) && is_string($item);
        }, ARRAY_FILTER_USE_BOTH);  

        foreach ($dataArr as $dataKey => $dataValue) {
            if($dataKey == '') continue;        
            
            if(is_string($dataKey)){
                if (isset($mapperKeyValueItemsArr[$dataKey])) {                    
                    $data[$mapperKeyValueItemsArr[$dataKey]] = $dataValue;
                }
            }

            foreach ($mapperArr as $mapperKey  => $mapperSubArr) {
               	if(is_int($mapperKey) && is_array($mapperSubArr)){
					
					if(count($mapperSubArr) != 3)
                        throw new MapperException("Provided mapper array is not in correct format");
                    
					if($mapperSubArr[1] === '<=>' || $mapperSubArr[1] === '=>'){
                        if(end($mapperSubArr) == '' || reset($mapperSubArr) == '') continue;
						if(reset($mapperSubArr) == $dataKey){
                            $data[end($mapperSubArr)] = $dataValue;
                        }
                    }
                }
            }
            
            if(is_array($dataValue) && array_key_exists('__ARRAY__',$mapperArr)){               
                foreach ($mapperArr['__ARRAY__'] as $subArray) {
                    
                    if(!is_array($subArray) || (count($subArray) != 4))
                        throw new MapperException("Provided mapper array is not in correct format");
					
					if($subArray[1] === '<=>' || $subArray[1] === '=>'){
						if($subArray[0] == '' || $subArray[2] == '') continue;
						
                        if ((reset($subArray) === $dataKey) && is_array($dataValue)){                            
                            $newKey        = $subArray[2];
                            $data[$newKey] = static::mapToMapperValues(end($subArray), $dataValue);
                        }                            
                    }                    
                }
            }
        }
        return $data;
    }


    private static function mapToMapperKeys(array $mapperArr, array $dataArr) : array {        
        $data = [];

        /*
        $mapperKeyValueItemsArr = array_filter($mapperArr, function ($item, $key) {
            return is_string($key) && is_string($item);
        }, ARRAY_FILTER_USE_BOTH);
        */        

        foreach ($dataArr as $dataKey => $dataValue) {
            if($dataKey == '') continue;            
            
            /*
            if(is_string($dataKey)){
                $mapKey = array_search($dataKey, $mapperKeyValueItemsArr);
                if ($mapKey) {
                    $data[$mapKey] = $dataValue;
                }
            }
            */

            foreach ($mapperArr as $mapperKey  => $mapperSubArr) {
                if(is_int($mapperKey)){
                    if(count($mapperSubArr) != 3)
                        throw new MapperException("Provided mapper array is not in correct format");
                    
                    if($mapperSubArr[1] === '<=>' || $mapperSubArr[1] === '<='){
						if(end($mapperSubArr) == '' || reset($mapperSubArr) == '') continue;
						if(end($mapperSubArr) == $dataKey){
                            $data[reset($mapperSubArr)] = $dataValue;
                        }
                    }
                }
            }
            
            if(is_array($dataValue) && array_key_exists('__ARRAY__',$mapperArr)){               
                foreach ($mapperArr['__ARRAY__'] as $subArray) {
                    
                    if(!is_array($subArray) || (count($subArray) != 4))
                        throw new MapperException("Provided mapper array is not in correct format");
                    
                    if($subArray[1] === '<=>' || $subArray[1] === '<='){
                        if($subArray[0] == '' || $subArray[2] == '') continue;						
						if (($subArray[2] === $dataKey) && is_array($dataValue)){
                            $newKey        = reset($subArray);
                            $data[$newKey] = static::mapToMapperKeys(end($subArray), $dataValue);
                        }                            
                    }                    
                }
            }
        }
        return $data;
    }
    
}