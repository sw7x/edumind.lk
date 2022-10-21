@extends('layouts.master')
@section('title','Help page')




@section('content')
            <div class="main-container container m-auto px-4">

                <div class="lg:flex justify-between items-center">
                    <div class="lg:w-6/12 md:text-left text-center">

                       <div class="md:text-3xl text-xl font-semibold mb-7"> How can we help? </div>

                       <form class="js-focus-state input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="askQuestions">
                            <span class="fas fa-search"></span>
                          </span>
                        </div>

                        <div class="input-with-icon border rounded-md">
                            <i class="uil-search"></i>
                            <input type="text" class="input-text" placeholder="Search the knowledge base...">
                        </div>
                       </form>

                       <p class="text-sm">
                           Popular help topics:
                           <a class="text-gray-400" href="#">pricing,</a>
                           <a class="text-gray-400" href="#">upgrade,</a>
                           <a class="text-gray-400" href="#">ebook,</a>
                           <a class="text-gray-400" href="#">membership</a>
                       </p>


                     </div>
                     <div class="lg:w-5/12 order-2 md:block hidden">
                       <img src="{{asset('images/help.png')}}" alt="">
                     </div>
                </div>



                <div class="-mt-2 lg:block hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1600 220" class="text-white fill-current">
                      <path d="M918.34,99.41C388.23,343.6,47.11,117.12,0,87.54V220H1600V87.54C1378.72-76.71,1077.32,27.41,918.34,99.41Z">
                      </path>
                    </svg>
                </div>


                <div class="bg-white lg:py-10 py-8">
                    <div class="container m-auto px-6 lg:-mt-44">

                        <div class="grid lg:grid-cols-2 gap-6">

                            <!--  card 1 -->
                            <div class="p-8 lg:flex items-start rounded-lg bg-white shadow-sm border hover:shadow-lg">
                                <img src="{{asset('images/icons/help-icon-1.png')}}" alt="" class="lg:w-24 lg:h-14 w-10 h-10 mb-2 object-cover">
                                <div class="space-y-3 lg:ml-4">
                                    <h1 class="text-xl font-semibold  text-blue-600"> Getting started </h1>
                                    <p class="text-gray-600">Welcome to Courseplus! We're so glad you're here. Let's get started! </p>
                                    <div class="flex mt-2 space-x-2">
                                        <div class="flex items-center -space-x-2 -mt-1">
                                            <img alt="Image placeholder" src="{{asset('images/avatars/avatar-1.jpg')}}"
                                                class="border-2 border-white rounded-full w-8">
                                            <img alt="Image placeholder" src="{{asset('images/avatars/avatar-2.jpg')}}"
                                                class="border-2 border-white rounded-full w-8">
                                        </div>
                                        <div class="flex-1 leading-5 text-sm space-y-1">
                                            <span>Written by</span>
                                            <span class="font-semibold">Fiona Burke </span>, <span class="font-semibold">Luisa Woodfine</span>
                                            <span class="font-semibold">and</span>
                                            <span class="font-semibold"> Neil Galavan </span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!--  card 2 -->
                            <div class="p-8 lg:flex items-start rounded-lg bg-white shadow-sm border hover:shadow-lg">
                                <img src="{{asset('images/icons/help-icon-2.png')}}" alt="" class="lg:w-24 lg:h-14 w-10 h-10 mb-2 object-cover">
                                <div class="space-y-3 lg:ml-4">
                                    <h1 class="text-xl font-semibold  text-blue-600"> Account </h1>
                                    <p class="text-gray-500">Adjust your profile and preferences to make Courseplus work just for you! </p>
                                    <div class="flex mt-2 space-x-2">
                                        <div class="flex items-center -space-x-2 -mt-1">
                                            <img alt="Image placeholder" src="{{asset('images/avatars/avatar-3.jpg')}}"
                                                class="border-2 border-white rounded-full w-8">
                                            <img alt="Image placeholder" src="{{asset('images/avatars/avatar-5.jpg')}}"
                                                class="border-2 border-white rounded-full w-8">
                                        </div>
                                        <div class="flex-1 leading-5 text-sm space-y-1">
                                            <span>Written by</span>
                                            <span class="font-semibold">Fiona Burke </span>, <span class="font-semibold">Luisa Woodfine</span>
                                            <span class="font-semibold">and</span>
                                            <span class="font-semibold"> Neil Galavan </span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!--  card 3 -->
                            <div class="p-8 lg:flex items-start rounded-lg bg-white shadow-sm border hover:shadow-lg">
                                <img src="{{asset('images/icons/help-icon-4.png')}}" alt="" class="lg:w-24 lg:h-14 w-10 h-10 mb-2 object-cover">
                                <div class="space-y-3 lg:ml-4">
                                    <h1 class="text-xl font-semibold  text-blue-600"> Market </h1>
                                    <p class="text-gray-500">Detailed information on how our customer data is securely stored. </p>
                                    <div class="flex mt-2 space-x-2">
                                        <div class="flex items-center -space-x-2 -mt-1">
                                            <img alt="Image placeholder" src="{{asset('images/avatars/avatar-3.jpg')}}"
                                                class="border-2 border-white rounded-full w-8">
                                            <img alt="Image placeholder" src="{{asset('images/avatars/avatar-5.jpg')}}"
                                                class="border-2 border-white rounded-full w-8">
                                        </div>
                                        <div class="flex-1 leading-5 text-sm space-y-1">
                                            <span>Written by</span>
                                            <span class="font-semibold">Fiona Burke </span>, <span class="font-semibold">Luisa Woodfine</span>
                                            <span class="font-semibold">and</span>
                                            <span class="font-semibold"> Neil Galavan </span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!--  card 4 -->
                            <div class="p-8 lg:flex items-start rounded-lg bg-white shadow-sm border hover:shadow-lg">
                                <img src="{{asset('images/icons/help-icon-3.png')}}" alt="" class="lg:w-24 lg:h-14 w-10 h-10 mb-2 object-cover">
                                <div class="space-y-3 lg:ml-4">
                                    <h1 class="text-xl font-semibold  text-blue-600"> Data security </h1>
                                    <p class="text-gray-500">Some further explanation on when Courseplus can and cannot be used.</p>
                                    <div class="flex mt-2 space-x-2">
                                        <div class="flex items-center -space-x-2 -mt-1">
                                            <img alt="Image placeholder" src="{{asset('images/avatars/avatar-3.jpg')}}"
                                                class="border-2 border-white rounded-full w-8">
                                            <img alt="Image placeholder" src="{{asset('images/avatars/avatar-5.jpg')}}"
                                                class="border-2 border-white rounded-full w-8">
                                        </div>
                                        <div class="flex-1 leading-5 text-sm space-y-1">
                                            <span>Written by</span>
                                            <span class="font-semibold">Fiona Burke </span>, <span class="font-semibold">Luisa Woodfine</span>
                                            <span class="font-semibold">and</span>
                                            <span class="font-semibold"> Neil Galavan </span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!--  card 5 -->
                            <div class="p-8 lg:flex items-start rounded-lg bg-white shadow-sm border hover:shadow-lg">
                                <img src="{{asset('images/icons/help-icon-5.png')}}" alt="" class="lg:w-24 lg:h-14 w-10 h-10 mb-2 object-cover">
                                <div class="space-y-3 lg:ml-4">
                                    <h1 class="text-xl font-semibold  text-blue-600"> Subscription </h1>
                                    <p class="text-gray-500">Assistance on how and when you might use the subscription product. </p>
                                    <div class="flex mt-2 space-x-2">
                                        <div class="flex items-center -space-x-2 -mt-1">
                                            <img alt="Image placeholder" src="{{asset('images/avatars/avatar-3.jpg')}}"
                                                class="border-2 border-white rounded-full w-8">
                                            <img alt="Image placeholder" src="{{asset('images/avatars/avatar-5.jpg')}}"
                                                class="border-2 border-white rounded-full w-8">
                                        </div>
                                        <div class="flex-1 leading-5 text-sm space-y-1">
                                            <span>Written by</span>
                                            <span class="font-semibold">Fiona Burke </span>, <span class="font-semibold">Luisa Woodfine</span>
                                            <span class="font-semibold">and</span>
                                            <span class="font-semibold"> Neil Galavan </span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!--  card 6 -->
                            <div class="p-8 lg:flex items-start rounded-lg bg-white shadow-sm border hover:shadow-lg">
                                <img src="{{asset('images/icons/help-icon-6.png')}}" alt="" class="lg:w-24 lg:h-14 w-10 h-10 mb-2 object-cover">
                                <div class="space-y-3 lg:ml-4">
                                    <h1 class="text-xl font-semibold  text-blue-600">Tips, tricks & more </h1>
                                    <p class="text-gray-500">Tips and tools for beginners and experts alike. </p>
                                    <div class="flex mt-2 space-x-2">
                                        <div class="flex items-center -space-x-2 -mt-1">
                                            <img alt="Image placeholder" src="{{asset('images/avatars/avatar-3.jpg')}}"
                                                class="border-2 border-white rounded-full w-8">
                                            <img alt="Image placeholder" src="{{asset('images/avatars/avatar-5.jpg')}}"
                                                class="border-2 border-white rounded-full w-8">
                                        </div>
                                        <div class="flex-1 leading-5 text-sm space-y-1">
                                            <span>Written by</span>
                                            <span class="font-semibold">Fiona Burke </span>, <span class="font-semibold">Luisa Woodfine</span>
                                            <span class="font-semibold">and</span>
                                            <span class="font-semibold"> Neil Galavan </span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>


@stop
