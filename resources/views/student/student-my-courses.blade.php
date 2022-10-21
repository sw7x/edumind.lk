@extends('layouts.master')
@section('title','Student enrolled courses')


@section('css-files')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/tooltipster/dist/css/tooltipster.bundle.min.css')}}" />
@stop

@section('page-css')
    <style>
        #curriculum ul.course-curriculum-list a{/*color: unset;*/ }

        /*tooltipster noir theme styles*/
        .tooltipster-sidetip.tooltipster-noir .tooltipster-box{border-radius:0;border:3px solid #000;background:#fff}
        .tooltipster-sidetip.tooltipster-noir .tooltipster-content{color:#000}
        .tooltipster-sidetip.tooltipster-noir .tooltipster-arrow{height:11px;margin-left:-11px;width:22px}
        .tooltipster-sidetip.tooltipster-noir.tooltipster-left .tooltipster-arrow,.tooltipster-sidetip.tooltipster-noir.tooltipster-right .tooltipster-arrow{height:22px;margin-left:0;margin-top:-11px;width:11px}
        .tooltipster-sidetip.tooltipster-noir .tooltipster-arrow-background{border:11px solid transparent}
        .tooltipster-sidetip.tooltipster-noir.tooltipster-bottom .tooltipster-arrow-background{border-bottom-color:#fff;top:4px}
        .tooltipster-sidetip.tooltipster-noir.tooltipster-left .tooltipster-arrow-background{border-left-color:#fff;left:-4px}
        .tooltipster-sidetip.tooltipster-noir.tooltipster-right .tooltipster-arrow-background{border-right-color:#fff;left:4px}
        .tooltipster-sidetip.tooltipster-noir.tooltipster-top .tooltipster-arrow-background{border-top-color:#fff;top:-4px}
        .tooltipster-sidetip.tooltipster-noir .tooltipster-arrow-border{border-width:11px}
        .tooltipster-sidetip.tooltipster-noir.tooltipster-bottom .tooltipster-arrow-uncropped{top:-11px}
        .tooltipster-sidetip.tooltipster-noir.tooltipster-right .tooltipster-arrow-uncropped{left:-11px}
    </style>
@stop


@section('content')
    <div class="main-container container">
        <div class="max-w-full  md:p-2 mx-auto">

            @if(isset($message))
                <div class="flash-msg {{$cls ?? 'flash-info'}} rounded-none">
                    <a href="#" class="close">×</a>
                    <div class="text-lg"><strong>{{ $msgTitle ?? 'Info!'}}</strong></div>
                    <p>{{ $message ?? 'Info!' }}</p>
                    <div class="text-base">{!! $message2 ?? '' !!}</div>
                </div>
            @endif

            @if(isset($student_courses))
                <div class="lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-5 p-3">
                    <div style="flex:1">
                        <h2 class="font-semibold mb-3 text-xl lg:text-3xl">My Courses</h2>
                        <hr class="mb-5">
                        <!-- <h4 class="font-semibold mb-2 text-base"> Description </h4>    -->

                        <section class="tabs-section">
                             <div class="_container">
                                <div class="row">

                                    <div class="col-md-3 col-lg-3 nav-section">
                                        @include('includes.student-profile-menu')
                                    </div>

                                    <div class="col-md-9 col-lg-9 content-section">
                                        <div class="tab-content">
                                            <div class="tab-pane active show" id="tab-1">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="tube-card p-3 lg:p-6 divide-y">


                                                            @foreach ($student_courses as $course)
                                                                <div class="flex md:space-x-6 space-x-3 relative course-item pt-3 mb-5">
                                                                    <a href="{{route('course-single',$course->slug)}}" class="md:w-60 md:h-36 w-28 h-20 overflow-hidden rounded-lg relative shadow-sm">
                                                                        @if($course->image)
                                                                            <img src="{{URL('/')}}/storage/{{$course->image}}" class="w-full h-full absolute inset-0 object-cover" alt="">
                                                                        @else
                                                                            <img src="{{asset('images/default-images/course.png')}}" class="w-full h-full absolute inset-0 object-cover" alt="">
                                                                        @endif
                                                                    </a>
                                                                    <div class="flex-1 md:space-y-2 space-y-1">
                                                                        <a href="{{route('course-single',$course->slug)}}" class="md:text-xl font-semibold line-clamp-2">{{$course->name}}</a>
                                                                        <p class="leading-6 pr-4 line-clamp-2 md:block hidden">{{$course->heading_text}}</p>
                                                                        <a href="{{route('teacher.view-profile',$course->teacher->username)}}" class="md:font-semibold block text-sm">{{$course->teacher->full_name}}</a>
                                                                        <div class="flex items-center justify-between">
                                                                            <div class="flex __space-x-2 items-center text-sm">
                                                                                <div class="font-semibold">
                                                                                    <span class="">
                                                                                        <i class="align-middle icon-feather-youtube" style="font-size: 1.20rem;"></i> {{$course->video_count}} lectures
                                                                                    </span>
                                                                                </div>

                                                                                <div class="font-semibold ml-3">
                                                                                    <span class="">
                                                                                        <i class="align-middle icon icon-feather-clock" style="font-size: 1.20rem;"></i> {{$course->duration}}
                                                                                    </span>
                                                                                </div>

                                                                                {{--
                                                                                <div class="flex items-center space-x-1 text-yellow-500 ml-5">
                                                                                    <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                                                    <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                                                    <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                                                    <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                                                    <ion-icon name="star" class="text-gray-300 md hydrated" role="img" aria-label="star"></ion-icon>
                                                                                    <div class="font-semibold ml-5 mt-1">4.0</div>
                                                                                </div>
                                                                                --}}
                                                                                <div></div>
                                                                            </div>
                                                                            @if($course->price)
                                                                                <div class="text-lg font-semibold">{{ $course->price == 0 ? "Free" : 'Rs '.$course->price }}</div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="absolute top-4 -right-1 cursor-pointer">
                                                                        @if($course->pivot->status == 'completed')
                                                                            <ion-icon name="checkmark-done-circle-sharp" class="text-2xl text-green-500 course-status" title="completed"></ion-icon>
                                                                        @else
                                                                            <ion-icon name="checkmark-circle-sharp" class="text-2xl text-green-300 course-status" title="enrolled"></ion-icon>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach



                                                            <div class="flex md:space-x-6 space-x-3 md:p-5 p-2 relative course-item">
                                                                <a href="course-intro-2.php" class="md:w-60 md:h-36 w-28 h-20 overflow-hidden rounded-lg relative shadow-sm">
                                                                    <img src="{{asset('images/courses/img-5.jpg')}}" alt=""  class="w-full h-full absolute inset-0 object-cover">
                                                                </a>
                                                                <div class="flex-1 md:space-y-2 space-y-1">
                                                                    <a href="course-intro-2.php" class="md:text-xl font-semibold line-clamp-2"> Learn C sharp for Beginners Crash Course </a>
                                                                    <p class="leading-6 pr-4 line-clamp-2 md:block hidden"> Lorem ipsum dolor sit amet,
                                                                        consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut
                                                                        magna . </p>
                                                                    <a href="#" class="md:font-semibold block text-sm"> John Michael</a>
                                                                    <div class="flex items-center justify-between">
                                                                        <div class="flex __space-x-2 items-center text-sm">
                                                                            <div class="font-semibold"><span class=""><i class="align-middle icon-feather-youtube" style="font-size: 1.20rem;"></i> 15 Lessons</span></div>

                                                                            <div class="font-semibold ml-3"><span class=""><i class="align-middle icon icon-feather-clock" style="font-size: 1.20rem;"></i> 18 Hourse </span></div>

                                                                            <div class="flex items-center space-x-1 text-yellow-500 ml-5">
                                                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                                                <ion-icon name="star" class="text-gray-300 md hydrated" role="img" aria-label="star"></ion-icon>
                                                                                <div class="font-semibold ml-5 mt-1">4.0</div>
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                        <div class="text-lg font-semibold"> $11.99 </div>
                                                                    </div>
                                                                </div>
                                                                <div class="absolute top-4 -right-1 cursor-pointer">
                                                                    <i class="fa fa-check-circle text-2xl text-green-500 course-status" style="" aria-hidden="true" title="complete"></i>
                                                                </div>
                                                            </div>

                                                            <div class="flex md:space-x-6 space-x-3 md:p-5 p-2 relative course-item">
                                                                <a href="course-intro-2.php" class="md:w-60 md:h-36 w-28 h-20 overflow-hidden rounded-lg relative shadow-sm">
                                                                    <img src="{{asset('images/courses/img-1.jpg')}}" alt=""  class="w-full h-full absolute inset-0 object-cover">
                                                                </a>
                                                                <div class="flex-1 md:space-y-2 space-y-1">
                                                                    <a href="course-intro-2.php" class="md:text-xl font-semibold line-clamp-2"> Learn C sharp for Beginners Crash Course </a>
                                                                    <p class="leading-6 pr-4 line-clamp-2 md:block hidden"> Lorem ipsum dolor sit amet,
                                                                        consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut
                                                                        magna . </p>
                                                                    <a href="#" class="md:font-semibold block text-sm"> John Michael</a>
                                                                    <div class="flex items-center justify-between">
                                                                        <div class="flex __space-x-2 items-center text-sm">
                                                                            <div class="font-semibold"><span class=""><i class="align-middle icon-feather-youtube" style="font-size: 1.20rem;"></i> 15 Lessons</span></div>

                                                                            <div class="font-semibold ml-3"><span class=""><i class="align-middle icon icon-feather-clock" style="font-size: 1.20rem;"></i> 18 Hourse </span></div>

                                                                            <div class="flex items-center space-x-1 text-yellow-500 ml-5">
                                                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                                                <ion-icon name="star" class="text-gray-300 md hydrated" role="img" aria-label="star"></ion-icon>
                                                                                <div class="font-semibold ml-5 mt-1">4.0</div>
                                                                            </div>
                                                                            <div></div>
                                                                        </div>
                                                                        <div class="text-lg font-semibold"> $11.99 </div>
                                                                    </div>
                                                                </div>
                                                                <div class="absolute top-4 -right-1 cursor-pointer">
                                                                    <i class="fa fa-circle-o text-2xl text-red-600 course-status" style="" aria-hidden="true" title="pending"></i>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                             </div>
                        </section>

                    </div>
                </div>
            @endif



        </div>
    </div>
@stop


@section('script-files')
    <script src="{{asset('plugins/tooltipster/dist/js/tooltipster.bundle.min.js')}}"></script>
@stop


@section('javascript')
    <script>

		$(document).ready(function() {

			$('.course-item .course-status').tooltipster({
				animation: 'grow',
				theme: 'tooltipster-noir',
				touchDevices: true,
				trigger: 'hover',
				position: 'right',
				contentAsHTML:true
				//content: $('<span><strong>prev text is in bold case !</strong></span>'),
			});

		});

    </script>
@stop
