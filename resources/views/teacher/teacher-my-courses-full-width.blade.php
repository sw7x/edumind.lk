@extends('layouts.master')
@section('title','Courses belongs to teacher')


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
            <div class="lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-5 p-3">
                <div style="flex:1">

                    <h2 class="font-semibold mb-3 text-xl lg:text-3xl">My courses (teacher)</h2>
                    <hr class="mb-5">

                    @if(Session::has('message'))
                        <div class="flash-msg {{ Session::get('cls', 'flash-info')}}">
                            <a href="#" class="close">×</a>
                            <div class="text-lg"><strong>{{ Session::get('msgTitle') ?? 'Info!'}}</strong></div>
                            <p>{{ Session::get('message') ?? 'Info!' }}</p>
                            <div class="text-base">{!! Session::get('message2') ?? '' !!}</div>
                        </div>
                    @endif

                    @if(isset($teacher_courses))
                    <section class="tabs-section">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tab-1">
                                <div class="tube-card p-3 lg:p-6 divide-y">

                                    @forelse ($teacher_courses as $course)
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
                                                                <i class="align-middle icon icon-feather-clock" style="font-size: 1.20rem;"></i>{{$course->duration}}
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
                                                @if($course->status == App\Models\Course::PUBLISHED)
                                                    <ion-icon name="bag-check-sharp" class="text-2xl text-green-500 course-status" title="published"></ion-icon>
                                                @else
                                                    <ion-icon name="trash-bin-sharp" class="text-2xl text-red-500 course-status" title="Draft"></ion-icon>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="md:text-xl font-semibold line-clamp-2">No Courses</div>
                                    @endforelse

                                </div>
                            </div>
                        </div>
                    </section>
                    @endif

                </div>
            </div>
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
