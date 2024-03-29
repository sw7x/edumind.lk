@extends('admin-panel.layouts.master',['title' => 'My Courses(t)'])
@section('title','My Courses')

@section('css-files')
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" />

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
		
		.course-item{
			border-radius: 4px;
		}
        .course-item.disabled{
        	background-color: #6b728047;
        }
    </style>
@stop



@section('content')

	<div class="row" id="_sortable-view">
		<div class="col-lg-12">
					
			<div class="ibox">
                <div class="ibox-content">
                	//todo --> add attr from (admin/course) datatable

                	@if(isset($teacher_courses) && is_array($teacher_courses))  	                    
	                    <section class="tabs-section">
	                        <div class="tab-content">
	                            <div class="tab-pane active show" id="tab-1">
	                                <div class="tube-card py-3 divide-y">

	                                    @forelse ($teacher_courses as $course)
	                                        <div class="flex md:space-x-6 space-x-3 relative course-item py-2 pl-2 pr-3 mb-3 border {{ ($course['status'] == App\Models\Course::PUBLISHED) ? '' : 'disabled'}}">
	                                            <a href="{{route('courses.show',$course['slug'])}}" class="md:w-60 md:h-36 w-28 h-20 overflow-hidden rounded-lg relative shadow-sm">
	                                                <img src="{{$course['image']}}" class="w-full h-full absolute inset-0 object-cover" alt="">
	                                            </a>
	                                            <div class="flex-1 space-y-1">
	                                                <a href="{{route('courses.show',$course['slug'])}}" class="md:text-xl font-semibold line-clamp-2">{{$course['name']}}</a>
	                                                <p class="leading-6 pr-4 line-clamp-2 md:block hidden">{{$course['headingText']}}</p>
	                                                <a href="{{route('teachers.show',$course['creatorArr']['username'])}}" class="md:font-semibold block text-sm">{{$course['subjectArr']['name']}}</a>
	                                                <div class="flex items-center justify-between">
	                                                    <div class="flex __space-x-2 items-center text-sm">
	                                                        <div class="font-semibold">
	                                                            <span class="">
	                                                                <i class="align-middle fa fa-youtube-play mr-1" style="font-size: 1.20rem;"></i> {{$course['videoCount']}} lectures
	                                                            </span>
	                                                        </div>
	                                                        <div class="font-semibold ml-3">
	                                                            <span class="">
	                                                                <i class="align-middle fa fa-clock-o mr-1" style="font-size: 1.20rem;"></i>{{$course['duration']}}
	                                                            </span>
	                                                        </div>

	                                                        
	                                                        <div></div>
	                                                    </div>
                            							@if(isset($course['price']))
	                                                        <div class="text-lg font-semibold">{{ $course['price'] == 0 ? "Free" : 'Rs '.$course['price'] }}</div>
	                                                    @endif
	                                                </div>
	                                            </div>
	                                            
	                                            <div class="absolute top-2 right-2 cursor-pointer">
	                                                @if($course['status'] == App\Models\Course::PUBLISHED)
	                                                    <i class="fa fa-trash text-2xl text-red-500 course-status" aria-hidden="true" title="Make draft"></i>
	                                                @else
	                                                    <i class="fa fa-check-circle text-2xl text-green-500 course-status" aria-hidden="true" title="Make published"></i>	                                                    
	                                                @endif
	                                            </div>
	                                        </div>
	                                    @empty
	                                        <x-flash-message 
                                                class="flash-info mt-3"  
                                                title="No Courses !" 
                                                message="" 
                                                :canClose="false"/>
	                                    @endforelse

	                                </div>
	                            </div>
	                        </div>
	                    </section>
	                @else                
	                    <x-flash-message 
		                    class="flash-danger"  
		                    title="Data not available!" 
		                    message="Course data is not available or not in correct format"  
		                    message2=""  
		                    :canClose="false" />                
	                @endif

                </div>
            </div>           
						
		</div>
	</div>
	<div class="hr-line-dashed"></div>

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
