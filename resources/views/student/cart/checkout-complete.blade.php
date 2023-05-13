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
                        
                        <div class="w-5/12 mx-auto">                            
                            <div class="flex justify-center">
                                <ion-icon name="checkmark-circle-outline" class="text-9xl text-center text-green-500 course-status" title="Enrolled"></ion-icon>
                            </div> 
                            <br>

                            <p class="mb-2 text-base __text-center">Thank you for your purchase</p>
                            
                            @isset($invoiceId)
                                <p class="mb-2 text-base __text-center">Your Invoice code : {{$invoiceId}}</p>
                            @endisset
                            
                            <p class="text-base">Your Billing information</p>
                            <ul class="list-disc ml-10">
                                <li>Full name - Evans Frank Ghosh Hills Irwin Jones</li>
                                <li>Country / Region - America</li>
                                <li>Town / City - Newyork</li>    
                                <li>Street Address  - 106, Jorg Avenu</li>
                                <li>Postcode / ZIP - 20678</li>    
                                <li>Phone - (123) 601-4590</li>
                                <li>Email address - johnsmith123@gmail.com</li>    
                                <li>Additional information (optional) - </li>    
                            </ul>  
                            <br>

                            @if(isset($courses) && is_array($courses) && !empty($courses))
                                <p class="text-base">You have purched following courses</p>
                                <ul class="list-disc ml-10">
                                    @foreach($courses as $course)
                                        <li><a href="{{$course['url']}}" class="text-blue-500">{{$course['name']}}</a></li>
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
                                        <a href="{{route('student.my-courses')}}" title="" class="btn bg-green-500 hover:bg-green-600 font-semibold px-5 py-2 hover:text-white rounded-md text-center text-white w-full">My courses</a>
                                    </div>
                                </div>
                            </div>
                        
                        




                    </div>

                </div>
            </div>

            
        </div>
    </div>

@stop
