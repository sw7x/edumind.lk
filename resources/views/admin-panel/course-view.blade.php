@extends('admin-panel.layouts.master')
@section('title','View course')


@section('css-files')
    <!-- Feather Icons (https://feathericons.com/) -->
    <link href="{{asset('admin/css/icons.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('admin/css/uikit.css')}}">

    <!-- toastr CSS file-->
    <link rel="stylesheet" href="{{asset('admin/css/plugins/toastr/toastr.min.css')}}">
@stop

@section('page-css')
    <style>
        #curriculum ul.course-curriculum-list a{
            color: unset;
        }


    </style>
@stop



@section('content')
    <div class="row" id="">
        <div class="col-lg-12">

            @if(Session::has('message'))
                <x-flash-message  
                    :class="Session::get('cls', 'flash-info')"  
                    :title="Session::get('msgTitle') ?? 'Info!'" 
                    :message="Session::get('message') ?? ''"  
                    :message2="Session::get('message2') ?? ''"  
                    :canClose="true" />
            @endif
            
            @isset($course)
                <div class="ibox">
                    <div class="ibox-content">

                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                <li><a class="nav-link" data-toggle="tab" href="#tab-course-details">Course details</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-course-curriculum">Course curriculum</a></li>
                            </ul>

                            <div class="tab-content mb-3">

                                <!-- add-course tab -->
                                <div role="tabpanel" id="tab-course-details" class="tab-pane ">
                                    <div class="panel-body">

                                        <form class="" id="" action="" method="POST">
                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Name</label>
                                                <label class="col-sm-8 col-form-label">{{$course['name']}}</label>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Subject</label>
                                                <label class="col-sm-8 col-form-label">{{$course['subjectName']}}</label>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Teacher</label>
                                                <label class="col-sm-8 col-form-label">{{$course['teacherName']}}</label>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            {{--//todo - enrollment_id - enrolled ,complete,rating--}}

                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Heading text</label>
                                                <label class="col-sm-8 col-form-label">{{$course['headingText']}}</label>
                                            </div>
                                            <div class="hr-line-dashed"></div>


                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Description</label>
                                                <label class="col-sm-8 col-form-label">{!! $course['description'] !!}</label>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group row"><label class="col-sm-4 col-form-label">Image</label>
                                                <div class="col-sm-8">
                                                    
                                                    <img style="max-width:500px" src="{{$course['image']}}"/>
                                                    
                                                    <br>
                                                    <small>Image Size should be 300X350</small>
                                                </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>


                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Duration<br> <small>X Hours : Y minutes</small></label>
                                                <label class="col-sm-8 col-form-label">{{$course['duration']}}</label>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Videos <small>(count)</small></label>
                                                <label class="col-sm-8 col-form-label">{{$course['videoCount']}}</label>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Price</label>
                                                @if(isset($course['price']) && $course['price'] != '0.00')
                                                    <label class="col-sm-8 col-form-label">Rs {{$course['price']}}</label>
                                                @else
                                                    <label class="col-sm-8 col-form-label">Free</label>
                                                @endif
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            
                                            @if(isset($course['authorSharePercentage']) && is_numeric($course['authorSharePercentage']))
                                                <div class="form-group  row">
                                                    <label class="col-sm-4 col-form-label">Author Share</label>                                                
                                                    <label class="col-sm-8 col-form-label">{{$course['authorSharePercentage']}}%</label>
                                                </div>
                                                <div class="hr-line-dashed"></div>
                                            @endif

                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Created</label>
                                                <label class="col-sm-8 col-form-label">{{$course['createdAtAgo']}} <small>({{$course['createdAt']}})</small></label>
                                            </div>
                                            <div class="hr-line-dashed"></div>

                                            <div class="form-group  row">
                                                <label class="col-sm-4 col-form-label">Last update</label>
                                                <label class="col-sm-8 col-form-label">{{$course['updatedAtAgo']}} <small>({{$course['updatedAt']}})</small></label>
                                            </div>
                                            <div class="hr-line-dashed"></div>


                                            <div class="form-group row">
                                                <label class="col-sm-4 col-form-label">Submit status</label>
                                                <label class="col-sm-8 col-form-label">{{$course['status']}} </label>
                                            </div>
                                            <div class="hr-line-dashed"></div>



                                            <div class="form-group row">
                                                <div class="col-sm-4 offset-sm-4">
                                                    <a class="btn btn-danger btn-sm mr-2" href="{{route('admin.course.index')}}">Go back</a>
                                                    <a class="btn btn-info btn-sm" target="_blank" href="{{route('course-single',$course['slug'])}}">Open course in new tab</a>
                                                </div>                                                
                                            </div>

                                        </form>

                                    </div>
                                </div>
                                
                                <div role="tabpanel" id="tab-course-curriculum" class="tab-pane">
                                    <div class="panel-body">

                                        <pre class="py-1"><span class="text-red-500 text-sm font-bold">* View URL                 - Hover the link </span></pre>
                                        <pre class="py-1"><span class="text-red-500 text-sm font-bold">* Copy URL to clipboard    - Click the link </span></pre>

                                        <div id="curriculum" class="tube-card mt-5">

                                            @php
                                                //dump($course->content);
                                                //dump($courseContent);
                                            @endphp

                                            @if(isset($courseContent))
                                                @if($courseContentInvFormat == false)
                                                    <ul uk-accordion="multiple: true" class="divide-y space-y-3">
                                                        @foreach($courseContent as $sectionHeading => $sectionContent)
                                                        <li class="uk-open bg-gray-200 px-2 pb-3 rounded {{($loop->index>0)?'pt-2':''}}">

                                                            <a class="uk-accordion-title text-md mx-2 pt-3 font-semibold" href="#">
                                                                <div class="mb-1 text-sm font-medium"> Section {{$loop->index+1}}</div> {{$sectionHeading}}</a>

                                                            <div class="uk-accordion-content mt-3 text-base border-gray-400 border-t">

                                                                <ul class="course-curriculum-list font-medium">                                                                                               

                                                                    @foreach($sectionContent as $arr)
                                                                    <li class=" hover:bg-gray-100 p-2 flex rounded-md
                                                                        {{($arr['isFree'] == true)?' text-blue-500':''}}
                                                                        {{($arr['type'] == 'Download')?' __pl-8-important':''}}">

                                                                        @if(strtolower($arr['type']) == 'video')
                                                                            <i class="fa fa-play-circle text-2xl mr-2"></i>
                                                                            <!-- <ion-icon name="play-circle" class="text-2xl mr-2"></ion-icon> -->
                                                                        @elseif (strtolower($arr['type']) =="download")
                                                                            <i class="fa fa-download leading-6 text-2xl mr-2"></i>
                                                                            <!-- <ion-icon class="icon-feather-download text-2xl mr-2"></ion-icon> -->
                                                                        @elseif (strtolower($arr['type']) =="other")
                                                                            <i class="fa fa-link leading-6 text-2xl mr-2"></i>
                                                                            <!-- <ion-icon class="icon-feather-link text-2xl mr-2"></ion-icon> -->
                                                                        @else
                                                                            <i class="fa fa-info-circle leading-6 text-2xl mr-2"></i>
                                                                            <!-- <ion-icon class="icon-feather-box text-2xl mr-2"></ion-icon> -->
                                                                        @endif

                                                                        <div class="link_div mr-2 text-justify">    
                                                                            <a class="link" href="{{$arr['inputUrl']}}">{{$arr['inputText']}}</a>                                                    

                                                                            @if($arr['isFree'] == true)
                                                                            <span class="bg-blue-500 text-white bg-gray-200 ml-4 px-3 py-1 rounded-full text-xs">Free</span>
                                                                            @endif
                                                                        </div>

                                                                        @if($arr['linkParam'] !='')
                                                                        <span class="param text-sm ml-auto">{{$arr['linkParam']}}</span>
                                                                        @endif
                                                                    </li>
                                                                    @endforeach

                                                                </ul>

                                                            </div>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p class="text-center text-sm font-semibold text-red-600">Course content is not in correct format</p>
                                                @endif
                                            @else
                                                <p class="text-center text-sm font-semibold">Course content is empty</p>
                                            @endif

                                        </div>

                                        {{--
                                        <div id="curriculum" class="tube-card mt-5">

                                            <ul uk-accordion="multiple: true" class="divide-y space-y-3">

                                                <li class="uk-open bg-gray-200 px-2 pb-3 rounded">
                                                    <a class="uk-accordion-title text-md mx-2 pt-3 font-semibold" href="#">  <div class="mb-1 text-sm font-medium"> Section 1 </div> Html Introduction </a>
                                                    <div class="uk-accordion-content mt-3 text-base border-gray-400 border-t">

                                                        <ul class="course-curriculum-list font-medium">
                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md text-blue-500">
                                                                <ion-icon name="play-circle" class="text-2xl mr-2"></ion-icon>
                                                                <a class="" href="#111">Introduction</a>
                                                                <span class="bg-blue-500 text-white bg-gray-200 ml-4 px-3 py-1 rounded-full text-xs">Free</span>
                                                                <span class="text-sm ml-auto"> 4 min </span>
                                                            </li>

                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md">
                                                                <ion-icon name="play-circle" class="text-2xl mr-2"></ion-icon>
                                                                <a class="" href="url-htmlzip">What is HTML</a>
                                                                 <span class="text-sm ml-auto"> 5 min </span>
                                                            </li>
                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md text-blue-500 pl-8-important">
                                                                <ion-icon class="icon-feather-download text-2xl leading-6 mr-2"></ion-icon>
                                                                <a class="" href="url-htmlzip">HTML.zip</a>
                                                                <span class="bg-blue-500 text-white bg-gray-200 ml-4 px-3 py-1 rounded-full text-xs">Free</span>
                                                                <span class="text-sm ml-auto">5 MB</span>

                                                            </li>
                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md text-blue-500 pl-8-important">
                                                                <ion-icon class="icon-feather-download text-2xl leading-6 mr-2"></ion-icon>
                                                                <a class="" href="#">CSS.zip</a>
                                                                <span class="bg-blue-500 text-white bg-gray-200 ml-4 px-3 py-1 rounded-full text-xs">Free</span>
                                                                <span class="text-sm ml-auto">5 MB</span>
                                                            </li>
                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md text-blue-500 pl-8-important">
                                                                <ion-icon class="icon-feather-download text-2xl leading-6 mr-2"></ion-icon>
                                                                <a class="" href="#">Java.zip</a>
                                                                <span class="bg-blue-500 text-white bg-gray-200 ml-4 px-3 py-1 rounded-full text-xs">Free</span>
                                                                <span class="text-sm ml-auto">5 MB</span>
                                                            </li>

                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md">
                                                                <ion-icon name="play-circle" class="text-2xl mr-2"></ion-icon>
                                                                <a class="" href="url-htmlzip">What is a Web page?</a>
                                                                <span class="text-sm ml-auto">8 min</span>
                                                            </li>

                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md text-blue-500">
                                                                <ion-icon name="play-circle" class="text-2xl mr-2"></ion-icon>
                                                                <a class="" href="#">Your First Web Page</a>
                                                                <span class="bg-blue-500 text-white bg-gray-200 ml-4 px-3 py-1 rounded-full text-xs">Free</span>
                                                                <span class="text-sm ml-auto"> 4 min </span>
                                                            </li>

                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md">
                                                                <ion-icon name="play-circle" class="text-2xl mr-2"></ion-icon>
                                                                <a class="" href="url-Brain Streak">Brain Streak?</a>
                                                                <span class="text-sm ml-auto">5 min</span>
                                                            </li>

                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md pl-8-important">
                                                                <ion-icon class="icon-feather-download text-2xl leading-6 mr-2"></ion-icon>
                                                                <a class="" href="#">PHP.zip</a><span class="text-sm ml-auto">7 MB</span>
                                                            </li>
                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md pl-8-important">
                                                                <ion-icon class="icon-feather-download text-2xl leading-6 mr-2"></ion-icon>
                                                                <a class="" href="#">C#.zip</a><span class="text-sm ml-auto">7 MB</span>
                                                            </li>

                                                        </ul>

                                                    </div>
                                                </li>
                                                <li class="pt-2 bg-gray-200 px-2 pb-3 rounded">
                                                    <a class="uk-accordion-title text-md mx-2 pt-3 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 2 </div> Your First webpage  </a>
                                                    <div class="uk-accordion-content mt-3 text-base border-gray-400 border-t">

                                                        <ul class="course-curriculum-list font-medium">
                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md">
                                                                <ion-icon name="play-circle" class="text-2xl mr-2"></ion-icon> Headings
                                                                <span class="text-sm ml-auto"> 4 min </span>
                                                            </li>
                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md">
                                                                <ion-icon name="play-circle" class="text-2xl mr-2"></ion-icon> Paragraphs
                                                                <span class="text-sm ml-auto"> 5 min </span>
                                                            </li>
                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md">
                                                                <ion-icon name="play-circle" class="text-2xl mr-2"></ion-icon>
                                                                Emphasis and Strong Tag
                                                                <span class="text-sm ml-auto"> 8 min </span>
                                                            </li>
                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md">
                                                                <ion-icon name="play-circle" class="text-2xl mr-2"></ion-icon>
                                                                Brain Streak
                                                                <span class="bg-blue-500 text-white bg-gray-200 ml-4 px-2 py-1 rounded-full text-xs"> Preview </span>
                                                                <span class="text-sm ml-auto"> 4 min </span>
                                                            </li>
                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md">
                                                                <ion-icon name="play-circle" class="text-2xl mr-2"></ion-icon>
                                                                Live Preview Feature
                                                                <span class="text-sm ml-auto"> 5 min </span>
                                                            </li>
                                                        </ul>

                                                    </div>
                                                </li>
                                                <li class="pt-2 bg-gray-200 px-2 pb-3 rounded">
                                                    <a class="uk-accordion-title text-md mx-2 pt-3 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 3 </div> Build Complete Webste  </a>
                                                    <div class="uk-accordion-content mt-3 text-base border-gray-400 border-t">

                                                        <ul class="course-curriculum-list font-medium">
                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md">
                                                                <ion-icon name="play-circle" class="text-2xl mr-2"></ion-icon> The paragraph tag
                                                                <span class="text-sm ml-auto"> 4 min </span>
                                                            </li>
                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md">
                                                                <ion-icon name="play-circle" class="text-2xl mr-2"></ion-icon> The break tag
                                                                <span class="text-sm ml-auto"> 5 min </span>
                                                            </li>
                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md">
                                                                <ion-icon name="play-circle" class="text-2xl mr-2"></ion-icon>
                                                                Headings in HTML
                                                                <span class="text-sm ml-auto"> 8 min </span>
                                                            </li>
                                                            <li class=" hover:bg-gray-100 p-2 flex rounded-md">
                                                                <ion-icon name="play-circle" class="text-2xl mr-2"></ion-icon>
                                                                Bold, Italics Underline
                                                                <span class="bg-blue-500 text-white bg-gray-200 ml-4 px-2 py-1 rounded-full text-xs"> Preview </span>
                                                                <span class="text-sm ml-auto"> 4 min </span>
                                                            </li>
                                                        </ul>

                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        --}}

                                    </div>
                                </div>                            
                            
                            </div>
                        </div>

                    </div>
                </div>
            @endif

        </div>
    </div>
@stop




@section('script-files')
    <script src="{{asset('admin/js/uikit.js')}}"></script>
    <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>

    <!-- toastr js file-->
    <script src="{{asset('admin/js/plugins/toastr/toastr.min.js')}}"></script>

@stop

@section('javascript')
    <script>

		jQuery(document).ready(function ($) {
			let selectedTab = window.location.hash;
			selectedTab = (selectedTab=='')?'#tab-course-details':selectedTab;
			$('.nav-link[href="' + selectedTab + '"]' ).trigger('click');

			//Prevent default hash behavior on page load
			window.scrollTo(0,0);
		});



		$(document).ready(function() {

			toastr.options = {
				"closeButton": true,
				"debug": false,
				"newestOnTop": true,
				"progressBar": true,
				"positionClass": "toast-top-right",
				"preventDuplicates": false,
				"onclick": null,
				"showDuration": "300",
				"hideDuration": "1000",
				"timeOut": "5000",
				"extendedTimeOut": "1000",
				"showEasing": "swing",
				"hideEasing": "linear",
				"showMethod": "fadeIn",
				"hideMethod": "fadeOut"
			};


			$('#curriculum .course-curriculum-list a').tooltip({
                placement : 'right',
				title: function() {
					return $(this).attr('href');
				}
			});


			$('#curriculum .course-curriculum-list a').click(function(event){
				//alert('Please');
				event.preventDefault();
				//event.preventDefault();

				var $temp = $("<input>");
				$("body").append($temp);
				$temp.val($(this).attr('href')).select();
				document.execCommand("copy");
				$temp.remove();
				toastr["success"]("Url is copied to clipboard!")
            })




		});


		function copyToClipboard(element) {
			var $temp = $("<input>");
			$("body").append($temp);
			$temp.val($(element).text()).select();
			document.execCommand("copy");
			$temp.remove();
		}




    </script>
@stop
