<?php


namespace App\Services;




use App\Models\User;
use App\Models\Course;


use App\Models\CourseSelection;
class StudentService
{






    public function getCoursesByStudent(User $student){
		


		$enrolledCourses = 	Course::join('course_selections', function($join) use ($student){
								$join->on('courses.id','=','course_selections.course_id')							    	
							    	->where('course_selections.student_id', '=', $student->id);									
							})
							->join('enrollments','course_selections.id','=','enrollments.course_selection_id')
							->get([
								//'course_selections.student_id',
								'enrollments.is_complete',
								'courses.*'
							]);
							//->toArray()
		
		return $enrolledCourses;
        
        /*
        return $student->course_selections()
            ->where('courses.status', Course::PUBLISHED)
            ->where(function($query) {
                $query->where('enrollments.status', 'enrolled')
                    ->orWhere('enrollments.status', 'completed');
            })->get();
        */
    }




	// stud view his profile - front side
	//  stud edit his profile - front side
	
	

}
