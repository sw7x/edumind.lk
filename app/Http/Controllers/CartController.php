<?php
namespace App\Http\Controllers;


use App\Exceptions\CustomException;
use App\Domain\Exceptions\DomainException;
use Symfony\Component\HttpKernel\Exception\HttpException;

use App\Http\Requests\BillingInfoRequest;
use App\Http\Requests\CreditCardDetailsRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use Cookie;
use Sentinel;

use App\Common\Utils\AlertDataUtil;
use App\Services\CartService;
use App\View\DataFormatters\CourseDataFormatter;
use App\Repositories\CourseRepository;

use App\Permissions\Abilities\CartAbilities;
use App\Permissions\Traits\PermissionCheck;


class CartController extends Controller
{
    use PermissionCheck;

    private CartService $cartService;

    function __construct(CartService $cartService){
        $this->cartService  = $cartService;
        //$this->middleware('withUserRoles:RoleModel::STUDENT');
    }


    public function viewCart(){
        $this->hasPermission(CartAbilities::VIEW_CART);

        try {
            $msgArr = [];
            $user   = Sentinel::getUser();

            //before load cart page view, resetting and remove invalid cart items in user's cart
            $freeCoursArr   = $this->cartService->removeFreeCourseFromCart($user);
            $inavildCcArr   = $this->cartService->removeInavildCouponsFromCart($user);
            $NonExistCcArr  = $this->cartService->removeNonExistCouponsFromCart($user);
            $usedCcArr      = $this->cartService->removeUsedMultipleCouponsFromCart($user);

            //remove empty arrays and merge
            $msgArr =   array_filter(array_merge($freeCoursArr, $inavildCcArr, $NonExistCcArr, $usedCcArr));

            $cartReInitMsg      = empty($msgArr)? '' : 'Cart reset. Some items unavailable or modified. Please review and update your cart.';
            $cartReInitMsgCls   = empty($msgArr)? '' : 'flash-warning';
            $cartReInitMsgTitle = empty($msgArr)? '' : 'Invalid Cart Items !';

            return view('student.cart.cart-page')->with([
                'cart_re_init_message'  => $cartReInitMsg,
                'cart_re_init_cls'      => $cartReInitMsgCls,
                'cart_re_init_msgTitle' => $cartReInitMsgTitle,
                'cart_re_init_msg_arr'  => $msgArr
            ]);;

        }catch(\Throwable $ex){
            $msg = ($ex instanceof HttpException) ? $ex->getMessage() : 'Form submission failed !';
            return view('student.cart.cart-page')->with([
                //'cart_re_init_message'  => 'Cart reinitialization failed',
                //'cart_re_init_message'  => $ex->getMessage(),
                'cart_re_init_message'  => $msg,                
                'cart_re_init_cls'      => 'flash-danger',
                'cart_re_init_msgTitle' => 'Error',
                'cart_re_init_msg_arr'  => []
            ]);

        }

    }


    public function loadBillingInfoForm(Request $request){
        $this->hasPermission(CartAbilities::VIEW_CART);

        $user = Sentinel::getUser();
        if(is_null($user))
            abort(401, "You need to login before access this page");

        $arr = $this->cartService->loadBillingInfoData($request);
        return view('student.cart.bill-info')->with($arr);
    }


    public function submitBillingInfo(BillingInfoRequest $request){
        $this->hasPermission(CartAbilities::VIEW_CART);

        try{
            $user = Sentinel::getUser();
            if(is_null($user))
                abort(401, "You need to login before submit billing info form");

            $errMessageBag = optional(Session::get('errors'))->billingInfo;
            if(!is_null(optional($errMessageBag)->getMessages()))
                $billingInfoValErrors = $errMessageBag->getMessages();

            /* if have validation errors */
            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation is failed');

            $cartCourseCount = $this->cartService->getCartItemCountByStudent($user);
            if($cartCourseCount <= 0)
                return redirect()->route('view-cart')->with(
                    AlertDataUtil::error('Your cart is empty therefore cannot submit billing info !')
                );

            $saveFormData   = json_encode($request->except(['from','_token']));
            $dbRec          = $this->cartService->saveBillingInfoData($saveFormData, $user);
            if(!$dbRec)
                abort(500, "Failed to save Billing Info form due to server error!");

            $randomId       = substr(md5(mt_rand()), 0, 5);
            $viewDataArr    = array(
                'order' =>  $dbRec->id,
                'key'   =>  'edumind_order_'.md5($dbRec->id).$randomId,
                'code'  =>  base64_encode($randomId)
            );

            return redirect()->to(route('load-checkout', $viewDataArr))
                ->withCookie('USER_B_INFO', Crypt::encryptString($saveFormData));

        }catch(\Throwable $ex){
            $msg = ($ex instanceof CustomException) ? $ex->getMessage() : 'Form submission failed !';
            return redirect()->back()
                ->withErrors($billingInfoValErrors ?? [],'billingInfoErrMsgArr')
                ->withInput($request->input())
                ->with(AlertDataUtil::error($msg));

        }

    }


    public function loadCheckout(Request $request){
        $this->hasPermission(CartAbilities::VIEW_CART);

        $user = Sentinel::getUser();
        if(is_null($user))
            abort(403);

        $checkoutDataArr = $this->cartService->loadCheckoutData($request, $user);
        return view('student.cart.pay-with-credit-card')->with($checkoutDataArr);
    }


    public function addToCart(Request $request){
        $this->hasPermission(CartAbilities::ADD_TO_CART);

        $courseId = $request->input('courseId');
        $user     = Sentinel::getUser();

        try{
            if(!filter_var($courseId, FILTER_VALIDATE_INT))
                throw new CustomException('Invalid id');

            $course = (new CourseRepository())->findByIdWithGlobalScope($courseId);

            if(is_null($course))
                abort(404,'Course does not exists in database');

            if($course->price == 0)
                throw new CustomException('This is free course cannot add to cart');

            $insertedRec = $this->cartService->saveCartItem($course, $user);
            if(!$insertedRec)
                abort(500, "Course add to cart failed due to server error !");

            return  redirect()->back()
                        ->with(AlertDataUtil::success('Successfully added course to your cart'));

        }catch(CustomException $e){
            return redirect()->back()->with(AlertDataUtil::error($e->getMessage()));

        }catch(\Exception $e){
            return redirect()->back()->with(
                AlertDataUtil::error('Course add to cart failed !',[
                    //'message'     => $e->getMessage(),
                ])
            );
        }
    }


    public function removeFromCart(Request $request, $id){
        $this->hasPermission(CartAbilities::REMOVE_FROM_CART);

        try{
            $user       = Sentinel::getUser();
            $isDelete   = $this->cartService->deleteCartItem($id, $user);

            /*
            if(!$isDelete)
                abort(500, "Course delete from cart is failed due to server error !");*/

            if(!$isDelete)
                return redirect(route('view-cart'))->with(AlertDataUtil::error('Course delete from cart is failed due to server error !'));

            if($request->get('page') == 'cart'){
                return redirect(route('view-cart'));
            }else{
                return redirect()->back();
            }

        }catch(CustomException $e){
            return redirect()->back()->with(AlertDataUtil::error($e->getMessage()));

        }catch(\Exception $e){
            return redirect()->back()->with(
                AlertDataUtil::error('Course delete from cart is failed !',[
                    'message'     => $e->getMessage(),
                ])
            );
        }

    }


    public function applyCoupon(Request $request){
        $this->hasPermission(CartAbilities::APPLY_COUPON);

        try{
            $user = Sentinel::getUser();
            $couponCode = $request->get('coupon_code');

            if(!$couponCode)
                throw new CustomException('Coupon code is missing');

            $this->cartService->applyCouponToCart($couponCode, $user);

            return redirect()->route('view-cart')->with(AlertDataUtil::success('Successfully applied coupon code'));

        }catch(CustomException $e){
            return redirect()->route('view-cart')->with(AlertDataUtil::error($e->getMessage()));

        }catch(DomainException $e){
            return redirect()->route('view-cart')->with(AlertDataUtil::error($e->getMessage()));

        }catch(\Exception $e){
            return redirect()->route('view-cart')->with(
                AlertDataUtil::error('Coupon code was failed to apply',[
                    //'message' => $e->getMessage(),
                ])
            );
        }

    }


    public function removeCoupon(Request $request){
        $this->hasPermission(CartAbilities::REMOVE_COUPON);

        try{
            $user           = Sentinel::getUser();
            $couponCode     = $request->get('cc');
            $courseSelId    = $request->get('courseSelectionId');

            if(!$couponCode)
                throw new CustomException('Coupon code is missing');

            if(!$courseSelId)
                throw new CustomException('Cart item id is missing');

            $this->cartService->RemoveCouponFromCart($couponCode, $user, $courseSelId);

            return  redirect()->route('view-cart')
                        ->with(AlertDataUtil::success('Successfully removed coupon from your cart'));

        }catch(CustomException $e){
            return redirect()->route('view-cart')->with(AlertDataUtil::error($e->getMessage()));

        }catch(\Exception $e){
            return redirect()->route('view-cart')->with(
                AlertDataUtil::error('Unable to remove coupon from your cart',[
                    //'message' => $e->getMessage()
                ])
            );
        }
    }


    public function checkout(CreditCardDetailsRequest $request){
        $this->hasPermission(CartAbilities::CHECKOUT);

        try{
            $user       = Sentinel::getUser();

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
            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Invalid credit card information');

            if($cardNumber != env('DUMMY_CREDIT_CARD_NUMBERUC') || $cvc != env('DUMMY_CVC'))
                throw new CustomException("Payment Failed: unable to process your payment.");

            $checkoutData   = $this->cartService->submitCheckout($user, $orderId);
            $courseDataArr  = CourseDataFormatter::prepareCoursListData($checkoutData['courseDtoArr']);

            return view('student.cart.checkout-complete')->with([
                'submit_status'  => true,
                'billingInfoArr' => $checkoutData['billingInfoArr'],
                'invoiceId'      => ($checkoutData['invoiceDto'])->getId(),
                'courseArr'      => $courseDataArr
            ]);

        }catch(CustomException $e){
            //dd($e->getMessage());
            return view('student.cart.payment-failed')->with(
                AlertDataUtil::error($e->getMessage(),['returnUrl' => $returnUrl])
            );

        }catch(\Exception $e){
            //dd($e->getMessage());
            return view('student.cart.payment-failed')->with(
                AlertDataUtil::error('There was an issue processing your payment',[
                    //'message' => $e->getMessage(),
                    'returnUrl' => $returnUrl
                ])
            );
        }
    }


}
