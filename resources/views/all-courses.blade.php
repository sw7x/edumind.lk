@extends('layouts.master')
@section('title','All courses')


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

                    <h2 class="font-semibold mb-3 text-xl lg:text-3xl">All Courses</h2>
                    <!--
                    <hr class="mb-5">
                    <h4 class="font-semibold mb-2 text-base"> Description </h4>
                    -->
                    <?php //dump($all_courses)?>
                    
                    <section class="tabs-section">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tab-1">

                                @if(isset($all_courses) && is_array($all_courses))                                
                                    <div class="col-lg-12">
                                        <div class="tube-card p-3 lg:p-6 divide-y">
                                            <div class="mt-1 text-base font-semibold mb-3">{{count($all_courses)}} Courses</div>
                                            
                                            @if(!empty($all_courses))
                                                @foreach ($all_courses as $course)
                                                    <div class="flex md:space-x-6 space-x-3 relative course-item pt-3 mb-5">
                                                        <a href="{{route('courses.show',$course['slug'])}}" class="md:w-60 md:h-36 w-28 h-20 overflow-hidden rounded-lg relative shadow-sm">
                                                            <img src="{{$course['image']}}" class="w-full h-full absolute inset-0 object-cover" alt="">                                                        
                                                        </a>
                                                        <div class="flex-1 md:space-y-2 space-y-1">
                                                            <a href="{{route('courses.show',$course['slug'])}}" class="md:text-xl font-semibold line-clamp-2">{{$course['name']}}</a>
                                                            <p class="leading-6 pr-4 line-clamp-2 md:block hidden">{{$course['headingText']}}</p>
                                                            
                                                            @if($course['teacher'])
                                                                <a  href="{{route('teachers.show',$course['teacherUsername'])}}" 
                                                                    class="md:font-semibold block text-sm">
                                                                    {{$course['teacherFullName']}}
                                                                </a>
                                                            @endif

                                                            <div class="flex items-center justify-between">
                                                                <div class="flex __space-x-2 items-center text-sm">
                                                                    <div class="font-semibold">
                                                                        <span class="">
                                                                            <i class="align-middle icon-feather-youtube" style="font-size: 1.20rem;"></i> {{$course['videoCount']}} lectures
                                                                        </span>
                                                                    </div>

                                                                    <div class="font-semibold ml-3">
                                                                        <span class="">
                                                                            <i class="align-middle icon icon-feather-clock" style="font-size: 1.20rem;"></i> {{$course['duration']}}
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
                                                                @if(isset($course['price']))
                                                                    <div class="text-lg font-semibold">
                                                                        {{ $course['price'] == 0 ? "Free" : 'Rs '.$course['price'] }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="absolute top-4 -right-1 cursor-pointer">                                                      
                                                            @if(isset($course['enrollmentsStatus']))
                                                                @if($course['enrollmentsStatus']      == 'FRESH')
                                                                    <ion-icon name="list-circle-sharp" class="text-2xl text-red-500 course-status" title="Fresh"></ion-icon>
                                                                @elseif ($course['enrollmentsStatus'] == 'ADDED_TO_CART')
                                                                    <ion-icon name="bag-add-sharp" class="text-2xl text-yellow-500 course-status" title="Added to cart"></ion-icon>
                                                                @elseif ($course['enrollmentsStatus'] == 'ENROLLED')
                                                                    <ion-icon name="checkmark-circle-outline" class="text-2xl text-green-500 course-status" title="Enrolled"></ion-icon>
                                                                @elseif ($course['enrollmentsStatus'] == 'COMPLETED')
                                                                    <ion-icon name="checkmark-done-circle-sharp" class="text-2xl text-green-500 course-status" title="Completed"></ion-icon>
                                                                @else
                                                                    <!-- for users other than students,guests -->
                                                                @endif
                                                            @endif                                               
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <x-flash-message 
                                                    class="flash-info"  
                                                    title="No Courses" 
                                                    message=""  
                                                    message2=""  
                                                    :canClose="false" />
                                            @endif

                                        </div>
                                    </div>
                                @else
                                    <div class="my-5">
                                        <x-flash-message 
                                            class="flash-danger"  
                                            title="Data not available!" 
                                            message="Courses data is not available or not in correct format"  
                                            message2=""  
                                            :canClose="false" />
                                    </div>
                                @endif

                            </div>
                        </div>
                    </section>

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
				//contentAsHTML:true
				//content: $('<span><strong>prev text is in bold case !</strong></span>'),
			});
		});

    </script>
@stop