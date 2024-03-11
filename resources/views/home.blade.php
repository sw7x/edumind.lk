@php
    $page = 'home';
@endphp


@extends('layouts.master')
@section('title','Home')




@section('content')
    <!-- Slideshow -->
    <div class="uk-position-relative uk-visible-toggle overflow-hidden mb-8 lg:-mt-20" tabindex="-1" uk-slideshow="animation: scale ;min-height: 200; max-height: 500 ;autoplay: false">

        <ul class="uk-slideshow-items rounded">
            <li>
                <div class="uk-position-cover" uk-slideshow-parallax="scale: 1.2,1.2,1">
                    <img src="{{asset('images/hero-3.png')}}" class="object-cover" alt="" uk-cover>
                </div>
                <div class="container relative p-20 lg:mt-12 h-full">
                    <div uk-slideshow-parallax="scale: 1,1,0.8" class="flex flex-col justify-center h-full w-full space-y-3">

                        <h1 uk-slideshow-parallax="y: 100,0,0" class="lg:text-4xl text-2xl text-white font-semibold">Learn from the best - Edumind.lk</h1>
                        {{--<p uk-slideshow-parallax="y: 150,0,0" class="text-base text-white font-medium pb-1 lg:w-1/2"> Choose from 130,000 online video courses with new additions published every month </p>--}}
                        <!-- <a uk-slideshow-parallax="y: 200,0,50" href="#" class="bg-opacity-90 bg-white py-2.5 rounded-md text-base text-center w-32"> Get Started </a>  -->

                        <div class="main-search-bar wrapper">
                            <!-- <div class="label">Learn how to create an animated search form with CSS.</div> -->
                            <div class="searchBar">
                                <form>
                                    <!-- todo - ajax search
                                    <input id="searchQueryInput" type="text" name="searchQueryInput" placeholder="Search for anything" value="" />
                                    <button id="searchQuerySubmit" type="submit" name="searchQuerySubmit">
                                        <svg style="" viewBox="0 0 24 24">
                                            <path fill="#666666" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                                        </svg>
                                    </button>
                                    -->
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </li>

            <li>
                <div class="uk-position-cover" uk-slideshow-parallax="scale: 1.2,1.2,1">
                    <img src="{{asset('images/hero-4.png')}}" class="object-cover" alt="" uk-cover>
                </div>
                <div class="container relative p-20 lg:mt-12 h-full">
                    <div uk-slideshow-parallax="scale: 1,1,0.8" class="flex flex-col justify-center h-full w-full space-y-3">
                        <h1 uk-slideshow-parallax="y: 100,0,0" class="lg:text-4xl text-2xl text-white font-semibold">Learning never exhausts the mind.</h1>
                        {{--<p uk-slideshow-parallax="y: 150,0,0" class="text-base text-white font-medium pb-4 lg:w-1/2"> Choose from 130,000 online video courses with new additions published every month </p>--}}

                        <div class="main-search-bar wrapper">
                            <!-- <div class="label">Learn how to create an animated search form with CSS.</div> -->
                            <div class="searchBar">
                                <form>
                                    <!-- todo - ajax search
                                    <input id="searchQueryInput" type="text" name="searchQueryInput" placeholder="Search for anything" value="" />
                                    <button id="searchQuerySubmit" type="submit" name="searchQuerySubmit">
                                        <svg style="" viewBox="0 0 24 24">
                                            <path fill="#666666" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                                        </svg>
                                    </button>
                                    -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            <li>
                <div class="uk-position-cover" uk-slideshow-parallax="scale: 1.2,1.2,1">
                    <img src="{{asset('images/hero-5.png')}}" class="object-cover" alt="" uk-cover>
                </div>
                <div class="container relative p-20 lg:mt-12 h-full">
                    <div uk-slideshow-parallax="scale: 1,1,0.8" class="flex flex-col justify-center h-full w-full space-y-3">
                        <h1 uk-slideshow-parallax="y: 100,0,0" class="lg:text-4xl text-2xl text-white font-semibold">The doer alone learneth.</h1>
                        {{--<p uk-slideshow-parallax="y: 150,0,0" class="text-base text-white font-medium pb-4 lg:w-1/2"> Choose from 130,000 online video courses with new additions published every month </p>--}}

                        <div class="main-search-bar wrapper">
                            <!-- <div class="label">Learn how to create an animated search form with CSS.</div> -->
                            <div class="searchBar">
                                <form>
                                    <!-- todo - ajax search
                                    <input id="searchQueryInput" type="text" name="searchQueryInput" placeholder="Search for anything" value="" />
                                    <button id="searchQuerySubmit" type="submit" name="searchQuerySubmit">
                                        <svg style="" viewBox="0 0 24 24">
                                            <path fill="#666666" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                                        </svg>
                                    </button>
                                    -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>

        <a class="uk-position-center-left-out uk-position-small uk-hidden-hover slidenav-prev" href="#" uk-slideshow-item="previous"></a>
        <a class="uk-position-center-right-out uk-position-small uk-hidden-hover slidenav-next" href="#" uk-slideshow-item="next"></a>

    </div>




    <div class="main-container container mx-auto max-w-5xl __p-4">
        @if(Session::has('message'))
            <x-flash-message
                :class="Session::get('cls', 'flash-info')"
                :title="Session::get('msgTitle') ?? 'Info!'"
                :message="Session::get('message') ?? ''"
                :message2="Session::get('message2') ?? ''"
                :canClose="true" />
        @endif





        @php
            //var_dump ($popular_courses);
        @endphp

        @if(isset($popular_courses) && isNotEmptyArray($popular_courses))
            <!--  Popular Courses  feature section -->
            <div class="sm:my-4 my-3 flex items-end justify-between pt-3">
                <h2 class="text-2xl font-semibold">Popular Courses</h2>
            </div>

            @foreach ($popular_courses as $course)
                <a href="{{route('courses.show',$course['slug'])}}" class="uk-link-reset">
                    <div class="horizontal-course-item bg-white md:flex shadow-sm rounded-lg uk-transition-toggle mb-5">
                        <div class="md:w-5/12 md:h-60 h-40 overflow-hidden rounded-l-lg relative">
                            <img src="{{$course['image']}}" class="w-full h-full absolute inset-0 object-cover" alt="">
                        </div>
                        <div class="flex-1 md:p-6 p-4">
                            <div class="font-semibold line-clamp-2 md:text-xl md:leading-relaxed">{{$course['name']}}</div>
                            <div class="line-clamp-2 mt-2 md:block hidden">{{$course['headingText']}}</div>
                            <div class="font-semibold mt-3">{{$course['teacherName']}}</div>

                            <div class="items-center mt-2">
                                <div class="lg:flex __space-x-2 items-center text-sm justify-between">
                                    <div class="md:flex">
                                        <div class="font-semibold mt-3 lg:mt-0 lg:mr-3 md:mt-2 md:mr-4"><span class="">
                                                <i class="align-middle icon-feather-youtube mr-1" style="font-size: 1.20rem;"></i> {{$course['videoCount']}} lectures</span>
                                        </div>

                                        <div class="font-semibold mt-3 lg:mt-0 lg:mr-3 md:mt-2">
                                            <span class=""><i class="align-middle icon icon-feather-clock mr-1" style="font-size: 1.20rem;"></i>{{$course['duration']}}</span>
                                        </div>
                                    </div>
                                    {{--
                                    <div class="flex items-center space-x-1 text-yellow-500 md:ml-5 mt-3 lg:mt-0 lg:mr-3 md:mt-2">
                                        <ul class="flex text-gray-300 gap-4">
                                            <li class="flex items-center">
                                                <span class="avg bg-yellow-500 mr-2 px-2 rounded text-white font-semiold"> 4.9 </span>
                                                <div class="star-rating text-yellow-300">
                                                    <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                    <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                    <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                    <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                    <ion-icon name="star-half" role="img" class="md hydrated" aria-label="star half"></ion-icon>
                                                </div>
                                                <span>(1,873 ratings)</span>
                                            </li>
                                        </ul>
                                    </div>
                                    --}}
                                </div>
                                @if(isset($course['price']))
                                    <div class="text-lg font-semibold mt-3">{{ $course['price'] == 0 ? "Free" : 'Rs '.$course['price'] }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach

            <hr class="mb-5">
        @endif





        <!--  course feature -->
        {{--
        <div class="sm:my-4 my-3 flex items-end justify-between pt-3">
            <h2 class="text-2xl font-semibold">Top courses</h2>
        </div>

        <div class="relative -mt-3" uk-slider="finite: true">
           <div class="uk-slider-container px-1 py-3">
               <ul class="uk-slider-items uk-child-width-1-1@m uk-grid">
                    <li>
                        <div class="bg-white shadow-sm rounded-lg uk-transition-toggle md:flex">
                            <div class="md:w-5/12 md:h-60 h-40 overflow-hidden rounded-l-lg relative">
                                <img src="{{asset('images/courses/img-6.jpg')}}" alt="" class="w-full h-full absolute inset-0 object-cover">
                                <img src="{{asset('images/icon-play.svg')}}" class="w-16 h-16 uk-position-center uk-transition-fade" alt="">
                            </div>
                            <div class="flex-1 md:p-6 p-4">
                                <div class="font-semibold line-clamp-2 md:text-xl md:leading-relaxed">Learn How to Build Responsive Web Design Essentials HTML5 CSS3 and Bootstrap </div>
                                <div class="line-clamp-2 mt-2 md:block hidden">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam</div>
                                <div class="font-semibold mt-3"> John Michael </div>
                                <div class="mt-1 flex items-center justify-between">
                                    <div class="flex space-x-2 items-center text-sm pt-2">
                                       <div> 13 hours </div>
                                       <div>·</div>
                                       <div> 32 lectures </div>
                                   </div>
                                   <div class="text-lg font-semibold"> $14.99 </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li>
                       <div class="bg-white shadow-sm rounded-lg uk-transition-toggle md:flex">
                           <div class="md:w-5/12 md:h-60 h-40 overflow-hidden rounded-l-lg relative">
                               <img src="{{asset('images/courses/img-1.jpg')}}" alt="" class="w-full h-full absolute inset-0 object-cover">
                               <img src="{{asset('images/icon-play.svg')}}" class="w-16 h-16 uk-position-center uk-transition-fade" alt="">
                           </div>
                           <div class="flex-1 md:p-6 p-4">
                               <div class="font-semibold line-clamp-2 md:text-xl md:leading-relaxed"> Learn JavaScript and Express to become a professional JavaScript developer. </div>
                               <div class="line-clamp-2 mt-2 md:block hidden">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam</div>
                               <div class="font-semibold mt-3"> John Michael </div>
                               <div class="mt-1 flex items-center justify-between">
                                   <div class="flex space-x-2 items-center text-sm pt-2">
                                       <div> 13 hours </div>
                                       <div>·</div>
                                       <div> 32 lectures </div>
                                   </div>
                                   <div class="text-lg font-semibold"> $14.99 </div>
                               </div>
                           </div>
                       </div>

                   </li>
               </ul>
            </div>

           <a class="absolute bg-white uk-position-center-left -ml-3 flex items-center justify-center p-2 rounded-full shadow-md text-xl w-11 h-11 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="previous"> <i class="icon-feather-chevron-left"></i></a>
           <a class="absolute bg-white uk-position-center-right -mr-3 flex items-center justify-center p-2 rounded-full shadow-md text-xl w-11 h-11 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="next"> <i class="icon-feather-chevron-right"></i></a>

        </div>
        <hr class="mb-5">
        --}}



        @php
            //var_dump ($new_courses);
        @endphp

        @if(isset($new_courses) && isNotEmptyArray($new_courses))
            <!--  slider courses -->
            <div class="sm:my-4 my-3 flex items-end justify-between pt-3">
                <h2 class="text-2xl font-semibold">New Courses</h2>
                <a href="{{route('courses.search')}}" class="text-blue-500 sm:block hidden"> Search Courses </a>
            </div>

            <div class="mt-3">
                <h4 class="py-3 border-b font-semibold text-grey-700  mx-1 mb-4" hidden> <ion-icon name="star"></ion-icon> Featured today </h4>

                <div class="relative" uk-slider="finite: true">
                    <div class="uk-slider-container px-1 py-3">
                        <ul class="uk-slider-items uk-child-width-1-4@m uk-child-width-1-2@s uk-grid-small uk-grid">
                            @foreach ($new_courses as $course)
                                <li>
                                    <a href="{{route('courses.show',$course['slug'])}}" class="uk-link-reset">
                                        <div class="bg-white shadow-sm rounded-lg uk-transition-toggle">
                                            <div class="w-full h-40 overflow-hidden rounded-t-lg relative">
                                                <img src="{{$course['image']}}" class="w-full h-full absolute inset-0 object-cover" alt="">
                                                <img src="{{asset('images/icon-play.svg')}}" class="w-12 h-12 uk-position-center uk-transition-fade" alt="">
                                            </div>
                                            <div class="p-4">
                                                <div class="font-semibold line-clamp-2">{{$course['name']}}</div>
                                                <div class="_flex _space-x-2 items-center text-sm pt-3">
                                                    <div>{{$course['duration']}}</div>
                                                    {{--<div>·</div>--}}
                                                    <div>{{$course['videoCount']}} lectures</div>
                                                </div>
                                                <div class="pt-1 _flex items-center justify-between">
                                                    
                                                    <div class="text-sm font-semibold">{!! $course['teacherName'] ?? '<span class="text-red-500">Author not available<span>' !!}</div>
                                                    
                                                    @if(isset($course['price']))
                                                        <div class="text-lg font-semibold">{{ $course['price'] == 0 ? "Free" : 'Rs '.$course['price'] }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                            {{--
                            <li>
                                <a href="course-intro.php" class="uk-link-reset">
                                    <div class="bg-white shadow-sm rounded-lg uk-transition-toggle">
                                        <div class="w-full h-40 overflow-hidden rounded-t-lg relative">
                                            <img src="{{asset('images/courses/img-1.jpg')}}" alt="" class="w-full h-full absolute inset-0 object-cover">
                                            <img src="{{asset('images/icon-play.svg')}}" class="w-12 h-12 uk-position-center uk-transition-fade" alt="">
                                        </div>
                                        <div class="p-4">
                                            <div class="font-semibold line-clamp-2"> Learn JavaScript and Express to become a professional
                                            JavaScript developer. </div>
                                            <div class="flex space-x-2 items-center text-sm pt-3">
                                                <div>  13 hours  </div>
                                                <div>·</div>
                                                <div> 32 lectures </div>
                                            </div>
                                            <div class="pt-1 flex items-center justify-between">
                                                <div class="text-sm font-semibold"> John Michael </div>
                                                <div class="text-lg font-semibold"> $14.99 </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            <li>
                                <a href="course-intro.php" class="uk-link-reset">
                                    <div class="bg-white shadow-sm rounded-lg uk-transition-toggle">
                                        <div class="w-full h-40 overflow-hidden rounded-t-lg relative">
                                            <img src="{{asset('images/courses/img-2.jpg')}}" alt="" class="w-full h-full absolute inset-0 object-cover">
                                            <img src="{{asset('images/icon-play.svg')}}" class="w-12 h-12 uk-position-center uk-transition-fade" alt="">
                                        </div>
                                        <div class="p-4">
                                            <div class="font-semibold line-clamp-2">Learn Angular Fundamentals From beginning to advance </div>
                                            <div class="flex space-x-2 items-center text-sm pt-3">
                                                <div>  26 hours  </div>
                                                <div>·</div>
                                                <div> 26 lectures </div>
                                            </div>
                                            <div class="pt-1 flex items-center justify-between">
                                                <div class="text-sm font-semibold"> Stella Johnson </div>
                                                <div class="text-lg font-semibold"> $18.99  </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>

                            --}}

                            @endforeach
                        </ul>

                        <a class="absolute bg-white top-1/4 flex items-center justify-center p-2 -left-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="previous"> <i class="icon-feather-chevron-left"></i></a>
                        <a class="absolute bg-white top-1/4 flex items-center justify-center p-2 -right-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="next"> <i class="icon-feather-chevron-right"></i></a>
                    </div>
                </div>
                <hr class="mb-5">
            </div>
        @endif






        @php
            //var_dump ($teachers);
        @endphp

        @if(isset($teachers) && isNotEmptyArray($teachers))
            <!--  Teachers  -->
            <div class="sm:my-4 my-3 flex items-end justify-between pt-3">
                <h2 class="text-2xl font-semibold">Teachers</h2>
                <a href="{{route('teachers.index')}}" class="text-blue-500 sm:block hidden"> See all </a>
            </div>

            <div class="relative" uk-slider="finite: true">
                <div class="uk-slider-container px-1 py-3">
                    <ul class="uk-slider-items uk-child-width-1-6@m uk-child-width-1-3@s uk-child-width-1-1 uk-grid-small uk-grid text-sm font-medium text-center">
                        @foreach ($teachers as $teacher)
                            <li>
                                <div class="relative overflow-hidden bg-white shadow-sm md:rounded-lg rounded-md">
                                    <a href="{{route('teachers.show',$teacher['username'])}}">
                                        <img src="{{$teacher['profilePic']}}" class="w-full h-52 object-cover" alt="">
                                        <div class="p-3 truncate">{{$teacher['fullName']}}</div>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <a class="absolute bg-white bottom-1/2 flex items-center justify-center p-2 -left-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white"
                      href="#" uk-slider-item="previous"> <i class="icon-feather-chevron-left"></i></a>
                    <a class="absolute bg-white bottom-1/2 flex items-center justify-center p-2 -right-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white"
                      href="#" uk-slider-item="next"> <i class="icon-feather-chevron-right"></i></a>
                </div>
            </div>
            <hr class="mb-5">
        @endif




        @php
            //dd($subject_info);
        @endphp

        @if(isset($subject_info) && isNotEmptyArray($subject_info))
            <!--  Subjects section  -->
            <div class="sm:my-4 my-3 flex items-end justify-between pt-3">
                <h2 class="text-2xl font-semibold">Top Subjects</h2>
                <a href="{{route('subjects.index')}}" class="text-blue-500 sm:block hidden"> See all </a>
            </div>

            <div class="grid lg:grid-cols-4 md:grid-cols-3 md:gap-4 grid-cols-1 gap-8 mt-3 mb-3">
                @forelse ($subject_info as $subject_Item)
                    <a href="{{route('subjects.show',$subject_Item['slug'])}}" class="rounded-md overflow-hidden relative w-full lg:h-56 h-40">
                        <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                        </div>
                        <img src="{{$subject_Item['image']}}" class="absolute w-full h-full object-cover" alt="">
                        {{--<img src="{{asset('images/category/design.jpg')}}" class="absolute w-full h-full object-cover" alt="">--}}
                        <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg">{{$subject_Item['name']}}</div>
                    </a>
                @empty

                @endforelse
            </div>
            <hr class="mb-5">
        @endif





        <!--  Help  section -->
        <div class="sm:my-4 my-3 flex items-end justify-between pt-3">
            <h2 class="text-2xl font-semibold">Help</h2>
            <!-- <a href="#" class="text-blue-500 sm:block hidden"> See all </a> -->
        </div>

        <div class="grid lg:grid-cols-2 gap-6">

            <!--  card 1 -->
            <div class="px-3 py-5 lg:flex items-start rounded-lg bg-white shadow-sm border hover:shadow-lg">
                <img src="{{asset('images/icons/help-icon-1.png')}}" alt="" class="lg:w-24 lg:h-14 w-10 h-10 mb-2 object-cover">
                <div class="space-y-3 lg:ml-4">
                    <h1 class="text-xl font-semibold  text-blue-600">EDUMIND අපි</h1>
                    <p class="text-blue-900 text-sm">මෙහිදී online class එකකට වඩා online courses මගින් ඉගැන්වීමෙන් සැලකිය යුතු වාසි රාශියක් ගුරුවරුන් හා සිසුන් යන දෙපිරිසටම හිමි වෙනු ඇත.... </p>
                    <a href="{{route('about-us')}}" class="text-blue-500 text-sm sm:block hidden"> See all </a>
                </div>
            </div>

            <!--  card 2 -->
            <div class="px-3 py-5 lg:flex items-start rounded-lg bg-white shadow-sm border hover:shadow-lg">
                <img src="{{asset('images/icons/help-icon-2.png')}}" alt="" class="lg:w-24 lg:h-14 w-10 h-10 mb-2 object-cover">
                <div class="space-y-3 lg:ml-4">
                    <h1 class="text-xl font-semibold  text-blue-600"> Getting started </h1>
                    <p class="text-blue-900 text-sm">ඔබට online courses නිර්මාණය කිරීමට කිසිඳු මූලික දැනුමක් නොමැති වුවත් Edumind සමග සම්බන්ධ වීමට හැකියාව ඇති බව අපි සතුටින් දැනුම් දෙන්නෙමු. ඒ සඳහා ...</p>
                    <a href="{{route('instructions')}}" class="text-blue-500 text-sm sm:block hidden"> See all </a>
                </div>
            </div>

            <!--  card 3 -->
            <div class="px-3 py-5 lg:flex items-start rounded-lg bg-white shadow-sm border hover:shadow-lg">
                <img src="{{asset('images/icons/help-icon-3.png')}}" alt="" class="lg:w-24 lg:h-14 w-10 h-10 mb-2 object-cover">
                <div class="space-y-3 lg:ml-4">
                    <h1 class="text-xl font-semibold  text-blue-600">ලබාගත හැකි ආදායම</h1>
                    <p class="text-blue-900 text-sm">Edumind වෙතින් ඔබට ලබාගත හැකි ආදායම් පිළිබඳව අදහසක් ලබාගැනීම පිණිස මෙම කොටස හොඳින් අධ්යයන කරන මෙන් අපි ...</p>
                    <a href="{{route('terms-and-services')}}" class="text-blue-500 text-sm sm:block hidden"> See all </a>
                </div>
            </div>

            <!--  card 4 -->
            <div class="px-3 py-5 lg:flex items-start rounded-lg bg-white shadow-sm border hover:shadow-lg">
                <img src="{{asset('images/icons/help-icon-4.png')}}" alt="" class="lg:w-24 lg:h-14 w-10 h-10 mb-2 object-cover">
                <div class="space-y-3 lg:ml-4">
                    <h1 class="text-xl font-semibold  text-blue-600">ප්රතිලාභ</h1>
                    <p class="text-blue-900 text-sm">ඔබ සාම්ප්රදායික tution ගුරුවරයෙක් නම් ඔබේ ශිෂ්යයන් හා සම්බන්ධ වීමේ හැකියාව සිමිත විය හැකිය. ඊට ප්රධාන හේතුව වන්නේ..</p>
                    <a href="{{route('why-choose-us')}}" class="text-blue-500 text-sm sm:block hidden"> See all </a>
                </div>
            </div>

        </div>

    </div>
@stop
