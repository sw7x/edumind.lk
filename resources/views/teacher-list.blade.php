@extends('layouts.master')
@section('title','Teacher profile')


@section('content')


    <div class="main-container container">
        <div class="lg:flex lg:space-x-10 mt-8 mb-4">


            <div class="w-full">

                <div class="my-2 flex items-center justify-between pb-2">
                    <div><h2 class="text-xl font-semibold">Teachers List</h2></div>
                </div>
                
                @if(Session::has('message'))
                    <x-flash-message  
                        :class="Session::get('cls', 'flash-info')"  
                        :title="Session::get('msgTitle') ?? 'Info!'" 
                        :message="Session::get('message') ?? ''"  
                        :message2="Session::get('message2') ?? ''"  
                        :canClose="true" />
                @endif

                @if(isset($teachers))

                    @if(!empty($teachers))
                        <div class="_space-y-7 mt-6 flex flex-row justify-between flex-wrap">     
                            @forelse ($teachers as $teacher)                        
                                <div class="relative p-3 bg-white shadow rounded-md flex items-center space-x-3 mb-10 teacher-card">
                                    <a href="{{route('teachers.show',$teacher['username'])}}" class="profile-image rounded-lg shadow-md">
                                        <img src="{{$teacher['profilePic']}}" class="w-40 h-48  __-mt-7" alt="">
                                    </a>

                                    <div class="flex-1">
                                        <div class="font-semibold">
                                            <a href="{{route('teachers.show',$teacher['username'])}}">{{$teacher['fullName']}}</a>
                                        </div>

                                        <hr class="my-2">
                                        {{--<div class="text-sm"><strong>Subjects</strong>: Science, Maths, Ai</div>--}}
                                        <div class="text-sm">                                        
                                            <strong>No of courses</strong>: {{$teacher['courseCount']}} Course{{ $teacher['courseCount'] == 1 ? "" : "s" }}
                                        </div>
                                        <hr class="my-2">

                                        <div>
                                            <p class="mb-0"><strong>Email</strong>: {{$teacher['email']}}</p>
                                            <p class="mt-0"><strong>Phone</strong>: {{$teacher['phone']}}</p>
                                        </div>
                                    </div>

                                    <div class="absolute top-4 right-2 cursor-pointer">
                                        <a href="{{route('teachers.show',$teacher['username'])}}">
                                            <ion-icon class="text-4xl text-blue-400 hover:text-blue-700" name="link"></ion-icon>
                                        </a>
                                    </div>
                                </div>                                                
                            @endforeach    
                        </div>                        
                        <!-- Pagination -->
                        <div class="nr-pagination-wrapper flex justify-center mt-9 space-x-2 font-semibold items-center">
                            <ul class="pagination">
                                <!-- <li><a href="#" class="prev font-bold">< Prev</a></li> -->
                                <li>
                                    <a class="flex w-10 h-10 mr-1 justify-center items-center rounded-full border border-gray-200 bg-white text-black hover:border-gray-300" href="#" title="Previous Page">
                                        <svg class="block w-4 h-4 fill-current" viewBox="0 0 256 512" aria-hidden="true" role="presentation">
                                            <path d="M238.475 475.535l7.071-7.07c4.686-4.686 4.686-12.284 0-16.971L50.053 256 245.546 60.506c4.686-4.686 4.686-12.284 0-16.971l-7.071-7.07c-4.686-4.686-12.284-4.686-16.97 0L10.454 247.515c-4.686 4.686-4.686 12.284 0 16.971l211.051 211.05c4.686 4.686 12.284 4.686 16.97-.001z"></path>
                                        </svg>
                                    </a>
                                </li>

                                <li class="pageNumber active"><a href="#">1</a></li>
                                <li class="pageNumber"><a href="#">2</a></li>
                                <li class="pageNumber"><a href="#">3</a></li>
                                <li class="pageNumber"><a href="#">4</a></li>
                                <li class="pageNumber"><a href="#">5</a></li>
                                <li class="pageNumber"><a href="#">6</a></li>
                                <!-- <li><a href="#" class="next font-bold">Next ></a></li> -->
                                <li>
                                    <a class="flex w-10 h-10 ml-1 justify-center items-center rounded-full border border-gray-200 bg-white text-black hover:border-gray-300" href="#" title="Next Page">
                                        <svg class="block w-4 h-4 fill-current" viewBox="0 0 256 512" aria-hidden="true" role="presentation">
                                            <path d="M17.525 36.465l-7.071 7.07c-4.686 4.686-4.686 12.284 0 16.971L205.947 256 10.454 451.494c-4.686 4.686-4.686 12.284 0 16.971l7.071 7.07c4.686 4.686 12.284 4.686 16.97 0l211.051-211.05c4.686-4.686 4.686-12.284 0-16.971L34.495 36.465c-4.686-4.687-12.284-4.687-16.97 0z"></path>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @else
                        <x-flash-message  
                            class="flash-info"  
                            title="No teachers" 
                            message="There is no teachers to show"  
                            message2=""  
                            :canClose="false" />
                        
                    @endif
                    


                   


                    {{--<div class="relative p-3 bg-white shadow rounded-md flex items-center space-x-3 mb-10 teacher-card">
                        <a href="#" class="profile-image rounded-lg shadow-md">
                            <img src="{{asset('images/book/book1.jpg')}}" class="w-40 h-48  __-mt-7 " alt="">
                        </a>

                        <div class="flex-1">
                            <div class="font-semibold"><a href="">Frank Kane</a></div>
                            <div class="text-sm">28 Courses</div>
                            <hr class="my-2">
                                <div class="text-sm"><strong>Subjects</strong>: Science, Maths, Ai</div>
                            <hr class="my-2">
                            <div>
                                <p class="mb-0"><strong>Email</strong>: mante.lauriane@example.com</p>
                                <p class="mt-0"><strong>Phone</strong>: (937) 637-3007</p>
                            </div>
                        </div>

                        <div class="absolute top-4 right-2 cursor-pointer">
                            <a href="#">
                                <ion-icon class="text-4xl text-blue-400 hover:text-blue-700" name="link"></ion-icon>
                            </a>
                        </div>
                    </div>

                    <div class="relative p-3 bg-white shadow rounded-md flex items-center space-x-3 mb-10 teacher-card">
                        <a href="#" class="profile-image rounded-lg shadow-md">
                            <img src="{{asset('images/book/book2.jpg')}}" class="w-40 h-48  __-mt-7 " alt="">
                        </a>

                        <div class="flex-1">
                            <div class="font-semibold"><a href="">John smith</a></div>
                            <div class="text-sm">21 Courses</div>
                            <hr class="my-2">
                            <div class="text-sm"><strong>Subjects</strong>: Science, Maths, Ai</div>
                            <hr class="my-2">
                            <div>
                                <p class="mb-0"><strong>Email</strong>: mante.lauriane@example.com</p>
                                <p class="mt-0"><strong>Phone</strong>: (937) 637-3007</p>
                            </div>
                        </div>

                        <div class="absolute top-4 right-2 cursor-pointer">
                            <a href="#">
                                <ion-icon class="text-4xl text-blue-400 hover:text-blue-700" name="link"></ion-icon>
                            </a>
                        </div>
                    </div>

                    <div class="relative p-3 bg-white shadow rounded-md flex items-center space-x-3 mb-10 teacher-card">
                        <a href="#" class="profile-image rounded-lg shadow-md">
                            <img src="{{asset('images/book/book3.jpg')}}" class="w-40 h-48  __-mt-7 " alt="">
                        </a>

                        <div class="flex-1">
                            <div class="font-semibold"><a href="">John doe</a></div>
                            <div class="text-sm">12 Courses</div>
                            <hr class="my-2">
                            <div class="text-sm"><strong>Subjects</strong>: Science, Maths, Ai</div>
                            <hr class="my-2">
                            <div>
                                <p class="mb-0"><strong>Email</strong>: mante.lauriane@example.com</p>
                                <p class="mt-0"><strong>Phone</strong>: (937) 637-3007</p>
                            </div>
                        </div>

                        <div class="absolute top-4 right-2 cursor-pointer">
                            <a href="#">
                                <ion-icon class="text-4xl text-blue-400 hover:text-blue-700" name="link"></ion-icon>
                            </a>
                        </div>
                    </div>

                    <div class="relative p-3 bg-white shadow rounded-md flex items-center space-x-3 mb-10 teacher-card">
                        <a href="#" class="profile-image rounded-lg shadow-md">
                            <img src="{{asset('images/book/book4.jpg')}}" class="w-40 h-48  __-mt-7 " alt="">
                        </a>

                        <div class="flex-1">
                            <div class="font-semibold"><a href="">Miguel Estevez</a></div>
                            <div class="text-sm">2 Courses</div>
                            <hr class="my-2">
                            <div class="text-sm"><strong>Subjects</strong>: Science, Maths, Ai</div>
                            <hr class="my-2">
                            <div>
                                <p class="mb-0"><strong>Email</strong>: mante.lauriane@example.com</p>
                                <p class="mt-0"><strong>Phone</strong>: (937) 637-3007</p>
                            </div>
                        </div>

                        <div class="absolute top-4 right-2 cursor-pointer">
                            <a href="#">
                                <ion-icon class="text-4xl text-blue-400 hover:text-blue-700" name="link"></ion-icon>
                            </a>
                        </div>
                    </div>--}}
                                        
                @else
                    <x-flash-message  
                        class="flash-danger"  
                        title="Data not available" 
                        message="No Data available to show"  
                        message2=""  
                        :canClose="false" />                    
                @endif

            </div>
        </div>
    </div>

@stop
