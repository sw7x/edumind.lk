<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use App\Models\CourseSelection;
use App\Exceptions\CustomException;
use App\Models\Course;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use App\Models\Enrollment;
use App\Models\Coupon;

use App\Http\Requests\BillingInfoRequest;
use App\Http\Requests\CreditCardDetailsRequest;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;


use Illuminate\Support\Facades\Crypt;
//use Illuminate\Http\Response;
use Cookie;

use App\Models\User;
class CartController extends Controller
{
	public function viewCart()
    {

        try {
            $msgArr = [];
            $user = Sentinel::getUser();
            
            //before load cart page view, resetting and remove invalid cart items in user's cart
            if($user && ($user->roles()->first()->slug == Role::STUDENT)){


                /*=== 1. Courses that were once paid but have now been made free of charge ===*/
                $cartFreeCourses    =   Course::join('course_selections', 'courses.id', '=', 'course_selections.course_id')
                                            ->where('course_selections.student_id', $user->id)
                                            ->where('course_selections.is_checkout', 0)
                                            ->where('course_selections.cart_added_date', '!=', null)
                                            ->where('courses.price', 0)
                                            //->toSql()
                                            ->get('courses.*');


                if($cartFreeCourses->isNotEmpty()){
                    $msgArr['rlsCourses']['errTitle'] = 'The price of some course(s) in your cart has changed to free. They have been automatically removed from your cart.';
                    $msgArr['rlsCourses']['errArr']   =  $cartFreeCourses->map(function ($freeCourse) use ($user){

                        /* delete free cuses from cart */
                        CourseSelection::where('course_selections.student_id', $user->id)
                            ->where('course_selections.is_checkout', 0)
                            ->where('course_selections.cart_added_date', '!=', null)
                            ->where('course_selections.course_id',$freeCourse->id)
                            ->delete();
                        
                        //dump($freeCourse->id);

                        // generate message for the user to tell about deleted courses
                        return '<a href="'.route('course-single',$freeCourse->slug).'">'.$freeCourse->name.'</a>';
                    });
                }
                //dump('1.cartFreeCourses');
                //dump($cartFreeCourses);
                /*=== 1 END =========================================================== ===*/



                /*=== 2. Coupon codes become invalid after apply - available count is over, disabled ===*/
                $cartInvalidCc  =   CourseSelection::join('courses', 'course_selections.course_id', '=', 'courses.id')
                                        ->where('course_selections.student_id', $user->id)
                                        ->where('course_selections.is_checkout', 0)
                                        ->where('course_selections.cart_added_date', '!=', null)

                                        ->latest('course_selections.updated_at')
                                        ->where('courses.price', '!=', 0)
                                        //->where('courses.status', 'published');

                                        ->join('coupons', 'course_selections.used_coupon_code', '=', 'coupons.code')
                                        ->where(function ($query){
                                            $query
                                                ->orWhere('coupons.is_enabled', '!=', 1)
                                                ->orWhereColumn('coupons.total_count', '<=', 'coupons.used_count')
                                                ->orWhere(function ($subQuery){
                                                    $subQuery->whereNotNull('coupons.cc_course_id')
                                                        ->WhereColumn('course_selections.course_id', '!=', 'coupons.cc_course_id');
                                                });
                                        })
                                        //->toSql();
                                        /*->get();*/
                                        ->get([
                                            'course_selections.*',
                                            'coupons.cc_course_id',
                                            'coupons.is_enabled',
                                            'coupons.total_count',
                                            'coupons.used_count'
                                        ]);

            
                if($cartInvalidCc->isNotEmpty()){
                    $msgArr['invoiceCc']['errTitle'] = 'Invalid coupon code(s) detected. They have been automatically removed from your cart.';
                    $msgArr['invoiceCc']['errArr']   =  $cartInvalidCc->map(function ($cartItem) use ($user){

                        $ccMsg  = '';
                        $coupon = Coupon::withoutGlobalScope('enabled')->find($cartItem->used_coupon_code);

                        $cartItemCourseId   = $cartItem->course_id;
                        $ccCourseId         = $coupon->cc_course_id;
                        $ccAvalableCount    = $coupon->total_count - $coupon->used_count;
                        //dump($coupon);
                        //dump($cartItemCourseId .' === '.$ccCourseId);
            
                        $ccMsg .= !is_null($ccCourseId) ? (($cartItemCourseId != $ccCourseId) ? ', not valid for the course(s) in your cart' : '') : '';
                        $ccMsg .= ($ccAvalableCount <= 0)?', no longer available':'';
                        $ccMsg .= (!$coupon->is_enabled)?', disabled':'';

                        // format error messages
                        $ccMsg = Str::replaceFirst(', ', '', $ccMsg);
                        $ccMsg = Str::ucfirst($ccMsg);
                        $ccMsg = $cartItem->used_coupon_code.' - '.$ccMsg;
                        //dump($ccMsg);

                        /* remove invalid coupons from courseSelection records */
                        $cartItem->used_coupon_code        = null;
                        $cartItem->discount_amount         = 0;
                        $cartItem->revised_price           = $cartItem->course->price;
                        $cartItem->edumind_lose_amount     = 0;
                        $cartItem->benificiary_earn_amount = 0;
                        $cartItem->updated_at              = now();
                        $cartItem->save(['timestamps' => false]);
                        

                        return $ccMsg;
                    });
                }
                //dump('2.cartInvalidCc');
                //dump($cartInvalidCc);
                /*=== 2 END ======================================================================= ===*/
                
                




                /*=== 3. If the foreign key relationship fails due to the nonexistence of the Coupon record ===*/
                $csWithoutCC    =   CourseSelection::whereNotExists(function ($query) {
                                        $query->select('code')
                                            ->from('coupons')
                                            ->whereColumn('coupons.code', 'course_selections.used_coupon_code');
                                    })
                                    ->whereNotNull('course_selections.used_coupon_code')
                                    //->toSql();
                                    ->get();               
                
                if($csWithoutCC->isNotEmpty()){
                    $msgArr['csWithoutCC']['errTitle'] = 'Nonexistence coupon code(s) have been automatically removed from your cart';
                    $msgArr['csWithoutCC']['errArr']   =  $cartInvalidCc->map(function ($cartItem) use ($user){

                        $msg   = '';                        
                        $msg   = $cartItem->used_coupon_code;

                        /* remove nonexistence coupons from user cart */
                        $cartItem->used_coupon_code        = null;
                        $cartItem->discount_amount         = 0;
                        $cartItem->revised_price           = $cartItem->course->price;
                        $cartItem->edumind_lose_amount     = 0;
                        $cartItem->benificiary_earn_amount = 0;
                        $cartItem->updated_at              = now();
                        $cartItem->save(['timestamps' => false]);
                        
                        
                        return $msg;       
                    });
                }
                //dump('3.csWithoutCC');
                //dump($csWithoutCC);
                /*=== 3 END ============================================================================== ===*/










                /*=== 4. check multiple (valid) coupon codes have used in user cart ===========================*/
                $cartValidCc    =   CourseSelection::join('courses', 'course_selections.course_id', '=', 'courses.id')
                                        ->where('course_selections.student_id', $user->id)
                                        ->where('course_selections.is_checkout', 0)
                                        ->where('course_selections.cart_added_date', '!=', null)

                                        ->latest('course_selections.updated_at')
                                        ->where('courses.price', '!=', 0)
                                        //->where('courses.status', 'published');

                                        ->join('coupons', 'course_selections.used_coupon_code', '=', 'coupons.code')

                                        ->where('coupons.is_enabled',1)
                                        ->whereColumn('coupons.total_count', '>', 'coupons.used_count')
                                        ->where(function ($query){
                                            $query->orWhereNull('coupons.cc_course_id')
                                                ->orWhereColumn('course_selections.course_id', '=', 'coupons.cc_course_id');
                                        })
                                        //->toSql();
                                        ->get('course_selections.*');
                        
                if($cartValidCc->count() > 1){
                    $msgArr['cartValidCc']['errTitle'] = 'Only one coupon code can be applied at a time. The latest applied coupon has been kept, and following coupon codes were removed from your cart';
                    $msgArr['cartValidCc']['errArr']   =  $cartValidCc->skip(1)->map(function ($cartItem, $key) use ($user){

                        $valCcMsg   = '';
                        $valCcMsg   = $cartItem->used_coupon_code;

                        /* latest applied coupon has been kept, and the others remove from user cart */
                        $cartItem->used_coupon_code        = null;
                        $cartItem->discount_amount         = 0;
                        $cartItem->revised_price           = $cartItem->course->price;
                        $cartItem->edumind_lose_amount     = 0;
                        $cartItem->benificiary_earn_amount = 0;
                        $cartItem->updated_at              = now();
                        $cartItem->save(['timestamps' => false]);
                        
                        
                        return $valCcMsg;                        
                    });
                }      
                //dump('4.cartValidCc');
                //dump($cartValidCc->count());
                //dump($cartValidCc);
                /*=== 4 END ============================================================================== ===*/
            }
            //dd($msgArr);

            $cartReInitMsg      = empty($msgArr)? '' : 'Cart reset. Some items unavailable or modified. Please review and update your cart.';
            $cartReInitMsgCls   = empty($msgArr)? '' : 'flash-warning';
            $cartReInitMsgTitle = empty($msgArr)? '' : 'Invalid Cart Items !';           

            return view('student.cart.cart-page')->with([
                'cart_re_init_message'  => $cartReInitMsg,
                'cart_re_init_cls'      => $cartReInitMsgCls,
                'cart_re_init_msgTitle' => $cartReInitMsgTitle,
                'cart_re_init_msg_arr'  => $msgArr
            ]);;

        } catch (\Exception $e) {

            return view('student.cart.cart-page')->with([
                'cart_re_init_message'  => 'Cart reinitialization failed',
                //'cart_re_init_message'  => $e->getMessage(),
                'cart_re_init_cls'      => 'flash-danger',
                'cart_re_init_msgTitle' => 'Error',
                'cart_re_init_msg_arr'  => []
            ]);

        }

    }


    public function removeFromCart(Request $request, $id){
        
        //dump($request->get('page'));
        //dd($id);

        $user = Sentinel::getUser();

        //dump($id);
        //dump($user->id);

        $isDelete = CourseSelection::Where('course_id',$id)
                        ->where('student_id',$user->id)
                        ->where('is_checkout',0)
                        ->first()
                        ->delete();


       //dd($isDelete);  


       if($isDelete){

            if($request->get('page') == 'cart'){
                return redirect(route('view-cart'));
            }else{
                return redirect()->back();;
            }
            
       }else{
            return redirect(route('view-cart'))->with([
                'message'   => 'Course remove from cart failed!',
                'cls'       => 'flash-danger',
                'msgTitle'  => 'Error!',
            ]);
       }       

    }

    public function checkoutCart()
    {
        //dump('checkoutCart');

        try{

        	$user 			= Sentinel::getUser();
        	$courseInfoArr 	= array();
        	$invoiceRec;

	        if($user && ($user->roles()->first()->slug == Role::STUDENT)){	            
	            
	        	DB::transaction(function () use ($user, &$courseInfoArr, &$invoiceRec) {
				    $courseSelections = CourseSelection::join('courses', 'course_selections.course_id', '=', 'courses.id')
				        ->where('course_selections.is_checkout', 0)
				        ->where('course_selections.student_id', $user->id)
				        ->where('courses.price', '!=', 0)
				        ->get('course_selections.*');

				    $now 		= Carbon::now();
				    /**/
				    $invoice   	= Invoice::create([
			            'checkout_date' => $now,
			            'billing_info' 	=> 'mm',
			        ]);

			        // re-retrieve the instance to get all of the fields in the table.
					$invoiceRec = $invoice->fresh();

 					
				    foreach ($courseSelections as $selection) {
				        // upda course_selections table record
				        $selection->is_checkout 	= 1;
				        $selection->cart_added_date = $now;
				        $selection->save();

				        Enrollment::create([
				            'course_selection_id' 	=> $selection->id,
				            'is_complete' 			=> false,
				            'invoice_id'			=> $invoiceRec->id
				        ]);
				        /**/

				        $courseInfoArr[] = array(
				        	'name' => $selection->course->name,
							'url' => route('course-single',$selection->course->slug)
				        );
						



				    }
				});
	            
	            //dump($invoice->id);
	           	//dump($courseInfoArr);
	            //dd();



	            return view('student.checkout-complete')->with([
	            	'invoiceId' => $invoiceRec->id,
	            	'courses'	=> $courseInfoArr
	            ]);             

	        }else{            
	        	throw new CustomException('Invalid user');         
	        }

        }catch(CustomException $e){
			dd($e->getMessage());
            return redirect()->back()->with([
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);

        }catch(\Exception $e){
        	dd($e->getMessage());
            return redirect()->back()->with([
                'message'     => $e->getMessage(),
                //'message'     => 'Course does not exist!',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }

    }


	public function loadBillingInfoPage(Request $request){

        dump('loadBillingInfoPage');      
        $csrfToken      = $request->session()->token();
        $tokenFromUrl   = $request->get('key');

        dump($csrfToken);
        dump($tokenFromUrl);
        
        if($csrfToken == $tokenFromUrl){
            return view('student.cart.bill-info');
        }else{
            abort(403);
        } 
	}
    
    //public function submitBillingInfo(Request $request){
	public function submitBillingInfo(BillingInfoRequest $request){        
        
        dump('submitBillingInfo');
        dump($request->all());
        dump('request->from - '.$request->get('from'));

        
        $saveFormData = json_encode($request->except(['from','_token']));
        dump($saveFormData);

        dump($request->header('referer'));

        if(!$request->get('from')){
            return redirect()->route('home');
        }
		
		//dump(URL::previous());
		//dump(route('bill-info'));
		//dump($request->method());
		//dd($request->get('country'));

		

		if(null != Session::get('errors') && null != Session::get('errors')->couponCreate->getMessages()){
            //$couponCreateValErrors = Session::get('errors')->couponCreate->getMessages();            
        }

        dump(Session::get('errors'));
        //dd(Session::get('errors')->billingInfo->getMessages());
		
        return view('student.cart.pay-with-credit-card');
        
	}


	public function checkout(CreditCardDetailsRequest $request){

        dump('checkout');
        dump($request->all());
		dump($request->header('referer'));
        dump($request->method());
        $request->merge(['from' => '']);

        try{
            $cardNumber = $request->get('card_number');
            $cvc        = $request->get('cvc');  

            //dump($request->all());
            //dump(env('DUMMY_CREDIT_CARD_NUMBERUC'));
            //dump(env('DUMMY_CVC'));  

            if($cardNumber == env('DUMMY_CREDIT_CARD_NUMBERUC') && $cvc == env('DUMMY_CVC')){
                
                dump($request->all());
                
                dump($request->all());



                //TODO-checkout
                //TODO-populate order info
                return view('student.cart.checkout-complete')->with([
                    'submit_status'     => true,
                ]);

            }else{
                return view('student.cart.payment-failed')->with([
                    'submit_status'     => true,
                ]);

                //throw new CustomException('the provided credit card information is invalid.');
            }

        }catch(CustomException $e){
            dump('CustomException');
            return view('student.cart.payment-failed')->with([
                'message'     => $e->getMessage(),
            ]);

        }catch(\Exception $e){
            dump('Exception');
            return view('student.cart.payment-failed')->with([
                //'message'   => $e->getMessage(),
                'message'   => 'there was an issue processing your payment',
            ]);
        }

        
        dd();   
 		if(null != Session::get('errors') && null != Session::get('errors')->creditCardPay->getMessages()){
            //$couponCreateValErrors = Session::get('errors')->couponCreate->getMessages();            
        }
        dump(Session::get('errors'));
        dd(Session::get('errors')->creditCardPay->getMessages());
		//return view('student.cart.pay-with-credit-card');
	}


    public function addToCart(Request $request){

        //dd('ss');
        $courseId = $request->input('courseId');
        $user     = Sentinel::getUser();

        try{
            if(!filter_var($courseId, FILTER_VALIDATE_INT)){
                throw new CustomException('Invalid id');
            }

            if($user == null){
                throw new CustomException('First login before enrolling');
            }

            if(Sentinel::getUser()->roles()->first()->slug != 'student'){
                throw new CustomException('Invalid user');
            }

            $course = Course::find($courseId);

            if($course != null){

            	if($course->price == 0){
            		throw new CustomException('This is free course cannot add to cart');
            	}   



                CourseSelection::create([
                    'cart_added_date'   => Carbon::now(),
                    'is_checkout'       => false,
                    'course_id'         => $courseId,
                    'student_id'        => $user->id,
                	'edumind_amount' 	=> $course->price * ((100-$course->author_share_percentage)/100),
					'author_amount' 	=> $course->price * ($course->author_share_percentage/100),

                    'used_coupon_code'          => null,
                    'discount_amount'           => 0,
					'revised_price'    	        => $course->price,
                    'edumind_lose_amount'       => 0,
                    'benificiary_earn_amount'   => 0
                ]); 
               
                return redirect()->back()->with([
                    'message'     => 'Successfully added course to your cart',
                    'cls'         => 'flash-success',
                    'msgTitle'    => 'Success !',
                ]);

            }else{
                throw new ModelNotFoundException;
            }
        }catch(CustomException $e){

            return redirect()->back()->with([
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);

        }catch(\Exception $e){

            return redirect()->back()->with([
                'message'     => $e->getMessage(),
                //'message'     => 'Course does not exist!',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }
    }
    
    public function removeCoupon(Request $request){
    	
    	try{

    		$user     		= Sentinel::getUser();
    		$couponCode     = $request->get('cc');
	    	$courseSelId 	= $request->get('courseSelectionId');

    		if(!$user){
    			throw new CustomException("Invalid user - you dont have permissions to do this task");    			
    		}

    		if (Str::length($couponCode) !== 6 || !preg_match('/^[A-Za-z0-9]+$/', $couponCode)) {
	    		// String does not have six characters or does not contain only letters and numbers
				throw new CustomException('Invalid coupon code');				
			}
    		
    		if(!filter_var($courseSelId, FILTER_VALIDATE_INT)){
                //throw new CustomException('Invalid id');
                throw new CustomException('Invalid coupon code');
            }
	    	
	    	$csRec = CourseSelection::where('student_id',$user->id)->where('id',$courseSelId)->first();

	    	if(!$csRec){
	    		throw new CustomException('Invalid coupon code');
	    	}

	    	$csRec->used_coupon_code 		= null;
			$csRec->discount_amount 		= 0;
			$csRec->revised_price 			= $csRec->course->price;
			$csRec->edumind_lose_amount 	= 0;
			$csRec->benificiary_earn_amount = 0;
			$csRec->save();

			return redirect()->route('view-cart')->with([
                'message'     => 'Successfully removed coupon from your cart',
                'cls'         => 'flash-success',
                'msgTitle'    => 'Success !',
            ]);;


    	}catch(CustomException $e){
			
			return redirect()->route('view-cart')->with([
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);

        }catch(\Exception $e){
			
			return redirect()->route('view-cart')->with([
                'message'     => 'Unable to remove coupon from your cart',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }
    }






    public function applyCoupon(Request $request){

    	//remove multiple applied cc
		//dump($cartItemsQuery->where('used_coupon_code','!=',null)->count());



    	
    	try{
			$user = Sentinel::getUser();
			$couponCode = $request->get('coupon_code');

			if(!$couponCode){
				throw new CustomException('Invalid coupon code');
			}

			if (Str::length($couponCode) !== 6 || !preg_match('/^[A-Za-z0-9]+$/', $couponCode)) {
	    		// String does not have six characters or does not contain only letters and numbers
				throw new CustomException('Invalid coupon code');
			}
					
			$ccRec = Coupon::find($couponCode);			
			if(!$ccRec){
				throw new CustomException('Invalid coupon code');
			}

			if(!$ccRec->is_enabled){
				//throw new CustomException('Invalid coupon code');
				throw new CustomException('This coupon code is no longer valid.');
			}

			if(!($ccRec->total_count > $ccRec->used_count)){
				//throw new CustomException('Invalid coupon code');
				throw new CustomException('Coupon code usage limit reached.');	
			}
			
			if($ccRec->discount_percentage <= 0){
				throw new CustomException('Invalid coupon code');	
			}

			$cartItemsQuery = 	CourseSelection::join('courses', 'course_selections.course_id', '=', 'courses.id')			
							        ->where('course_selections.is_checkout', 0)
							        ->where('course_selections.student_id', $user->id)						        
							        ->where('course_selections.cart_added_date', '!=', null)
							        
							        ->where('courses.price', '!=', 0)
							        ->orderBy('courses.price', 'DESC')
							        ->where('courses.status', 'published');
							        
			$cartItemsOrigQuery = 	clone $cartItemsQuery;			
			//dump($cartItemsQuery->toSql(), $cartItemsQuery->getBindings());
			
			/*	check submit coupon code already used in cart	*/			      			
			$ccUsedCountInCart 	= 	$cartItemsQuery->join('coupons', 'course_selections.used_coupon_code', '=', 'coupons.code')				
							    		->where('course_selections.used_coupon_code', $ccRec->code)
							    		->count();			

			if($ccUsedCountInCart >= 1){
				throw new CustomException('Coupon code already used in your cart');		
			}				    		
			
			/*=== remove all previous coupon codes and apply new coupon ===*/
			DB::transaction(function () use ($cartItemsOrigQuery, $ccRec){
			   	/* $cartItems = $cartItemsOrigQuery->get('course_selections.*');

                dd($cartItems);
			
			   	remove all previous coupon code or coupon codes(if apply multiple codes)
			   	$cartItems->map(function ($cartItem) {					
					$cartItem->used_coupon_code 	   = null;
					$cartItem->discount_amount 		   = 0;
					$cartItem->revised_price 		   = $cartItem->course->price;
					$cartItem->edumind_lose_amount 	   = 0;
					$cartItem->benificiary_earn_amount = 0;
					$cartItem->updated_at              = now();
                    $cartItem->save(['timestamps' => false]);
                    //$cartItem->save();
                    //return $user;
				});*/

			   	/* get coupon can apply cart items */
				$ccCanCrtItems = $cartItemsOrigQuery->where(function ($query) use ($ccRec){									    
		        	if($ccRec->course_id){
				    	$query->where('course_selections.course_id', $ccRec->course_id);
		        	}
				})->get('course_selections.*');
				
				if($ccCanCrtItems->isEmpty()){
					throw new CustomException('Coupon code not valid for courses in your cart.');		
				}
				
				/* apply coupon to the course that has 2nd highest price */
				$ccAppliedCrtItem = ($ccCanCrtItems->count() > 1) ? $ccCanCrtItems->get(1) : $ccCanCrtItems->first();
				
                $ccAppliedCourse     = $ccAppliedCrtItem->course;
				$discountAmount 	 = $ccRec->course->price * ($ccRec->discount_percentage/100);
				$commisionPercentage = $ccRec->beneficiary_commision_percentage_from_discount;

				$ccAppliedCrtItem->used_coupon_code 		= $ccRec->code;
				$ccAppliedCrtItem->discount_amount 		 	= $discountAmount;
				$ccAppliedCrtItem->revised_price 			= ($ccAppliedCourse->price - $discountAmount);
				$ccAppliedCrtItem->edumind_lose_amount 	 	= ($discountAmount/100) * (100 + $commisionPercentage);
				$ccAppliedCrtItem->benificiary_earn_amount 	= $discountAmount * ($commisionPercentage/100);
				$ccAppliedCrtItem->save();
			});

            return redirect()->route('view-cart')->with([
                'message'     => 'Successfully applied coupon code',
                'cls'         => 'flash-success',
                'msgTitle'    => 'Success !',
            ]);		


		}catch(CustomException $e){

            return redirect()->route('view-cart')->with([
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);

        }catch(\Exception $e){

            return redirect()->route('view-cart')->with([
                //'message'     => $e->getMessage(),
                'message'     => 'Coupon code was failed to apply',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);
        }

	}



}









/*

select * from `course_selections`
inner join `courses` on `course_selections`.`course_id` = `courses`.`id`
inner join `coupons` on `course_selections`.`used_coupon_code` = `coupons`.`code`
where
`course_selections`.`is_checkout` = ?
and `course_selections`.`student_id` = ?
and `course_selections`.`cart_added_date` is not null
and `courses`.`price` != ?
and `courses`.`status` = ?
and `course_selections`.`course_id` = `coupons`.`course_id`

order by `course_selections`.`updated_at` desc



select * from `course_selections` inner join `courses` on `course_selections`.`course_id` = `courses`.`id` inner join `coupons` on `course_selections`.`used_coupon_code` = `coupons`.`code` where `course_selections`.`is_checkout` = ? and `course_selections`.`student_id` = ? and `course_selections`.`cart_added_date` is not null and `courses`.`price` != ?
and `courses`.`status` = ?
or `course_selections`.`course_id` = `coupons`.`course_id`
order by `course_selections`.`updated_at` desc








select * from `course_selections`

inner join `courses` on `course_selections`.`course_id` = `courses`.`id`
inner join `coupons` on `course_selections`.`used_coupon_code` = `coupons`.`code`
where
`course_selections`.`is_checkout` = ?
and `course_selections`.`student_id` = ?
and `course_selections`.`cart_added_date` is not null
and `courses`.`price` != ?
and `courses`.`status` = ?
and `coupons`.`is_enabled` = ?
and `coupons`.`total_count` > `coupons`.`used_count`
and `course_selections`.`course_id` = `coupons`.`course_id`
order by `course_selections`.`updated_at` desc

*/



