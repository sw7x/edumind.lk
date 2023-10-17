<?php
if(! function_exists('cleanString')){
    function cleanString($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
    }
}

    /*
     * username have letters characters and
     * no spaces,
     * not repeating periods, (can have single period)
     * not repeating underscores (can have single underscore)
     * no special characters
     * */
if(! function_exists('cleanUsernameString')){
    function cleanUsernameString($string) {
        $string = replaceMultipleSpaces($string);
        $string = str_replace(' ', '.', $string); // Replaces all spaces with hyphens.

        // Removes special chars. (include hyphen)
        $string = preg_replace('/[^a-zA-Z0-9_.]/', '', $string);

        // Removes special chars (not hyphen).
        //$string = preg_replace('/[^A-Za-z0-9_\-]/', '', $string);

        $string = replaceMultipleperiods($string);
        $string = replaceMultipleUnderscores($string);
        //return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
        return strtolower($string);
    }
}

if(! function_exists('replaceMultipleSpaces')){
    //replacing multiple spaces with a single space
    function replaceMultipleSpaces($string){
        return preg_replace ('!\s+!', ' ', $string);
    }
}

if(! function_exists('replaceMultipleperiods')){
    function replaceMultipleperiods($string){
        return preg_replace ('!\.+!', '.', $string);
    }
}

if(! function_exists('replaceMultipleUnderscores')){
    function replaceMultipleUnderscores($string){
        return preg_replace('/_+/', '_', $string);
    }
}


if(! function_exists('snakeToCamelCase')){
    function snakeToCamelCase($string){
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
    }
}

if(! function_exists('arrayToString')){
    function arrayToString(array $arr) {
        $str = (!empty($arr)) ? implode(',', $arr) : '';
        return $str;
    }
}