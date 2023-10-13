<?php

namespace App\Utils;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Str;
use Request;
use Illuminate\Support\Facades\Http;


class BreadcrumbUtil{

    public static function createBreadcrumb($title=null){

        $urlSegments = Request::segments();
        // $urlSegments = request()->segments(); -ok
        $urlSegCount = count($urlSegments);

        $url='';
        $breadcrumbHtml ='';

        foreach($urlSegments as $key => $segment){
            $class = ($key == ($urlSegCount -1))?' active':'';
            $breadcrumbHtml .= "<li class='breadcrumb-item{$class}'>";

            if($key == 0){
                $url = $url . url ('/' . $segment);
            }elseif($key == ($urlSegCount -1)){
                $url = '';
            }else{
                $url = $url . '/' . $segment;
            }

            try {
                $isLink = true;
                $result = Http::get($url);
            } catch (\Exception $e) {}

            if ($result->failed() || $result->status() === 404) {
                // Url doesnt exist
                $isLink = false;
            }

            /*
            dump($url);
            dump($result->failed());
            dump($result->status());
            dump($isLink);
            dump("====================");
            */

            $segment = str_replace('-', ' ', $segment);

            if($url == ''){
                $breadcrumbHtml .= "<strong>".ucfirst(($title??$segment))."</strong>";
            }else{
                $breadcrumbHtml .= (!$isLink)? "<span>".ucfirst($segment)."</span>": "<a class='text-blue-400 hover:text-blue-700' href='{$url}'>".ucfirst($segment)."</a>";
            }
            //$breadcrumbHtml .= (!$isLink || $url == '')? "<strong>".ucfirst(($title??$segment))."</strong>": "<a href='{$url}'>".ucfirst($segment)."</a>";
            $breadcrumbHtml .= "</li>";
        }

        $breadcrumbHtml = '<ol class="breadcrumb text-xl">'.$breadcrumbHtml.'</ol>';
        return $breadcrumbHtml;
    }

}