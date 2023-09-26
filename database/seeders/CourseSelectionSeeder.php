<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Collection;

use Sentinel;
use App\Models\Course as CourseModel;
use App\Models\CourseSelection as CourseSelectionModel;
use Ramsey\Uuid\Uuid;
use App\Models\Role as RoleModel;


class CourseSelectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        try {                        
            
            $faker = \Faker\Factory::create();

            $data = array();
            
            $allStudIdArr  = Sentinel::findRoleBySlug(RoleModel::STUDENT)->users()->with('roles')->get()->pluck('id')->toArray();
            $studentsIdArr = collect($allStudIdArr)->filter(function ($value) {
                return $value <= 40;
            })->toArray();


            // exclude courses, then student can add these courses to cart
            //  if paid - 
            //  if free - then enroll 
            //$excludeCourseIdArr = CourseModel::inRandomOrder()->take(10)->get()->pluck('id')->toArray();
            
            $courseIdArr    = CourseModel::inRandomOrder()->get()->pluck('id')->toArray();
            $courseCount    = count($courseIdArr);
            $breakCount     = 100;


            $resultCount = 0;
            foreach (range(0, ($courseCount-1)) as $i) {
                if ($resultCount >= $breakCount ) break;
                
                    
                $courseId       = $courseIdArr[$i];///////////////
                $innerLoopCount = $faker->numberBetween(0, count($studentsIdArr)-1);            
                //dump2($innerLoopCount);
                
                // randomize how many enrollments have for one course
                //$limit = $faker->randomElement([1,2,2,3,4,3,3,1,1]);
                $limit = $faker->randomElement([1,2,3,4]);
                
                // to randomize the student selections for each course
                shuffle($studentsIdArr);


                foreach (range(0, $innerLoopCount) as $j) {                
                    if (($resultCount >= $breakCount) || ($j > $limit)) break;
                    

                    // to prevent course_id and student_id combine key make duplicate values
                    $duplicates = Collection::make($data)->groupBy(function ($item) {
                        return $item['course_id'] . '-' . $item['student_id'];
                    })->filter(function ($group) {  return $group->count() > 1;})->flatten(1);

                    if($duplicates->isNotEmpty()) continue;
                    


                    $course         = CourseModel::find($courseId);
                    $isFreecourse   = ($course->price == 0)?true:false;

                    if(!$isFreecourse){
                        $edumindAmount  = $course->price * ((100 - $course->author_share_percentage)/100);              
                        $authorAmount   = $course->price * ($course->author_share_percentage/100);

                        //coupon code assign  
                        $coupons            = $course->activeCoupons;
                        $assignedCouponCode = $coupons->shuffle()->first();
                        $assignedCouponCode = $faker->randomElement([$assignedCouponCode,null,$assignedCouponCode]);
                        $code               = is_null($assignedCouponCode)?null: $assignedCouponCode->code;


                        //====== when coupon code use by customer(student) ==================/          
                        $discountAmount         = is_null($assignedCouponCode)? 0 : ($course->price * ($assignedCouponCode->discount_percentage/100));
                        $commisionPercentage    = is_null($assignedCouponCode)? 0 : ($assignedCouponCode->beneficiary_commision_percentage_from_discount);

                        $edumindLoseAmount       = ($discountAmount/100) * (100 + $commisionPercentage);
                        $beneficiaryEarnAmount   = $discountAmount * ($commisionPercentage/100);

                        $cartAddedDate  = $faker->dateTimeBetween('-6 week', '-5 week');
                        $isCheckout     = $faker->randomElement([false,true,true,true]);

                    }else{
                        $edumindAmount  = 0;              
                        $authorAmount   = 0;

                        //coupon code assign
                        $code               = null;

                        //====== when coupon code use by customer(student) ==================/          
                        $discountAmount         = 0;
                        $commisionPercentage    = 0;

                        $edumindLoseAmount       = 0;
                        $beneficiaryEarnAmount   = 0;

                        $cartAddedDate  = null;
                        $isCheckout     = false;
                    }
                   
                    //=================================================================/

                    $data[]     =   array(                
                        'uuid'              => str_replace('-', '', Uuid::uuid4()->toString()),
                        'cart_added_date'   => $cartAddedDate,
                        'is_checkout'       => $isCheckout,                                
                        'course_id'         => $courseId,          
                        'student_id'        => $studentsIdArr[$j],

                        'edumind_amount'    =>  $edumindAmount,           
                        'author_amount'     =>  $authorAmount,

                        'discount_amount'   => $discountAmount,             
                        'revised_price'     => $course->price - $discountAmount,

                        'edumind_lose_amount'       => $edumindLoseAmount,
                        'beneficiary_earn_amount'   => $beneficiaryEarnAmount,
                        'used_coupon_code'          => $code,
                        'created_at'                => date('Y-m-d H:i:s'),
                        'updated_at'                => date('Y-m-d H:i:s')
                    );  

                    $resultCount++;
                    //dump($resultCount);                
                }                     
            }
            //dd2($data);
            CourseSelectionModel::insert($data);





           
        } catch (\Exception $e) {
            $this->command->error('Failed to seed course selections to database !');
        }





        
    }
}


