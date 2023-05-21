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


                $courseQuery    =  Course::join('course_selections', 'courses.id', '=', 'course_selections.course_id')
                                    ->where('course_selections.student_id', $user->id)
                                    ->where('course_selections.is_checkout', 0)
                                    ->where('course_selections.cart_added_date', '!=', null);


                $cartAddedCoursesQuery  =   clone $courseQuery;               
                $discountedCoursesQuery =   clone $courseQuery;


                $cartAddedCourses   =   $cartAddedCoursesQuery
                                            ->where('courses.price', '!=', 0)
                                            //->toSql();
                                            //->get();
                                           ->get([
                                                'course_selections.is_checkout',
                                                'course_selections.id as courseSel_id',
                                                'course_selections.used_coupon_code',
                                                'course_selections.discount_amount',
                                                'course_selections.revised_price',
                                                'courses.*'
                                            ]);
                //dd($cartAddedCourses);
    
                $discountedCourses  =   $discountedCoursesQuery
                                            ->where('courses.price', '!=', 0)

                                            ->join('coupons', 'course_selections.used_coupon_code', '=', 'coupons.code')
                                            ->where('coupons.discount_percentage','!=',0)
                                            ->where('coupons.is_enabled',1)
                                            ->whereColumn('coupons.total_count', '>', 'coupons.used_count')

                                            //->toSql();
                                            ->get([
                                                'courses.name as course_name',
                                                'courses.id as course_id',
                                                'courses.slug as course_slug',
                                                'courses.price as course_price',

                                                'coupons.discount_percentage as coupon_discount_percentage',

                                                'course_selections.*',
                                                //'course_selections.discount_amount'
                                            ]);
                                            /*->first();*/
                                            //->pluck('used_coupon_code');

                //dd($discountedCourses);
                //dd($cartAddedCourses);
                //dd($cartAddedCourses->toArray());

                $totPrice    = 0;
                $subTotPrice = 0;
                foreach ($cartAddedCourses as $key => $course) {
                    $subTotPrice    += ($course->price > 0)?$course->price:0;
                    $totPrice       += ($course->revised_price > 0)?$course->revised_price:0;
                }


                $cartCourses        = $cartAddedCourses->toArray();
                $cartCourseCount    = $cartAddedCourses->count();
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
            dd($e->getMessage());
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
            'cartDiscountedCourses' => $ccUsedCourses,
        ]);


    }

}


