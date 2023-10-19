<?php
namespace App\Common\Utils;


class AlertDataUtil{

	public static function success(string $msg, array $arr = []): array {
		$tempArr =  array(
			'message'  	 => $msg,
            'cls'     	 => 'flash-success',
            'msgTitle'	 => 'Success!'          
        );
        return array_merge($tempArr, $arr);		
	}

	public static function info(string $msg, array $arr = []): array {
		$tempArr =  array(
			'message'  	 => $msg,
            'cls'     	 => 'flash-info',
            'msgTitle'	 => 'Info!'
        );
        return array_merge($tempArr, $arr);
    }

	public static function warning(string $msg, array $arr = []): array {
		$tempArr =  array(
			'message'  	 => $msg,
            'cls'     	 => 'flash-warning',
            'msgTitle'	 => 'Warning!'            
        );
        return array_merge($tempArr, $arr);		
	}


	public static function error(string $msg, array $arr = []): array {
		$tempArr =  array(
			'message'  	 => $msg,
            'cls'     	 => 'flash-danger',
            'msgTitle'	 => 'Error!'         
        );
        return array_merge($tempArr, $arr);	
    }


}