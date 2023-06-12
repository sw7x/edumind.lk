<?php

namespace App\Services;

use App\Models\User;
use Sentinel;
use App\Models\Course;


class TeacherService
{



    public function loadPopularTeachers(){
        //load 8 teachers that have higher number of courses

        $popularTeachers = User::withCount('getTeachingCourses')->orderBy('get_teaching_courses_count', 'desc')->skip(0)->take(8)->get();;
        //$popularTeachers = User::withCount('enrolled_courses')->orderBy('enrolled_courses_count', 'desc')->skip(0)->take(8)->get();;

        //dd($popularTeachers);

        //return null;
        return $popularTeachers;


    }


    public function getPublishedCoursesByTeacher(User $teacher){
        //return $teacher->getTeachingCourses()->where('status',Course::PUBLISHED)->get();
        return $teacher->getTeachingCourses()->get();
    }

    public function getAllCoursesByTeacher(User $teacher){
        //dd($teacher->getTeachingCourses()->get());
        
        //return $teacher->getTeachingCourses()->get();
        return $teacher->getTeachingCourses()->withoutGlobalScope('published')->get();

    }



    public function getAllTeachers(){
        //dd($teacher->getTeachingCourses()->get());
        //$teachers   =   Sentinel::findRoleBySlug('teacher')->users()->with('roles')->where('status',1)->orderBy('id')->get();
        $teachers   =   Sentinel::findRoleBySlug('teacher')->users()->with('roles')->orderBy('id')->get();
        return $teachers;
    }








}



//service only methods - not in entity    
    //viewprofile()  - site frontend
    //edit profile   - (teacher can edit his own profile in admin panel)

    //view teacher courses   
    //view earnings by teacher
    


//service methods - also in entity   
    //change user status


