@extends('layouts.master')
@section('title','cart')



@php
    //dd($cartCourses);
@endphp




@section('content')
    <div class="main-container container">
        <div class="max-w-5xl md:p-5 mx-auto">
            <div class="lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-8 p-3">

                <div>
                    <h2 class="font-semibold mb-3 text-xl lg:text-3xl">Cart</h2>
                    <hr class="mb-5">
                    <!--
                    <p>To start using the Flexbox model, you need to first define a flex container.</p>
                    <h4 class="font-semibold mb-2 text-base"> Description </h4>
                    -->
                    <div class="__space-y-2">                      

                        <div class="cart">
                            @if(!empty($cartCourses))
                                <div class="tbl-div mb-5" style="overflow-x:auto;">
                                                                    
                                    <table class="table cart-table">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Course</th>
                                                <th scope="col">Price(Rs)</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cartCourses as $course)                                          
                                                <tr>
                                                    <td class="w-3/12 course-img">
                                                        <a href="{{route('course-single',$course['slug'])}}" title="{{$course['name']}}">
                                                            <img src="{{$course['image']}}" class="img-fluid img-thumbnail" alt="{{$course['name']}}">
                                                        </a>
                                                    </td>
                                                    <td><a href="{{route('course-single',$course['slug'])}}" title="{{$course['name']}}">{{$course['name']}}</a></td>
                                                    <td>                                                           
                                                        @if( $loop->index == 0)
                                                            <div class="line-through">{{$course['price']}}</div>
                                                            <div class="">2000.00</div>
                                                        @else
                                                            <div class="">{{$course['price']}}</div>
                                                        @endif
                                                    </td>
                                                    <td class="">1</td>
                                                    <td>                                                        
                                                        <form action="{{route('remove-cart',$course['id'])}}" method="post" class='course-enroll-form'>
                                                            {{csrf_field ()}}
                                                            <div class="mt-4">
                                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full" style="width:40px; height: 40px">
                                                                    <i class="align-middle text-2xl font-bold icon-feather-x leading-4"></i>
                                                                </button>
                                                            </div>
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

                                <div class="border-top-0 d-flex justify-content-end btn-div mb-5">
                                    <div class="d-flex justify-content-between coupon-wrapper">
                                        <input type="text" placeholder="Coupon code" class="shadow-none with-border coupon_code" name="coupon_code">
                                        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded">Apply coupon</button>
                                    </div>
                                </div>

                                <div class="border-top-0 d-flex justify-content-end btn-div mb-1">
                                    <div class=""><h2 class="font-bold mb-2 text-lg">Total Amount</h2></div>
                                </div>

                                <div class="border-top-0 d-flex justify-content-end btn-div mb-1">
                                    <div class=""><span class="line-through text-base font-semibold">Rs {{$cartTotal}}</span></div>                                    
                                </div>

                                <div class="border-top-0 d-flex justify-content-end btn-div mb-1">
                                    <div class=""><span class="text-base font-semibold">Rs 20000</span></div>
                                </div>

                                <div class="border-top-0 d-flex justify-content-end btn-div mb-5">
                                    <div class=""><p class="text-base">87% off</p></div>
                                </div>

                                <div class="border-top-0 d-flex justify-content-end btn-div mb-1">
                                    <button type="button" class="checkout-btn bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Checkout</button>
                                </div>
                            @else
                                <div class="">No Items</div>
                            @endif

                            //when apply coupon code works for any course and multiple courses in cart<br>
                            //then ask which course to apply coupon code

                            <br><br><br>
                            checkout btn move last step(after entering billing info)
                        </div>




                        {{--
                        <div class="cart">
                            @if(!empty($addedCourses))
                                <div class="tbl-div mb-5" style="overflow-x:auto;">
                                                                    
                                        <table class="table cart-table">
                                            <thead>
                                                <tr>
                                                    <th scope="col"></th>
                                                    <th scope="col">Course</th>
                                                    <th scope="col">Price(Rs)</th>
                                                    <th scope="col">Qty</th>
                                                    <th scope="col">remove</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($addedCourses as $course)                                          
                                                    <tr>
                                                        <td class="w-3/12 course-img">
                                                            <img src="{{$course->image}}" class="img-fluid img-thumbnail" alt="{{$course->name}}">
                                                        </td>
                                                        <td>{{$course->name}}</td>

                                                        <td>                                                           
                                                            @if( $loop->index == 0)
                                                                <div class="line-through">{{$course->price}}</div>
                                                                <div class="">2000.00</div>
                                                            @else
                                                                <div class="">{{$course->price}}</div>
                                                            @endif

                                                        </td>
                                                        <td class="">1</td>
                                                        <td>
                                                            
                                                            <form action="{{route('remove-cart',$course->id)}}" method="post" class='course-enroll-form'>
                                                                {{csrf_field ()}}
                                                                <div class="mt-4">
                                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full" style="width:40px; height: 40px">
                                                                        <i class="align-middle text-2xl font-bold icon-feather-x leading-4"></i>
                                                                    </button>
                                                                </div>
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

                                <div class="border-top-0 d-flex justify-content-end btn-div mb-5">
                                    <div class="d-flex justify-content-between coupon-wrapper">
                                        <input type="text" placeholder="Coupon code" class="shadow-none with-border coupon_code" name="coupon_code">
                                        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded">Apply coupon</button>
                                    </div>
                                </div>

                                <div class="border-top-0 d-flex justify-content-end btn-div mb-1">
                                    <div class=""><h2 class="font-bold mb-2 text-lg">Total Amount</h2></div>
                                </div>

                                <div class="border-top-0 d-flex justify-content-end btn-div mb-1">
                                    <div class=""><span class="line-through text-base font-semibold">Rs {{$totalPrice}}</span></div>                                    
                                </div>

                                <div class="border-top-0 d-flex justify-content-end btn-div mb-1">
                                    <div class=""><span class="text-base font-semibold">Rs 20000</span></div>
                                </div>

                                <div class="border-top-0 d-flex justify-content-end btn-div mb-5">
                                    <div class=""><p class="text-base">87% off</p></div>
                                </div>

                                <div class="border-top-0 d-flex justify-content-end btn-div mb-1">
                                    <button type="button" class="checkout-btn bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Checkout</button>
                                </div>
                            @else
                                <div class="">No Items</div>
                            @endif

                            //when apply coupon code works for any course and multiple courses in cart<br>
                            //then ask which course to apply coupon code

                            <br><br><br>
                            checkout btn move last step(after entering billing info)
                        </div>
                        --}}


                    </div>

                </div>

            </div>
        </div>
    </div>
@stop
