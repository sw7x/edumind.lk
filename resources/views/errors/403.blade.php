<?php $page = ''; ?>
@include('includes.header')
<!--         <header  uk-sticky>
            <div class="header_inner">
                <div class="left-side"> -->

    <div class="main-container container">
        <div class="max-w-5xl md:p-5 mx-auto">
            <div class="lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-8 p-3">
                <div class="">

                    <div>
                        <h2 class="font-semibold mb-3 text-xl lg:text-3xl">Access Denied 403</h2>
                        <hr class="mb-5">
                        <h4 class="font-semibold mb-2 text-base"> 403 page </h4>

                        <div class="content centered">
                         	<img class="align-center" style="width:500px;" src="{{asset('images/access-denied.png')}}">
                            <h1 class="font-semibold mb-2 text-xl">It appears you don't have permission to access this page.</h1>

                            <div class="flex mt-5">
                                <div class="mr-5">
                                    <a href="{{url()->previous()}}" title="" class="btn bg-blue-500 hover:bg-blue-700 font-semibold p-2.5 hover:text-white rounded-md text-center text-white w-full">Go Back</a>
                                </div>
                                <div class="mr-5">
                                    <a href="{{route('home')}}" title="" class="btn bg-green-500 hover:bg-green-600 font-semibold p-2.5 hover:text-white rounded-md text-center text-white w-full">Go to Home</a>
                                </div>
								@if(Sentinel::check() && (Sentinel::getUser()->roles()->first()->slug != 'student'))
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

@include('includes.footer')
