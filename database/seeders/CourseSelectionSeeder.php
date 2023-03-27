<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseSelection;
use Faker\Generator as Faker;
use Sentinel;
use App\Models\Course;





class CourseSelectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        //CourseSelection::factory()->count(100)->create();
        $data = array();
        $studentsIdArr           = Sentinel::findRoleBySlug('student')->users()->with('roles')->get()->pluck('id')->toArray();    
        $courseIdArr             = Course::inRandomOrder()->get()->pluck('id')->toArray();

        //dump2($studentsIdArr);
        //dump2($courseIdArr);dd();


        $resultCount = 0;
        foreach (range(0, 49) as $i) {
            if ($resultCount >= 250 ) {
                break;
            }else{
                $courseId = $courseIdArr[$i];
                $innerLoopCount = $faker->numberBetween(0, count($studentsIdArr)-1);            
                //dump2($innerLoopCount);
                
                // randomize how many enrollments have for one course
                $limit = $faker->randomElement([1,2,2,3,4,3,3,1,1]);

                
                foreach (range(0, $innerLoopCount) as $j) {                
                    if ($resultCount >= 250 || $j > $limit) {
                        break;
                    }else{
                        $data[]     =   array(                
                            'cart_add_date' => $faker->dateTimeBetween('-6 week', '-5 week'),
                            'is_checkout'   => $faker->randomElement([false,true,true,true]),                                
                            'course_id'     => $courseId,          
                            'student_id'    => $studentsIdArr[$j]
                        );                    
                    }
                    $resultCount++;
                }
            }         
        }
        //dd2($data);
        CourseSelection::insert($data);
    }
}
