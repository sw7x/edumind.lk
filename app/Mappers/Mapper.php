<?php

namespace App\Mappers;

/*
use App\DataTransferObjects\AbstractDto;
use Illuminate\Database\Eloquent\Model;
use App\Domain\IEntity;
*/
use App\Mappers\Exceptions\MapperException;

class Mapper{

    const DATABSE_MAP   = 'DATABSE_MAP';
    //const ENTITY_MAP  = 'ENTITY_MAP';
    const POST_MAP      = 'POST_MAP';
    


    /*  DB Record  ===_convet_to_===>  ENTITY  */
    public static function dbRecConvertToEntityArr(array $modelDataArr, bool $noStrict = true) : array {       
        $dbMapper     = static::mapper[self::DATABSE_MAP];              
        return static::mapToMapperValues($dbMapper, $modelDataArr, $noStrict);
    }    
    
    /*  ENTITY  ===_convet_to_===> DB Record   */
    public static function entityConvertToDbArr(array $entityDataArr, bool $noStrict = true) : array {        
        $dbMapper   = static::mapper[self::DATABSE_MAP];
        return static::mapToMapperKeys($dbMapper, $entityDataArr, $noStrict);
    }




    /*  DTO  ===_convet_to_===>    ENTITY
    public static function dtoConvertToEntityArr(array $dtoDataArr, bool $noStrict = true) : array {
        $entityMapper   = static::mapper[self::ENTITY_MAP];          
        return static::mapToMapperKeys($entityMapper, $dtoDataArr, $noStrict);
    }
    
    /*  ENTITY  ===_convet_to_===>  DTO  
    public static function entityConvertToDtoArr(array $entityDataArr, bool $noStrict = true) : array {        
        $entityMapper  = static::mapper[self::ENTITY_MAP];
        return static::mapToMapperValues($entityMapper, $entityDataArr, $noStrict);
    }
    */
    


    
    /*  DTO  ===_convet_to_===>  Array(from frontend)  */
    public function dtoConvertToArr(array $dtoDataArr, bool $noStrict = true) : array {
        $postMapper   = static::mapper[self::POST_MAP];               
        return static::mapToMapperValues($postMapper, $dtoDataArr, $noStrict);
    }

    /*  Array(from frontend)  ===_convet_to_===> DTO   */
    public static function arrConvertToDtoArr(array $arr, bool $noStrict = true) : array {
        $postMapper   = static::mapper[self::POST_MAP];             
        return static::mapToMapperKeys($postMapper, $arr, $noStrict);
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


    
    private static function mapToMapperValues(array $mapperArr, array $dataArr, bool $noStrict = true) : array {        
        $data = [];

        $mapperKeyValueItemsArr = array_filter($mapperArr, function ($item, $key) {
            return is_string($key) && is_string($item);
        }, ARRAY_FILTER_USE_BOTH);  

        foreach ($dataArr as $dataKey => $dataValue) {
            if($dataKey == '') continue;        
            
			// ["mapperKey1", 	=>,	'mapperKey2'],
            if(is_string($dataKey)){
                if (isset($mapperKeyValueItemsArr[$dataKey])){                   
					$data[$mapperKeyValueItemsArr[$dataKey]] = $dataValue;
				}
                
                $mapperArrkey = array_search ($dataKey, $mapperKeyValueItemsArr);				
				if(($noStrict == false) && $mapperArrkey){
					$data[$mapperKeyValueItemsArr[$mapperArrkey]] = $dataValue;
				}			
			}

			// ["mapperKey1", 	'<=>',	'mapperKey2'],
            foreach ($mapperArr as $mapperKey  => $mapperSubArr) {
                if(is_int($mapperKey) && is_array($mapperSubArr)){
					
					if(count($mapperSubArr) != 3)
                        throw new MapperException("Provided mapper array is not in correct format");
                    
					if($mapperSubArr[1] === '<=>' || $mapperSubArr[1] === '=>'){
                        if(end($mapperSubArr) == '' || reset($mapperSubArr) == '') continue;
						
						if(reset($mapperSubArr) == $dataKey){
                            $data[end($mapperSubArr)] = $dataValue;
                        }
						
						if(($noStrict == false) && (end($mapperSubArr) == $dataKey)){
							$data[end($mapperSubArr)] = $dataValue;
						}
                    }
                }
            }
            
            //[	"mapperKey1",     '<=>',   "mapperKey2",    mapperArray],
			if(is_array($dataValue) && array_key_exists('__ARRAY__',$mapperArr)){               
                foreach ($mapperArr['__ARRAY__'] as $subArray) {
                    
                    if(!is_array($subArray) || (count($subArray) != 4))
                        throw new MapperException("Provided mapper array is not in correct format");
					
					if($subArray[1] === '<=>' || $subArray[1] === '=>'){
						if($subArray[0] == '' || $subArray[2] == '') continue;
						
                        if ((reset($subArray) === $dataKey) && is_array($dataValue)){                            
                            $newKey        = $subArray[2];
                            $data[$newKey] = static::mapToMapperValues(end($subArray), $dataValue, $noStrict);
                        }

						if(($noStrict == false) && ($subArray[2] === $dataKey) && is_array($dataValue)){
							$newKey        = $subArray[2];
							$data[$newKey] = static::mapToMapperValues(end($subArray), $dataValue, $noStrict);
						}
                    }                    
                }
            }
        }
        return $data;
    }


    private static function mapToMapperKeys(array $mapperArr, array $dataArr, bool $noStrict = true) : array {        
        $data = [];

        /*
        $mapperKeyValueItemsArr = array_filter($mapperArr, function ($item, $key) {
            return is_string($key) && is_string($item);
        }, ARRAY_FILTER_USE_BOTH);
        */        

        foreach ($dataArr as $dataKey => $dataValue) {
            if($dataKey == '') continue;            
            
            /*
            // ["mapperKey1", 	=>,	'mapperKey2'],
            if(is_string($dataKey)){
                $mapKey = array_search($dataKey, $mapperKeyValueItemsArr);
                if ($mapKey) {
                    $data[$mapKey] = $dataValue;
                }
            }
            */

            // ["mapperKey1", 	'<=>',	'mapperKey2'],
            foreach ($mapperArr as $mapperKey  => $mapperSubArr) {
                if(is_int($mapperKey)){
                    if(count($mapperSubArr) != 3)
                        throw new MapperException("Provided mapper array is not in correct format");
                    
                    if($mapperSubArr[1] === '<=>' || $mapperSubArr[1] === '<='){
						if(end($mapperSubArr) == '' || reset($mapperSubArr) == '') continue;
						
						if(end($mapperSubArr) == $dataKey){
                            $data[reset($mapperSubArr)] = $dataValue;
                        }
						
						if(($noStrict == false) && (reset($mapperSubArr) == $dataKey)){
							$data[reset($mapperSubArr)] = $dataValue;
						}
                    }
                }
            }
            
            //[	"mapperKey1",     '<=>',   "mapperKey2",    mapperArray],
            if(is_array($dataValue) && array_key_exists('__ARRAY__',$mapperArr)){               
                foreach ($mapperArr['__ARRAY__'] as $subArray) {
                    
                    if(!is_array($subArray) || (count($subArray) != 4))
                        throw new MapperException("Provided mapper array is not in correct format");
                    
                    if($subArray[1] === '<=>' || $subArray[1] === '<='){
                        if($subArray[0] == '' || $subArray[2] == '') continue;						
						
						if (($subArray[2] === $dataKey) && is_array($dataValue)){
                            $newKey        = reset($subArray);
                            $data[$newKey] = static::mapToMapperKeys(end($subArray), $dataValue, $noStrict);
                        } 

						if(($noStrict == false) && (reset($subArray) === $dataKey) && is_array($dataValue)){
							$newKey        = reset($subArray);
                            $data[$newKey] = static::mapToMapperKeys(end($subArray), $dataValue, $noStrict);
						}
                    }                    
                }
            }
        }
        return $data;
    }
    
}