<?php

if(! function_exists('arrKeysSnakeToCamel')){
    function arrKeysSnakeToCamel($array) {
        $result = [];
        foreach ($array as $key => $value) {
            $camelKey = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
            $result[$camelKey] = $value;
            if (is_array($value)) {
                $result[$camelKey] = arrKeysSnakeToCamel($value);
            } else {
                $result[$camelKey] = $value;
            }
        }
        return $result;
    }
}


if(! function_exists('arrKeysCamelToSnake')){
    function arrKeysCamelToSnake($array) {
        $result = [];
        foreach ($array as $key => $value) {
            $snakeKey = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $key));
            if (is_array($value)) {
                $result[$snakeKey] = arrKeysCamelToSnake($value);
            } else {
                $result[$snakeKey] = $value;
            }
        }
        return $result;
    }
}