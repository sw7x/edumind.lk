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

                        $course         = Course::find($courseId);
                        $edumindAmount  = $course->price * ((100 - $course->author_share_percentage)/100);              
                        $authorAmount   = $course->price * ($course->author_share_percentage/100);

                        //coupon code assign  
                        $coupons            = $course->coupons;
                        $assignedCouponCode = $coupons->shuffle()->first();          
                        $code               = is_null($assignedCouponCode)?null: $assignedCouponCode->code;


                        //====== when coupon code use by customer(student) ==================/          
                        $discountAmount         = is_null($assignedCouponCode)? 0 : ($course->price * ($assignedCouponCode->discount_percentage/100));
                        $commisionPercentage    = is_null($assignedCouponCode)? 0 : ($assignedCouponCode->beneficiary_commision_percentage_from_discount);
                       
                        $edumindLoseAmount       = ($discountAmount/100) * (100 + $commisionPercentage);
                        $benificiaryEarnAmount   = $discountAmount * ($commisionPercentage/100);
                        //=================================================================/


                        $data[]     =   array(                
                            'cart_add_date' => $faker->dateTimeBetween('-6 week', '-5 week'),
                            'is_checkout'   => $faker->randomElement([false,true,true,true]),                                
                            'course_id'     => $courseId,          
                            'student_id'    => $studentsIdArr[$j],



                            'edumind_amount'    =>  $edumindAmount,           
                            'author_amount'     =>  $authorAmount,

                            'discount_amount'       => $discountAmount,             
                            'price_afeter_discouunt'=> $course->price - $discountAmount,



                            'edumind_lose_amount'       => $edumindLoseAmount,
                            'benificiary_earn_amount'   => $benificiaryEarnAmount,
                            'used_coupon_code'   => $code,


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
