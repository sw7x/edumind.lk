@extends('layouts.master')
@section('title','404 Page Not Found')




@section('content')
    <div class="main-container container">
        <div class="max-w-5xl md:p-5 mx-auto">
            <div class="plg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-8 p-3">
                <div class="">

                    <div>
                        <h2 class="font-semibold mb-3 text-xl lg:text-3xl">404 Page Not Found</h2>
                        <hr class="mb-5">
                        <!-- <h4 class="font-semibold mb-2 text-base"> 404 page </h4> -->

                        <div class="content centered">
                         	<img style="width:500px;" class="m-auto mb-3" src="{{asset('images/errors/404.svg')}}">
                            @php
                                //dump($errMsg);
                            @endphp
                            
                            @if(isset($errMsg) && $errMsg)
                                <h1 class="text-center font-semibold mb-2 text-xl">{{$errMsg}}</h1>
                            @else
                                <h1 class="text-center font-semibold mb-2 text-xl">Oops, looks like the page is lost.</h1>
                            @endif

							<div class="flex mt-5 justify-center">
								<div class="mr-5">
									<a href="{{url()->previous()}}" title="" class="btn bg-blue-500 hover:bg-blue-700 font-semibold p-2.5 hover:text-white rounded-md text-center text-white w-full">Go Back</a>
								</div>
								<div class="mr-5">
									<a href="{{route('home')}}" title="" class="btn bg-green-500 hover:bg-green-600 font-semibold p-2.5 hover:text-white rounded-md text-center text-white w-full">Go to Home</a>
								</div>
								@if(Sentinel::check() && (Sentinel::getUser()->roles()->first()->slug != App\Models\Role::STUDENT))
									<div>
										<a href="{{route('admin.dashboard')}}" title="" class="btn bg-red-500 hover:bg-red-600 font-semibold p-2.5 hover:text-white rounded-md text-center text-white w-full">Admin Panel</a>
									</div>
								@endif
							</div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@stop