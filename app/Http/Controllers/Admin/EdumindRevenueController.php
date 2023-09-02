<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\Admin\EdumindRevenueService;
use App\Http\Controllers\Controller;

use App\Models\Coupon;
use App\Repositories\Eloquent_impl\CouponRepository;





class EdumindRevenueController extends Controller
{
    public function loadEarningsRecords(Request $request){
        //dump($request->all());
        //dump('sssss');

        $draw = $request->get('draw');

        $data = array();
        for ($i=0; $i < 10; $i++) { 
            $data[] = array(
                             
                //'',
                
                /**/
                //'' => null,
                'claimed Amount'                    => $draw.'claimed Amount'.$i,                
                'order'                             => $draw.'order'.$i,
                'enrollment date'                   => $draw.'enrollment date'.$i,
                'coupon code'                       => $draw.'coupon code'.$i,
                'coupon code discount precentage'   => $draw.'coupon code discount precentage'.$i,
                'id'                                => $draw.'id'.$i,

                //'course' => 'course',
                //'teacher' => 'teacher',
                //'coursePrice'=> 'coursePrice',
                //'student'=> 'student',


                //'edumindShareFromCoursePrice' =>40,
                //'edumindEarnAmountFromCoursePrice' =>959.6,
                //'discountPercentage' =>0,
                //'discountAmount' =>0,                         
                //'beneficiaryShareFromDiscount' =>0,
                //'edumindShareFromDiscount' =>0,
                //'beneficiaryEarnAmount' =>0,
                //'edumindLoseAmount' =>0,




                /*
                
                'couponCode' =>"",
                'course' =>"Odio repellat.",
                'coursePrice' =>2399,
                
                
                'edumindEarnAmount' =>959.6,
                
                
                
                
                'enrolledDateTime' =>"2023-06-12 06:07:02",
                'id' =>23,
                'invoiceId' =>1201,
                'student' =>"Faustino Rodriguez",
                'teacher' =>"Alfonzo Huel"*/

                /*null => null,
                'claimed Amount'=>'claimed Amount'.$i,                
                'order'=>'order'.$i,
                'enrollment date'=>'enrollment date'.$i,
                'coupon code'=>'coupon code'.$i,
                'coupon code discount precentage'=>'coupon code discount precentage'.$i,
                'id'    =>'id'.$i*/


            );
        }


        $response = array(
            "draw" => intval($draw),
            //"recordsTotal" => 33,
            //"recordsFiltered" => 33,
            //"data" => $data

            "iTotalRecords" => 33,
            "iTotalDisplayRecords" => 33,
            "aaData" => $data
        );

        echo json_encode($response);

/*draw
start
length

array:5 [
    "draw" => "1"
    "columns" => array:7 [
        0 => array:5 [
          "data" => null
          "name" => null
          "searchable" => "false"
          "orderable" => "false"
          "search" => array:2 [
            "value" => null
            "regex" => "false"
          ]
        ]
        1 => array:5 [
          "data" => "claimed Amount"
          "name" => null
          "searchable" => "false"
          "orderable" => "false"
          "search" => array:2 [
            "value" => null
            "regex" => "false"
          ]
        ]
        2 => array:5 [
          "data" => "order"
          "name" => null
          "searchable" => "true"
          "orderable" => "false"
          "search" => array:2 [
            "value" => null
            "regex" => "false"
          ]
        ]
        3 => array:5 [
          "data" => "enrollment date"
          "name" => null
          "searchable" => "false"
          "orderable" => "false"
          "search" => array:2 [
            "value" => null
            "regex" => "false"
          ]
        ]
        4 => array:5 [
          "data" => "coupon code"
          "name" => null
          "searchable" => "true"
          "orderable" => "false"
          "search" => array:2 [
            "value" => null
            "regex" => "false"
          ]
        ]
        5 => array:5 [
          "data" => "coupon code discount precentage"
          "name" => null
          "searchable" => "false"
          "orderable" => "false"
          "search" => array:2 [
            "value" => null
            "regex" => "false"
          ]
        ]
        6 => array:5 [
          "data" => "id"
          "name" => null
          "searchable" => "false"
          "orderable" => "false"
          "search" => array:2 [
            "value" => null
            "regex" => "false"
          ]
        ]
  ]
  "start" => "0"
  "length" => "10"
  "search" => array:2 [
    "value" => null
    "regex" => "false"
  ]
]*/








    // Service layer returning an array of DTOs
    /* 
       
    $userDTO = $userService->getFirstUser();
    $viewModel = new UserViewModel($userDTOs);
    $userData = $viewModel->getUserData();
    return view('user.index', compact())->with('userData'=>$userData);

    */













    }





    public function loadEarnings(){

        /*
        $cc = Coupon::find('0QZI7O');
        dump($cc);
        dump($cc->discount_percentage);
        dump($cc->beneficiary_commision_percentage_from_discount);
        dump($cc->is_enabled);
        

        dump('================');

        $cx = Coupon::create([
            'code'          => 'Z12345',
            'total_count'   => 55,
            'used_count'    => 5,
            'discount_percentage' => 22.20,
            'beneficiary_commision_percentage_from_discount' =>  54.12,
        ]);

        dump($cx->fresh());
        dump($cx->discount_percentage);
        dump($cx->beneficiary_commision_percentage_from_discount);
        dump($cx->is_enabled);
        dd();
        */




        //dd((new CouponRepository())->findByCode('XXX'));

        //dd('d');
        $edumindRevenueDTOArr = (new EdumindRevenueService())->loadEarnings();

        
        return view('admin-panel.admin.earnings',["data" => $edumindRevenueDTOArr]);


    }
}
