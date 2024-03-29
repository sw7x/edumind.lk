<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Sentinel;
use Ramsey\Uuid\Uuid;

use App\Models\Role as RoleModel;
use App\Models\Course as CourseModel;
use App\Models\Coupon as CouponModel;
use App\Models\CourseSelection as CourseSelectionModel;

class InvCartItems_ValidMultipleCc extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        try {                        
            
            /*===   
            insert multiple course selections they have assigned valid coupon codes 
            with their intended courses                                        
            ===*/

            $stud1User      =   Sentinel::findRoleBySlug(RoleModel::STUDENT)->users()->with('roles')->oldest('id')->first();
            
            $stud1CoursesQuery  =   CourseSelectionModel::where('course_selections.student_id', $stud1User->id);
            $stud1Courses       = $stud1CoursesQuery->orderBy('course_id')->get()->pluck('course_id')->toArray();
            $stud1Ccs           = $stud1CoursesQuery->whereNotNull('used_coupon_code')->get()->pluck('used_coupon_code')->toArray();
                                            

            $tempArr            = array();
            $skipCoursesIdArr   = array();
            $skipCcArr          = array();
            
            $skipCoursesIdArr   = $stud1Courses;
            $skipCcArr          = $stud1Ccs;

            
            $courseAssignCc =   CouponModel::Join('courses', 'coupons.cc_course_id', '=', 'courses.id')                
                                    ->whereColumn('coupons.total_count', '>', 'coupons.used_count')
                                    ->where('coupons.discount_percentage', '!=', 0)                        
                                    ->whereNotIn('coupons.code',$skipCcArr) 
                                    //->where('coupons.code','EEEDDD')                        
                                    ->whereNotIn('coupons.cc_course_id', $skipCoursesIdArr)
                                    ->where('courses.price', '!=', 0)
                                    ->get();

            

            $courseNotAssignCc  =   CouponModel::WhereNull('coupons.cc_course_id')
                                        ->whereColumn('coupons.total_count', '>', 'coupons.used_count')
                                        ->where('coupons.discount_percentage', '!=', 0)                        
                                        ->whereNotIn('coupons.code',$skipCcArr)                     
                                        ->get();
                                        //->toSql();
                
            if(collect($courseAssignCc->first())->isNotEmpty()){
                $cc0                =   $courseAssignCc->first();
                $tempArr[]          =   array('cc' => $cc0, 'insert_course_id' => $cc0->cc_course_id);
                $skipCoursesIdArr[] =   $cc0->cc_course_id;
            }
            
            if(collect($courseAssignCc->get(1))->isNotEmpty()){
                $cc1                =   $courseAssignCc->get(1);
                $tempArr[]          =   array('cc' => $cc1, 'insert_course_id' => $cc1->cc_course_id);
                $skipCoursesIdArr[] =   $cc1->cc_course_id;
            }    

            if(collect($courseAssignCc->get(2))->isNotEmpty()){
                $cc2                =   $courseAssignCc->get(2);
                $tempArr[]          =   array('cc' => $cc2, 'insert_course_id' => $cc2->cc_course_id);
                $skipCoursesIdArr[] =   $cc2->cc_course_id;
            }    

            
            

            if(collect($courseNotAssignCc->first())->isNotEmpty()){
                $cc3        =   $courseNotAssignCc->first();

                $paidCourseArr      =   CourseModel::inRandomOrder()->where('courses.price', '!=', 0)->get()->pluck('id')->toArray();
                $availableCourses   =   array_diff($paidCourseArr, $skipCoursesIdArr);
                $cId                =   collect($availableCourses)->random();

                $tempArr[]  =   array('cc' => $cc3, 'insert_course_id' => $cId);
                //$skipCoursesIdArr[] =   $cId;
            }

            //dump($tempArr);

            

            $arr = array();
            foreach ($tempArr as $tempArrRecord) {            
                
                $ccRec          = $tempArrRecord['cc'];
                $insertCourseId = $tempArrRecord['insert_course_id'];

                $studCourseSelectedCount    =   CourseSelectionModel::where('course_id',$insertCourseId)
                                                    ->where('student_id',$stud1User->id)
                                                    ->count();
                
                // if the student has already enrolled or added the course to their cart, skip it.
                if($studCourseSelectedCount > 0) continue;       
                
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
            
            //dump($arr);
            CourseSelectionModel::insert($arr);


        } catch (\Exception $e) {
            $this->command->error('Failed to seed invalid cart items - one user applied multiple valid coupon codes to his/her cart !');
        }
        
    }
}