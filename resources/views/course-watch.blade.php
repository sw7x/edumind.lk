@php
    $page       = 'course-watch';
    $wrapperCls = 'course-watch';    
    $pgtitle    = 'Watch - '.$courseData->name.'/'.$videoId;  
@endphp



@extends('layouts.master')
@section('title',$pgtitle)


@section('css-files')
<link rel="stylesheet" type="text/css" href="{{asset('plugins/tooltipster/dist/css/tooltipster.bundle.min.css')}}" />
@stop



@section('page-css')
    <style>
        #curriculum ul.course-curriculum-list a{
            /*color: unset;*/
        }

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

        <div class="row">

            <!-- sidebar -->
            <div class="sidebar static" id="sidebar">


                <div class="c_link_navigator flex justify-between font-bold text-lg px-2 md:px-0" style="">
                    <!-- <a title="Announcements Overview 123" class="text-left prev text-base bg-white px-3 py-3 rounded leading-4" href="">🡸  Back</a> -->
                    <span title="Previous" class="text-left prev text-base bg-white px-3 py-3 rounded leading-4" href="">🡸  Back</span>
                    
                    <h1 class="lg:text-2xl text-lg font-bold mt-2 line-clamp-2">{{$courseData->name}}</h1>

                    <!-- <a title="Overview to" class="text-right next text-base bg-white px-3 py-3 rounded leading-4" href="" >Next  🢂</a> -->
                    <span title="Next" class="text-right next text-base bg-white px-3 py-3 rounded leading-4" href="" >Next  🢂</span>
                </div>
             
                
                <!-- 
                <div class="course_progress">
                    <div class="relative overflow-hidden _rounded-md bg-gray-200 h-3 mt-4">
                        <div class="w-2/4 h-full bg-green-500"></div>
                    </div>
                    <div class="mt-2 mb-3 text-base border-b-2 border-gray-300 pb-3 font-semibold">
                        <div> 146% Complete</div>
                        <div> Last activity on April 20, 2021 11</div>
                    </div>
                </div> 
                -->
                <br>
                <hr>
                <br>




                <!-- course Curriculum -->
                <div id="curriculum_sidebar" class="curriculum_sidebar">
                    <h3 class="text-center mb-4 text-xl font-semibold lg:mb-5"> Course Curriculum </h3>
                    @if($courseData->content)
                        <ul uk-accordion="multiple: true" class="divide-y space-y-3">

                            @php($liCount = 1)

                            @foreach($courseData->content as $sectionHeading => $sectionContent)
                                

                                <li class="aac{{$loop->index}} accordion_item bg-gray-200 px-0 pb-3 rounded {{($loop->index>0)?'pt-2':'uk-open'}}">

                                    <a class="text-center uk-accordion-title text-md mx-2 pt-3 font-semibold" href="#">
                                        <div class="mb-1 text-sm font-medium"> Section {{$loop->index+1}}</div>
                                        {{$sectionHeading}}
                                    </a>

                                    <div class="uk-accordion-content mt-3 text-base border-gray-400 border-t pt-3">

                                        <ul class="course-curriculum-list font-medium px-0" _uk-switcher="connect: #video_tabs; animation: animation: uk-animation-slide-right-small, uk-animation-slide-left-medium">


                                            @if(array_key_first($courseData->content) == $sectionHeading)                                            
                                            <!-- 
                                            <li class="hover:bg-gray-50 font-normal pl-2 pr-1 py-2 text-black border-gray-300 border-b">
                                                <div class="mb-1 text-base font-normal">
                                                    <a class="" style="" href="url1">
                                                        <span class="mr-3">1.</span>
                                                        Related nav container. By default, nav items are found in related items container only.
                                                    </a>
                                                </div>

                                                <div class="flex text-sm">
                                                    <i class="fa fa-play-circle leading-5 text-xl mr-0 md hydrated" aria-hidden="true"></i>
                                                    <span style="" class="ml-5">15 minutes</span>
                                                    <button class="ml-1 change_lec_stat ml-auto" name="" type="button" class="">✅</button>
                                                </div>
                                            </li>

                                            <li class="hover:bg-gray-50 font-normal pl-2 pr-1 py-2 text-black border-gray-300 border-b">
                                                <div class="mb-1 text-sm font-normal">
                                                    <a class="" style="" href="url1">
                                                        <span class="mr-3">2.</span>
                                                        Want related  to request new icons? Here's how. Need By default, nav nav found in related items container only container items are .
                                                    </a>
                                                </div>

                                                <div class="flex text-sm">
                                                    <i class="fa fa-download leading-5 text-xl mr-0 md hydrated" aria-hidden="true"></i>
                                                    <span style="" class="ml-5">5 MB</span>
                                                    <button class="ml-1 change_lec_stat ml-auto" name="" type="button" class="">⬜</button>
                                                </div>
                                            </li>

                                            <li class="hover:bg-gray-50 font-normal pl-2 pr-1 py-2 text-black border-gray-300 border-b">
                                                <div class="mb-1 text-sm font-normal">
                                                    <a class="" style="" href="url1">
                                                        <span class="mr-3">3.</span>
                                                        Nav related container. By default, nav items are found in related items container only.
                                                    </a>
                                                </div>

                                                <div class="flex text-sm">
                                                    <i class="fa fa-link leading-5 text-xl mr-0 md hydrated" aria-hidden="true"></i>
                                                    <span style="" class="ml-5">15 minutes</span>
                                                    <button class="ml-1 change_lec_stat ml-auto" name="" type="button" class="">⬜</button>
                                                </div>
                                            </li>

                                            <li class="hover:bg-gray-50 font-normal pl-2 pr-1 py-2 text-black border-gray-300 border-b">
                                                <div class="mb-1 text-sm font-normal">
                                                    <a class="" style="" href="url1">
                                                        <span class="mr-3">3.</span>
                                                        Nav related container. By default, nav items are found in related items container only.
                                                    </a>
                                                </div>

                                                <div class="flex text-sm">
                                                    <i class="fa fa-info-circle leading-5 text-xl mr-0 md hydrated" aria-hidden="true"></i>
                                                    <span style="" class="ml-5">15 minutes</span>
                                                    <button class="ml-1 change_lec_stat ml-auto" name="" type="button" class="">✅</button>
                                                </div>
                                            </li>
                                            -->
                                            @endif


                                            @foreach($sectionContent as $key=>$arr)
                                                <!-- {{$liCount}} -->
                                                
                                                <li class="hover:bg-gray-50 font-normal pl-2 pr-1 py-2 text-black border-gray-300 border-b">

                                                    <div class="mb-1 text-sm font-normal">
                                                        <a class="block switch-links" style="" href="{{$arr['url']}}" data-id="{{$liCount}}">
                                                            <!-- <span class="mr-3">{{$key + 1}}.</span> -->
                                                            <span class="mr-3">{{$liCount}}.</span>
                                                            {{$arr['text']}}
                                                        </a>
                                                    </div>

                                                    <div class="flex text-sm">

                                                        @if(strtolower($arr['type']) == 'video')
                                                            <i class="fa fa-play-circle leading-5 text-xl mr-0 md hydrated"></i>
                                                        @elseif (strtolower($arr['type']) =="download")
                                                            <i class="fa fa-download leading-5 text-xl mr-0 md hydrated"></i>
                                                        @elseif (strtolower($arr['type']) =="other")
                                                            <i class="fa fa-link leading-5 text-xl mr-0 md hydrated"></i>
                                                        @else
                                                            <i class="fa fa-info-circle leading-5 text-xl mr-0 md hydrated"></i>
                                                        @endif

                                                        @if($arr['param'] !='')
                                                            <span class="param ml-5">{{$arr['param']}}</span>
                                                        @endif

                                                        <!-- <button class="ml-1 change_lec_stat ml-auto" name="" type="button" class="">✅</button> -->

                                                        <!--
                                                        @if($loop->index%2==0)
                                                        <button class="ml-1 change_lec_stat ml-auto" name="" type="button" class="">✅</button>
                                                        @else
                                                        <button class="ml-1 change_lec_stat ml-auto" name="" type="button" class="">⬜</button>
                                                        @endif  -->
                                                    </div>
                                                </li>
                                                @php($liCount++)
                                            @endforeach


                                        </ul>

                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    @else
                        <p class="text-center text-sm font-semibold">Course content is empty</p>
                    @endif
                </div>
                                        

            </div>

            <!-- Main Contents -->
            <div class="main_content ml-0--imp">
                <div class="relative">

                    <ul class="_uk-switcher relative z-10" id="video_tabs">
                    @if($courseData->content)
                        @foreach($courseData->content as $sectionHeading => $sectionContent)
                            @foreach($sectionContent as $key=>$arr)



                                @if(strtolower($arr['type']) == 'video')
                                    <li>
                                        <div class="embed-video">
                                            <iframe uk-video="automute: false;autoplay:false" src="{{$arr['url']}}" allow="autoplay; fullscreen" allowfullscreen></iframe>
                                        </div>
                                    </li>
                                @elseif (strtolower($arr['type']) =="download")
                                    <li>
                                        <div class="text-center text-white link p-10 bg-gray-800 min-h-screen-half">

                                            <div class=" font-bold text-4xl">{{$arr['text']}}</div>

                                            <div class="my-5 inline-block top-div">
                                                <div class="border-8 rounded-full mb-1">
                                                    <a href="{{$arr['url']}}" download class="down_icon py-5 inline-block" title="Download">
                                                        <i class="fa fa-download text-6xl"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            @if($arr['param'] !='')
                                            <p class="text-2xl font-bold mt-0">({{$arr['param']}})</p>
                                            @endif
                                        </div>
                                    </li>
                                @elseif (strtolower($arr['type']) =="other")
                                    <li>
                                        <div class="text-center text-white link p-10 bg-gray-800 min-h-screen-half">

                                            <div class=" font-bold text-4xl">{{$arr['text']}}</div>

                                            <div class="my-5 inline-block top-div">
                                                <div class="border-8 rounded-full mb-1">
                                                    <a href="{{$arr['url']}}" target="_blank" class="down_icon py-5 inline-block" title="Download">
                                                        <i class="fa fa-link text-6xl"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            @if($arr['param'] !='')
                                            <p class="text-2xl font-bold mt-0">{{$arr['param']}}</p>
                                            @endif
                                        </div>
                                    </li>
                                @else
                                    <li>
                                        <div class="text-center text-white link p-10 bg-gray-800 min-h-screen-half">

                                            <div class=" font-bold text-4xl">{{$arr['text']}}</div>

                                            <div class="my-5 inline-block top-div">
                                                <div class="border-8 rounded-full mb-1">
                                                    <a href="{{$arr['url']}}" target="_blank" class="down_icon py-5 inline-block" title="Download">
                                                        <i class="fa fa-info-circle text-6xl"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            @if($arr['param'] !='')
                                            <p class="text-2xl font-bold mt-0">{{$arr['param']}}</p>
                                            @endif
                                        </div>
                                    </li>
                                @endif


                            @endforeach
                        @endforeach
                    @else
                        <li>
                            <div class="text-center text-white download-link p-10 bg-gray-800 min-h-screen-half">
                                <div class=" font-bold text-4xl">Course content is empty</div>
                            </div>
                        </li>
                    @endif
                    </ul>

                    <div class="bg-gray-200 w-full h-full absolute inset-0 animate-pulse"></div>

                </div>

               <!--  <div class="flex justify-between font-bold text-lg p-3 text-blue-500">
                    <a title="Announcements Overview 123" class="bg-white border border-blue-600 px-3 py-3 rounded leading-4 ssss" href="">🡸 Previous</a>
                    <a title="Overview to" class="bg-white border border-blue-600 px-3 py-3 rounded leading-4 ssss" href="">Next 🢂</a>
                </div> -->


                <nav class="cd-secondary-nav border-b md:p-0 lg:px-6 bg-white mt-3">

                    <ul id="c_menu_switcher" uk-switcher="connect: #course-tabs; animation: uk-animation-fade">
                        <li class="course_curriculum"><a href="#" class="lg:px-2"> Curriculum </a></li>
                        <li><a href="#" class="lg:px-2"> Overview </a></li>
                        <li><a href="#" class="lg:px-2"> Announcements  </a></li>
                        <li><a href="#" class="lg:px-2"> Faq  </a></li>
                    </ul>
                </nav>

                <div class="container">

                    <div class="__max-w-2xl lg:py-6 mx-auto uk-switcher" id="course-tabs">

                        <!--  curriculum -->
                        <div class="">

                            <!-- sidebar width:100%;position: static;display: block;background-color: transparent;    border-width: 0px;box-shadow: unset;-->
                            <div class="curriculum_tab">

                                <!-- title -->
                                <h2 class="text-2xl font-bold">Learn Responsive Web Design Essentials</h1>

                                <div class="">
                                    <div class="relative overflow-hidden _rounded-md bg-gray-200 h-3 mt-4">
                                        <div class="w-2/4 h-full bg-green-500"></div>
                                    </div>
                                    <div class="mt-2 mb-3 text-base border-b-2 border-gray-300 pb-3 font-semibold">
                                        <div> 146% Complete</div>
                                        <div> Last activity on April 20, 2021</div>
                                    </div>
                                </div>

                                <!-- course Curriculum -->
                                <div id="curriculum_mobile" class="curriculum_container">
                                    <h3 class="mb-4 text-xl font-semibold lg:mb-5"> Course Curriculum </h3>
                                    @if($courseData->content)
                                        <ul uk-accordion="multiple: true" class="divide-y space-y-3">
                                            @php($li_count = 1)
                                            @foreach($courseData->content as $sectionHeading => $sectionContent)
                                                <li class="bg-gray-200 px-0 pb-3 rounded {{($loop->index>0)?'pt-2':'uk-open'}}">

                                                    <a class="uk-accordion-title text-md mx-2 pt-3 font-semibold" href="#">
                                                        <div class="mb-1 text-sm font-medium"> Section {{$loop->index+1}}</div> {{$sectionHeading}}</a>

                                                    <div class="uk-accordion-content mt-3 text-base border-gray-400 border-t">

                                                        <ul class="course-curriculum-list font-medium">

                                                            @foreach($sectionContent as $arr)
                                                                <li class="font-normal hover:bg-gray-100 p-2 flex text-blue-500
                                                                    {{($arr['price'] == 'Free')?' __text-blue-500':''}}
                                                                    {{($arr['type'] == 'Download')?' __pl-8':''}}">

                                                                    {{--$arr['type']--}}


                                                                    @if(strtolower($arr['type']) == 'video')
                                                                        <i class="text-blue-500 fa fa-play-circle leading-6 text-3xl mr-2"></i>
                                                                        <!-- <ion-icon name="play-circle" class="leading-6 text-2xl mr-2"></ion-icon> -->
                                                                    @elseif (strtolower($arr['type']) =="download")
                                                                        <i class="text-blue-500 fa fa-download leading-6 text-3xl mr-2"></i>
                                                                        <!-- <ion-icon class="icon-feather-download leading-6 text-2xl mr-2"></ion-icon> -->
                                                                    @elseif (strtolower($arr['type']) =="other")
                                                                        <i class="text-blue-500 fa fa-link leading-6 text-3xl mr-2"></i>
                                                                        <!-- <ion-icon class="icon-feather-link leading-6 text-2xl mr-2"></ion-icon> -->
                                                                    @else
                                                                        <i class="text-blue-500 fa fa-info-circle leading-6 text-3xl mr-2"></i>
                                                                        <!-- <ion-icon class="icon-feather-box leading-6 text-2xl mr-2"></ion-icon> -->
                                                                    @endif

                                                                    



                                                                    <div class="link_div mr-2 text-justify">
                                                                        <a class="switch-links" href="{{$arr['url']}}" data-id="{{$li_count}}">{{$li_count}} . {{$arr['text']}}</a>

                                                                        @if($arr['price'] == 'Free' && $arr['type'] == 'Video')
                                                                        <!-- <a href="#trailer-modal" class="bg-blue-500 hover:text-white text-white bg-gray-200 ml-4 px-2 py-1 rounded-full text-xs" uk-toggle="">Preview</a> -->
                                                                        @endif

                                                                        @if($arr['price'] == 'Free' && $arr['type'] == 'Download')
                                                                        <!-- <a href="{{$arr['url']}}" target="_blank" class="bg-blue-500 hover:text-white text-white bg-gray-200 ml-4 px-2 py-1 rounded-full text-xs" uk-toggle="">Download</a> -->
                                                                        @endif
                                                                    </div>


                                                                    @if($arr['param'] !='')
                                                                        <span class="param text-sm ml-auto">{{$arr['param']}}</span>
                                                                    @endif


                                                                    <!--
                                                                    @if($loop->index%2==0)
                                                                    <button class="ml-1 change_lec_stat" name="" type="button" class="">✅</button>
                                                                    @else
                                                                    <button class="ml-1 change_lec_stat" name="" type="button" class="">⬜</button>
                                                                    @endif
                                                                    -->
                                                                </li>
                                                                @php($li_count++)
                                                            @endforeach

                                                        </ul>

                                                    </div>
                                                </li>
                                            @endforeach

                                        </ul>
                                    @else
                                        <p class="text-center text-sm font-semibold">Course content is empty</p>
                                    @endif
                                </div>

                            </div>
                        </div>


                        <!--  Overview -->
                        <div>
                            <h4 class="text-2xl font-semibold"> About this course </h4>

                            <p> Learn Web Development Without Writing Much Code </p>
                            <hr class="my-5">

                            <div class="grid lg:grid-cols-3 mt-8 gap-8">
                                <div>
                                    <h3 class="text-lg font-semibold"> Description </h3>
                                </div>
                                <div class="col-span-2">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod
                                        tincidunt ut
                                        laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim laoreet dolore magna
                                        aliquam erat
                                        volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit
                                        lobortis
                                        nisl ut aliquip ex ea commodo consequat

                                        <br>
                                        <a href="#" class="text-blue-500">Read more .</a>
                                    </p>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold"> What You’ll Learn </h3>
                                </div>
                                <div class="col-span-2">
                                    <ul>
                                        <li> <i class="uil-check text-xl font-bold mr-2"></i>Setting up the environment</li>
                                        <li> <i class="uil-check text-xl font-bold mr-2"></i>Advanced HTML Practices</li>
                                        <li> <i class="uil-check text-xl font-bold mr-2"></i>Build a portfolio website</li>
                                        <li> <i class="uil-check text-xl font-bold mr-2"></i>Responsive Designs</li>
                                        <li> <i class="uil-check text-xl font-bold mr-2"></i>Understand HTML Programming</li>
                                        <li> <i class="uil-check text-xl font-bold mr-2"></i>Code HTML</li>
                                        <li> <i class="uil-check text-xl font-bold mr-2"></i>Start building beautiful websites</li>
                                    </ul>
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold"> Requirements </h3>
                                </div>
                                <div class="col-span-2">
                                    <ul class="list-disc ml-5 space-y-1">
                                        <li>Any computer will work: Windows, macOS or Linux</li>
                                        <li>Basic programming HTML and CSS.</li>
                                        <li>Basic/Minimal understanding of JavaScript</li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                        <!-- -->




                        <!--  Announcements -->
                        <div>
                            <h3 class="text-xl font-semibold mb-3"> Announcement </h3>

                            <div class="flex items-center gap-x-4 mb-5">
                                <img src="{{asset('images/avatars/avatar-4.jpg')}}" alt="" class="rounded-full shadow w-12 h-12">
                                <div>
                                    <h4 class="-mb-1 text-base"> Stella Johnson</h4>
                                    <span class="text-sm"> Instructor <span class="text-gray-500"> 1 year ago </span> </span>
                                </div>
                            </div>

                            <h4 class="leading-8 text-xl"> Nam liber tempor cum soluta nobis eleifend option congue imperdiet
                                doming id quod mazim placerat facer possim assum.</h4>
                            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                                laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                                voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod
                                tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis
                                nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Nam
                                liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim
                                placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam
                                nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad
                                minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea
                                commodo consequat.</p>
                        </div>
                        <!--  -->


                        <!-- faq -->
                        <div>
                            <h3 class="text-xl font-semibold mb-3"> Course Faq </h3>
                            <ul uk-accordion="multiple: true" class="divide-y space-y-3 space-y-6">
                                <li class="uk-open">
                                    <a class="uk-accordion-title font-semibold text-xl mt-4" href="#"> Html Introduction </a>
                                    <div class="uk-accordion-content mt-3">
                                        <p> The primary goal of this quick start guide is to introduce you to
                                            Unreal
                                            Engine 4`s (UE4) development environment. By the end of this guide,
                                            you`ll
                                            know how to set up and develop C++ Projects in UE4. This guide shows
                                            you
                                            how
                                            to create a new Unreal Engine project, add a new C++ class to it,
                                            compile
                                            the project, and add an instance of a new class to your level. By
                                            the
                                            time
                                            you reach the end of this guide, you`ll be able to see your
                                            programmed
                                            Actor
                                            floating above a table in the level. </p>
                                    </div>
                                </li>
                                <li>
                                    <a class="uk-accordion-title font-semibold text-xl mt-4" href="#"> Your First webpage</a>
                                    <div class="uk-accordion-content mt-3">
                                        <p> The primary goal of this quick start guide is to introduce you to
                                            Unreal
                                            Engine 4`s (UE4) development environment. By the end of this guide,
                                            you`ll
                                            know how to set up and develop C++ Projects in UE4. This guide shows
                                            you
                                            how
                                            to create a new Unreal Engine project, add a new C++ class to it,
                                            compile
                                            the project, and add an instance of a new class to your level. By
                                            the
                                            time
                                            you reach the end of this guide, you`ll be able to see your
                                            programmed
                                            Actor
                                            floating above a table in the level. </p>
                                    </div>
                                </li>
                                <li>
                                    <a class="uk-accordion-title font-semibold text-xl mt-4" href="#"> Some Special Tags </a>
                                    <div class="uk-accordion-content mt-3">
                                        <p> The primary goal of this quick start guide is to introduce you to
                                            Unreal
                                            Engine 4`s (UE4) development environment. By the end of this guide,
                                            you`ll
                                            know how to set up and develop C++ Projects in UE4. This guide shows
                                            you
                                            how
                                            to create a new Unreal Engine project, add a new C++ class to it,
                                            compile
                                            the project, and add an instance of a new class to your level. By
                                            the
                                            time
                                            you reach the end of this guide, you`ll be able to see your
                                            programmed
                                            Actor
                                            floating above a table in the level. </p>
                                    </div>
                                </li>
                                <li>
                                    <a class="uk-accordion-title font-semibold text-xl mt-4" href="#"> Html Introduction </a>
                                    <div class="uk-accordion-content mt-3">
                                        <p> The primary goal of this quick start guide is to introduce you to
                                            Unreal
                                            Engine 4`s (UE4) development environment. By the end of this guide,
                                            you`ll
                                            know how to set up and develop C++ Projects in UE4. This guide shows
                                            you
                                            how
                                            to create a new Unreal Engine project, add a new C++ class to it,
                                            compile
                                            the project, and add an instance of a new class to your level. By
                                            the
                                            time
                                            you reach the end of this guide, you`ll be able to see your
                                            programmed
                                            Actor
                                            floating above a table in the level. </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!--  -->

                    </div>

                </div>


            </div>

        </div>

        <!-- 
        <div class="max-w-5xl md:p-5 mx-auto">
            <div class="lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-8 p-3">
                <div class="">

                    <div>
                        <h2 class="font-semibold mb-3 text-xl lg:text-3xl">Empty Page</h2>
                        <hr class="mb-5">
                        <h4 class="font-semibold mb-2 text-base"> Description </h4>
                        <div class="__space-y-2">

                        </div>
                    </div>

                </div>
            </div>
        </div> 
        -->

    </div>
@stop

@section('bootstrap-modals')
    <!-- course-watch.php -->
    <!-- This is the modal -->
    <div id="modal-example" class="lg:ml-80" uk-modal>
        <div class="uk-modal-dialog uk-modal-body rounded-md shadow-xl">

            <button class="absolute block top-0 right-0 m-6 rounded-full bg-gray-100 leading-4 p-1 text-2xl uk-modal-close" type="button">
                <i class="icon-feather-x"></i>
            </button>

            <div class="text-sm mb-2">  Section 2  </div>
            <h2 class="mb-5 font-semibold text-2xl">  Your First webpage  </h2>
            <p class="text-base">Do You want to skip the rest of this chapter and chumb to next chapter.</p>

            <div class="text-right  pt-3 mt-3">
                <a href="#" class="py-2 inline-block px-8 rounded-md hover:bg-gray-200 uk-modal-close"> Stay </a>
                <a href="#" class="button"> Continue </a>
            </div>
        </div>
    </div>

@stop



@section('script-files')
<script src="{{asset('plugins/tooltipster/dist/js/tooltipster.bundle.min.js')}}"></script>
@stop




@section('javascript')
<script>    


    //handle next,previous arrows according to selected video
    function handle_vid_next_prev(v_id){
        var prev_vid    = v_id - 1;
        var next_vid    = v_id + 1;
        var $cc_list    = $('#curriculum_sidebar .course-curriculum-list');        
        
        var $prev       = $('.c_link_navigator .prev');
        var $next       = $('.c_link_navigator .next');

        var prevText = $cc_list.find('a[data-id="'+ prev_vid +'"]').html();        
        var nextText = $cc_list.find('a[data-id="'+ next_vid +'"]').html();

        if (typeof prevText === 'undefined'){
            $prev.addClass('disabled');
            $prev.tooltipster('content', null);
        }else{
            $prev.removeClass('disabled');
            $prev.tooltipster('content', prevText);
        }

        if (typeof nextText === 'undefined'){
            $next.addClass('disabled');
            $next.tooltipster('content', null);
        }else{
            $next.removeClass('disabled');
            $next.tooltipster('content', nextText);
        }
    }



    $(document).ready(function() {
        
        $('.c_link_navigator .prev').tooltipster({
            animation: 'grow',            
            theme: 'tooltipster-noir',
            touchDevices: true,
            trigger: 'hover',
            position: 'right',
            contentAsHTML:true
            //content: $('<span><strong>prev text is in bold case !</strong></span>'),
        });

        $('.c_link_navigator .next').tooltipster({
            animation: 'grow',            
            theme: 'tooltipster-noir',
            touchDevices: true,
            trigger: 'hover',
            position: 'left',
            contentAsHTML:true
            //content: $('<span><strong>next text is in bold case !</strong></span>'),
        });         

    });


  

    $(document).on('click','a.switch-links',function(event,is_url_push_history=true){
        event.preventDefault();
        var id          = $(this).data('id');  
        var courseTitle = '{{$courseData->name}}';
        var iframe      = $( "ul#video_tabs li").eq(id-1).find('iframe');      
        // reset content list
        $( "ul#video_tabs li").each(function( index, element ){
            $( element).removeClass('active');
            $( element).hide();
            console.log(element);
        });

        //load new content
        $( "ul#video_tabs li").eq((id-1)).addClass('active');
        $( "ul#video_tabs li").eq((id-1)).fadeIn(1000);



        //reload iframe
        if(iframe.length > 0){
            var url_src = iframe.attr('src');
            iframe.attr('src', url_src);
        }
        

        //highlight links in #curriculum_sidebar 
        $("#curriculum_sidebar ul.course-curriculum-list li").removeClass("active");
        $("#curriculum_sidebar ul.course-curriculum-list li a.switch-links").filter("[data-id='" + id + "']")
        .closest('li').addClass("active");
        


        //highlight links in #curriculum_mobile
        $("#curriculum_mobile ul.course-curriculum-list li").removeClass("active");
        $("#curriculum_mobile ul.course-curriculum-list li a.switch-links").filter("[data-id='" + id + "']")
        .closest('li').addClass("active");

       
        handle_vid_next_prev(id);
        
        //console.log(`is_url_push_history - [${is_url_push_history}]`);        
        if(is_url_push_history == true){
            history.pushState({ vid: id }, `Selected: ${id}`, `./${id}`);
            $(document).prop('title', `Watch - ${courseTitle}/${id}`);
        }                      

        var cont_position = $("#video_tabs").offset().top;
        //set a callback function for the animate command which will execute after the scroll animation has finished.
        $("html, body").stop().animate({scrollTop:cont_position}, 500, 'swing', function() { 
            //alert("Finished animating");
            //play
        });  
        
    })
    



    $(window).on('popstate', function(event) {        
        
        var push_url_to_history = false;
        //console.log(event.originalEvent.state);            
        
        var state = event.originalEvent.state;
        console.log(state);
        var v_id = state.vid;
        
        if(!isNaN(v_id)){
            $('#curriculum_sidebar .course-curriculum-list').find('a[data-id="'+ v_id +'"]').trigger('click',[push_url_to_history]);        
        }
        return false;
    });




    $('.c_link_navigator .prev').on( "click", function(event) {
        var $cc_list        = $('#curriculum_sidebar ul.course-curriculum-list');
        var current_id      = $cc_list.find('li.active a.switch-links').data('id');
        var prev_id         = current_id - 1;
        var prev_id_index   = prev_id - 1;

        // prev button click disable when selected video is in top of the list 
        if(prev_id_index >= 0){
            var $prev_li_item   = $cc_list.find('li').eq(prev_id_index);
            $prev_li_item.find('a.switch-links').trigger("click",[true]);      
            
            //expand section 
            var accordion_wrapper = $prev_li_item.closest('li.accordion_item');
            var sec_id = $('#curriculum_sidebar ul.uk-accordion > li').index(accordion_wrapper);       
            if(!accordion_wrapper.hasClass('uk-open')){
                UIkit.accordion('#curriculum_sidebar ul.uk-accordion').toggle(sec_id,false);           
            }
            console.log(sec_id);            
        }        
        event.preventDefault();
    });



    $('.c_link_navigator .next').on( "click", function(event) {
        var $cc_list        = $('#curriculum_sidebar ul.course-curriculum-list');
        var current_id      = $cc_list.find('li.active a.switch-links').data('id');
        var last_id         = $cc_list.last().find('li a.switch-links').last().data('id');   
        var next_id         = current_id + 1;
        var next_id_index   = next_id - 1;
        
        // next button click disable when selected video is at last position in list
        if(last_id != next_id_index){
            var $next_li_item   = $cc_list.find('li').eq(next_id_index);
            $next_li_item.find('a.switch-links').trigger("click",[true]);
            
            //expand section
            var accordion_wrapper = $next_li_item.closest('li.accordion_item');
            var sec_id = $('#curriculum_sidebar ul.uk-accordion > li').index(accordion_wrapper);
            if(!accordion_wrapper.hasClass('uk-open')){
                UIkit.accordion('#curriculum_sidebar ul.uk-accordion').toggle(sec_id,false);            
            }
            console.log(sec_id);            
        }
        event.preventDefault();       
    });

 

    //switch tabs under the video
    function uiKit_menu_switcher(listSelectorStr){
        var win_width       = $(window).width();
        var list            = $(listSelectorStr);
        var li_item_first   = list.find('li:nth-child(1)');

        if (win_width > 1024) {
            if(li_item_first.is(":visible")){
                li_item_first.hide();
                UIkit.switcher(listSelectorStr).show(1);
            }
        }else{
            if(!li_item_first.is(":visible")){
                li_item_first.show();
                UIkit.switcher(listSelectorStr).show(0);
            }
        }
    }


    
    $(document).ready(function(){
        var vid                 = JSON.parse("{{ json_encode($videoId) }}");
        var sectionId           = JSON.parse("{{ json_encode($sectionId) }}");       
        var push_url_to_history = false;                     
        if(sectionId ==-1){
            return;
        }        
        
        $('#curriculum_sidebar > ul > li').each(function( index, element ){            
            if(index == sectionId){
                //expand the section which contains the link
                if(!$(element).hasClass('uk-open')){
                    UIkit.accordion('#curriculum_sidebar > ul').toggle(index, false);
                    UIkit.accordion('#curriculum_mobile > ul').toggle(index, false);
                }
            }else{
                //collapse other sections
                if($(element).hasClass('uk-open')){
                    UIkit.accordion('#curriculum_sidebar > ul').toggle(index, false);
                    UIkit.accordion('#curriculum_mobile > ul').toggle(index, false);
                }
            }
        });
        
        $('#curriculum_sidebar .course-curriculum-list').find('a[data-id="'+ vid +'"]').trigger('click',[push_url_to_history]);
        uiKit_menu_switcher('#c_menu_switcher');
    });



    $(window).on('resize', function(){
        //var win = $(this); //this = window
        //console.log(win.width());
        uiKit_menu_switcher('#c_menu_switcher');
    });


	// mark course vide comple/not complete status
	//todo - ajax
    /*
    $(document).on('click','.change_lec_stat',function(event){	
        var content = $(this).text();
		//alert(content);
		if(content == '✅'){
			$(this).text('⬜')
		}else if(content == '⬜'){
			$(this).text('✅')
		}
		event.stopPropagation();
		event.preventDefault();
	});
    */
	
</script>
@stop
