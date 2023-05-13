@extends('layouts.master')
@section('title','cart')


@section('css-files')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/tooltipster/dist/css/tooltipster.bundle.min.css')}}" />
@stop

@section('page-css')
    <style>
        #curriculum ul.course-curriculum-list a{/*color: unset;*/ }

        /*tooltipster noir theme styles*/
        .tooltipster-sidetip.tooltipster-noir .tooltipster-box{border-radius:0;border:3px solid #000;background:#fff}
        .tooltipster-sidetip.tooltipster-noir .tooltipster-content{color:#000}
        .tooltipster-sidetip.tooltipster-noir .tooltipster-arrow{height:11px;margin-left:-11px;width:22px}
        .tooltipster-sidetip.tooltipster-noir.tooltipster-left .tooltipster-arrow,.tooltipster-sidetip.tooltipster-noir.tooltipster-right .tooltipster-arrow{height:22px;margin-left:0;margin-top:-11px;width:11px}
        .tooltipster-sidetip.tooltipster-noir .tooltipster-arrow-background{border:11px solid transparent}
        .tooltipster-sidetip.tooltipster-noir.tooltipster-bottom .tooltipster-arrow-background{border-bottom-color:#fff;top:4px}
        .tooltipster-sidetip.tooltipster-noir.tooltipster-left .tooltipster-arrow-background{border-left-color:#fff;left:-4px}
        .tooltipster-sidetip.tooltipster-noir.tooltipster-right .tooltipster-arrow-background{border-right-color:#fff;left:4px}
        .tooltipster-sidetip.tooltipster-noir.tooltipster-top .tooltipster-arrow-background{border-top-color:#fff;top:-4px}
        .tooltipster-sidetip.tooltipster-noir .tooltipster-arrow-border{border-width:11px}
        .tooltipster-sidetip.tooltipster-noir.tooltipster-bottom .tooltipster-arrow-uncropped{top:-11px}
        .tooltipster-sidetip.tooltipster-noir.tooltipster-right .tooltipster-arrow-uncropped{left:-11px}
    </style>
@stop


@php
    //dd($cartCourses);
@endphp




@section('content')
    <div class="main-container container">
        <div class="max-w-5xl md:p-5 mx-auto">
            <div class="lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-8 p-3">

                <div class="w-full">
                    <h2 class="font-semibold mb-3 text-xl lg:text-3xl">
                        @if($cartStatus == 'success')
                            My Cart ({{ $cartCourseCount }} {{ $cartCourseCount == 1 ? 'item' : 'items' }})
                        @else
                            My Cart
                        @endif

                    </h2>
                    <hr class="mb-5">


                    <!--
                    <p>To start using the Flexbox model, you need to first define a flex container.</p>
                    <h4 class="font-semibold mb-2 text-base"> Description </h4>
                    -->
                    <div class="__space-y-2">                      
                            @if($cartStatus == 'success')
                                @if(!empty($cartCourses))
                                    <div class="cart mx-auto w-11/12">


                                        @if(Session::has('message'))
                                            <x-flash-message
                                                class="{{ Session::get('cls', 'flash-info')}}" 
                                                :title="Session::get('msgTitle')"
                                                :message="Session::get('message')">                            
                                            </x-flash-message>            
                                        @endif



                                        <div class="tbl-div mb-5" style="overflow-x:auto;">                                                                    
                                            <table class="table cart-table w-full">
                                                <thead>
                                                    <tr>
                                                        <th scope="col"></th>
                                                        <th scope="col">Course</th>
                                                        <th scope="col">Price(Rs)</th>
                                                        <th scope="col">remove</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($cartCourses as $course)                                          
                                                        <tr data-course_selections_id="{{$course['courseSel_id']}}">
                                                            <td class="w-3/12 course-img">
                                                                <a href="{{route('course-single',$course['slug'])}}" title="{{$course['name']}}">
                                                                    <img src="{{$course['image']}}" class="img-fluid img-thumbnail" alt="{{$course['name']}}">
                                                                </a>
                                                            </td>
                                                            <td><a href="{{route('course-single',$course['slug'])}}" title="{{$course['name']}}">{{$course['name']}}</a></td>
                                                            <td>                                                           
                                                                

                                                                @if( $course['used_coupon_code'])
                                                                    <div class="line-through">{{$course['price']}}</div>                                                            
                                                                @endif
                                                                <div class="">{{$course['revised_price']}}</div>



                                                               
                                                            </td>
                                                            <td>                                                        
                                                                <form action="{{route('remove-cart',$course['id'])}}" method="post" class='course-enroll-form'>
                                                                    {{csrf_field ()}}
                                                                    <div class="mt-4">
                                                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full" style="width:40px; height: 40px">
                                                                            <i class="align-middle text-2xl font-bold icon-feather-x leading-4"></i>
                                                                        </button>
                                                                    </div>
                                                                    <input type="hidden" name="page" value="cart">
                                                                </form>                                                        
                                                            </td>
                                                        </tr>
                                                    @endforeach                                    
                                                </tbody>
                                            </table>                                   
                                            <!--
                                            <div class="d-flex justify-content-end">
                                                <h5>Total: <span class="price text-success">89$</span></h5>
                                            </div> -->
                                        </div>

                                        <div class="border-t mt-5 pt-6 __space-y-6">

                                            <div class="border-top-0 d-flex justify-content-end btn-div mb-8">
                                                <div class="coupon-wrapper w-3/5">
                                                    
                                                    <form action="{{route('apply-coupon')}}" method="post" id="apply-cc">
                                                        @csrf
                                                        <div class="w-full flex justify-content-between">                                               
                                                            <input type="text" placeholder="Coupon code" name="coupon_code"
                                                                class="w-3/5 mr-1 shadow-none with-border coupon_code" maxlength="6">
                                                            <button type="submit" class="w-2/5 bg-blue-500 hover:bg-blue-700 text-sm text-white font-bold px-3 py-1 rounded">Apply coupon</button>
                                                        </div>
                                                    
                                                    
                                                    

                                                        <div class="flex w-full mt-3 __items-center">
                                                            
                                                            <div class="w-1/5 space-y-2 used-cc-container">

                                                                
                                                                @foreach($cartDiscountedCourses as $discountedCourse)                                                                    
                                                                    <div class="flex items-center justify-between border rounded p-1 border-gray-500">
                                                                        <span class="inline-block px-5 py-2 font-semibold leading-none bg-gray-500 text-white rounded-sm mr-1 cc-code">{{$discountedCourse['used_coupon_code']}}</span>
                                                                        
                                                                        <button class="text-gray-600 hover:text-gray-800 text-base pr-1 remove-cc" 
                                                                                data-cc="{{$discountedCourse['used_coupon_code']}}" data-course-selection-id="{{$discountedCourse['id']}}">
                                                                            <i class="fa fa-times"></i>                                                                            
                                                                        </button>                                                                        
                                                                    </div>
                                                                   
                                                                @endforeach

                                                                {{--                                                               
                                                                <div class="flex items-center justify-between border rounded p-1 border-gray-500">
                                                                    <span class="inline-block px-5 py-2 font-semibold leading-none bg-gray-500 text-white rounded-sm mr-1 cc-code">A34GE8</span>
                                                                    <button class="text-gray-600 hover:text-gray-800 text-base pr-1 remove-cc"
                                                                            data-cc="cc1" data-course-selection-id="CS-1">
                                                                        <a href="" class="used-cc" title="Remove">
                                                                            <i class="fa fa-times"></i>
                                                                        </a>
                                                                    </button>
                                                                </div>                                                            

                                                                <div class="flex w-1/5 items-center justify-between border rounded p-1 border-gray-500">
                                                                    <span class="inline-block px-5 py-2 font-semibold leading-none bg-gray-500 text-white rounded-sm mr-1 cc-code">GE8A34</span>
                                                                    <button class="text-gray-600 hover:text-gray-800 text-base pr-1 remove-cc"
                                                                            data-cc="cc2" data-course-selection-id="CS-2">
                                                                        <a href="" class="used-cc" title="Remove">
                                                                            <i class="fa fa-times"></i>
                                                                        </a>
                                                                    </button>
                                                                </div>                                                            

                                                                <div class="flex w-1/5 items-center justify-between border rounded p-1 border-gray-500">
                                                                    <span class="inline-block px-5 py-2 font-semibold leading-none bg-gray-500 text-white rounded-sm mr-1 cc-code">FFA4GE</span>
                                                                    <button class="text-gray-600 hover:text-gray-800 text-base pr-1 remove-cc"
                                                                            data-cc="cc3" data-course-selection-id="CS-3">
                                                                        <a href="" class="used-cc" title="Remove">
                                                                            <i class="fa fa-times"></i>
                                                                        </a>
                                                                    </button>
                                                                </div>
                                                                --}} 
                                                                

                                                            </div>

                                                            <div class="w-4/5 error-msg text-center p-1 mt-2"></div>
                                                        </div>
                                                    </form>


                                                    <form action="{{route('remove-coupon')}}" method="post" id="remove-cc">
                                                        @csrf
                                                        <input type="hidden" name="cc" value="">
                                                        <input type="hidden" name="courseSelectionId" value="">                                                        
                                                    </form>

                                                </div>
                                            </div>
                                            <br>
                                            


                                            <div class="flex justify-between __px-6 mb-2 pt-2">
                                                <div class="flex-1 min-w-0">
                                                    <h1 class="text-lg font-medium">Subtotal </h1>
                                                </div>
                                                <h5 class="font-semibold text-black text-xl">Rs {{$cartSubTotPrice}}</h5>
                                            </div>
                                            <hr>

                                                




                                            @forelse ($cartDiscountedCourses as $discountedCourse)
                                                <div class="flex justify-between __px-6 mb-2 pt-2">
                                                    <div class="flex-1 min-w-0">
                                                        <h1 class="text-lg font-medium">
                                                            Discount(Coupon)                                                
                                                        </h1>
                                                    </div>
                                                    <h5 class="font-semibold text-black text-xl">- Rs {{$discountedCourse['discount_amount']}}</h5>
                                                </div>
                                                    
                                                <div class="w-11/12 mt-2 float-right text-sm discount-details">
                                                    <ul class="list-disc" style="list-style-type:disc">
                                                        <!-- 
                                                        <li class="pt-1 flex justify-between border-b">                                                    
                                                            <div>Coupon</div>
                                                            <span class="block mb-2 inline-block px-5 py-2 font-semibold leading-none bg-gray-500 text-white rounded">A34GE8</span>
                                                        </li>
                                                         -->
                                                         <li class="py-1 flex justify-between border-b">
                                                            <div>Coupon discount percentage</div>
                                                            <div>{{$discountedCourse['coupon_discount_percentage']}}%</div>                                                            
                                                        </li>
                                                        <li class="py-1 flex justify-between border-b">
                                                            <div>Coupon applied course</div>
                                                            <a href="{{route('course-single',$discountedCourse['course_slug'])}}" class="text-blue-600">
                                                                {{$discountedCourse['course_name']}}
                                                            </a>
                                                        </li>
                                                        <li class="py-1 flex justify-between border-b">
                                                            <div>Course price</div>
                                                            <div>Rs {{$discountedCourse['course_price']}}</div>
                                                        </li>                                            
                                                        <li class="py-1 flex justify-between">
                                                            <div>New Course price</div>
                                                            <div>Rs {{$discountedCourse['revised_price']}}</div>
                                                        </li>

                                                    </ul>                                            
                                                </div>
                                                <div class="clearfix"></div>                                    
                                                <br><hr>
                                            @empty
                                                
                                            @endforelse
                                            




                                                                                
                                            <div class="flex justify-between __px-6 mb-5 pt-5">
                                                <div class="flex-1 min-w-0">
                                                    <h1 class="text-lg font-medium">Total Amount </h1>
                                                </div>
                                                <h5 class="font-semibold text-black text-xl">Rs {{$cartTotal}}</h5>
                                            </div>
                                            <br>

                                            <div class="__px-6 pb-5 mb-5">                                       
                                                <!-- checkout-cart -->
                                                <form action="{{route('checkout1')}}" method="post" class=''>
                                                    {{csrf_field ()}}                                            
                                                        <button type="submit" class="w-full block py-2 text-center text-base hover:text-white checkout-btn 
                                                            bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                                            Checkout
                                                        </button>                                            
                                                    <!-- <input type="hidden" name="page" value="cart"> -->
                                                </form>    

                                                <div class="flex items-center justify-center mt-4 space-x-1.5">
                                                    <p class="font-medium"> or </p> <a href="{{route('all-courses')}}" class="text-blue-600 font-semibold text-center">Continue Shopping</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                @else
                                    <div class="flash-msg flash-info">
                                        <p>Your cart is currently empty.</p>
                                    </div>
                                @endif

                            @elseif($cartStatus == 'error')
                                <div class="flash-msg flash-danger">
                                    <div class="text-lg"><strong>Error</strong></div>                    
                                    <p>Unable to retrieve your cart</p>
                                </div>                               
                            @else
                                <!-- invalid  -->                                
                                <div class="flash-msg flash-warning">
                                    <div class="text-lg"><strong>Access denied</strong></div>
                                    <p>You do not have permission to view this page.</p>
                                </div>
                            @endif

                            //when apply coupon code works for any course and multiple courses in cart<br>
                            //then ask which course to apply coupon code
                            <br><br><br>
                            after checkout cc used_count ++
                        




                        


                    </div>

                </div>

            </div>
        </div>
    </div>
@stop


@section('script-files')
    <script src="{{asset('plugins/tooltipster/dist/js/tooltipster.bundle.min.js')}}"></script>    

    <!-- jQuery validate -->
    <script src="{{asset('admin/js/plugins/validate/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin/js/plugins/validate/custom-additional-methods.js')}}"></script>
    <script src="{{asset('admin/js/plugins/validate/additional-methods.min.js')}}"></script>
@stop


@section('javascript')
    <script>

        $(document).ready(function() {

            $('.used-cc').tooltipster({
                animation: 'grow',
                theme: 'tooltipster-noir',
                touchDevices: true,
                trigger: 'hover',
                position: 'right',
                //contentAsHTML:true
                //content: $('<span><strong>prev text is in bold case !</strong></span>'),
            });

            $.validator.addMethod("checkAlreadyUsed", function(value, element, param) {
                if(param === true){
                    var usedCcArr  = [];
                    $('.used-cc-container').find('.cc-code').each(function() {
                        usedCcArr.push($(this).text());
                    });
                    //console.log(usedCcArr);
                    //console.log(value);
                    //console.log(usedCcArr.includes(value));
                    //console.log(param);
                    //console.log('==checkAlreadyUsed==');
                    return !usedCcArr.includes(value);
                    //return true;
                
                }else{
                    return true;
                }       
                            
            }, "Coupon already used in your cart");


            /*
            jquery.validate ignores hidden fields by default, not validating them.
            To turn it back on simply do the following:
            */
            $.validator.setDefaults({ ignore: '' });

            var validator =  $("#apply-cc").validate({                       
                //ignore: [],
                onkeyup: false,
                errorClass: "validationErrorCls",
                //focusInvalid: false,
                rules:{
                    
                    "coupon_code": {
                        required: true,
                        exactlength :6,
                        lettersAndNumbersOnly:true,
                        checkAlreadyUsed: true
                    },
                    
                },
                messages:{
                    "coupon_code": {
                        required:"Coupon is required",
                        
                        exactlength: "Coupon code length should be 6 characters",
                        lettersAndNumbersOnly: "Coupon code should be in alpha numeric characters",
                        //exactlength: "Invalid coupon code",
                        //lettersAndNumbersOnly: "Invalid coupon code"                        
                    },                    
                },
                submitHandler: function(form){
                    console.log('submitHandler');
                    form.submit();
                },
                invalidHandler: function(form, validator) {
                    if (!validator.numberOfInvalids()){
                        //return;
                    }
                },
                errorPlacement: function (error, element)
                {
                    var elementName = $(element).attr("name");
                    console.log(element);
                    
                    //console.log(error);
                    //console.log(error.text());
                    //element.before(error);
                    //element.after(error);
                    
                    var erroMsgDiv =  element.parent().parent().parent().find('.error-msg');                    
                    error.appendTo(erroMsgDiv);
                    erroMsgDiv.find('label').css('color','red');
                    erroMsgDiv.find('label').css('fontSize','14px');
                    erroMsgDiv.find('label').css('margin-bottom','0px');
                }

            });    



            $('.remove-cc').on('click',function(event){
                alert();
                var form                = $('form#remove-cc');
                var cc                  = $(this).data('cc');
                var courseSelectionId   = $(this).data('courseSelectionId');

                console.log(cc);
                console.log(courseSelectionId);

                form.find('[name="cc"]').val(cc);                
                form.find('[name="courseSelectionId"]').val(courseSelectionId);


                form.submit();

                event.preventDefault();

            });



        });

    </script>
@stop