@extends('layouts.master')
@section('title','Error')




@section('content')
    <div class="main-container container">
        <div class="max-w-5xl md:p-5 mx-auto">
            <div class="---lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-8 p-3">
                <div class="">

                    <div>
                        <h2 class="font-semibold mb-3 text-xl lg:text-3xl">Invalid User Type Page</h2>
                        <hr class="mb-5">
                        <!-- <h4 class="font-semibold mb-2 text-base"> 403 page </h4> -->
                                              
                        <div class="content centered">
                         	<img class="align-center m-auto mb-10" style="width:250px;" src="{{asset('images/errors/invalid-user-type.png')}}">
                            
                            @if(isset($errMsg) && $errMsg)
                                <h1 class="font-semibold mb-2 text-xl text-center">{{$errMsg}}</h1>                                
                            @else
                                <h1 class="font-semibold mb-2 text-xl text-center">Your user role is not valid for this platform. Please log out and log in with a valid user role.</h1>
                            @endif
                                                        
                            <div class="flex mt-5 justify-center">
                                @if(Sentinel::check())
                                    <div class="mr-5">
                                        <form action="{{route('auth.logout')}}" method="post" class='logout-form'>
                                            {{csrf_field ()}}
                                            <a href="" class="btn bg-red-500 hover:bg-red-600 font-semibold p-2.5 hover:text-white rounded-md text-center text-white w-full">
                                                <ion-icon name="log-out" class="is-icon" ></ion-icon>Log Out</a>
                                        </form>
                                    </div>
                                @endif 

                                <div class="ml-5 mr-5">
                                    <a href="{{url()->previous()}}" title="" class="btn bg-blue-500 hover:bg-blue-700 font-semibold p-2.5 hover:text-white rounded-md text-center text-white w-full">Go Back</a>
                                </div>

                                <div class="ml-5 mr-5">
                                    <a href="{{route('home')}}" title="" class="btn bg-green-500 hover:bg-green-600 font-semibold p-2.5 hover:text-white rounded-md text-center text-white w-full">Go to Home</a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
