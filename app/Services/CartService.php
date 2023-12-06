<?php

namespace App\Services;

use App\Repositories\CourseSelectionRepository;
use App\Repositories\CouponRepository;
use App\Repositories\EnrollmentRepository;
use App\Repositories\InvoiceRepository;

use App\Exceptions\CustomException;
use App\Models\User as UserModel;
use App\Models\Course as CourseModel;
use App\Models\CourseSelection as CourseSelectionModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\TempBillingInfo as TempBillingInfoModel;
use App\DataTransformers\Database\CouponCodeDataTransformer;
use App\DataTransformers\Database\UserDataTransformer;

use App\Domain\CourseItem as CourseItemEntity;
use App\DataTransferObjects\Factories\CourseItemDtoFactory;
use App\DataTransformers\Database\CourseItemDataTransformer;
use App\DataTransformers\Database\CourseDataTransformer;
use App\Domain\ValueObjects\DateTimeVO;
use App\Mappers\CourseItemMapper;
use App\Mappers\CouponMapper;
use Illuminate\Support\Facades\DB;

use App\Mappers\InvoiceMapper;
use App\DataTransferObjects\Factories\InvoiceDtoFactory;
use App\DataTransferObjects\Factories\CourseDtoFactory;

/*
use App\Repositories\CourseRepository;
use App\Repositories\CourseItemRepository;
use App\DataTransferObjects\UserDto;
use App\DataTransferObjects\CourseItemDto;
*/

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
                if(!$isRemove)
                    abort(500, "Failed to delete free courses from your cart due to server error !");

                // message for the user to tell about deleted courses
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

				if(!$isReset)
                    abort(500, "Failed to remove invalid coupons from your cart due to server error !");

                // message for the user to tell about removed invalid coupons
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

                if(!$isReset)
                    abort(500, "Failed to remove non exist coupons from your cart due to server error !");

                // message for the user to tell about removed non exist coupons
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

                if(!$isReset)
                    abort(500, "Failed to remove applied multiple coupons from your cart due to server error !");

                // message for the user to tell about removed valid coupons
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


    public function saveCartItem(CourseModel $course, UserModel $studentRec) : CourseSelectionModel {
        $courseEntity       = CourseDataTransformer::buildEntity($course->toArray());
        $courseItemEntity   = new CourseItemEntity ($courseEntity, DateTimeVO::now(), false);
        $courseItemDto      = CourseItemDtoFactory::fromArray($courseItemEntity->toArray());

        $payloadArr = CourseItemDataTransformer::dtoToDbRecArr($courseItemDto);
        unset($payloadArr['id']);
        unset($payloadArr['uuid']);
        $payloadArr['student_id'] = $studentRec->id;

        return $this->courseSelectionRepository->create($payloadArr);
    }


    public function deleteCartItem(int $courseId, UserModel $studentRec) : bool {
        $courseSelRec = $this->courseSelectionRepository->getStudentCartItemByCourseId($courseId, $studentRec->id);
        if(is_null($courseSelRec))
            throw new CustomException("We couldn't locate the item in your cart. Please check again.");

        return $this->courseSelectionRepository->deleteById($courseSelRec->id);
    }


    public function applyCouponToCart(string $couponCode, UserModel $studentRec) : void {
        // String does not have six characters or does not contain only letters and numbers
        if (Str::length($couponCode) !== 6 || !preg_match('/^[A-Za-z0-9]+$/', $couponCode))
            throw new CustomException('Invalid coupon code');

        $ccRec = (new CouponRepository())->findByCodeWithGlobalScope($couponCode);
        if(!$ccRec)
            abort(404,'Coupon code does not exists');

        if(!$ccRec->is_enabled)
            throw new CustomException('This coupon code is no longer valid.');

        if(!($ccRec->total_count > $ccRec->used_count))
            throw new CustomException('Coupon code usage limit reached.');

        if($ccRec->discount_percentage <= 0)
            throw new CustomException('Invalid coupon code');

        $ccEntity       = CouponCodeDataTransformer::buildEntity($ccRec->toArray());
        $studentEntity  = UserDataTransformer::buildEntity($studentRec->toArray());
        $cartEntity     = $studentEntity->getCart();


        $cartEntity->canCouponUse($ccEntity);

        /* remove all previous coupon code or coupon codes(if apply multiple codes) */
        $cartEntity->removeAllCoupons();

        /* apply coupon to the course that has 2nd highest price */
        $cartEntity->applyCouponCode($ccEntity);


        DB::transaction(function () use ($cartEntity){
            $cartEntityArr = collect($cartEntity->toArray());
            $cartEntityArr->map(function ($cartItemArr){
                $arr = CourseItemMapper::entityConvertToDbArr($cartItemArr);
                unset($arr['cart_added_date']);
                $payload = $arr;

                // for stop change timestamp of updated_at table column when removing the coupon from the cart item
                $updateTimestamps = true;
                if(is_null($payload['used_coupon_code'])){
                    $updateTimestamps = false;
                }

                $isUpdated = $this->courseSelectionRepository->update($payload['id'], $payload, $updateTimestamps);
                if(!$isUpdated)
                    abort(500, "Course add to cart failed due to server error !");
            });

        });

    }


    public function RemoveCouponFromCart(string $couponCode, UserModel $studentRec, int $courseSelId) : void {
        // String does not have six characters or does not contain only letters and numbers
        if (Str::length($couponCode) !== 6 || !preg_match('/^[A-Za-z0-9]+$/', $couponCode))
            throw new CustomException('Invalid coupon code');

        if(!filter_var($courseSelId, FILTER_VALIDATE_INT))
            throw new CustomException('Invalid coupon code');

        $ccRec = (new CouponRepository())->findByCodeWithGlobalScope($couponCode);
        if(!$ccRec)
            abort(404,'Coupon code does not exists');

        $ccEntity       = CouponCodeDataTransformer::buildEntity($ccRec->toArray());
        $studentEntity  = UserDataTransformer::buildEntity($studentRec->toArray());
        $cartEntity     = $studentEntity->getCart();

        $courseSelRec   = $this->courseSelectionRepository->findById($courseSelId);
        if(is_null($courseSelRec) || $courseSelRec->student_id != $studentRec->id)
            abort(500,'Invalid cart Item');

        if(!$cartEntity->isCouponUsed($ccEntity))
            throw new CustomException("The coupon code you're attempting to remove wasn't applied to your cart.");

        $cartEntity->removeCouponCode($ccEntity);


        $cartEntityArr = collect($cartEntity->toArray());
        $cartEntityArr->map(function ($cartItemArr) use ($courseSelId){
            $arr = CourseItemMapper::entityConvertToDbArr($cartItemArr);
            if($arr['id'] == $courseSelId){
                unset($arr['cart_added_date']);
                $payload = $arr;

                $isUpdated = $this->courseSelectionRepository->update($courseSelId, $payload);
                if(!$isUpdated)
                    abort(500, "Coupon remove from cart failed due to server error !");
            }
        });

    }

    public function submitCheckout(UserModel $studentRec, int $orderId) : array {
        $courseInCart = $this->courseSelectionRepository->cartItemsByStudentId($studentRec->id);
        if(count($courseInCart) <= 0)
            throw new CustomException('Your cart is empty therefore cannot checkout');

        $billingInfoArr;
        $invoiceEntity;
        $courseArr = array();

        //database changes when user checkout
        DB::transaction(function () use ($studentRec, $orderId, $courseInCart, &$billingInfoArr, &$invoiceEntity, &$courseArr){

            //check in temp_billing_info table provided temporary record(order) exists
            $tempRec = TempBillingInfoModel::find($orderId);
            if(!$tempRec) throw new CustomException("e-Invalid order");
            if($tempRec->is_checkout) throw new CustomException("This order is already expired");

            //update temp_billing_info table
            $tempRec->is_checkout = true;
            $tempRec->save();

            $orderInfoarr = json_decode($tempRec->billing_info, true, 512, JSON_THROW_ON_ERROR);


            $studentEntity      = UserDataTransformer::buildEntity($studentRec->toArray());
            $cartEntity         = $studentEntity->getCart();
            $totalPaidAmount    = $cartEntity->calcTotal()->getValue();


            $invoicData = array(
                'checkoutDate' => now(),
                'billingInfo'  => $orderInfoarr,
                'paidAmount'   => $totalPaidAmount
            );

            $order          = $cartEntity->checkout($studentEntity, $invoicData);

            // save invoice in database
            $invoiceEntity  = $order->getInvoice();
            $payload        = InvoiceMapper::entityConvertToDbArr($invoiceEntity->toArray());
            $invoiceRec     = (new InvoiceRepository())->create($payload);
            if(!$invoiceRec){
                abort(500, "Checkout failed due to server error !");
            }
            $invoiceEntity->setId($invoiceRec->id);

            $orderEnrollments = $order->getAllEnrollements();
            foreach ($orderEnrollments as $orderEnrollment) {
                $orderCourseItem = $orderEnrollment->getCourseItem();

                //to collect purchased informations of the purchased courses
                $courseArr[]     = $orderCourseItem->getCourse();

                //if coupon code is used then increase coupon used count by one
                $usedCC = $orderCourseItem->getCouponCode();
                if(!is_null($usedCC)){
                    if($usedCC->getIsEnabled() == true){
                        $usedCC->increaseUsedCountByOne();

                        $arr = CouponMapper::entityConvertToDbArr($usedCC->toArray());
                        unset($arr['assigned_course_arr']);
                        unset($arr['beneficiary_arr']);
                        $payload = $arr;
                        (new CouponRepository())->update($usedCC->getCode(), $payload);
                    }
                }


                // update cartItem recods in database as checkout = true
                $orderCourseItem->markAsCheckout();
                $arr        = CourseItemMapper::entityConvertToDbArr($orderCourseItem->toArray());
                unset($arr['cart_added_date']);
                $payload    = $arr;
                $isUpdated  = $this->courseSelectionRepository->update($payload['id'], $payload);
                if(!$isUpdated)
                    abort(500, "Checkout failed due to following server error - cartItem failed to update !");


                // create enrollments for each cartItem
                $isSaved  = (new EnrollmentRepository())->create([
                    'course_selection_id'   => $orderCourseItem->getId(),
                    'invoice_id'            => $invoiceRec->id
                ]);
                if(!$isSaved) //todo cehck is that rollback
                    abort(500, "Checkout failed due to following server error - failed to create enrollemnts !");
            }

            $billingInfoArr     =   array(
                'fullname'       => $orderInfoarr['fname'].' '.$orderInfoarr['lname'],
                'email'          => $orderInfoarr['email'],
                'phone'          => $orderInfoarr['phone'],
                'country'        => $orderInfoarr['country'],
                'city'           => $orderInfoarr['city'],
                'street_address' => $orderInfoarr['street_address'],
            );

        });

        $invoiceDto = InvoiceDtoFactory::fromArray($invoiceEntity->toArray());

        $courseDtoArr = [];
        foreach ($courseArr as $courseEntity) {
            $courseDtoArr[]['dto'] = CourseDtoFactory::fromArray($courseEntity->toArray());
        }

        return array(
            'billingInfoArr' => $billingInfoArr,
            'invoiceDto'     => $invoiceDto,
            'courseDtoArr'   => $courseDtoArr
        );
    }



}
