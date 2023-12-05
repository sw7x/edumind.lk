@extends('layouts.master')
@section('title','Checkout complete')




@section('content')

    <div class="main-container container">
        <div class="max-w-5xl md:p-5 mx-auto">

            <div class="---lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-8 p-3">
                <div class="">

                    <div>
                        <h2 class="font-semibold mb-3 text-xl lg:text-3xl">Checkout complete</h2>
                        <hr class="mb-5">

                        <div class="flex justify-center">
                            <ion-icon name="checkmark-circle-outline" class="text-9xl text-center text-green-500 course-status" title="Enrolled"></ion-icon>
                        </div>

                        <div class="w-8/12 mx-auto">
                            <p class="mb-2 text-base __text-center">Thank you for your purchase</p>

                            @isset($invoiceId)
                                <p class="mb-2 text-base __text-center">Your Invoice code : {{$invoiceId}}</p>
                            @endisset

                            @if(isset($billingInfoArr) && isNotEmptyArray($billingInfoArr))
                            {{--
                            @if(isset($billingInfoArr) && is_array($billingInfoArr) && !empty($billingInfoArr))
                            --}}
                                <p class="text-base">Your Billing information</p>
                                <ul class="list-disc ml-10">
                                    @if($billingInfoArr['fullname'])
                                        <li>Full name - {{$billingInfoArr['fullname']}}</li>
                                    @endif

                                    @if($billingInfoArr['email'])
                                        <li>Email address - {{$billingInfoArr['email']}}</li>
                                    @endif

                                    @if($billingInfoArr['phone'])
                                        <li>Phone - {{$billingInfoArr['phone']}}</li>
                                    @endif

                                    @if($billingInfoArr['country'])
                                        <li>Country / Region - {{$billingInfoArr['country']}}</li>
                                    @endif

                                    @if($billingInfoArr['city'])
                                        <li>Town / City - {{$billingInfoArr['city']}}</li>
                                    @endif

                                    @if($billingInfoArr['street_address'])
                                        <li>Street Address - {{$billingInfoArr['street_address']}}</li>
                                    @endif
                                </ul>
                                <br>
                            @endif

                            {{--
                            @if(isset($courseArr) && is_array($courseArr) && !empty($courseArr))
                            --}}
                            @if(isset($courseArr) && isNotEmptyArray($courseArr))
                                <p class="text-base">You have purched following courses</p>
                                <ul class="list-disc ml-10">
                                    @foreach($courseArr as $course)
                                        <li><a href="{{route('courses.show', $course['slug'])}}" class="text-blue-500">{{$course['name']}}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                            <br>
                        </div>

                        <p class="mb-2 text-base text-center">Details about your order will be sent to you through email.</p>
                        <br>
                        <hr>

                        <div class="content centered mt-12">
                            <h1 class="font-semibold mb-2 text-xl text-center">What do you want to do next?</h1>
                            <div class="flex mt-5 justify-center">
                                <div class="mr-5">
                                    <a href="{{route('home')}}" title="" class="btn bg-blue-500 hover:bg-blue-600 font-semibold px-5 py-2 hover:text-white rounded-md text-center text-white w-full">Continue shopping</a>
                                </div>
                                <div class="mr-5">
                                    <a href="{{route('enrolled-courses')}}" title="" class="btn bg-green-500 hover:bg-green-600 font-semibold px-5 py-2 hover:text-white rounded-md text-center text-white w-full">Enrolled courses</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>
@stop


@section('javascript')
    <script>
        /*window.history.pushState(null, "", window.location.href);
        window.onpopstate = function () {
            window.history.pushState(null, "", window.location.href);
        };*/


        history.pushState(null, document.title, location.href);
        window.addEventListener('popstate', function (event){
            history.pushState(null, document.title, location.href);
        });
    </script>
@stop
