@extends('layouts.master')
@section('title','Course page')


@if(!isset($txtColor))
    @php
        $txtColor ="#FFFFFF";
    @endphp
@endif



@section('page-css')

    <style>
        a.invHover:hover{
            color:{{ $hovColor= ($txtColor == '#FFFFFF')?'#4aa1ff':'#0e54a0'}}
        }
    </style>
@stop

@section('content')

    @if(isset($message))
        <div class="flash-msg {{$cls ?? 'flash-info'}} rounded-none">
            <a href="#" class="close">×</a>
            <div class="text-lg"><strong>{{ $msgTitle ?? 'Info!'}}</strong></div>
            <p>{{ $message ?? 'Info!' }}</p>
            <div class="text-base">{!! $message2 ?? '' !!}</div>
        </div>
    @endif


    @php
        //var_dump($courseData);
        //var_dump($courseData->subject->name);
        //var_dump($courseData->teacher->full_name);
    @endphp

    @if(isset($courseData))
        <!-- course preview details -->
        <div class="bg-gray-600 text-white lg:-mt-20 lg:pt-20" style="background: {{$bgColor ?? 'grey'}}">free
            <div class="container p-0">
                <div class="lg:flex items-center lg:space-x-12 lg:py-14 lg:px-20 p-3">

                    <div class="lg:w-4/12">
                        <div class="w-full lg:h-52 h-40 overflow-hidden rounded-lg relative lg:mb-0 mb-4" style="border:2px solid {{$txtColor ?? 'black'}}">
                            @if($courseData->image)
                                <img src="{{URL('/')}}/storage/{{$courseData->image}}" class="w-full h-full absolute inset-0 object-cover" alt="">
                            @else
                                <img src="{{asset('images/default-images/course.png')}}" class="w-full h-full absolute inset-0 object-cover" alt="">
                            @endif
                        </div>
                    </div>
                    <div class="lg:w-8/12 text-white" style="color:{{$txtColor ?? '#fff'}}">
                        @if($courseData->subject)
                            <div class="capitalize mb-2 font-semibold">
                                <a class="__hover:text-white invHover" href="{{route('viewTopic',$courseData->subject->slug)}}">{{$courseData->subject->name}}</a>
                            </div>
                        @endif

                        <h1 style="color:{{$txtColor ?? '#fff'}}" class="lg:leading-10 lg:text-3xl text-xl leading-8 font-bold">{{$courseData->name}}</h1>
                        <p class="lg:w-4/5 mt-2 md:text-lg md:block hidden">{{$courseData->heading_text}}</p>

                        {{--
                        <ul class="flex text-gray-300 gap-4 mt-4 mb-3">
                            <li class="flex items-center">
                                <span class="avg bg-yellow-500 mr-2 px-2 rounded text-white font-semiold"> 4.9 </span>
                                <div class="star-rating text-yellow-300">
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star"></ion-icon>
                                    <ion-icon name="star-half"></ion-icon>
                                </div>
                                <span class="text-white ml-2"> (3453)</span>
                            </li>
                            <li> <ion-icon name="people-circle-outline"></ion-icon> 1200 Enerolled </li>
                        </ul>
                        --}}
                        <ul class="lg:flex items-center">
                            @if($courseData->teacher)
                                <li> Teacher : <a href="{{route('teacher.view-profile',$courseData->teacher->username)}}" class="fond-bold invHover">{{$courseData->teacher->full_name}}</a> </li>
                                <li> <span class="lg:block hidden mx-3 text-2xl">·</span> </li>
                            @endif

                            @if($courseData->created_at)
                                <li> Posted {{$courseData->created_at->diffForHumans()}}</li>
                            @endif
                        </ul>

                    </div>

                </div>
            </div>
        </div>

        <div class="main-container container p-0">
            @if(Session::get('message') !== null)
                <div class="flash-msg {{Session::get('cls') ?? 'flash-info'}} rounded-none">
                    <a href="#" class="close">×</a>
                    <div class="text-lg"><strong>{{ Session::get('msgTitle') ?? 'Info!'}}</strong></div>
                    <p>{{ Session::get('message') ?? 'Info!' }}</p>
                    <div class="text-base">{!! Session::get('message2') ?? '' !!}</div>
                </div>
            @endif

            <div class="lg:flex lg:space-x-4 mt-4">
                <div class="lg:w-8/12 space-y-4">

                    <div class="tube-card z-20 mb-4 overflow-hidden uk-sticky" uk-sticky="cls-active:rounded-none ; media: 992 ; offset:70 ">
                        <nav class="cd-secondary-nav extanded ppercase nav-small">
                            <ul class="space-x-3" uk-scrollspy-nav="closest: li; scroll: true">
                                <li><a href="#Overview" uk-scroll>Overview</a></li>
                                <li><a href="#curriculum" uk-scroll>Curriculum</a></li>
                                <li><a href="#enrollment-details" uk-scroll>Enrollment Details</a></li>
                                {{--
                                <li><a href="#reviews">Reviews</a></li>
                                <li><a href="#comments">Comments</a></li>
                                --}}
                            </ul>
                        </nav>
                    </div>


                    <!-- course description -->
                    <div class="tube-card p-5 lg:p-8" id="Overview">

                        <div class="space-y-6">
                            {!! $courseData->description !!}
                            {{--
                            <div>
                                <h3 class="text-xl font-semibold mb-3"> Description </h3>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod
                                    tincidunt ut
                                    laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim laoreet dolore magna
                                    aliquam erat
                                    volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit
                                    lobortis
                                    nisl ut aliquip ex ea commodo consequat
                                </p>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold mb-1"> What You’ll Learn </h3>
                                <ul class="grid md:grid-cols-2">
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
                                <h3 class="text-lg font-semibold mb-1"> Requirements</h3>
                                <ul class="list-disc ml-5 space-y-1">
                                    <li>Any computer will work: Windows, macOS or Linux</li>
                                    <li>Basic programming HTML and CSS.</li>
                                    <li>Basic/Minimal understanding of JavaScript</li>
                                </ul>
                            </div>
                            <div>
                                <h3> Here is exactly what we cover in this course: </h3>
                                <p> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod
                                    tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis
                                    nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                                    Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod
                                    mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
                                    sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut
                                    wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut
                                    aliquip ex ea commodo consequat.</p>
                            </div>
                            --}}
                        </div>

                    </div>

                    <!-- course Curriculum -->
                    <div id="curriculum" class="tube-card p-5 lg:p-8">
                        <h3 class="mb-4 text-xl font-semibold lg:mb-5"> Course Curriculum </h3>
                        @if(isset($courseData->content))
                            <ul uk-accordion="multiple: true" class="divide-y space-y-3">
                                @php($liCount = 1)
                                @foreach($courseData->content as $sectionHeading => $sectionContent)
                                    <li class="bg-gray-200 px-0 pb-3 rounded {{($loop->index>0)?'pt-2':'uk-open'}}">

                                        <a class="uk-accordion-title text-md mx-2 pt-3 font-semibold" href="#">
                                            <div class="mb-1 text-sm font-medium"> Section {{$loop->index+1}}</div> {{$sectionHeading}}</a>

                                        <div class="uk-accordion-content mt-3 text-base border-gray-400 border-t">

                                            <ul class="course-curriculum-list font-normal">
                                                @foreach($sectionContent as $arr)
                                                    <li class=" hover:bg-gray-100 p-2 flex _rounded-md
                                                        {{($arr['price'] == 'Free')?' text-blue-500':''}}
                                                        {{($arr['type'] == 'Download')?' __pl-8':''}}">


                                                        @if(strtolower($arr['type']) == 'video')
                                                            <i class="fa fa-play-circle leading-6 text-3xl mr-2"></i>
                                                        @elseif (strtolower($arr['type']) =="download")
                                                            <i class="fa fa-download leading-6 text-3xl mr-2"></i>
                                                        @elseif (strtolower($arr['type']) =="other")
                                                            <i class="fa fa-link leading-6 text-3xl mr-2"></i>
                                                        @else
                                                            <i class="fa fa-info-circle leading-6 text-3xl mr-2"></i>
                                                        @endif

                                                        <div class="link_div mr-2 text-justify">
                                                            @if($arr['price'] == 'Free')
                                                                @if($arr['type'] == 'Video')
                                                                    <a href="#preview-modal-{{$liCount}}" class="_underline link" uk-toggle>{{$arr['text']}}</a>
                                                                    <a href="#preview-modal-{{$liCount}}" class="bg-blue-500 hover:text-white text-white bg-gray-200 ml-4 px-2 py-1 rounded-full text-xs" uk-toggle>Preview</a>
                                                                @elseif($arr['type'] == 'Download')
                                                                    <a class="_underline link" download href="{{$arr['url']}}">{{$arr['text']}}</a>
                                                                    <a href="{{$arr['url']}}" download class="bg-blue-500 hover:text-white text-white bg-gray-200 ml-4 px-2 py-1 rounded-full text-xs">Download</a>
                                                                @else
                                                                    <a class="_underline link" href="{{$arr['url']}}" target="_blank">{{$arr['text']}}</a>
                                                                @endif
                                                            @else
                                                                {{$arr['text']}}
                                                            @endif
                                                        </div>

                                                        @if($arr['param'] !='')
                                                            <span class="param text-sm ml-auto">{{$arr['param']}}</span>
                                                        @endif

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



                    <!-- Student details -->
                    <div class="tube-card p-5 lg:p-8 course-student-info bg-yellow-50 space-y-4" id="enrollment-details">
                        <div>
                            <h3 class="text-xl font-semibold lg:mb-5">Teacher details</h3>
                            <div class="bg-gray-50 border flex gap-x-4 p-4 relative rounded-md my-5">

                                <div class="lg:w-1/4">
                                    @if($courseData->teacher->profile_pic)
                                        <img src="{{URL('/')}}/storage/{{$courseData->teacher->profile_pic}}" class="rounded shadow w-full" alt="">
                                    @else
                                        <img src="{{asset('images/default-images/teacher-profile-pic.png')}}" class="rounded shadow w-full" alt="">
                                    @endif
                                </div>

                                <div class="w-3/4 md:text-justify">
                                    <h4 class="text-base m-0 font-semibold"><a href="{{route('teacher.view-profile',$courseData->teacher->username)}}">{{$courseData->teacher->full_name}}</a></h4>
                                    {!! $courseData->teacher->edu_qualifications !!}
                                    {{--
                                    <p class="mt-2 md:ml-0 -ml-16  text-sm">
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam ut laoreet dolore
                                        magna aliquam erat volutpat.
                                    </p>
                                    <p class="mt-2 md:ml-0 -ml-16  text-sm">
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam ut laoreet dolore
                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation
                                        ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                                    </p>
                                    --}}
                                </div>
                            </div>
                        </div>

                        {{--
                        <div>
                            <h3 class="text-xl font-semibold lg:mb-5">Student details</h3>
                            <!-- ACCORDION -->

                            <ul uk-accordion class="uk-accordion">

                                <li class="__uk-open bg-gray-100 px-4 py-3">
                                    <h3 class="uk-accordion-title font-semibold text-base">Enrolled students (65)</h3>
                                    <div class="uk-accordion-content rounded-md">
                                        <ul class="stud-name-list">
                                            <?php //for($i=0;$i<20;$i++): ?>
                                            <li><a href="#">HTML</a></li>
                                            <li><a href="#">CSS</a></li>
                                            <li><a href="#">JavaScript</a></li>
                                            <li><a href="#">PHP</a></li>
                                            <li><a href="#">CSS</a></li>
                                            <li><a href="#">JavaScript</a></li>
                                            <li><a href="#">PHP</a></li>
                                            <li><a href="#">SC</a></li>
                                            <li><a href="#">JavaScript Abc</a></li>
                                            <li><a href="#">PHPT</a></li>
                                            <li><a href="#">SC</a></li>
                                            <li><a href="#">JavaScript We Abc</a></li>
                                            <li><a href="#">PHPT</a></li>
                                            <li><a href="#">PHP</a></li>
                                            <li><a href="#">CSS</a></li>
                                            <li><a href="#">JavaScript</a></li>
                                            <li><a href="#">PHP</a></li>
                                            <li><a href="#">SC</a></li>
                                            <li><a href="#">JavaScript Abc</a></li>
                                            <li><a href="#">PHPT</a></li>
                                            <li><a href="#">SC</a></li>
                                            <li><a href="#">JavaScript We Abc</a></li>
                                            <li><a href="#">PHPT</a></li>
                                            <?php //endfor; ?>
                                        </ul>
                                    </div>
                                </li>

                                <li class="bg-gray-100 px-4 py-3">
                                    <h3 class="uk-accordion-title font-semibold text-base">Course complete students (45)</h3>
                                    <div class="uk-accordion-content rounded-md">
                                        <p class="mt-3">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor reprehenderit.</p>
                                        <ul class="stud-name-list">
                                            <?php //for($i=0;$i<20;$i++): ?>
                                            <li><a href="#">HTML</a></li>
                                            <li><a href="#">CSS</a></li>
                                            <li><a href="#">JavaScript</a></li>
                                            <li><a href="#">PHP</a></li>
                                            <li><a href="#">CSS</a></li>
                                            <li><a href="#">JavaScript</a></li>
                                            <li><a href="#">PHP</a></li>
                                            <li><a href="#">SC</a></li>
                                            <li><a href="#">JavaScript Abc</a></li>
                                            <li><a href="#">PHPT</a></li>
                                            <li><a href="#">SC</a></li>
                                            <li><a href="#">JavaScript We Abc</a></li>
                                            <li><a href="#">PHPT</a></li>
                                            <li><a href="#">PHP</a></li>
                                            <li><a href="#">CSS</a></li>
                                            <li><a href="#">JavaScript</a></li>
                                            <li><a href="#">PHP</a></li>
                                            <li><a href="#">SC</a></li>
                                            <li><a href="#">JavaScript Abc</a></li>
                                            <li><a href="#">PHPT</a></li>
                                            <li><a href="#">SC</a></li>
                                            <li><a href="#">JavaScript We Abc</a></li>
                                            <li><a href="#">PHPT</a></li>
                                            <?php //endfor; ?>
                                        </ul>
                                    </div>
                                </li>
                            </ul>

                        </div>
                        --}}

                    </div>



                    <!-- todo - disable rating after onece done rating -->
                    <!-- course Reviews -->
                    {{--
                    <div id="reviews" class="tube-card p-5 lg:p-8">
                        <h3 class="text-xl font-semibold lg:mb-5"> Reviews (4610) </h3>
                        <section class='rating-widget space-y-2 mb-0'>
                            <!-- Rating Stars Box -->
                            <div class='rating-stars text-center'>
                                <ul id='stars'>
                                    <li class='star' title='Poor' data-value='1'>
                                        <i class='icon-material-outline-star star-icon'></i>
                                    </li>
                                    <li class='star' title='Fair' data-value='2'>
                                        <i class='icon-material-outline-star star-icon'></i>
                                    </li>
                                    <li class='star' title='Good' data-value='3'>
                                        <i class='icon-material-outline-star star-icon'></i>
                                    </li>
                                    <li class='star' title='Excellent' data-value='4'>
                                        <i class='icon-material-outline-star star-icon'></i>
                                    </li>
                                    <li class='star' title='WOW!!!' data-value='5'>
                                        <i class='icon-material-outline-star star-icon'></i>
                                    </li>
                                </ul>
                            </div>
                            <div class='success-box'>
                                <div class='text-center text-message font-semibold'></div>
                            </div>
                        </section>
                    </div>
                    --}}


                    <!-- course Comments -->
                    {{--
                    <div id="comments" class="tube-card p-5 lg:p-8">
                        <h3 class="text-xl font-semibold lg:mb-5"> Comments</h3>

                        <div class=" mb-5">
                            <form>
                                <div class="">
                                    <div class="col-span-2">
                                        <textarea id="about" name="message" cols="30" rows="5" class="with-border" placeholder="Message" required="" autocomplete="off"></textarea>
                                    </div>
                                    <div class="flex justify-end">
                                        <div class="mr-4">
                                            <button type="submit" class="w-32 btn bg-blue-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white">Submit</button>
                                        </div>
                                        <div>
                                            <button type="reset" class="w-32 btn bg-red-600 font-semibold p-2.5 mt-2 rounded-md text-center text-white">Clear</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="space-y-3">
                            <div class="px-4 py-4 bg-gray-50 border">
                                <div class="flex gap-x-4 relative rounded-md" style="justify-content: space-between;">
                                    <div><a href="" class="text-blue-500 text-base m-0 font-semibold">Stella Johnson</a></div>
                                    <div><span class="text-gray-600 font-semibold text-sm"> 14th, April 2021 </span></div>
                                </div>
                                <div>
                                    <p class="text-justify mt-0 md:ml-0 -ml-16">
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam ut laoreet dolore
                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation
                                        ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                                    </p>
                                </div>
                            </div>
                            <div class="px-4 py-4 bg-gray-50 border">
                                <div class="flex gap-x-4 relative rounded-md" style="justify-content: space-between;">
                                    <div><a href="" class="text-blue-500 text-base m-0 font-semibold">Stella Johnson</a></div>
                                    <div><span class="text-gray-600 font-semibold text-sm"> 14th, April 2021 </span></div>
                                </div>
                                <div>
                                    <p class="text-justify mt-0 md:ml-0 -ml-16">
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam ut laoreet dolore
                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation
                                        ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                                    </p>
                                </div>
                            </div>
                            <div class="px-4 py-4 bg-gray-50 border">
                                <div class="flex gap-x-4 relative rounded-md" style="justify-content: space-between;">
                                    <div><a href="" class="text-blue-500 text-base m-0 font-semibold">Stella Johnson</a></div>
                                    <div><span class="text-gray-600 font-semibold text-sm"> 14th, April 2021 </span></div>
                                </div>
                                <div>
                                    <p class="text-justify mt-0 md:ml-0 -ml-16">
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam ut laoreet dolore
                                        magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation
                                        ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                                    </p>
                                </div>
                            </div>

                            <div class="flex justify-center mt-9">
                                <a href="#" class="bg-gray-50 border hover:bg-gray-100 px-4 py-1.5 rounded-full text-sm">More Comments ..</a>
                            </div>

                        </div>
                    </div>
                    --}}
                </div>


                <div class="lg:w-4/12 space-y-4">

                    <div uk-sticky="top:600;offset:; offset:90 ; media: 1024">
                        <div class="tube-card p-5">

                            <div class="">

                                @if($courseData->price)
                                    <div class="items-center">
                                        {{--<div class="text-3xl font-semibold">Rs {{$courseData->price}}</div>--}}
                                        <div class="text-3xl font-semibold">{{ $courseData->price == 0 ? "Free" : 'Rs '.$courseData->price }}</div>
                                    </div>
                                @endif

                                {{--
                                @if($courseData->duration)
                                    <div class="items-center">
                                        <div class="text-xl font-semibold">{{$courseData->duration}}</div>
                                    </div>
                                @endif

                                @if($courseData->video_count)
                                    <div class="space-y-1 items-center">
                                        <div class="text-xl font-semibold">{{$courseData->video_count}} Videos</div>
                                    </div>
                                @endif
                                --}}

                            </div>

                            <hr class="-mx-5 border-gray-200 my-4">
                            <h4 hidden> COURSE INCLUDES</h4>

                            <div class="-m-5 divide-y divide-gray-200 text-sm">
                                @if($courseData->duration)
                                    <div class="flex items-center px-5 py-3 text-xl font-semibold">{{$courseData->duration}}</div>
                                @endif

                                @if($courseData->video_count)
                                    <div class="flex items-center px-5 py-3 text-xl font-semibold">{{$courseData->video_count}} Videos</div>
                                @endif

                                <!--
                                <div class="flex items-center px-5 py-3">  <ion-icon name="play-outline" class="text-2xl mr-2"></ion-icon> 13 hours on-demand video </div>
                                <div class="flex items-center px-5 py-3">  <ion-icon name="key-outline" class="text-2xl mr-2"></ion-icon> Full lifetime access </div>
                                <div class="flex items-center px-5 py-3">  <ion-icon name="download-outline" class="text-2xl mr-2"></ion-icon> 42 downloadable resources </div>
                                <div class="flex items-center px-5 py-3">  <ion-icon name="help-circle-outline" class="text-2xl mr-2"></ion-icon>Assignments </div>
                                <div class="flex items-center px-5 py-3">  <ion-icon name="medal-outline" class="text-2xl mr-2"></ion-icon>Certificate of Completion </div>
                                -->
                            </div>
                        </div>

                        <?php //var_dump ($enrolled_status);?>



                        @if(Sentinel::check())
                            @if(Sentinel::getUser()->roles()->first()->slug == 'student')
                                @if($enrolled_status !='enrolled' || $enrolled_status !='completed')

                                    <form action="{{route('course.enroll')}}" method="post" class='course-enroll-form'>
                                        {{csrf_field ()}}
                                        <div class="mt-4">
                                            <button type="submit" class="w-full h-9 px-6 rounded-md bg-blue-600 hover:bg-blue-700 hover:text-white text-white">Enroll Now</button>
                                        </div>
                                        <input name="courseId" type="hidden" value="{{$courseData->id}}">
                                    </form>

                                @endif
                            @endif
                        @else
                            <div class="mt-4">
                                <a href="{{route('course-guest-enroll')}}" class="flex items-center justify-center h-9 px-6 rounded-md bg-blue-600 hover:text-white text-white">Enroll Now</a>
                            </div>

                            {{-- todo
                            <div class="mt-2">
                                <a href="#" class="flex items-center justify-center h-9 px-6 rounded-md hover:bg-red-600 hover:text-white bg-red-500 border border-red-600 text-white">Add to Cart</a>
                            </div>
                            --}}
                        @endif



                        {{--
                        <div class="mt-2">
                            <a href="#" class="flex items-center justify-center h-9 px-6 rounded-md bg-green-400 hover:bg-green-600 hover:text-white text-white border border-green-300">Complete course</a>
                        </div>
                        <div class="mt-2">
                            <a href="#" class="flex items-center justify-center h-9 px-6 rounded-md hover:bg-red-600 hover:text-white bg-red-500 border border-red-600 text-white">Add to Cart</a>
                        </div>
                        <div class="mt-2">
                            <a href="{{route('cart')}}" class="flex items-center justify-center h-9 px-6 rounded-md bg-red-50 border hover:text-red-500 border-red-600 text-red-600">View Cart</a>
                        </div>
                        --}}

                    </div>


                <!--
                        <div class="tube-card p-5">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h4 class="text-lg -mb-0.5 font-semibold"> Related  Courses </h4>
                                </div>
                                <a href="#" class="text-blue-600"> <ion-icon name="refresh" class="-mt-0.5 -mr-2 hover:bg-gray-100 p-1.5 rounded-full text-lg"></ion-icon> </a>
                            </div>
                            <div class="p-1">
                                <a href="#" class="-mx-3 block hover:bg-gray-100 p-2 rounded-md">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{asset('images/courses/img-2.jpg')}}" alt="" class="h-12 object-cover rounded-md w-12">
                                        <div class="line-clamp-2 text-sm font-medium">
                                            The Complete JavaScript From beginning to Experts for advance
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="-mx-3 block hover:bg-gray-100 p-2 rounded-md">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{asset('images/courses/img-4.jpg')}}" alt="" class="h-12 object-cover rounded-md w-12">
                                        <div class="line-clamp-2 text-sm font-medium">
                                            The Complete JavaScript From beginning to Experts for advance
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="-mx-3 block hover:bg-gray-100 p-2 rounded-md">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{asset('images/courses/img-3.jpg')}}" alt="" class="h-12 object-cover rounded-md w-12">
                                        <div class="line-clamp-2 text-sm font-medium">
                                            The Complete JavaScript From beginning to Experts for advance
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <a href="#" class="hover:bg-gray-100 -mb-1.5 mt-0.5 h-8 flex items-center justify-center rounded-md text-blue-400 text-sm">
                                See all
                            </a>
                        </div>
                        -->

                </div>
            </div>

        </div>
    @else
        <div></div>
    @endif

@stop





@section('bootstrap-modals')

    @if(isset($courseData->content))
        @php($liCount = 1)
        @foreach($courseData->content as $sectionHeading => $sectionContent)

            @foreach($sectionContent as $arr)
                @if($arr['price'] == 'Free')
                    @if($arr['type'] == 'Video')
                    <!-- model for video {{$liCount}} -->
                        <div id="preview-modal-{{$liCount}}" uk-modal>
                            <div class="uk-modal-dialog shadow-lg rounded-md">
                                <button class="uk-modal-close-default m-2.5" type="button" uk-close></button>
                                <div class="uk-modal-header  rounded-t-md">
                                    <h4 class="text-lg font-semibold mb-2">{{$liCount}} . {{$arr['text']}}</h4>
                                </div>

                                <div class="embed-video">
                                    <iframe src="{{$arr['url']}}" class="w-full" uk-video="automute: false;autoplay:true"
                                            frameborder="0" allow="autoplay; fullscreen" allowfullscreen uk-responsive></iframe>
                                </div>

                                <!--
                                <div class="uk-modal-body">
                                    <h3 class="text-lg font-semibold mb-2">Build Responsive Websites </h3>
                                    <p>Duis aute irure dolor in reprehenderit in voluptate velit</p>
                                </div>
                                -->
                            </div>
                        </div>
                    @endif
                @endif
                @php($liCount++)
            @endforeach

        @endforeach
    @endif

@stop




@section('javascript')
<script>

	$(document).ready(function() {
		/* 1. Visualizing things on Hover - See next part for action on click */
		$('#stars li').on('mouseover', function () {
			var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
			// Now highlight all the stars that's not after the current hovered star
			$(this).parent().children('li.star').each(function (e) {
				if (e < onStar)
				{
					$(this).addClass('hover');
				}
				else
				{
					$(this).removeClass('hover');
				}
			});
		}).on('mouseout', function () {
			$(this).parent().children('li.star').each(function (e) {
				$(this).removeClass('hover');
			});
		});



		/* 2. Action to perform on click */
		$('#stars li').on('click', function () {
			var onStar = parseInt($(this).data('value'), 10); // The star currently selected
			var stars = $(this).parent().children('li.star');
			for (i = 0; i < stars.length; i++)
			{
				$(stars[i]).removeClass('selected');
			}
			for (i = 0; i < onStar; i++)
			{
				$(stars[i]).addClass('selected');
			}
			// JUST RESPONSE (Not needed)
			var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
			var msg = "";
			alert(ratingValue);
			if (ratingValue > 1)
			{
				msg = "Thanks! You rated this " + ratingValue + " stars.";
			}
			else
			{
				msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
			}
			responseMessage(msg);
		});

		function responseMessage(msg)
		{
			$('.success-box').fadeIn(200);
			$('.success-box div.text-message').html("<span>" + msg + "</span>");
		}

	})


	//delete course
	$('.delete-course-btn').on('click', function(event){

		var courseId = $(this).data('courseid');
		var form     = $(this).parent().parent().find('form.course-destroy');

		Swal.fire({
			title: 'Delete course',
			text: "Are you sure you want to course this user ?",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#d33',
			cancelButtonColor: '#3fcc98',
			confirmButtonText: 'Delete'
		}).then((result) => {


			if (result.isConfirmed) {

				$.ajax({
					url: "{{route('admin.course.check-empty')}}",
					type: "post",
					async:true,
					dataType:'json',
					data:{
						_token : '{{ csrf_token() }}',
						courseId : courseId
					},
					success: function (response) {

						if(response.status === 'success'){

							if(response.message === true){
								// course content is empty
								//submit form
								form.submit();
							}else{
								// course content is empty
								Swal.fire({
									title: 'Course already have content',
									text: "Are you sure you want to delete this course",
									icon: 'warning',
									showCancelButton: true,
									confirmButtonColor: '#d33',
									cancelButtonColor: '#3fcc98',
									confirmButtonText: 'Delete'
								}).then((result) => {

									if (result.isConfirmed) {
										//sumit form
										form.submit();
									}
								})
							}
						}else if(response.status == 'error'){
							toastr[response.status](response.message);
						}
					},
					error:function(request,errorType,errorMessage)
					{
						//alert ('error - '+errorType+'with message - '+errorMessage);
						//toastr["success"]("User updated successfully! ", "Good Job!")
						toastr["error"]("Course check failed!")
					}
				});
			}
		});
		event.preventDefault();
	});




</script>
@stop
