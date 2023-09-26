<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Sentinel;
use App\Models\Course as CourseModel;
use App\Models\Coupon as CouponModel;
use App\Models\CourseSelection as CourseSelectionModel;
use Ramsey\Uuid\Uuid;
use App\Models\Role as RoleModel;
class InvCartItems_InvalidCc extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        try {                        
            
            //$paidCourseArr    =   CourseModel::inRandomOrder()->where('courses.price', '!=', 0)->get()->pluck('id');
            $stud1User          =   Sentinel::findRoleBySlug(RoleModel::STUDENT)->users()->with('roles')->oldest('id')->first();
            
            $stud1CoursesQuery  =   CourseSelectionModel::where('course_selections.student_id', $stud1User->id);
            $stud1Courses       =   $stud1CoursesQuery->orderBy('course_id')->get()->pluck('course_id')->toArray();
            $stud1Ccs           =   $stud1CoursesQuery->whereNotNull('used_coupon_code')->get()->pluck('used_coupon_code')->toArray();
                                            
            

            /*== 2.1 inser invalid coupon codes used cart records ===================
                    - not intended coupon
                    - coupon available count is over
                    - coupon is disabled
                    - coupon was used for the course which it was not intended to
            ========================================================================*/
            
            $tempArr            = array();
            $skipCoursesIdArr   = array();
            $skipCc             = array();
            
            $skipCoursesIdArr   = $stud1Courses;
            $skipCc             = $stud1Ccs;

            

            /* (2.1--1) === not intended coupon use === */        
            $RandCc1    =   CouponModel::where('coupons.cc_course_id', '!=', null)
                                ->whereColumn('coupons.total_count', '>', 'coupons.used_count')
                                ->where('coupons.discount_percentage', '!=', 0)
                                ->whereNotIn('coupons.code',$skipCc)
                                ->inRandomOrder()
                                ->first();      

            if(!is_null($RandCc1)){
                
                // get courses except course belongs to $RandCc1
                $courses1   =   CourseModel::Join('coupons', 'courses.id', '=', 'coupons.cc_course_id')
                                    ->where('coupons.cc_course_id', '!=', $RandCc1->cc_course_id)
                                    ->where('coupons.is_enabled', 1)
                                    ->where('courses.price', '!=', 0)
                                    //->where('courses.id', 1000)
                                    ->whereNotIn('courses.id', $skipCoursesIdArr)
                                    ->get();
                                  
                if($courses1->isNotEmpty()){
                    $courseId1          =  $courses1->first()->id;
                    $skipCoursesIdArr[] =  $courseId1;
                    $skipCc[]           =  $RandCc1->code;     
                    $tempArr[]          =  array('cc' => $RandCc1, 'insert_course_id' => $courseId1, 'v' => 'v1');
                }      
            }                    
            /* (2.1--1) === End ======================== */
               
            

            

            /* (2.1--2) === not intended coupon use and used coupon available count is over === */
            $RandCc2    =   CouponModel::where('coupons.cc_course_id', '!=', null)
                                ->whereColumn('coupons.total_count', '<=', 'coupons.used_count')
                                ->where('coupons.discount_percentage', '!=', 0)
                                ->whereNotIn('coupons.code',$skipCc)
                                ->inRandomOrder()
                                ->first();

            if(!is_null($RandCc2)){                    
                
                // get courses except $courseId1, and course belongs to $RandCc2  
                $courses2   =   CourseModel::Join('coupons', 'courses.id', '=', 'coupons.cc_course_id')
                                    ->where('coupons.is_enabled', '=', 1)
                                    ->where('coupons.cc_course_id', '!=', $RandCc2->cc_course_id)
                                    ->whereNotIn('courses.id', $skipCoursesIdArr)
                                    ->where('courses.price', '!=', 0)
                                    ->get();
                                    
                if($courses2->isNotEmpty()){                    
                    $courseId2          =  $courses2->first()->id;
                    $skipCoursesIdArr[] =  $courseId2;
                    $skipCc[]           =  $RandCc2->code;                  
                    $tempArr[]          =   array('cc' => $RandCc2, 'insert_course_id' => $courseId2, 'v' => 'v2');
                }
            }                 
            /* (2.1--2) === End ============================================================== */
             


            /* (2.1--3) === not intended coupon use and used coupon is disabled === */
            $RandCc3    =   CouponModel::withoutGlobalScope('enabled')
                                ->where('coupons.cc_course_id', '!=', null)
                                ->whereColumn('coupons.total_count', '>', 'coupons.used_count')
                                ->where('coupons.discount_percentage', '!=', 0)
                                ->where('coupons.is_enabled', '!=', 1)
                                ->whereNotIn('coupons.code',$skipCc)
                                ->inRandomOrder()
                                ->first();

            if(!is_null($RandCc3)){                    
                
                // get courses except $courseId1, $courseId2 and course belongs to $RandCc3  
                $courses3   =   CourseModel::Join('coupons', 'courses.id', '=', 'coupons.cc_course_id')
                                    ->where('coupons.is_enabled', '!=', 1)
                                    ->where('coupons.cc_course_id', '!=', $RandCc3->cc_course_id)
                                    ->whereNotIn('courses.id', $skipCoursesIdArr)
                                    ->where('courses.price', '!=', 0)
                                    ->get();
                                    
                if($courses3->isNotEmpty()){                    
                    $courseId3          =  $courses3->first()->id;
                    $skipCoursesIdArr[] =  $courseId3;
                    $skipCc[]           =  $RandCc3->code;                 
                    $tempArr[]          =   array('cc' => $RandCc3, 'insert_course_id' => $courseId3, 'v' => 'v3');
                }
            }
            /* (2.1--3) === End ================================================== */
            


            /* (2.1--4) === not intended coupon use, used coupon is disabled and available count is over  === */
            $RandCc4    =   CouponModel::withoutGlobalScope('enabled')
                                ->where('coupons.cc_course_id', '!=', null)
                                ->whereColumn('coupons.total_count', '<=', 'coupons.used_count')
                                ->where('coupons.discount_percentage', '!=', 0)
                                ->where('coupons.is_enabled', '!=', 1)                            
                                ->whereNotIn('coupons.code',$skipCc)
                                ->inRandomOrder()
                                ->first();
            
            if(!is_null($RandCc4)){
                
                // courses except $courseId1, $courseId2, $courseId3 and course belongs to $RandCc4 are skip 
                $courses4   =   CourseModel::Join('coupons', 'courses.id', '=', 'coupons.cc_course_id')
                                    ->where('coupons.is_enabled', '!=', 1)
                                    ->where('coupons.cc_course_id', '!=', $RandCc4->cc_course_id)
                                    ->whereNotIn('courses.id', $skipCoursesIdArr)
                                    ->where('courses.price', '!=', 0)                            
                                    ->get();
                                    
                if($courses4->isNotEmpty()){
                    $courseId4          =  $courses4->first()->id;
                    $skipCoursesIdArr[] =  $courseId4;
                    $skipCc[]           =  $RandCc4->code;                  
                    $tempArr[]          =   array(
                        'cc' => $RandCc4, 
                        'insert_course_id' => $courseId4, 
                        'v' => 'v4'
                    );
                }
            }
            /* (2.1--4) === End ============================================================================ */
            
            //dump($courses1,$courses2,$courses3,$courses4);
            

            


            // (2.2) disabled coupon codes, use to intended course
            $cc1    =   CouponModel::withoutGlobalScope('enabled')
                                    ->join('courses', 'coupons.cc_course_id', '=', 'courses.id')
                                    ->whereNotIn('coupons.code',$skipCc)
                                    ->where('coupons.is_enabled', '!=', 1)
                                    ->whereColumn('coupons.total_count', '>', 'coupons.used_count')
                                    ->where('coupons.cc_course_id', '!=', null)
                                    ->whereNotIn('courses.id', $skipCoursesIdArr)
                                    ->where('courses.price', '!=', 0)
                                    ->first();
            
            if(!is_null($cc1)){
                $tempArr[]          = array('cc' => $cc1, 'insert_course_id' => $cc1->cc_course_id, 'v' => 'v5');
                $skipCoursesIdArr[] = $cc1->cc_course_id;            
            }




            // (2.3) available count over coupon codes, use to intended course
            $cc2    =   CouponModel::whereColumn('coupons.total_count', '<=', 'coupons.used_count')
                            ->join('courses', 'coupons.cc_course_id', '=', 'courses.id')
                            ->whereNotIn('coupons.code',$skipCc)
                            ->where('coupons.cc_course_id', '!=', null)
                            ->whereNotIn('courses.id', $skipCoursesIdArr)
                            ->where('courses.price', '!=', 0)
                            ->first();

            if(!is_null($cc2)){
                $tempArr[]          = array('cc' => $cc2, 'insert_course_id' => $cc2->cc_course_id, 'v' => 'v6');
                $skipCoursesIdArr[] = $cc2->cc_course_id;
            }

            
            // (2.4) coupon codes that disabled and available count is over, use to intended course
            $cc3    =   CouponModel::withoutGlobalScope('enabled')
                            ->join('courses', 'coupons.cc_course_id', '=', 'courses.id')
                            ->where('coupons.is_enabled', '!=', 1)
                            ->whereColumn('coupons.total_count', '<=', 'coupons.used_count')
                            ->whereNotIn('coupons.code',$skipCc)
                            ->where('coupons.cc_course_id', '!=', null)
                            ->whereNotIn('courses.id', $skipCoursesIdArr)
                            ->where('courses.price', '!=', 0)
                            ->first();

            if(!is_null($cc3)){
                $tempArr[]          = array('cc' => $cc3, 'insert_course_id' => $cc3->cc_course_id, 'v' => 'v7');
                $skipCoursesIdArr[] = $cc3->cc_course_id;
            }
            

            //dump($tempArr);
            
            $arr = array();
            foreach ($tempArr as $tempArrRecord) {            
                
                $ccRec          = $tempArrRecord['cc'];
                $insertCourseId = $tempArrRecord['insert_course_id'];
                
                if(collect($ccRec)->isEmpty()) continue;
                if(is_null($insertCourseId)) continue;

                $course = CourseModel::find($insertCourseId);
                
                $discountAmount      = $course->price * ($ccRec->discount_percentage/100);
                $commisionPercentage = $ccRec->beneficiary_commision_percentage_from_discount;

                $arr[]  =   array(
                    'uuid'              => str_replace('-', '', Uuid::uuid4()->toString()),
                    'cart_added_date'   => now(),
                    'is_checkout'       => false,
                    'course_id'         => $insertCourseId,
                    'student_id'        => $stud1User->id,
                    'edumind_amount'    => $course->price * ((100 - $course->author_share_percentage)/100),
                    'author_amount'     => $course->price * ($course->author_share_percentage/100),

                    'used_coupon_code'          => $ccRec->code,
                    'discount_amount'           => $discountAmount,
                    'revised_price'             => $course->price - $discountAmount,
                    'edumind_lose_amount'       => ($discountAmount/100) * (100 + $commisionPercentage),
                    'beneficiary_earn_amount'   => $discountAmount * ($commisionPercentage/100),
                    
                    'created_at'                => date('Y-m-d H:i:s'),
                    'updated_at'                => date('Y-m-d H:i:s')
                    //'cc-course-id'    => $cc->cc_course_id,
                    //'cc-en'           => $cc->is_enabled,
                    //'cc-count'        => ($cc->total_count - $cc->used_count)
                );
            }

            CourseSelectionModel::insert($arr);
            //dd($arr);

        } catch (\Exception $e) {
            $this->command->error('Failed to seed invalid cart items that has Invalid coupon code(s) !');
        }

    }
}
