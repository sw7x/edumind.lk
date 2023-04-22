<?php


namespace App\View\Composers;

use Illuminate\View\View;




use App\Models\Course;
use App\Models\Enrollment;
use Sentinel;
use App\Models\Role;



class CartComposer
{
    public function compose(View $view)
    {

        $user = Sentinel::getUser();
        //dump();
        
        if($user && ($user->roles()->first()->slug == Role::STUDENT)){
            $addedCourses   =  Course::join('course_selections', function($join) use ($user){
                                            $join->on('courses.id','=','course_selections.course_id')
                                                ->where('course_selections.is_checkout', '=', 0)
                                                ->where('course_selections.student_id', '=', $user->id)
                                                ->where('courses.price', '!=', 0);
                                                //->where('courses.status', '=', "published");
                                        })
                                        //->toSql();  
                                        ->get([
                                            'course_selections.is_checkout',
                                            //'enrollments.is_complete',
                                            'courses.*'
                                        ]);

            //dd($addedCourses);
            //dd($addedCourses->toArray());          

            $totPrice = 0;
            foreach ($addedCourses as $key => $course) {
                 $totPrice +=  $course->price;
            }   

            $cartCourses     = $addedCourses->toArray();
            $cartCourseCount = $addedCourses->count();
            $cartTotal       = $totPrice;              

        }else{            
            $cartCourses     = [];
            $cartCourseCount = 0;
            $cartTotal       = 0;        
        }


        $view->with([                        
            'cartCourses'       => $cartCourses,      
            'cartCourseCount'   => $cartCourseCount,
            'cartTotal'         => $cartTotal
        ]);



    }





}


