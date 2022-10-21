<?php


namespace App\Services;




use App\Models\Course;

class CourseService
{

    public function loadNewCourse(){

        return Course::latest()->take(8)->get();
        //return Course::latest('id')->take(8)->get();

    }


    public function loadPopularCourse(){




        /*
        // todo filter when rows have (course_id,student_id) duplicate values
        return Course::whereHas('students', function ($q) {
            $q->where('enrollments.status', 'enrolled')
                ->orWhere('enrollments.status', 'completed');
        })->withCount(['students'=> function($query){
            $query->where('enrollments.status', 'enrolled')
                ->orWhere('enrollments.status', 'completed');
        }])->orderBy('students_count', 'desc')->skip(0)->take(8)->get();
        //dd($rr);
        */



        return Course::orderBy('id', 'desc')->skip(0)->take(5)->get();









    }



 /*
    public function checkUsernameExists($username){
        return User::where('username',$username)->get()->count();
    }

   public function getlinkCount($data){
        return User::where('username',$username)->get()->count();
    }*/




}
