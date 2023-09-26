<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Sentinel;
use App\Exceptions\CustomException;
use App\Http\Requests\Admin\Coupon\CouponStoreRequest;
use Illuminate\Support\Facades\Session;
use App\Services\Admin\CouponService as AdminCouponService;
use Illuminate\Support\Facades\Validator;
use App\View\DataTransformers\Admin\CouponCodeDataTransformer as AdminCouponCodeDataTransformer;
use App\Repositories\UserRepository;
use App\Repositories\CourseRepository;

//use Illuminate\Support\Collection;
//use App\Models\Course;
class CouponController extends Controller
{

    private AdminCouponService $adminCouponService;

    public function __construct(AdminCouponService $adminCouponService){
        $this->adminCouponService = $adminCouponService;
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponStoreRequest $request)
    //public function store(Request $request)
    {
        //dd($request->all());

        try{
            //todo
            //$this->authorize('create',$course);


            /* creating validation errors for view*/
            $errors                 =   Session::get('errors');
            $couponCreateValErrors  =   null;
            if (!is_null($errors) && !is_null($errors->couponCreate))
                $couponCreateValErrors  =   $errors->couponCreate->getMessages();


            /* if have validation errors */
            if (isset($request->validator) && $request->validator->fails()) {
                $validationErrMsg = 'Form validation is failed !';
                throw new CustomException($validationErrMsg);
            }


            $isSaved = $this->adminCouponService->saveCoupon($request);
            if (!$isSaved)
                throw new CustomException("Coupon create failed");

            return redirect()->route('admin.coupon-code.create')->with([
                'message' => 'Coupon created successfully',
                'cls'     => 'flash-success',
                'msgTitle'=> 'Success',
            ]);

        }catch(CustomException $e){

            return redirect(route('admin.coupon-code.create'))
                ->withErrors($couponCreateValErrors ?? [],'couponCreateError')
                ->withInput($request->input())
                ->with([
                    'message'               => $e->getMessage(),
                    //'message'             => $e->getMessage(),
                    'cls'                   => 'flash-danger',
                    'msgTitle'              => 'Error!',
                ]);

        }catch(AuthorizationException $e){
            return redirect(route('admin.coupon-code.create'))
                ->with([
                    'message'   => 'You dont have Permissions to create Coupons !',
                    //'message' => $e->getMessage(),
                    'cls'       => 'flash-danger',
                    'msgTitle'  => 'Permission Denied!'
                ]);

        }catch(\Exception $e){
            return redirect(route('admin.coupon-code.create'))
                ->withErrors($couponCreateValErrors ?? [],'couponCreateError')
                ->withInput($request->input())
                ->with([
                    //'message'   => 'Coupon create Failed!',
                    'message' => $e->getMessage(),
                    'cls'       => 'flash-danger',
                    'msgTitle'  => 'Error!'
                ]);
        }


    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(string $code)
    {
        try{
            $validator = Validator::make(['code' => $code], [
                'code' => 'required|regex:/^[a-zA-Z0-9]+$/|size:6'
            ]);

            if ($validator->fails())
                throw new CustomException('Invalid code');

            $couponCodeData     =   $this->adminCouponService->findDbRec($code);

            if(is_null($couponCodeData['dbRec']))
                throw new CustomException('Coupon code does not exist!');

            //todo
            //$this->authorize('view', $couponCodeData['dbRec']);

            $couponDataArr = AdminCouponCodeDataTransformer::prepareCouponData($couponCodeData);

            return view('admin-panel.marketer.coupon-code-view')->with([
                'coupon'   => $couponDataArr,
            ]);

        }catch(CustomException $e){
            session()->flash('message',$e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('admin-panel.marketer.coupon-code-view');

        }catch(AuthorizationException $e){
            /*return redirect(route('admin.user.index'))->with([
                'message'     => 'You dont have Permissions to view the user !',
                'cls'         => 'flash-danger',
                'msgTitle'    => 'Permission Denied !',
            ]);*/

        }catch(\Exception $e){
            session()->flash('message','Coupon code does not exist');
            //session()->flash('message',$e->getMessage());
            session()->flash('cls','flash-danger');
            session()->flash('msgTitle','Error!');
            return view('admin-panel.marketer.coupon-code-view');
        }

    }

    //public function edit(Coupon $coupon){}
    //public function update(Request $request, Coupon $coupon){}
    //public function destroy(Coupon $coupon){}





    public function generateCode(){

        try{

            $couponCode     =   '';
            $couponCode     =   $this->adminCouponService->createUniqueCode();

            if(!$couponCode)
                throw new Exception("Coupon code generate failed!");

            return response()->json([
                'code'      => $couponCode,
                'status'    => 'success',
            ]);

        }catch(CustomException $e){
            return response()->json([
                'message'   => $e->getMessage(),
                'status'    => 'error',
            ]);

        }catch(\Exception $e){
            return response()->json([
                'message'   => 'Coupon code generate failed!',
                'status'    => 'error',
            ]);
        }
    }



    public function fillBeneficiaries(Request $request){

        try{

            $courseId   = $request->get('courseId');

            //  $courseId = 0 if not course is selected
            if(!filter_var($courseId, FILTER_VALIDATE_INT) && $courseId != 0)
                throw new CustomException('Invalid id');

            $beneficiaries  =   $this->adminCouponService->loadBeneficiaries($courseId);
            //dd($beneficiaries);
            return response()->json([
                'marketers' => $beneficiaries['marketers'],
                'teachers'  => $beneficiaries['teachers'],
                'status'    => 'success',
            ]);

        }catch(CustomException $e){
            return response()->json([
                'message'   => $e->getMessage(),
                'status'    => 'error',
            ]);

        }catch(\Exception $e){
            return response()->json([
                'message'   => $e->getMessage(),
                //'message'   => 'Beneficiaries loading failed!',
                'status'    => 'error',
            ]);
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

    //TODO
    public function myCoupons__m(){

        return view('admin-panel.marketer.list-coupon-codes');
    }

    //TODO
    public function myCoupons__t(){

        return view('admin-panel.teacher.list-coupon-codes');
    }




}
