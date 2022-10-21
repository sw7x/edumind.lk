<?php


namespace App\Services;




use App\Models\User;

class StudentService
{






    public function getCoursesByStudent(User $student){

        return $student->enrolled_courses()
            ->where('courses.status','published')
            ->where(function($query) {
                $query->where('enrollments.status', 'enrolled')
                    ->orWhere('enrollments.status', 'completed');
            })->get();
    }



}
