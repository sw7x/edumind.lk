@extends('layouts.master')
@section('title','Subject page')




@section('content')


    <div class="main-container container _p-0">

        @if(Session::has('message'))
            <div class="flash-msg {{ Session::get('cls', 'flash-info')}}">
                <a href="#" class="close">×</a>
                <div class="text-lg"><strong>{{ Session::get('msgTitle') ?? 'Info!'}}</strong></div>
                <p>{{ Session::get('message') ?? 'Info!' }}</p>
                <div class="text-base">{!! Session::get('message2') ?? '' !!}</div>
            </div>
        @endif

        @if(isset($subjectData))
        <div class="flex bg-red-900 md:rounded-b-lg lg:-mt-5 relative overflow-hidden" style="background:{{$bgColor ?? '#7f1d1d'}}">

            <div class="lg:w-3/12 relative">
                <img src="{{$subjectData->image}}" class="_absolute bottom-0 right-0 hidden lg:block" alt="">
            </div>

            <div class="lg:w-9/12 relative z-10 px-8 py-8">

                {{--<div class="uppercase text-gray-200 mb-2 font-semibold">Web develpment</div>--}}
                <h1 class="lg:leading-10 lg:text-4xl text-white text-3xl leading-8 font-semibold capitalize" style="color:{{$txtColor??'#fff'}}">{{$subjectData->name}}</h1>
                <p class="mt-4 text-white text-xl" style="color:{{$txtColor??'#fff'}}">{{$subjectData->description}}</p>
                {{--
                <ul class="flex text-gray-200 gap-4 mt-4 mb-1">
                    <li class="flex items-center">
                        <span class="avg bg-yellow-500 mr-2 px-2 rounded text-white font-semiold"> 4.9 </span>
                        <div class="star-rating text-yellow-500">
                            <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon> <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                            <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon> <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                            <ion-icon name="star-half" role="img" class="md hydrated" aria-label="star half"></ion-icon>
                        </div>
                    </li>
                    <li> <ion-icon name="people-circle-outline" role="img" class="md hydrated" aria-label="people circle outline"></ion-icon> 1200 Enerolled </li>
                </ul>
                <ul class="lg:flex items-center text-gray-200">
                    <li> Created by <a href="#" class="text-white fond-bold hover:underline hover:text-white"> Stella Johnson </a> </li>
                    <li> <span class="lg:block hidden mx-3 text-2xl">·</span> </li>
                    <li> Last updated 10/2019</li>
                </ul>
                --}}
            </div>

        </div>

        <div class="page-spacer"></div>

        <div class="lg:flex lg:space-x-10">

            {{-- todo
            <div class="lg:w-3/12 space-y-4 lg:block hidden">

                <div>
                    <h4 class="font-semibold text-base mb-2"> Categories </h4>
                    <select class="selectpicker default" data-selected-text-format="count" data-size="7"
                            title="All Categories">
                        <option> Web Development </option>
                        <option> Mobile App </option>
                        <option> Business </option>
                        <option> IT Software </option>
                        <option> Desings </option>
                        <option> Marketing </option>
                        <option> Life Style </option>
                        <option> Photography </option>
                        <option> Health Fitness </option>
                        <option> Ecommerce </option>
                        <option> Food cooking </option>
                        <option> Teaching academy </option>
                    </select>
                </div>

                <div>
                    <h4 class="font-semibold text-base mb-2"> Course type </h4>
                    <form>
                        <div class="radio">
                            <input id="course-type-1" name="radio" type="radio" checked>
                            <label for="course-type-1"><span class="radio-label"></span>Free (42) </label>
                        </div>
                        <br>
                        <div class="radio">
                            <input id="course-type-2" name="radio" type="radio">
                            <label for="course-type-2"><span class="radio-label"></span> Paid (42)</label>
                        </div>
                    </form>
                </div>

                <div>
                    <h4 class="font-semibold text-base mb-2"> Duration </h4>
                    <form>
                        <div class="radio">
                            <input id="course-duration-1" name="radio" type="radio" checked>
                            <label for="course-duration-1"><span class="radio-label"></span> +5 Hourse (23) </label>
                        </div>
                        <br>
                        <div class="radio">
                            <input id="course-duration-2" name="radio" type="radio">
                            <label for="course-duration-2"><span class="radio-label"></span> +10 Hourse (42)</label>
                        </div>
                        <br>
                        <div class="radio">
                            <input id="course-duration-3" name="radio" type="radio">
                            <label for="course-duration-3"><span class="radio-label"></span> +20 Hourse (42)</label>
                        </div>
                        <br>
                        <div class="radio">
                            <input id="course-duration-4" name="radio" type="radio">
                            <label for="course-duration-4"><span class="radio-label"></span> +30 Hourse (42)</label>
                        </div>
                    </form>
                </div>

            </div>
            --}}








            @if(!empty($subjectCourses))
            <div class="w-full">
                <h4 class="font-semibold text-2xl mt-5 mb-5">{{ $subjectCourses->count() == 0 ? "No" : $subjectCourses->count() }} Courses found</h4>

                <div class="__tube-card mt-3 lg:mx-0 __-mx-5">

                    @foreach($subjectCourses as $course)

                        <?php //var_dump($course); ?>


                    {{--
                    $imgSrc = 'src="'.asset('images/courses/img-').$x.'.jpg"';
                    --}}


                        <div class="horizontal-course-item bg-white md:flex shadow-sm rounded-lg uk-transition-toggle mb-5">

                            <div class="md:w-5/12 md:h-60 h-40 overflow-hidden rounded-l-lg relative">
                                <a href="{{route('course-single',$course->slug)}}" alt="" title="">
                                    <img src="{{$course->image}}" class="w-full h-full absolute inset-0 object-cover" alt="">
                                </a>
                            </div>

                            <div class="flex-1 md:p-6 p-4">
                                <div class="font-semibold line-clamp-2 md:text-xl md:leading-relaxed">
                                    <a href="{{route('course-single',$course->slug)}}" alt="" title="">
                                    {{$course->name}}
                                    </a>
                                </div>

                                <div class="line-clamp-2 mt-2 md:block hidden">
                                    <a href="{{route('course-single',$course->slug)}}" alt="" title="">
                                        {{$course->heading_text}}
                                    </a>
                                </div>

                                <div class="font-semibold mt-3">
                                    <a href="{{route('teacher.view-profile',$course->teacher->username)}}" alt="" title="">
                                    {{$course->teacher->full_name}}
                                    </a>
                                </div>

                                <div class="items-center mt-2">
                                    <div class="lg:flex __space-x-2 items-center text-sm justify-between">
                                        <div class="md:flex">
                                            <div class="font-semibold mt-3 lg:mt-0 lg:mr-3 md:mt-2 md:mr-4"><span class="">
                                                    <i class="align-middle icon-feather-youtube mr-1" style="font-size: 1.20rem;"></i> {{$course->video_count}} lectures</span>
                                            </div>

                                            <div class="font-semibold mt-3 lg:mt-0 lg:mr-3 md:mt-2">
                                                <span class=""><i class="align-middle icon icon-feather-clock mr-1" style="font-size: 1.20rem;"></i>{{$course->duration}}</span>
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

                                    @if($course->price)
                                        <div class="text-lg font-semibold mt-3">{{ $course->price == 0 ? "Free" : 'Rs '.$course->price }}</div>
                                    @endif


                                </div>
                            </div>
                        </div>

                @endforeach


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


                </div>
            </div>
            @endif

        </div>
        @else
            <div></div>
        @endif
    </div>

@stop
