@php
    $page = 'course-watch';
    $wrapperCls = 'course-watch';
@endphp



@extends('layouts.master')
@section('title','aa Course watch page')


@section('page-css')
    <style>
        #curriculum ul.course-curriculum-list a{
            color: unset;
        }


    </style>
@stop



@section('content')
    <div class="main-container container">

        <div class="row">

            <!-- sidebar -->
            <div class="sidebar static" id="sidebar">

                <!-- slide_menu for mobile -->
                <span class="btn-close-mobi right-3 left-auto" uk-toggle="target: #wrapper ; cls: is-active"></span>

                <!-- back to home link -->
                <div class="flex justify-between lg:-ml-1 mt-1 mr-2">
                    
                    <a href="course-intro.php" class="flex items-center text-blue-500" title="123 Next Page">
                        <span class="fa fa-fast-backward text-lg"></span>&nbsp;&nbsp;
                        <span class="text-base md:inline hidden font-semibold">Back</span>
                    </a>

                    <a href="course-intro.php" class="flex items-center text-blue-500" title="Next Page">
                        <span class="text-base md:inline hidden font-semibold">Next</span>&nbsp;&nbsp;
                        <span class="fa fa-fast-forward text-lg"></span>
                    </a>

                </div>

                <!-- title -->
                <h1 class="lg:text-2xl text-lg font-bold mt-2 line-clamp-2"> Learn Responsive Web Design Essentials </h1>

                <!-- sidebar list -->
                <div class="sidebar_inner is-watch-2" data-simplebar>

                    <div class="lg:inline hidden">
                        <div class="relative overflow-hidden rounded-md bg-gray-200 h-1 mt-4">
                            <div class="w-2/4 h-full bg-green-500"></div>
                        </div>
                        <div class="mt-2 mb-3 text-sm border-b pb-3">
                            <div> 46% Complete</div>
                            <div> Last activity on April 20, 2021</div>
                        </div>
                    </div>

                    <div id="curriculum">
                        <div uk-accordion="multiple: true" class="divide-y space-y-3">

                            <div class="uk-open">
                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#">  <div class="mb-1 text-sm font-medium"> Section 1 </div> Html Introduction </a>
                                <div class="uk-accordion-content mt-3">

                                    <ul class="course-curriculum-list" uk-switcher="connect: #video_tabs; animation: animation: uk-animation-slide-right-small, uk-animation-slide-left-medium">
                                        <li>
                                            <a href="#" class="justify-between">
                                                What is HTML <button class="change_lec_stat" name="" type="button" class="">✅</button>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="justify-between">
                                                What is a Web page? <button class="change_lec_stat" name="" type="button" class="">⬜</button>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="justify-between">
                                                Your First Web Page
                                                <button class="change_lec_stat" name="" type="button" class="">⬜</button>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">

                                                Brain Streak <span class="hidden"> 5 min </span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div class="pt-2">
                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 2 </div> Your First webpage  </a>
                                <div class="uk-accordion-content mt-3">

                                    <ul class="course-curriculum-list">
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                 Headings111111111
                                                <span> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                 Paragraphs
                                                <span> 5 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                Emphasis and Strong Tag
                                                <span> 8 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                Brain Streak
                                                <span> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                Live Preview Feature
                                                <span> 5 min </span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div class="pt-2">
                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 3 </div> Build Complete Webste  </a>
                                <div class="uk-accordion-content mt-3">

                                    <ul class="course-curriculum-list font-medium">
                                        <li>
                                            <a href="#">
                                                 The paragraph tag
                                                <span class="hidden"> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                 The break tag
                                                <span class="hidden"> 5 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Headings in HTML
                                                <span class="hidden"> 8 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Bold, Italics Underline
                                                <span class="hidden"> 4 min </span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div class="pt-2">
                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 2 </div> Your First webpage  </a>
                                <div class="uk-accordion-content mt-3">

                                    <ul class="course-curriculum-list">
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                 Headings111111111
                                                <span> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                 Paragraphs
                                                <span> 5 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                Emphasis and Strong Tag
                                                <span> 8 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                Brain Streak
                                                <span> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                Live Preview Feature
                                                <span> 5 min </span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div class="pt-2">
                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 3 </div> Build Complete Webste  </a>
                                <div class="uk-accordion-content mt-3">

                                    <ul class="course-curriculum-list font-medium">
                                        <li>
                                            <a href="#">
                                                 The paragraph tag
                                                <span class="hidden"> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                 The break tag
                                                <span class="hidden"> 5 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Headings in HTML
                                                <span class="hidden"> 8 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Bold, Italics Underline
                                                <span class="hidden"> 4 min </span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div class="pt-2">
                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 3 </div> Build Complete Webste  </a>
                                <div class="uk-accordion-content mt-3">

                                    <ul class="course-curriculum-list font-medium">
                                        <li>
                                            <a href="#">
                                                 The paragraph tag
                                                <span class="hidden"> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                 The break tag
                                                <span class="hidden"> 5 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Headings in HTML
                                                <span class="hidden"> 8 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Bold, Italics Underline
                                                <span class="hidden"> 4 min </span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div class="pt-2">
                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 2 </div> Your First webpage  </a>
                                <div class="uk-accordion-content mt-3">

                                    <ul class="course-curriculum-list">
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                 Headings111111111
                                                <span> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                 Paragraphs
                                                <span> 5 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                Emphasis and Strong Tag
                                                <span> 8 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                Brain Streak
                                                <span> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                Live Preview Feature
                                                <span> 5 min </span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div class="pt-2">
                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 3 </div> Build Complete Webste  </a>
                                <div class="uk-accordion-content mt-3">

                                    <ul class="course-curriculum-list font-medium">
                                        <li>
                                            <a href="#">
                                                 The paragraph tag
                                                <span class="hidden"> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                 The break tag
                                                <span class="hidden"> 5 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Headings in HTML
                                                <span class="hidden"> 8 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Bold, Italics Underline
                                                <span class="hidden"> 4 min </span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div class="pt-2">
                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 2 </div> Your First webpage  </a>
                                <div class="uk-accordion-content mt-3">

                                    <ul class="course-curriculum-list">
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                 Headings111111111
                                                <span> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                 Paragraphs
                                                <span> 5 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                Emphasis and Strong Tag
                                                <span> 8 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                Brain Streak
                                                <span> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                Live Preview Feature
                                                <span> 5 min </span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div class="pt-2">
                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 3 </div> Build Complete Webste  </a>
                                <div class="uk-accordion-content mt-3">

                                    <ul class="course-curriculum-list font-medium">
                                        <li>
                                            <a href="#">
                                                 The paragraph tag
                                                <span class="hidden"> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                 The break tag
                                                <span class="hidden"> 5 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Headings in HTML
                                                <span class="hidden"> 8 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Bold, Italics Underline
                                                <span class="hidden"> 4 min </span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div class="pt-2">
                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 2 </div> Your First webpage  </a>
                                <div class="uk-accordion-content mt-3">

                                    <ul class="course-curriculum-list">
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                 Headings111111111
                                                <span> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                 Paragraphs
                                                <span> 5 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                Emphasis and Strong Tag
                                                <span> 8 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                Brain Streak
                                                <span> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                Live Preview Feature
                                                <span> 5 min </span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div class="pt-2">
                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 3 </div> Build Complete Webste  </a>
                                <div class="uk-accordion-content mt-3">

                                    <ul class="course-curriculum-list font-medium">
                                        <li>
                                            <a href="#">
                                                 The paragraph tag
                                                <span class="hidden"> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                 The break tag
                                                <span class="hidden"> 5 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Headings in HTML
                                                <span class="hidden"> 8 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Bold, Italics Underline
                                                <span class="hidden"> 4 min </span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div class="pt-2">
                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 3 </div> Build Complete Webste  </a>
                                <div class="uk-accordion-content mt-3">

                                    <ul class="course-curriculum-list font-medium">
                                        <li>
                                            <a href="#">
                                                 The paragraph tag
                                                <span class="hidden"> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                 The break tag
                                                <span class="hidden"> 5 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Headings in HTML
                                                <span class="hidden"> 8 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Bold, Italics Underline
                                                <span class="hidden"> 4 min </span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div class="pt-2">
                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 2 </div> Your First webpage  </a>
                                <div class="uk-accordion-content mt-3">

                                    <ul class="course-curriculum-list">
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                 Headings111111111
                                                <span> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                 Paragraphs
                                                <span> 5 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                Emphasis and Strong Tag
                                                <span> 8 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                Brain Streak
                                                <span> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                                Live Preview Feature
                                                <span> 5 min </span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div class="pt-2">
                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 3 </div> Build Complete Webste  </a>
                                <div class="uk-accordion-content mt-3">

                                    <ul class="course-curriculum-list font-medium">
                                        <li>
                                            <a href="#">
                                                 The paragraph tag
                                                <span class="hidden"> 4 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                 The break tag
                                                <span class="hidden"> 5 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Headings in HTML
                                                <span class="hidden"> 8 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Bold, Italics Underline
                                                <span class="hidden"> 4 min </span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="mt-5">
                        <h3 class="mb-4 text-lg font-semibold"> Quizzes</h3>
                        <ul>
                            <li><a href="#"> <ion-icon name="timer-outline" class="side-icon"></ion-icon>   Taking small eco-friendly steps </a></li>
                            <li><a href="#"> <ion-icon name="timer-outline" class="side-icon"></ion-icon>   Making your house eco-friendly </a></li>
                            <li><a href="#"> <ion-icon name="timer-outline" class="side-icon"></ion-icon>   Building and renovating for eco-friendly homes </a></li>
                            <li><a href="#"> <ion-icon name="log-in-outline" class="side-icon"></ion-icon> Taking small eco-friendly  </a>
                                <ul>
                                    <li><a href="#"> Making your house </a></li>
                                    <li><a href="#"> Building and renovating </a></li>
                                    <li><a href="#"> Taking small </a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                </div>

                <!-- overly for mobile -->
                <div class="side_overly" uk-toggle="target: #wrapper ; cls: is-collapse is-active"></div>

            </div>

            <!-- Main Contents -->
            <div class="main_content ml-0--imp">

                <div class="relative">

                    <ul class="uk-switcher relative z-10" id="video_tabs">
                        <li>
                            <!-- to autoplay video uk-video="automute: true" -->
                            <div class="embed-video">
                                <iframe src="https://www.youtube.com/embed/TPZElgylFgU" frameborder="0"
                                    uk-video="automute: true" allowfullscreen uk-responsive></iframe>
                            </div>

                        </li>

                        <li>
                            <!-- to autoplay video uk-video="automute: true" -->
                            <div class="embed-video">
                                <iframe src="https://player.vimeo.com/video/619963125?h=892a71964c" width="640" height="470" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </li>

                        
                        <li>
                            <!-- to autoplay video uk-video="automute: true" -->
                            <div class="embed-video">
                            <iframe src="https://player.vimeo.com/video/629141099?h=0e3552c488" width="640" height="480" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </li>


                        <li>
                            <div class="embed-video">
                                <iframe src="https://www.youtube.com/embed/dDn9uw7N9Xg" frameborder="0" allowfullscreen
                                    uk-responsive></iframe>
                            </div>
                        </li>
                        <li>
                            <div class="embed-video">
                                <iframe src="https://www.youtube.com/embed/CGSdK7FI9MY" frameborder="0" allowfullscreen
                                    uk-responsive></iframe>
                            </div>
                        </li>
                        <li>
                            <div class="embed-video">
                                <iframe src="https://www.youtube.com/embed/4I1WgJz_lmA" frameborder="0" allowfullscreen
                                    uk-responsive></iframe>
                            </div>
                        </li>
                        <li>
                            <div class="embed-video">
                                <iframe src="https://www.youtube.com/embed/dDn9uw7N9Xg" frameborder="0" allowfullscreen
                                    uk-responsive></iframe>
                            </div>
                        </li>
                        <li>
                            <div class="embed-video">
                                <iframe src="https://www.youtube.com/embed/CPcS4HtrUEU" frameborder="0" allowfullscreen
                                    uk-responsive></iframe>
                            </div>
                        </li>
                    </ul>

                    <div class="bg-gray-200 w-full h-full absolute inset-0 animate-pulse"></div>

                </div>

                <div class="flex justify-between font-bold text-lg p-3 text-blue-500">
                    <a title="Announcements Overview 123" class="bg-white border border-blue-600 px-3 py-3 rounded leading-4 ssss" href="">🡸 Previous</a>
                    <a title="Overview to" class="bg-white border border-blue-600 px-3 py-3 rounded leading-4 ssss" href="">Next 🢂</a>
                </div>


                <nav class="cd-secondary-nav border-b md:p-0 lg:px-6 bg-white " uk-sticky="cls-active:shadow-sm ; media: @s">
                    <ul uk-switcher="connect: #course-tabs; animation: uk-animation-fade">
                        <li><a href="#" class="lg:px-2"> Curriculum </a></li>
                        <li><a href="#" class="lg:px-2"> Overview </a></li>
                        <li><a href="#" class="lg:px-2"> Announcements  </a></li>
                        <li><a href="#" class="lg:px-2"> Faq  </a></li>
                    </ul>
                </nav>

                <div class="container">

                    <div class="max-w-2xl lg:py-6 mx-auto uk-switcher" id="course-tabs">

                        

                        <div>
                            <!-- sidebar -->
                            <div class="sidebar" id="sidebar" style="width:100%;position: static;display: block;background-color: transparent;    border-width: 0px;box-shadow: unset;">                                                     

                                <!-- title -->
                                <h1 class="lg:text-2xl text-center text-lg font-bold mt-2 line-clamp-2"> Learn Responsive Web Design Essentials </h1>

                                <!-- sidebar list -->
                                <div class="sidebar_inner" style="position: static;margin: 0px;width: unset;height: unset !important;background-color: transparent;">

                                    <div class="lg:inline">
                                        <div class="relative overflow-hidden rounded-md bg-gray-200 h-1 mt-4">
                                            <div class="w-2/4 h-full bg-green-500"></div>
                                        </div>
                                        <div class="mt-2 mb-3 text-sm border-b pb-3">
                                            <div> 146% Complete</div>
                                            <div> Last activity on April 20, 2021</div>
                                        </div>
                                    </div>

                                    <div id="curriculum">
                                        <div uk-accordion="multiple: true" class="divide-y space-y-3">

                                            <div class="uk-open">
                                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#">  <div class="mb-1 text-sm font-medium"> Section 1 </div> Html Introduction </a>
                                                <div class="uk-accordion-content mt-3">

                                                    <ul class="course-curriculum-list" uk-switcher="connect: #video_tabs; animation: animation: uk-animation-slide-right-small, uk-animation-slide-left-medium">
                                                        <li>
                                                            <a href="#" class="justify-between">
                                                                What is HTML <button class="change_lec_stat" name="" type="button" class="">✅</button>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="justify-between">
                                                                What is a Web page? <button class="change_lec_stat" name="" type="button" class="">⬜</button>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="justify-between">
                                                                Your First Web Page
                                                                <button class="change_lec_stat" name="" type="button" class="">⬜</button>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="#">

                                                                Brain Streak <span class="hidden"> 5 min </span>
                                                            </a>
                                                        </li>
                                                    </ul>

                                                </div>
                                            </div>
                                            <div class="pt-2">
                                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 2 </div> Your First webpage  </a>
                                                <div class="uk-accordion-content mt-3">

                                                    <ul class="course-curriculum-list">
                                                        <li>
                                                            <a href="#modal-example" uk-toggle>
                                                               Headings111111111
                                                               <span> 4 min </span>
                                                           </a>
                                                       </li>
                                                       <li>
                                                        <a href="#modal-example" uk-toggle>
                                                           Paragraphs
                                                           <span> 5 min </span>
                                                       </a>
                                                   </li>
                                                   <li>
                                                    <a href="#modal-example" uk-toggle>
                                                        Emphasis and Strong Tag
                                                        <span> 8 min </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#modal-example" uk-toggle>
                                                        Brain Streak
                                                        <span> 4 min </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#modal-example" uk-toggle>
                                                        Live Preview Feature
                                                        <span> 5 min </span>
                                                    </a>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                    <div class="pt-2">
                                        <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 3 </div> Build Complete Webste  </a>
                                        <div class="uk-accordion-content mt-3">

                                            <ul class="course-curriculum-list font-medium">
                                                <li>
                                                    <a href="#">
                                                       The paragraph tag
                                                       <span class="hidden"> 4 min </span>
                                                   </a>
                                               </li>
                                               <li>
                                                <a href="#">
                                                   The break tag
                                                   <span class="hidden"> 5 min </span>
                                               </a>
                                           </li>
                                           <li>
                                            <a href="#">
                                                Headings in HTML
                                                <span class="hidden"> 8 min </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                Bold, Italics Underline
                                                <span class="hidden"> 4 min </span>
                                            </a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <div class="pt-2">
                                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 2 </div> Your First webpage  </a>
                                <div class="uk-accordion-content mt-3">

                                    <ul class="course-curriculum-list">
                                        <li>
                                            <a href="#modal-example" uk-toggle>
                                               Headings111111111
                                               <span> 4 min </span>
                                           </a>
                                       </li>
                                       <li>
                                        <a href="#modal-example" uk-toggle>
                                           Paragraphs
                                           <span> 5 min </span>
                                       </a>
                                   </li>
                                   <li>
                                    <a href="#modal-example" uk-toggle>
                                        Emphasis and Strong Tag
                                        <span> 8 min </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#modal-example" uk-toggle>
                                        Brain Streak
                                        <span> 4 min </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#modal-example" uk-toggle>
                                        Live Preview Feature
                                        <span> 5 min </span>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                    <div class="pt-2">
                        <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 3 </div> Build Complete Webste  </a>
                        <div class="uk-accordion-content mt-3">

                            <ul class="course-curriculum-list font-medium">
                                <li>
                                    <a href="#">
                                       The paragraph tag
                                       <span class="hidden"> 4 min </span>
                                   </a>
                               </li>
                               <li>
                                <a href="#">
                                   The break tag
                                   <span class="hidden"> 5 min </span>
                               </a>
                           </li>
                           <li>
                            <a href="#">
                                Headings in HTML
                                <span class="hidden"> 8 min </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Bold, Italics Underline
                                <span class="hidden"> 4 min </span>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="pt-2">
                <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 3 </div> Build Complete Webste  </a>
                <div class="uk-accordion-content mt-3">

                    <ul class="course-curriculum-list font-medium">
                        <li>
                            <a href="#">
                               The paragraph tag
                               <span class="hidden"> 4 min </span>
                           </a>
                       </li>
                       <li>
                        <a href="#">
                           The break tag
                           <span class="hidden"> 5 min </span>
                       </a>
                   </li>
                   <li>
                    <a href="#">
                        Headings in HTML
                        <span class="hidden"> 8 min </span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        Bold, Italics Underline
                        <span class="hidden"> 4 min </span>
                    </a>
                </li>
            </ul>

        </div>
    </div>
    <div class="pt-2">
        <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 2 </div> Your First webpage  </a>
        <div class="uk-accordion-content mt-3">

            <ul class="course-curriculum-list">
                <li>
                    <a href="#modal-example" uk-toggle>
                       Headings111111111
                       <span> 4 min </span>
                   </a>
               </li>
               <li>
                <a href="#modal-example" uk-toggle>
                   Paragraphs
                   <span> 5 min </span>
               </a>
           </li>
           <li>
            <a href="#modal-example" uk-toggle>
                Emphasis and Strong Tag
                <span> 8 min </span>
            </a>
        </li>
        <li>
            <a href="#modal-example" uk-toggle>
                Brain Streak
                <span> 4 min </span>
            </a>
        </li>
        <li>
            <a href="#modal-example" uk-toggle>
                Live Preview Feature
                <span> 5 min </span>
            </a>
        </li>
    </ul>

</div>
</div>
<div class="pt-2">
    <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 3 </div> Build Complete Webste  </a>
    <div class="uk-accordion-content mt-3">

        <ul class="course-curriculum-list font-medium">
            <li>
                <a href="#">
                   The paragraph tag
                   <span class="hidden"> 4 min </span>
               </a>
           </li>
           <li>
            <a href="#">
               The break tag
               <span class="hidden"> 5 min </span>
           </a>
       </li>
       <li>
        <a href="#">
            Headings in HTML
            <span class="hidden"> 8 min </span>
        </a>
    </li>
    <li>
        <a href="#">
            Bold, Italics Underline
            <span class="hidden"> 4 min </span>
        </a>
    </li>
</ul>

</div>
</div>
<div class="pt-2">
    <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 2 </div> Your First webpage  </a>
    <div class="uk-accordion-content mt-3">

        <ul class="course-curriculum-list">
            <li>
                <a href="#modal-example" uk-toggle>
                   Headings111111111
                   <span> 4 min </span>
               </a>
           </li>
           <li>
            <a href="#modal-example" uk-toggle>
               Paragraphs
               <span> 5 min </span>
           </a>
       </li>
       <li>
        <a href="#modal-example" uk-toggle>
            Emphasis and Strong Tag
            <span> 8 min </span>
        </a>
    </li>
    <li>
        <a href="#modal-example" uk-toggle>
            Brain Streak
            <span> 4 min </span>
        </a>
    </li>
    <li>
        <a href="#modal-example" uk-toggle>
            Live Preview Feature
            <span> 5 min </span>
        </a>
    </li>
</ul>

</div>
</div>
<div class="pt-2">
    <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 3 </div> Build Complete Webste  </a>
    <div class="uk-accordion-content mt-3">

        <ul class="course-curriculum-list font-medium">
            <li>
                <a href="#">
                   The paragraph tag
                   <span class="hidden"> 4 min </span>
               </a>
           </li>
           <li>
            <a href="#">
               The break tag
               <span class="hidden"> 5 min </span>
           </a>
       </li>
       <li>
        <a href="#">
            Headings in HTML
            <span class="hidden"> 8 min </span>
        </a>
    </li>
    <li>
        <a href="#">
            Bold, Italics Underline
            <span class="hidden"> 4 min </span>
        </a>
    </li>
</ul>

</div>
</div>
<div class="pt-2">
    <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 2 </div> Your First webpage  </a>
    <div class="uk-accordion-content mt-3">

        <ul class="course-curriculum-list">
            <li>
                <a href="#modal-example" uk-toggle>
                   Headings111111111
                   <span> 4 min </span>
               </a>
           </li>
           <li>
            <a href="#modal-example" uk-toggle>
               Paragraphs
               <span> 5 min </span>
           </a>
       </li>
       <li>
        <a href="#modal-example" uk-toggle>
            Emphasis and Strong Tag
            <span> 8 min </span>
        </a>
    </li>
    <li>
        <a href="#modal-example" uk-toggle>
            Brain Streak
            <span> 4 min </span>
        </a>
    </li>
    <li>
        <a href="#modal-example" uk-toggle>
            Live Preview Feature
            <span> 5 min </span>
        </a>
    </li>
</ul>

</div>
</div>
<div class="pt-2">
    <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 3 </div> Build Complete Webste  </a>
    <div class="uk-accordion-content mt-3">

        <ul class="course-curriculum-list font-medium">
            <li>
                <a href="#">
                   The paragraph tag
                   <span class="hidden"> 4 min </span>
               </a>
           </li>
           <li>
            <a href="#">
               The break tag
               <span class="hidden"> 5 min </span>
           </a>
       </li>
       <li>
        <a href="#">
            Headings in HTML
            <span class="hidden"> 8 min </span>
        </a>
    </li>
    <li>
        <a href="#">
            Bold, Italics Underline
            <span class="hidden"> 4 min </span>
        </a>
    </li>
</ul>

</div>
</div>
<div class="pt-2">
    <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 3 </div> Build Complete Webste  </a>
    <div class="uk-accordion-content mt-3">

        <ul class="course-curriculum-list font-medium">
            <li>
                <a href="#">
                   The paragraph tag
                   <span class="hidden"> 4 min </span>
               </a>
           </li>
           <li>
            <a href="#">
               The break tag
               <span class="hidden"> 5 min </span>
           </a>
       </li>
       <li>
        <a href="#">
            Headings in HTML
            <span class="hidden"> 8 min </span>
        </a>
    </li>
    <li>
        <a href="#">
            Bold, Italics Underline
            <span class="hidden"> 4 min </span>
        </a>
    </li>
</ul>

</div>
</div>
<div class="pt-2">
    <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 2 </div> Your First webpage  </a>
    <div class="uk-accordion-content mt-3">

        <ul class="course-curriculum-list">
            <li>
                <a href="#modal-example" uk-toggle>
                   Headings111111111
                   <span> 4 min </span>
               </a>
           </li>
           <li>
            <a href="#modal-example" uk-toggle>
               Paragraphs
               <span> 5 min </span>
           </a>
       </li>
       <li>
        <a href="#modal-example" uk-toggle>
            Emphasis and Strong Tag
            <span> 8 min </span>
        </a>
    </li>
    <li>
        <a href="#modal-example" uk-toggle>
            Brain Streak
            <span> 4 min </span>
        </a>
    </li>
    <li>
        <a href="#modal-example" uk-toggle>
            Live Preview Feature
            <span> 5 min </span>
        </a>
    </li>
</ul>

</div>
</div>
<div class="pt-2">
    <a class="uk-accordion-title text-md mx-2 font-semibold" href="#"> <div class="mb-1 text-sm font-medium"> Section 3 </div> Build Complete Webste  </a>
    <div class="uk-accordion-content mt-3">

        <ul class="course-curriculum-list font-medium">
            <li>
                <a href="#">
                   The paragraph tag
                   <span class="hidden"> 4 min </span>
               </a>
           </li>
           <li>
            <a href="#">
               The break tag
               <span class="hidden"> 5 min </span>
           </a>
       </li>
       <li>
        <a href="#">
            Headings in HTML
            <span class="hidden"> 8 min </span>
        </a>
    </li>
    <li>
        <a href="#">
            Bold, Italics Underline
            <span class="hidden"> 4 min </span>
        </a>
    </li>
</ul>

</div>
</div>

</div>
</div>

<div class="mt-5">
    <h3 class="mb-4 text-lg font-semibold"> Quizzes</h3>
    <ul>
        <li><a href="#"> <ion-icon name="timer-outline" class="side-icon"></ion-icon>   Taking small eco-friendly steps </a></li>
        <li><a href="#"> <ion-icon name="timer-outline" class="side-icon"></ion-icon>   Making your house eco-friendly </a></li>
        <li><a href="#"> <ion-icon name="timer-outline" class="side-icon"></ion-icon>   Building and renovating for eco-friendly homes </a></li>
        <li><a href="#"> <ion-icon name="log-in-outline" class="side-icon"></ion-icon> Taking small eco-friendly  </a>
            <ul>
                <li><a href="#"> Making your house </a></li>
                <li><a href="#"> Building and renovating </a></li>
                <li><a href="#"> Taking small </a></li>
            </ul>
        </li>
    </ul>
</div>

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

                    </div>

                </div>


            </div>

        </div>

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


@section('javascript')
<script>


    // $('a.ssss').tooltip({
    //     placement : 'right',
    //     title: function() {
    //         return $(this).attr('href');
    //     }
    // });



    $(window).on('resize', function(){
        var win = $(this); //this = window
        console.log(win.width());

        if (win.height() >= 820) { /* ... */ }
        if (win.width() >= 1280) { /* ... */ }
    });


	$(document).ready(function(){
		// mark course vide comple/not complete status
		//todo - ajax
		$('.change_lec_stat').click(function(event){
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
	});
</script>
@stop
