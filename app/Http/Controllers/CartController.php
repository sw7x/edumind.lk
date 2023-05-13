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


class CartController extends Controller
{
	public function viewCart()
    {
        return view('student.cart.cart-page');
        

        /*
        $user = Sentinel::getUser();

        $addedCourses =  Course::join('course_selections', function($join) use ($user){
                        $join->on('courses.id','=','course_selections.course_id')
                            ->where('course_selections.is_checkout', '=', 0)
                            ->where('course_selections.student_id', '=', $user->id)
                            ->where('courses.status', '=', "published");
                    })
                    
                    ->get([
                        'course_selections.is_checkout',
                        //'enrollments.is_complete',
                        'courses.*'
                    ]);

        $totPrice = 0;
        foreach ($addedCourses as $key => $course) {
             $totPrice +=  $course->price;
        }        



        //dd($addedCourses);            
        return view('student.cart')->with([
            'addedCourses'  => $addedCourses,
            'totalPrice'    => $totPrice
        ]);
        */
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


	public function checkout1(){
		return view('student.cart.bill-info');
	}


	public function checkout2(BillingInfoRequest $request){

		dump($request->header('referer'));
		dump(URL::previous());
		dump(route('bill-info'));
		dump($request->method());
		dd($request->get('country'));

		

		if(null != Session::get('errors') && null != Session::get('errors')->couponCreate->getMessages()){
            //$couponCreateValErrors = Session::get('errors')->couponCreate->getMessages();            
        }

        dump(Session::get('errors'));
        dd(Session::get('errors')->billingInfo->getMessages());


		return view('student.cart.pay-with-credit-card');
	}


	public function checkout3(CreditCardDetailsRequest $request){

		//dd($request->header('referer'));

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
					'revised_price'    	=> $course->price 	        	
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
			   	$cartItems = $cartItemsOrigQuery->get('course_selections.*');
			
			   	/* remove all previous coupon code or coupon codes(if apply multiple codes) */
			   	$cartItems->map(function ($cartItem) {					
					$cartItem->used_coupon_code 	= null;
					$cartItem->discount_amount 		= 0;
					$cartItem->revised_price 		= $cartItem->course->price;
					$cartItem->edumind_lose_amount 	= 0;
					$cartItem->benificiary_earn_amount = 0;
					$cartItem->save();		
					//return $user;
				});
			
			   	/* get coupon can apply cart items */
				$ccCanCrtItems = $cartItemsOrigQuery->where(function ($query) use ($ccRec){									    
		        	if($ccRec->course_id){
				    	$query->where('course_selections.course_id', $ccRec->course_id);
		        	}
				})->get('course_selections.*');
				
				if(!$ccCanCrtItems){
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
	
			//dd('END');
			//dd();

			return redirect()->route('view-cart')->with([
                'message'     => 'Successfully applied coupon code',
                'cls'         => 'flash-success',
                'msgTitle'    => 'Success !',
            ]);		


		}catch(CustomException $e){
			dump('CustomException');
			dd($e->getMessage());
            return redirect()->route('view-cart')->with([
                'message'     => $e->getMessage(),
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Error !',
            ]);

        }catch(\Exception $e){
        	dump('\Exception');
			dd($e->getMessage());
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
	where `course_selections`.`is_checkout` = 0 
	and `course_selections`.`student_id` = 5 
	and `course_selections`.`cart_added_date` is not null 
	and `courses`.`price` != 0 
	and `courses`.`status` = 'published' 
	and `course_selections`.`used_coupon_code` = "I6TBZ9" 
	and (`course_selections`.`course_id` = 3) 
	order by `courses`.`price` desc


	


select * from `course_selections` 
inner join `courses` on `course_selections`.`course_id` = `courses`.`id` 
where `course_selections`.`is_checkout` = ? 
and `course_selections`.`student_id` = ? 
and `course_selections`.`cart_added_date` is not null 
and `courses`.`price` != ? and `courses`.`status` = ? 
and (`course_selections`.`course_id` = ?) 

order by `courses`.`price` desc ◀"

	*/				
