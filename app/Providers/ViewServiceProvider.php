<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\View\Composers\TopSubjectsComposer;
use Illuminate\Support\Facades\View;



class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /*view::composer (['includes.header','includes.footer','home'],function ($view){
            $subjects = Subject::withCount('courses')->orderBy('courses_count', 'desc')->skip(0)->take(8)->get();

            $arr = array();

            $arr = $subjects->map(function($subject) use ($arr){
                return array(
                    'name'  => $subject->name,
                    'url'   => $subject->slug,
                    'image' => $subject->image
                );
            });

            $view->with('subject_info',$subjects);
        });*/


        view::composer (['includes.header','includes.footer','home'],TopSubjectsComposer::class);
    }
}
