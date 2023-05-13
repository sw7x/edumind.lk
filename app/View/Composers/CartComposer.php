<?php


namespace App\View\Composers;

use Illuminate\View\View;




use App\Models\Course;
use App\Models\Enrollment;
use App\Models\CourseSelection;
use Sentinel;
use App\Models\Role;



class CartComposer
{
    public function compose(View $view)
    {
        try {

            $user = Sentinel::getUser();
            //dump();

            if($user && ($user->roles()->first()->slug == Role::STUDENT)){
                $addedCourses   =  Course::rightJoin('course_selections', function($join) use ($user){

                    $join->on('courses.id','=','course_selections.course_id')
                        ->where('course_selections.is_checkout', '=', 0)
                        ->where('course_selections.student_id', '=', $user->id)
                        ->where('courses.price', '!=', 0);
                        ////->where('courses.status', '=', "published");
                })
                //->toSql();
                //->get();
                ->get([
                    'course_selections.is_checkout',
                    'course_selections.id as courseSel_id',
                    'course_selections.used_coupon_code',
                    'course_selections.discount_amount',
                    'course_selections.revised_price',
                    //'enrollments.is_complete',
                    'courses.*'
                ]);

                dd($addedCourses);



                $discountedCourses  =   CourseSelection::Join('coupons', 'course_selections.used_coupon_code', '=', 'coupons.code')
                                            ->where('course_selections.is_checkout',0)
                                            ->where('course_selections.cart_added_date','!=',null)

                                            ->where('coupons.discount_percentage','!=',0)
                                            ->where('coupons.is_enabled',1)
                                            ->whereColumn('coupons.total_count', '>', 'coupons.used_count')

                                            ->Join('courses', 'course_selections.course_id', '=', 'courses.id')
                                            ->where('courses.price', '!=', 0)
                                            ->where('courses.status', 'published')

                                            //->toSql();
                                            ->get([
                                                'courses.name as course_name',
                                                'courses.slug as course_slug',
                                                'courses.price as course_price',

                                                'coupons.discount_percentage as coupon_discount_percentage',

                                                'course_selections.*',
                                                //'course_selections.discount_amount'
                                            ]);
                                            //->pluck('id');

                //dd2($discountedCourses);
                //dd($addedCourses);
                //dd($addedCourses->toArray());

                $totPrice    = 0;
                $subTotPrice = 0;
                foreach ($addedCourses as $key => $course) {
                    $subTotPrice    +=  $course->price;
                    $totPrice       +=  $course->revised_price;
                }


                $cartCourses        = $addedCourses->toArray();
                $cartCourseCount    = $addedCourses->count();
                $cartTotal          = $totPrice;
                $cartSubTotPrice    = $subTotPrice;
                $status             = 'success';
                $ccUsedCourses      = $discountedCourses;

            }else{
                $cartCourses        = [];
                $cartCourseCount    = 0;
                $cartTotal          = 0;
                $cartSubTotPrice    = 0;
                $status             = 'permission denied';
                $ccUsedCourses      = [];

            }
        } catch (\Exception $e) {
                $cartCourses        = [];
                $cartCourseCount    = 0;
                $cartTotal          = 0;
                $cartSubTotPrice    = 0;
                $status             = 'error';
                $ccUsedCourses      = [];
        }


        $view->with([                        
            'cartCourses'           => $cartCourses,
            'cartCourseCount'       => $cartCourseCount,
            'cartTotal'             => $cartTotal,
            'cartSubTotPrice'       => $cartSubTotPrice,
            'cartStatus'            => $status,
            'cartDiscountedCourses' => $ccUsedCourses
        ]);
    }

}
