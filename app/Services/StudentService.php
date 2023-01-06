<?php


namespace App\Services;




use App\Models\User;
use App\Models\Course;
class StudentService
{






    public function getCoursesByStudent(User $student){

        return $student->enrolled_courses()
            ->where('courses.status', Course::PUBLISHED)
            ->where(function($query) {
                $query->where('enrollments.status', 'enrolled')
                    ->orWhere('enrollments.status', 'completed');
            })->get();
    }



}
