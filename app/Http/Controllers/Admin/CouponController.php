<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sentinel;
use App\Exceptions\CustomException;
use App\Http\Requests\Admin\Coupon\CouponStoreRequest;
use Illuminate\Support\Facades\Session;
use App\Services\Admin\CouponService as AdminCouponService;
use Illuminate\Support\Facades\Validator;
use App\View\DataFormatters\Admin\CouponCodeDataFormatter as AdminCouponCodeDataFormatter;
use App\Repositories\UserRepository;
use App\Repositories\CourseRepository;
use App\Models\Role as RoleModel;
use App\Common\Utils\AlertDataUtil;


class CouponController extends Controller
{

    private AdminCouponService $adminCouponService;

    public function __construct(AdminCouponService $adminCouponService){
        $this->adminCouponService = $adminCouponService;
    }


    public function create(){
        $courses    =   (new CourseRepository())->getAllPaidCourses();
        $teachers   =   (new UserRepository())->findAllAvailableTeachers();
        $marketers  =   (new UserRepository())->findAllAvailableMarketers();

        return view('admin-panel.admin.coupon-code-add')->with([
            'courses'   => (!empty($courses))   ? $courses->pluck('name','id')->toArray()        : [],
            'teachers'  => (!empty($teachers))  ? $teachers->pluck('full_name','id')->toArray()  : [],
            'marketers' => (!empty($marketers)) ? $marketers->pluck('full_name','id')->toArray() : []
        ]);
    }

    
    public function store(CouponStoreRequest $request){
        try{
            //todo
            //You dont have Permissions to create Coupons !
            //$this->authorize('create',$course);
            
            /* creating validation errors for view*/
            $errors = Session::get('errors');            
            if (!is_null($errors) && !is_null($errors->couponCreate))
                $couponCreateValErrors = $errors->couponCreate->getMessages();

            /* if have validation errors */
            if (isset($request->validator) && $request->validator->fails())
                throw new CustomException('Form validation is failed !');
            
            $isSaved = $this->adminCouponService->saveCoupon($request);
            if (!$isSaved)
                abort(500, "Coupon create failed due to server error !");

            return redirect()->route('admin.coupon-codes.create')->with(
                AlertDataUtil::success('Coupon created successfully')
            );

        }catch(\Throwable $ex){
            $msg = ($ex instanceof CustomException) ? $ex->getMessage() : 'Coupon create failed !';
            return redirect(route('admin.coupon-codes.create'))
                ->withErrors($couponCreateValErrors ?? [],'couponCreateError')
                ->withInput($request->input())
                ->with(AlertDataUtil::error($msg));         
        }
    }


    public function show(string $code){
        $validator = Validator::make(['code' => $code], [
            'code' => 'required|regex:/^[a-zA-Z0-9]+$/|size:6'
        ]);

        if ($validator->fails())
            throw new CustomException('Invalid code');

        $couponCodeData = $this->adminCouponService->findDbRec($code);
        if(is_null($couponCodeData['dbRec']))
            throw new CustomException('Coupon code does not exist !');

        //todo
        //You dont have Permissions to view the user !
        //$this->authorize('view', $couponCodeData['dbRec']);

        $couponDataArr = AdminCouponCodeDataFormatter::prepareCouponData($couponCodeData);
        return view('admin-panel.coupon-code-view')->with(['coupon' => $couponDataArr]);
    }

    //public function edit(Coupon $coupon){}
    //public function update(Request $request, Coupon $coupon){}
    //public function destroy(Coupon $coupon){}

    public function generateCode(){
        try{
            $couponCode     =   '';
            $couponCode     =   $this->adminCouponService->createUniqueCode();

            if(!$couponCode)
                abort(500, "Coupon code generate failed due to server error !");

            return response()->json(['status' => 'success', 'code' => $couponCode]);

        }catch(\Throwable $ex){
            $msg = ($ex instanceof CustomException) ? $ex->getMessage() : 'Coupon code generate failed !';
            return response()->json(['status' => 'error','message' => $msg]);
        }
    }


    public function fillBeneficiaries(Request $request){
        try{

            $courseId   = $request->get('courseId');

            //  $courseId = 0 if not course is selected
            if(!filter_var($courseId, FILTER_VALIDATE_INT) && $courseId != 0)
                throw new CustomException('Invalid id');

            $beneficiaries  =   $this->adminCouponService->loadBeneficiaries($courseId);
            return response()->json([
                'marketers' => $beneficiaries['marketers'],
                'teachers'  => $beneficiaries['teachers'],
                'status'    => 'success',
            ]);

        }catch(\Throwable $ex){
            $msg = ($ex instanceof CustomException) ? $ex->getMessage() : 'Beneficiaries loading failed !';
            return response()->json(['status' => 'error','message' => $msg]);
        }
    }


    public function loadMarketerCoupons(){
        return view('admin-panel.admin.coupon-code-list-marketers');
    }

    public function loadTeacherCoupons(){
        return view('admin-panel.admin.coupon-code-list-teachers');
    }

    public function viewCoupons(){

    }

    public function newCoupons(){
        return view('admin-panel.marketer.new-coupon-codes');
    }

    public function usageOfCoupons(){
        return view('admin-panel.marketer.usage-coupon-codes');
    }


    public function myCoupons(){
        if(!Sentinel::check())
            abort(403);

        $user            = Sentinel::getUser();
        $allRoles        = [RoleModel::ADMIN, RoleModel::EDITOR, RoleModel::MARKETER, RoleModel::TEACHER, RoleModel::STUDENT];
        $currentUserRole = optional($user->roles()->first())->name;
        if(!in_array($currentUserRole, $allRoles))
            abort(403);


        // redirect users that have TEACHER, STUDENT roles
        $adminPanelAllowedRoles = [RoleModel::MARKETER, RoleModel::TEACHER];
        if(!in_array($currentUserRole, $adminPanelAllowedRoles))
            abort(404);


        $view   =   ($currentUserRole == RoleModel::TEACHER) ?
                        'admin-panel.teacher.list-coupon-codes' : // TEACHER
                        'admin-panel.marketer.list-coupon-codes'; // MARKETER

        // load page with data for EDITOR / MARKETER user roles
        return view($view);
    }

}