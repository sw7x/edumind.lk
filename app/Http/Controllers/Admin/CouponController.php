<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Coupon;
use Sentinel;
use App\Exceptions\CustomException;
use Illuminate\Support\Collection;
use App\Http\Requests\Admin\Coupon\CouponStoreRequest;

use Illuminate\Support\Facades\Session;





class CouponController extends Controller
{
        
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::Where('price','!=','0.00');
        

        //dd($courses->pluck('name','id')->toArray());

        //$teachers   =   Sentinel::findRoleBySlug('teacher')->users()->with('roles')->where('status',1)->orderBy('id')->get();         
        //$marketers  =   Sentinel::findRoleBySlug('marketer')->users()->with('roles')->where('status',1)->orderBy('id')->get();
        $teachers   =   Sentinel::findRoleBySlug('teacher')->users()->with('roles')->orderBy('id')->get();         
        $marketers  =   Sentinel::findRoleBySlug('marketer')->users()->with('roles')->orderBy('id')->get();

        //dd($teachers->pluck('full_name','id')->toArray());



        return view('admin-panel.admin.coupon-code-add')->with([
            'courses'   => $courses->pluck('name','id')->toArray(),
            'teachers'  => $teachers->pluck('full_name','id')->toArray(),
            'marketers' => $marketers->pluck('full_name','id')->toArray(),          
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
                 
            //todo--------------$this->authorize('update',$course);
            

            /* creating validation eroors for view*/
            if(null != Session::get('errors') && null != Session::get('errors')->couponCreate->getMessages()){
                $couponCreateValErrors = Session::get('errors')->couponCreate->getMessages();            
            }
            
            /* if have validation errors */
            if (isset($request->validator) && $request->validator->fails()) {
                $validationErrMsg = 'Form validation is failed';
                throw new CustomException($validationErrMsg);
            }
            
            $status = ($request->get('ccode_stat') == 'enable')?true:false;
            
            // if select any course then value = 0 , for mysql table insert convert it to null
            $courseId = ($request->get('course') == 0)? null: $request->get('course');

            
            if($courseId){

                $course              = Course::find($courseId);                
                $discountPercentage  = $request->get('discount_percentage');
                $commisionPercentage = $request->get('beneficiary_share_percentage_from_discount');
                
                //calculate Edumind recive no money from course due to discoun    
                $discountAmount         = ($course->price * ($discountPercentage/100));
                $edumindLoseAmount      = ($discountAmount/100) * (100 + $commisionPercentage);
                //dump($course->price);
                //dd($edumindLoseAmount);

                if($course->price <= $edumindLoseAmount){
                    $msg  = 'Edumind recive no money from this discount rate. ';
                    $msg .= 'pleae lower the discount precentage, Marketer/Teacher share precentage';
                    throw new CustomException($msg);
                }

            }

            //dd($status);
            Coupon::create([
                'code'                                              => $request->get('cc-code'),
                'discount_percentage'                               => $request->get('discount_percentage'),
                'beneficiary_commision_percentage_from_discount'    => $request->get('beneficiary_share_percentage_from_discount'),
                'total_count'                                       => $request->get('cc-count'),
                'used_count'                                        => 0,
                'is_enabled'                                        => $status,
                'cc_course_id'                                      => $courseId,
                'beneficiary_id'                                    => $request->get('beneficiary')       
            ]);            

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
                    'message'  => 'You dont have Permissions to create Coupons !',
                    //'message2' => $pwResetTxt,                
                    'cls'     => 'flash-danger',
                    'msgTitle'=> 'Permission Denied!'                    
                ]);

        }catch(\Exception $e){
            return redirect(route('admin.coupon-code.create'))
                ->withErrors($couponCreateValErrors ?? [],'couponCreateError')            
                ->withInput($request->input())
                ->with([
                    //'message'  => 'Coupon create Failed!',
                    'message'  => $e->getMessage(),
                    'cls'     => 'flash-danger',
                    'msgTitle'=> 'Error!'
                ]);
        }


    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        try{            
            
            $coupon = Coupon::withoutGlobalScope('enabled')->find($code);
            //dd($coupon);
            if(!$coupon)
                throw new CustomException("Coupon code doesn't exists");

            //dd($coupon);
           
            return view('admin-panel.marketer.coupon-code-view')->with([
                'coupon'   => $coupon,
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        //
    }





    public function generateCode(){
        
        try{         
            
            do{
                $genCode = strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));         
            }while(Coupon::withoutGlobalScope('enabled')->find($genCode) != null);

            if($genCode){
                return response()->json([
                    'code'  => $genCode,
                    'status' => 'success',
                ]);
            }else{
                throw new Exception("Coupon code generate failed!");
                
            }
          
        }catch(\Exception $e){
            return response()->json([
                'message'   => 'Coupon code generate failed!',
                'status'    => 'error',
            ]);
        }
    }



    public function loadBeneficiaries(Request $request){
        
        try{
            
            $courseId = $request->get('courseId');      

            if(!filter_var($courseId, FILTER_VALIDATE_INT) && $courseId != 0){
                //dd('courseId');
                throw new CustomException('Invalid id');
            }

            //dd($request->get('courseId'));
            //dump('courseId');
            //dump($courseId);




            $marketers  =   Sentinel::findRoleBySlug('marketer')->users()->with('roles')->orderBy('id')->get();
            
            if($courseId == 0){
                //$teachers   =   Sentinel::findRoleBySlug('teacher')->users()->with('roles')->where('status',1)->orderBy('id')->get();
                $teachers   =   Sentinel::findRoleBySlug('teacher')->users()->with('roles')->orderBy('id')->get();
            
            }else{
                
                $course = Course::find($courseId);
                if(!$course){
                    throw new CustomException('Course not found in database');
                }

                $authorId   = $course->teacher->id; 
                //dump('authorId');
                //dump($authorId);

                $teachers   =   Sentinel::findRoleBySlug('teacher')
                                ->users()
                                ->with('roles')
                                //->where('status', 1)
                                ->where('id', $authorId)
                                ->orderBy('id')
                                ->get();
            }
            
            //$marketers = '';
            //dump($marketers->pluck('full_name','id')->toArray());
            //dump($teachers->pluck('full_name','id')->toArray());


            
            return response()->json([
                'marketers' => $marketers->pluck('full_name','id')->toArray(),
                'teachers'  => $teachers->pluck('full_name','id')->toArray(),
                'status'    => 'success',
            ]);
        
            


        }catch(CustomException $e){
            return response()->json([            
                'message'   => $e->getMessage(),
                'status'    => 'error',
            ]);

        }catch(\Exception $e){
            return response()->json([
                'message'   => 'Beneficiaries loading failed!',
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


//--------------------------------------------


}
