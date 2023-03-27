<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;
use Sentinel;


class CourseSelectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [           
                       

            'cart_add_date' => $this->faker->dateTimeBetween('-6 week', '-5 week'),
            'is_checkout'   => $this->faker->randomElement([false,true,true,true]),
            
            //'course_id'     => Course::factory(),
            'course_id'     => Course::inRandomOrder()->first()->id,
            

            'student_id'    => function () {
                $students           = Sentinel::findRoleBySlug('student')->users()->with('roles')->get();                
                $shuffledStudents   = $students->shuffle();
                return $shuffledStudents->first();
            }     
        
        ];
    }
}
