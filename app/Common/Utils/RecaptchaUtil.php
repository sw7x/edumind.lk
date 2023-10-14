<?php


namespace App\Common\Utils;

use GuzzleHttp\Client;


class RecaptchaUtil{

    public static function validate($g_recaptcha_response){

        $client = new Client;
        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',[
                'form_params' =>    [
                        'secret' => config('services.recaptcha.secret-key'),
                        'response' => $g_recaptcha_response
                    ]
            ]
        );
        return json_decode((string)$response->getBody());
    }
	
}
