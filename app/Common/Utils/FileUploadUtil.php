<?php


namespace App\Common\Utils;


use Illuminate\Support\Facades\Storage;

class FileUploadUtil{

    public function upload($file,$dir){
        $path = rtrim($dir, '/') . '/';

        $jData = json_decode($file);
        $imgData = $jData->data;

        $filename   = pathinfo($jData->name, PATHINFO_FILENAME);
        $ext        = pathinfo($jData->name, PATHINFO_EXTENSION );
        //$imgType = $jData->type;
        //$imgBase = $imgData->baseData;


        //remove unwanted characters and spaces
        $filename = str_replace(' ', '-', $filename);
        $filename = preg_replace( '/[\W]/', '', $filename);


        $imageName = substr($filename, 0, 40).'_'.uniqid().'.'.$ext;

        Storage::disk('public')->put($path.$imageName, base64_decode($imgData));

        //$destination = Storage::disk('public')->getAdapter()->getPathPrefix(). '/' . pathinfo($imageName, PATHINFO_FILENAME) . '.jpeg';
        $destination = $path.$imageName;
        return $destination;
    }


}
