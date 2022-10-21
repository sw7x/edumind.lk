<?php


namespace App\Utils;


use App\Models\Subject;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Storage;

class UrlUtil
{

    public static function generateSubjectUrl($urlString){

        return SlugService::createSlug(Subject::class, 'slug', $urlString);

    }


    public static function wordsToUrl($string,$limit){
        //$string = "Below your Eyes 3.2 (2013) Unrated From database To  count words in a php string usually we can use str_word_count but I think not always a good solution";
        return implode(' ', array_slice(explode(' ', $string), 0, $limit));
    }



    

}
