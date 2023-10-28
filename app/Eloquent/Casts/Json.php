<?php
namespace App\Eloquent\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Json implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        //dump($model);
        ///dump($key);
        //dump($value);
        //dump($attributes);
        //return json_decode($value, true);
        //dd('value',$value);
        
        return json_decode($value, true, 512);
        //return json_decode($value, true, 512, JSON_THROW_ON_ERROR);        
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {        

        return json_encode($value,512);
        //return json_encode($value,JSON_THROW_ON_ERROR ,512);        
    }
}