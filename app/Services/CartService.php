<?php

namespace App\Services;

use App\Repositories\CourseSelectionRepository;
use App\Repositories\CouponRepository;

use App\Exceptions\CustomException;
use App\Models\User as UserModel;
use App\Models\CourseSelection as CourseSelectionModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\TempBillingInfo as TempBillingInfoModel;
use App\DataTransformers\Database\CouponCodeDataTransformer;

//use App\Repositories\CourseRepository;
//use App\Repositories\CourseItemRepository;


class CartService
{

	private CourseSelectionRepository $courseSelectionRepository;

    function __construct(CourseSelectionRepository $courseSelectionRepository){
        $this->courseSelectionRepository = $courseSelectionRepository;
    }


	/**
	 * === Step 1: Check for courses that were once paid but have now been made free of charge.
	 * then They have been automatically removed from your cart.
	 */
	public function removeFreeCourseFromCart(UserModel $userRec){
        $cartFreeCourses 	=	$this->courseSelectionRepository->getFreeCoursesFromCart($userRec);

        $msgArr = [];
        if($cartFreeCourses->isNotEmpty()){
            $msgArr['errTitle'] = 'The price of some course(s) in your cart has changed to free. They have been automatically removed from your cart.';
            $msgArr['errArr']   =  $cartFreeCourses->map(function (CourseSelectionModel $cartItem) use ($userRec){

               	$freeCourse = $cartItem->course;

                /* delete free cuses from cart */
                $isRemove = $this->courseSelectionRepository->deleteById($cartItem->id);

                // message for the user to tell about deleted courses
                if($isRemove)
                	return '<a href="'.route('courses.show',$freeCourse->slug).'">'.$freeCourse->name.'</a>';
            });
        }
        return array('rlsCourses' => $msgArr);
    }



	/**
	 * === Step 2: Check for coupon codes that have become invalid after being applied,
	 * such as when the available count is exceed or they are disabled. then remove
	 * these invalid codes from the cart.
	 */
	public function removeInavildCouponsFromCart(UserModel $userRec){
        $cartInvalidCc 	=	$this->courseSelectionRepository->getInavildCouponUsedCoursesFromCart($userRec);

       	$msgArr = [];
        if($cartInvalidCc->isNotEmpty()){
            $msgArr['errTitle'] = 'Invalid coupon code(s) detected. They have been automatically removed from your cart.';
            $msgArr['errArr']   =  $cartInvalidCc->map(function (CourseSelectionModel $cartItem) use ($userRec){

                $usedCc = $cartItem->used_coupon_code;

                $couponDataArr  = (new CouponRepository())->findDataArrByCode($usedCc);
                $couponEntity   = CouponCodeDataTransformer::buildEntity($couponDataArr);
                $ccCourseId     = optional($couponEntity->getCourse())->getId();

                $ccMsg  = '';
                $ccMsg .= !is_null($ccCourseId) ? (($cartItem->course_id != $ccCourseId) ? ', not valid for the course(s) in your cart' : '') : '';
                $ccMsg .= ($couponEntity->getAvailableCount() <= 0) ? ', no longer available' : '';
                $ccMsg .= ($couponEntity->isEnable()) ? '' : ', disabled';

                // format error messages
                $ccMsg = Str::replaceFirst(', ', '', $ccMsg);
                $ccMsg = Str::ucfirst($ccMsg);
                $ccMsg = $usedCc.' - '.$ccMsg;

                /* remove invalid coupons from courseSelection records */
                $isReset = $this->courseSelectionRepository->update($cartItem->id, [
					'used_coupon_code'        => null,
                	'discount_amount'         => 0,
                	'revised_price'           => $cartItem->course->price,
                	'edumind_lose_amount'     => 0,
                	'beneficiary_earn_amount' => 0,
                	//'updated_at'              => now(),
				], false);

				// message for the user to tell about removed invalid coupons
				if($isReset)
					return $ccMsg;
            });
        }
        return array('invoiceCc' => $msgArr);
    }



	/**
	 * === Step 3: Check if there are coupon records with non-existent foreign key relationships
	 * with the coupons table. If such records exist, remove the corresponding non-existent
	 * coupon code(s) from the cart.
	 */
	public function removeNonExistCouponsFromCart(UserModel $userRec){
        $csWithoutCC 	=	$this->courseSelectionRepository->getNonExistCouponUsedCoursesFromCart($userRec);

		$msgArr = array();
        if($csWithoutCC->isNotEmpty()){
            $msgArr['errTitle'] = 'Nonexistence coupon code(s) have been automatically removed from your cart';
            $msgArr['errArr']   =  $cartInvalidCc->map(function (CourseSelectionModel $cartItem) use ($user){

                $msg   = $cartItem->used_coupon_code;

                /* remove nonexistence coupons from user cart */
                $isReset = $this->courseSelectionRepository->update($cartItem->id, [
					'used_coupon_code'        => null,
                	'discount_amount'         => 0,
                	'revised_price'           => $cartItem->course->price,
                	'edumind_lose_amount'     => 0,
                	'beneficiary_earn_amount' => 0,
                	//'updated_at'              => now(),
				], false);

                // message for the user to tell about removed non exist coupons
                if($isReset)
                	return $msg;
            });
        }
        return array('csWithoutCC' => $msgArr);
    }


	/**
	 * === Step 4: Check if multiple valid coupon codes have been applied in the user's cart.
	 * If multiple valid coupon codes have been applied, keep the latest applied coupon code,
	 * and remove the other coupon codes from the cart.
	 */
	public function removeUsedMultipleCouponsFromCart(UserModel $userRec){
        $cartValidCc = $this->courseSelectionRepository->getValidCouponUsedCoursesFromCart($userRec);

		$msgArr = array();
        if($cartValidCc->count() > 1){
            $msgArr['errTitle'] = 'Only one coupon code can be applied at a time. The latest applied coupon has been kept, and following coupon codes were removed from your cart';
            $msgArr['errArr']   =  $cartValidCc->skip(1)->map(function (CourseSelectionModel $cartItem, $key){

                $valCcMsg   = $cartItem->used_coupon_code;

                /* remove invalid coupons from courseSelection records */
                $isReset = $this->courseSelectionRepository->update($cartItem->id, [
					'used_coupon_code'        => null,
                	'discount_amount'         => 0,
                	'revised_price'           => $cartItem->course->price,
                	'edumind_lose_amount'     => 0,
                	'beneficiary_earn_amount' => 0,
                	'updated_at'              => now(),
                	'timestamps' 			=> false
				], false);

				// message for the user to tell about removed valid coupons
                if($isReset)
                	return $valCcMsg;
            });
        }
        return array('cartValidCc' => $msgArr);
    }



    public function loadBillingInfoData(Request $request){
        $encryptedCookieVal = $request->cookie('USER_B_INFO');
        $cookieVal  = ($encryptedCookieVal) ? Crypt::decryptString($encryptedCookieVal) : '';
        $cookieData = json_decode($cookieVal, true, 512);

        $cookieData = ($cookieData === null) ? [] : $cookieData;

        $keys = ['fname','lname','email','phone','country','city','street_address'];

        $allKeysExist = true;
        foreach ($keys as $key) {
            if (!array_key_exists($key, $cookieData)) {
                $allKeysExist = false;
                break;
            }
        }

        // if one field is not there then create array with all keys with empty string value
        if(!$allKeysExist)
            $cookieData = array_fill_keys($keys, '');

        return $cookieData;
    }


    public function loadCheckoutData(Request $request, UserModel $user){
        $orderId    = $request->get('order');
        $random     = base64_decode($request->get('code'));
        $key        = $request->get('key');

        if(!filter_var($orderId, FILTER_VALIDATE_INT) || $orderId <= 0)
            throw new CustomException('Invalid order');

        if(!$random || !$key)
            abort(403);

        //for validate url
        $encryptedStr = 'edumind_order_'.md5($orderId).$random;
        if($key != $encryptedStr)
            abort(403);


        //check in temp_billing_info table provided temporary record(order) exists
        $rec = TempBillingInfoModel::find($orderId);
        if(!$rec || ($rec->is_checkout == true))
            abort(403);


        //check user of the temporary record(order)
        if($user->id != $rec->user_id)
            abort(403);

        return array(
            'orderId' => base64_encode($orderId),
            'random'  => base64_encode($random)
        );
    }


    public function getCartItemCountByStudent(UserModel $user) : int {
        return $this->courseSelectionRepository->cartItemCountByStudent($user);
    }



    public function saveBillingInfoData(string $saveFormData, UserModel $user){
        $dbRec  =   TempBillingInfoModel::Create([
            'user_id'       => $user->id,
            'billing_info'  => $saveFormData,
            'is_checkout'   => false
        ]);
        return $dbRec;
    }


}



//service only methods - not in entity

//methods - also in entity
	//addToCart()
	//removeFromCart()
	//checkout()
	//applyCoupon()
