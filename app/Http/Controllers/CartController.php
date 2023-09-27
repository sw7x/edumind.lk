<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;

use App\Exceptions\CustomException;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Models\Role as RoleModel;
use App\Models\Invoice as InvoiceModel;
use App\Models\Enrollment as EnrollmentModel;
use App\Models\Coupon as CouponModel;
use App\Models\TempBillingInfo as TempBillingInfoModel;
use App\Models\Course as CourseModel;
use App\Models\CourseSelection as CourseSelectionModel;



use App\Http\Requests\BillingInfoRequest;
use App\Http\Requests\CreditCardDetailsRequest;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

use Cookie;

//use App\Models\User as UserModel;
//use Illuminate\Support\Facades\URL;
//use Illuminate\Validation\ValidationException;
//use Illuminate\Http\Response;


class CartController extends Controller
{
	public function viewCart()
    {

        try {
            $msgArr = [];
            $user = Sentinel::getUser();

            //before load cart page view, resetting and remove invalid cart items in user's cart
            if($user && ($user->roles()->first()->slug == RoleModel::STUDENT)){


                /*=== 1. Courses that were once paid but have now been made free of charge ===*/
                $cartFreeCourses    =   CourseModel::join('course_selections', 'courses.id', '=', 'course_selections.course_id')
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
                        CourseSelectionModel::where('course_selections.student_id', $user->id)
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
                $cartInvalidCc  =   CourseSelectionModel::join('courses', 'course_selections.course_id', '=', 'courses.id')
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
                        $coupon = CouponModel::withoutGlobalScope('enabled')->find($cartItem->used_coupon_code);

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
                        $cartItem->beneficiary_earn_amount = 0;
                        $cartItem->updated_at              = now();
                        $cartItem->save(['timestamps' => false]);


                        return $ccMsg;
                    });
                }
                //dump('2.cartInvalidCc');
                //dump($cartInvalidCc);
                /*=== 2 END ======================================================================= ===*/






                /*=== 3. If the foreign key relationship fails due to the nonexistence of the Coupon record ===*/
                $csWithoutCC    =   CourseSelectionModel::whereNotExists(function ($query) {
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
                        $cartItem->beneficiary_earn_amount = 0;
                        $cartItem->updated_at              = now();
                        $cartItem->save(['timestamps' => false]);


                        return $msg;
                    });
                }
                //dump('3.csWithoutCC');
                //dump($csWithoutCC);
                /*=== 3 END ============================================================================== ===*/










                /*=== 4. check multiple (valid) coupon codes have used in user cart ===========================*/
                $cartValidCc    =   CourseSelectionModel::join('courses', 'course_selections.course_id', '=', 'courses.id')
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
                        $cartItem->beneficiary_earn_amount = 0;
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

        $isDelete = CourseSelectionModel::Where('course_id',$id)
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

	        if($user && ($user->roles()->first()->slug == RoleModel::STUDENT)){

	        	DB::transaction(function () use ($user, &$courseInfoArr, &$invoiceRec) {
				    $courseSelections = CourseSelectionModel::join('courses', 'course_selections.course_id', '=', 'courses.id')
				        ->where('course_selections.is_checkout', 0)
				        ->where('course_selections.student_id', $user->id)
				        ->where('courses.price', '!=', 0)
				        ->get('course_selections.*');

				    $now 		= Carbon::now();
				    /**/
				    $invoice   	= InvoiceModel::create([
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

				        EnrollmentModel::create([
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
        
        // todo ----------------add custom exception

        try {

            //dump('loadBillingInfoPage');
            $encryptedCookieVal = $request->cookie('USER_B_INFO');
            //dump($encryptedCookieVal);

            $cookieVal = ($encryptedCookieVal)?Crypt::decryptString($encryptedCookieVal):'';
            $arr = json_decode($cookieVal, true, 512, JSON_THROW_ON_ERROR);
            //dump($arr);

            $keys = ['fname','lname','email','phone','country','city','street_address'];

            $allKeysExist = true;
            foreach ($keys as $key) {
                if (!array_key_exists($key, $arr)) {
                    $allKeysExist = false;
                    break;
                }
            }

            // if one field is not there then skip form filling from cookie
            if(!$allKeysExist){
                throw new \Exception("cookie is not set");
            }

            return view('student.cart.bill-info')->with([
                'fname'         => $arr['fname'],
                'lname'         => $arr['lname'],
                'email'         => $arr['email'],
                'phone'         => $arr['phone'],
                'country'       => $arr['country'],
                'city'          => $arr['city'],
                'street_address'=> $arr['street_address']
            ]);

        } catch (\Exception $e) {
            return view('student.cart.bill-info')->with([
                'fname'         => '',
                'lname'         => '',
                'email'         => '',
                'phone'         => '',
                'country'       => '',
                'city'          => '',
                'street_address'=> ''
            ]);
        }
    }

    public function submitBillingInfo(BillingInfoRequest $request){

        try{
            //dump('submitBillingInfo');
            //dump($request->validated());
            //dump('request->from - '.$request->get('from'));
            //dump($request->header('referer'));

            $saveFormData = json_encode($request->except(['from','_token']));
            $user = Sentinel::getUser();


            // if user cart has no courses then
            $courseInCart   =   CourseSelectionModel::join('courses', 'course_selections.course_id', '=','courses.id')
                                    ->where('course_selections.student_id', $user->id)
                                    ->where('course_selections.is_checkout', 0)
                                    ->where('course_selections.cart_added_date', '!=', null)
                                    ->where('courses.price', '!=', 0)
                                    ->count();

            if($courseInCart <= 0){
                return  redirect()->route('view-cart')->with([
                    'message'     => 'Your cart is empty therefore cannot submit billing info !',
                    'cls'         => 'flash-danger',
                    'msgTitle'    => 'Error !'
                ]);
            }






            DB::beginTransaction ();

            $TempBillingInfo = TempBillingInfoModel::Create([
                'user_id'       => $user->id,
                'billing_info'  => $saveFormData,
                'is_checkout'   => false
            ]);
            //dd($TempBillingInfo);

            if(null != Session::get('errors') && null != Session::get('errors')->billingInfo->getMessages()){
                $billingInfoValErrors = Session::get('errors')->billingInfo->getMessages();
            }

            /* if have validation errors */
            if (isset($request->validator) && $request->validator->fails()) {
                $validationErrMsg = 'Form validation is failed';
                throw new CustomException($validationErrMsg);
            }

            DB::commit();

            $randomId = substr(md5(mt_rand()), 0, 5);

            return redirect()->to(route('load-checkout', [
                'order' => $TempBillingInfo->id,
                'key'   => 'edumind_order_'.md5($TempBillingInfo->id).$randomId,
                'code'  =>  base64_encode($randomId)
            ]))->withCookie('USER_B_INFO', Crypt::encryptString($saveFormData));

        }catch(CustomException $e){
            //dd('CustomException');
            DB::rollBack();
            return  redirect()->back()
                        ->withErrors($billingInfoValErrors ?? [],'billingInfoErrMsgArr')
                        ->withInput($request->input())
                        ->with([
                            'message'     => $e->getMessage(),
                            'cls'         => 'flash-danger',
                            'msgTitle'    => 'Error !',
                        ]);

        }catch(\Exception $e){
            //dd($e->getMessage());
            DB::rollBack();
            return  redirect()->back()
                        ->withErrors($billingInfoValErrors ?? [],'billingInfoErrMsgArr')
                        ->withInput($request->input())
                        ->with([
                            //'message'     => $e->getMessage(),
                            'message'     => 'Form submission failed !',
                            'cls'         => 'flash-danger',
                            'msgTitle'    => 'Error !',
                        ]);
        }

	}


    public function loadCheckout(Request $request){
        try {

            //dump('loadCheckout');
            $orderId    = $request->get('order');
            $random     = base64_decode($request->get('code'));
            $key        = $request->get('key');


            if(!filter_var($orderId, FILTER_VALIDATE_INT) || $orderId <= 0){
                throw new CustomException('Invalid order');
            }
            if(!$random) abort(403);
            if(!$key) abort(403);

            $encryptedStr = 'edumind_order_'.md5($orderId).$random;

            //for validate url
            if($key != $encryptedStr) abort(403);



            //check in temp_billing_info table provided temporary record(order) exists
            $rec = TempBillingInfoModel::find($orderId);
            if(!$rec || ($rec->is_checkout == true)) abort(403);
            //dump($rec->is_checkout);



            //check user of the temporary record(order)
            $user = Sentinel::getUser();
            if($user->id != $rec->user_id) abort(403);





            return view('student.cart.pay-with-credit-card')->with([
                'orderId' => base64_encode($orderId),
                'random'  => base64_encode($random)
            ]);

        } catch (\Exception $e) {
            //dd($e->getMessage());
            abort(403);
        }
    }

	public function checkout(CreditCardDetailsRequest $request){

        //dump('checkout');
        //dump($request->cookie('nameppp'));

        //dump($request->all());
		//dump($request->header('referer'));
        //dump($request->method());
        //$request->merge(['from' => '']);

        try{
            $user = Sentinel::getUser();

            $cardNumber = $request->get('card_number');
            $cvc        = $request->get('cvc');

            $orderId    = base64_decode($request->get('ord'));
            $randomId   = base64_decode($request->get('rnd'));

            if(isset($orderId) && isset($randomId)){
                $returnUrl = route('load-checkout', [
                    'order' => $orderId,
                    'key'   => 'edumind_order_'.md5($orderId).$randomId,
                    'code'  =>  base64_encode($randomId)
                ]);
            }else{
                $returnUrl = '';
            }


            /* if have validation errors */
            if (isset($request->validator) && $request->validator->fails()) {
                $validationErrMsg = 'Invalid credit card information';
                throw new CustomException($validationErrMsg);
            }


            //throw new \Exception('cc the provided credit card information is invalid.');
            if($cardNumber != env('DUMMY_CREDIT_CARD_NUMBERUC') || $cvc != env('DUMMY_CVC')){
                throw new CustomException("Payment Failed: unable to process your payment.");
            }


            // if user cart has no courses then
            $courseInCart   =   CourseSelectionModel::join('courses', 'course_selections.course_id', '=','courses.id')
                                    ->where('course_selections.student_id', $user->id)
                                    ->where('course_selections.is_checkout', 0)
                                    ->where('course_selections.cart_added_date', '!=', null)
                                    ->where('courses.price', '!=', 0)
                                    ->get('course_selections.*');
                                    //->count();

            if($courseInCart->count() <= 0)
                throw new CustomException('Your cart is empty therefore cannot checkout');



            $billingInfoArr;
            $InvoiceId;
            $courseArr = array();


            //database changes when user checkout
            DB::transaction(function () use ($orderId, $courseInCart, &$billingInfoArr, &$InvoiceId, &$courseArr){

                //check in temp_billing_info table provided temporary record(order) exists
                $tempRec = TempBillingInfoModel::find($orderId);
                if(!$tempRec) throw new CustomException("Invalid order");
                if($tempRec->is_checkout) throw new CustomException("This order is already expired");

                $tempRec->is_checkout = true;
                $tempRec->save();

                //create invoice
                $invoice = InvoiceModel::create([
                    'checkout_date' => now(),
                    'billing_info'  => $tempRec->billing_info,
                    'paid_amount'   => 0
                ]);
                $InvoiceId = $invoice->id;
                $totalPaidAmount    = 0;

                foreach ($courseInCart as $courseRecord) {

                    //collect purchased informations of the purchased courses
                    $course = CourseModel::find($courseRecord->course_id);
                    $courseArr[] = array(
                        'courseName' => $course->name,
                        'courseUrl'  => route('course-single',$course->slug)
                    );

                    //if coupon code is used then increase coupon used count by one
                    $usedCC = $courseRecord->used_coupon_code;
                    if($usedCC){
                        $ccRecord = CouponModel::find($usedCC);
                        if($ccRecord->is_enabled == true){
                            $ccRecord->used_count++;
                            $ccRecord->save();
                        }
                    }

                    $courseRecord->is_checkout = true;
                    $courseRecord->save();

                    // create enrollments for each course
                    EnrollmentModel::create([
                        'course_selection_id'   => $courseRecord->id,
                        'invoice_id'            => $InvoiceId
                    ]);

                    $totalPaidAmount += $courseRecord->revised_price;
                }

                $invoice->paid_amount = $totalPaidAmount;
                $invoice->save();

                $orderInfoarr = json_decode($tempRec->billing_info, true, 512, JSON_THROW_ON_ERROR);

                $billingInfoArr = array(
                    'fullname'      => $orderInfoarr['fname'].' '.$orderInfoarr['lname'],
                    'email'         => $orderInfoarr['email'],
                    'phone'         => $orderInfoarr['phone'],
                    'country'       => $orderInfoarr['country'],
                    'city'          => $orderInfoarr['city'],
                    'street_address'=> $orderInfoarr['street_address'],
                );

            });


            return view('student.cart.checkout-complete')->with([
                'submit_status' => true,
                'billingInfoArr'=> $billingInfoArr,
                'InvoiceId'     => $InvoiceId,
                'courseArr'     => $courseArr
            ]);

        }catch(CustomException $e){
            dd($e->getMessage());
            return view('student.cart.payment-failed')->with([
                'message'   => $e->getMessage(),
                'cls'       => 'flash-danger',
                'msgTitle'  => 'Error !',
                'returnUrl' => $returnUrl
            ]);

        }catch(\Exception $e){
            dd($e->getMessage());
            return view('student.cart.payment-failed')->with([
                //'message'   => $e->getMessage(),
                'message'   => 'there was an issue processing your payment',
                'cls'       => 'flash-danger',
                'msgTitle'  => 'Error !',
                'returnUrl' => $returnUrl
            ]);
        }
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

            if(Sentinel::getUser()->roles()->first()->slug != RoleModel::STUDENT){
                throw new CustomException('Invalid user');
            }

            $course = CourseModel::find($courseId);

            if($course != null){

            	if($course->price == 0){
            		throw new CustomException('This is free course cannot add to cart');
            	}

                CourseSelectionModel::create([
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
                    'beneficiary_earn_amount'   => 0
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

	    	$csRec = CourseSelectionModel::where('student_id',$user->id)->where('id',$courseSelId)->first();

	    	if(!$csRec){
	    		throw new CustomException('Invalid coupon code');
	    	}

	    	$csRec->used_coupon_code 		= null;
			$csRec->discount_amount 		= 0;
			$csRec->revised_price 			= $csRec->course->price;
			$csRec->edumind_lose_amount 	= 0;
			$csRec->beneficiary_earn_amount = 0;
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

			$ccRec = CouponModel::find($couponCode);
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

			$cartItemsQuery = 	CourseSelectionModel::join('courses', 'course_selections.course_id', '=', 'courses.id')
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
					$cartItem->beneficiary_earn_amount = 0;
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
				$ccAppliedCrtItem->beneficiary_earn_amount 	= $discountAmount * ($commisionPercentage/100);
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




