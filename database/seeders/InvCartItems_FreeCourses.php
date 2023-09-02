<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Sentinel;
use App\Models\Course;
use App\Models\CourseSelection;
use Ramsey\Uuid\Uuid;

class InvCartItems_FreeCourses extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        /*=== 1. Courses that were once paid but have now been made free of charge ===*/

        $stud1User      =   Sentinel::findRoleBySlug('student')->users()->with('roles')->oldest('id')->first();
        
        $stud1CoursesQuery  =   CourseSelection::where('course_selections.student_id', $stud1User->id);
        $stud1Courses       =   $stud1CoursesQuery->orderBy('course_id')->get()->pluck('course_id')->toArray();
                        
        $freeCourses        =   Course::where('courses.price', '=', 0)
                                    ->whereNotIn('courses.id', $stud1Courses)
                                    ->get();

        $tempArr            = array();
            
        if(collect($freeCourses->first())->isNotEmpty())
            $tempArr[]  =   $freeCourses->first();           
        
        if(collect($freeCourses->get(1))->isNotEmpty())
            $tempArr[] =   $freeCourses->get(1);           
        
        if(collect($freeCourses->get(2))->isNotEmpty())
            $tempArr[] =   $freeCourses->get(2);
              
        $arr = array();
        
        foreach ($tempArr as $courseRec) {           
            $arr[]  =   array(
                'uuid'              => str_replace('-', '', Uuid::uuid4()->toString()),
                'cart_added_date'   => now(), //important to be not null in this secnario
                'is_checkout'       => false,
                'course_id'         => $courseRec->id,////
                'student_id'        => $stud1User->id,
                'edumind_amount'    => 0,
                'author_amount'     => 0,

                'used_coupon_code'          => null,
                'discount_amount'           => 0,
                'revised_price'             => 0,
                'edumind_lose_amount'       => 0,
                'beneficiary_earn_amount'   => 0,
                
                'created_at'                => date('Y-m-d H:i:s'),
                'updated_at'                => date('Y-m-d H:i:s')                
            );
        }

        
        //dd($arr);
        CourseSelection::insert($arr);

    }
}
