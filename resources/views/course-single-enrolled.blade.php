@extends('layouts.master')
@section('title','Course page')




@section('content')
    
    @php
        //dd($courseData);
        //var_dump($courseData->subject->name);
        //var_dump($courseData['creatorArr']->full_name);
    @endphp

    @if(isset($courseData) && is_array($courseData))
        <!-- course preview details -->
        <div class="bg-gray-600 text-white lg:-mt-20 lg:pt-20">
            <div class="container p-0">
                <div class="lg:flex items-center lg:space-x-12 lg:py-14 lg:px-20 p-3">
                    <div class="lg:w-4/12">                        
                        @if(isset($courseData['image']) && $courseData['image'] != '')
                            <div class="w-full lg:h-52 h-40 overflow-hidden rounded-lg relative lg:mb-0 mb-4">
                                <img src="{{$courseData['image']}}" class="w-full h-full absolute inset-0 object-cover" alt="">                           
                            </div>
                        @endif
                    </div>
                    <div class="lg:w-8/12">
                        <div class="capitalize text-gray-200 mb-2 font-semibold text-base">
                            @if($courseData['subjectArr'])
                                @if(!$courseData['subjectArr']['deletedAt'])
                                    <a class="hover:text-white" href="{{route('subjects.show',$courseData['subjectArr']['slug'])}}">{{$courseData['subjectArr']['name']}}</a>
                                @else                            
                                    {{-- <span class="text-gray-400">{{$courseData['subjectArr']['name']}}</span> --}}
                                    <span class="text-gray-400">No subject !</span>
                                @endif
                            @else
                                <span class="text-gray-400">No subject</span>
                            @endif                      
                        </div>
                        <h1 class="lg:leading-10 lg:text-3xl text-white text-xl leading-8 font-bold">{{$courseData['name']}}</h1>
                        <p class="lg:w-4/5 mt-2 md:text-lg md:block hidden">{{$courseData['headingText']}}</p>

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
                        <ul class="lg:flex items-center text-gray-200">
                            @if($courseData['creatorArr'])
                                <li> Teacher : <a href="{{route('teachers.show',$courseData['creatorArr']['username'])}}" class="text-white fond-bold hover:underline hover:text-white">{{$courseData['creatorArr']['fullName']}}</a> </li>
                                <li> <span class="lg:block hidden mx-3 text-2xl">·</span> </li>
                            @endif

                            @if($courseData['createdAtAgo'])
                                <li> Posted {{$courseData['createdAtAgo']}}</li>
                            @endif                          
                        </ul>

                    </div>

                </div>
            </div>
        </div>

        <div class="main-container container p-0">            
            <div class="lg:flex lg:space-x-4 mt-4">
                <div class="lg:w-8/12 space-y-4">
                    
                    @if(Session::has('message'))
                        <x-flash-message  
                            :class="Session::get('cls', 'flash-info')"  
                            :title="Session::get('msgTitle') ?? 'Info!'" 
                            :message="Session::get('message') ?? ''"  
                            :message2="Session::get('message2') ?? ''"  
                            :canClose="true" />
                    @endif               

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
                            {!! $courseData['description'] !!}
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
                        <h3 class="mb-4 text-xl font-semibold lg:mb-5">Course Curriculum </h3>

                        <?php //dump($courseContent); ?>

                        @if(isset($courseContent))
                            @if($courseContentInvFormat == false)
                                <ul uk-accordion="multiple: true" class="divide-y space-y-3">
                                    @php($liCount = 1)                                    
                                    @forelse($courseContent as $sectionHeading => $sectionContent)
                                        
                                        <li class="bg-gray-200 px-2 pb-3 rounded {{($loop->index>0)?'pt-2':'uk-open'}}">

                                            <a class="uk-accordion-title text-md mx-2 pt-3 font-semibold" href="#">
                                                <div class="mb-1 text-sm font-medium"> Section {{$loop->index+1}}</div> {{$sectionHeading}}</a>

                                            <div class="uk-accordion-content mt-3 text-base border-gray-400 border-t">

                                                <ul class="course-curriculum-list font-medium">
                                                    @foreach($sectionContent as $arr)
                                                        <li class=" hover:bg-gray-100 p-2 flex _rounded-md text-blue-500">

                                                            @if(strtolower($arr['type']) == 'video')
                                                                <i class="fa fa-play-circle leading-6 text-3xl mr-2"></i>
                                                                <!-- <ion-icon name="play-circle" class="leading-6 text-2xl mr-2"></ion-icon> -->
                                                            @elseif (strtolower($arr['type']) =="download")
                                                                <i class="fa fa-download leading-6 text-3xl mr-2"></i>
                                                                <!-- <ion-icon class="icon-feather-download leading-6 text-2xl mr-2"></ion-icon> -->
                                                            @elseif (strtolower($arr['type']) =="other")
                                                                <i class="fa fa-link leading-6 text-3xl mr-2"></i>
                                                                <!-- <ion-icon class="icon-feather-link leading-6 text-2xl mr-2"></ion-icon> -->
                                                            @else
                                                                <i class="fa fa-info-circle leading-6 text-3xl mr-2"></i>
                                                                <!-- <ion-icon class="icon-feather-box leading-6 text-2xl mr-2"></ion-icon> -->
                                                            @endif

                                                            <div class="link_div mr-2 text-justify">
                                                                <a class="_underline link" href="{{route('courses.watch',['slug'=>$courseData['slug'], 'videoId'=>$liCount])}}">{{$arr['inputText']}}</a>
                                                            </div>

                                                            @if($arr['linkParam'] !='')
                                                                <span class="param text-sm ml-auto">{{$arr['linkParam']}}</span>
                                                            @endif

                                                        </li>
                                                        @php($liCount++)
                                                    @endforeach
                                                </ul>

                                            </div>
                                        </li>

                                    @empty
                                        <x-flash-message 
                                            class="flash-warning"  
                                            title="Course content is empty!" 
                                            message=""  
                                            message2=""  
                                            :canClose="false" />
                                    @endforelse
                                </ul>
                            @else
                                <x-flash-message 
                                    class="flash-danger"  
                                    title="Error!" 
                                    message="Course content is not in correct format"  
                                    message2=""  
                                    :canClose="false" />
                            @endif
                        @else
                            <x-flash-message 
                                class="flash-info"  
                                title="Course content is empty" 
                                message=""  
                                message2=""  
                                :canClose="false" />                            
                        @endif
                    </div>


                    
                        <!-- Teacher details -->
                        <div class="tube-card p-5 lg:p-8 course-student-info bg-yellow-50 space-y-4" id="enrollment-details">
                            <div>
                                <h3 class="text-xl font-semibold lg:mb-5">Teacher details</h3>
                                
                                @isset($courseData['creatorArr'])
                                    <div class="bg-gray-50 border flex gap-x-4 p-4 relative rounded-md my-5">

                                        <div class="lg:w-1/4">                                    
                                            <img src="{{$courseData['creatorArr']['profilePic']}}" class="rounded shadow w-full" alt="">
                                        </div>

                                        <div class="w-3/4 md:text-justify">
                                            <h4 class="text-base m-0 font-semibold">
                                                <a href="{{route('teachers.show',$courseData['creatorArr']['username'])}}">
                                                    {{$courseData['creatorArr']['fullName']}}
                                                </a>
                                            </h4>
                                            {!! $courseData['creatorArr']['eduQualifications'] !!}
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
                                @else
                                    <x-flash-message 
                                        class="flash-info"  
                                        title="Not available" 
                                        message=""  
                                        message2=""  
                                        :canClose="false" />
                                @endisset

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

                                @if(isset($courseData['price']))
                                    <div class="items-center">
                                        {{--<div class="text-3xl font-semibold">Rs {{$courseData['price']}}</div>--}}
                                        <div class="text-3xl font-semibold">
                                            {{ $courseData['price'] == 0 ? "Free" : 'Rs '.$courseData['price'] }}
                                        </div>
                                    </div>
                                @endif

                                {{--
                                @if($courseData['duration'])
                                    <div class="items-center">
                                        <div class="text-xl font-semibold">{{$courseData['duration']}}</div>
                                    </div>
                                @endif

                                @if($courseData['videoCount'])
                                    <div class="space-y-1 items-center">
                                        <div class="text-xl font-semibold">{{$courseData['videoCount']}} Videos</div>
                                    </div>
                                @endif
                                --}}
                            </div>

                            <hr class="-mx-5 border-gray-200 my-4">
                            <h4 hidden> COURSE INCLUDES</h4>

                            <div class="-m-5 divide-y divide-gray-200 text-sm">

                                <div class="flex items-center px-5 py-3 text-xl font-semibold">{{$courseData['duration']}}</div>
                                <div class="flex items-center px-5 py-3 text-xl font-semibold">{{$courseData['videoCount']}} Videos</div>
                                {{--
                                <div class="flex items-center px-5 py-3">  <ion-icon name="play-outline" class="text-2xl mr-2"></ion-icon> 13 hours on-demand video </div>
                                <div class="flex items-center px-5 py-3">  <ion-icon name="key-outline" class="text-2xl mr-2"></ion-icon> Full lifetime access </div>
                                <div class="flex items-center px-5 py-3">  <ion-icon name="download-outline" class="text-2xl mr-2"></ion-icon> 42 downloadable resources </div>
                                <div class="flex items-center px-5 py-3">  <ion-icon name="help-circle-outline" class="text-2xl mr-2"></ion-icon>Assignments </div>
                                <div class="flex items-center px-5 py-3">  <ion-icon name="medal-outline" class="text-2xl mr-2"></ion-icon>Certificate of Completion </div>
                                --}}
                            </div>
                        </div>

                        <?php //dump ($enroll_status);?>                        
                        <x-course-page-buttons 
                            :enrollStatus=$enroll_status 
                            :dataArr=$courseData 
                            page="enrolled" />
                        
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
        <div class="main-container container p-0">            
            <x-flash-message 
                class="flash-danger"  
                title="Data not available!" 
                message="Course data is not available or not in correct format"  
                message2=""  
                :canClose="false" />          
        </div>
    @endif



@stop



@section('bootstrap-modals')
    <!-- video demo model -->
    <div id="trailer-modal" uk-modal>
        <div class="uk-modal-dialog shadow-lg rounded-md">
            <button class="uk-modal-close-default m-2.5" type="button" uk-close></button>
            <div class="uk-modal-header  rounded-t-md">
                <h4 class="text-lg font-semibold mb-2"> Trailer video </h4>
            </div>

            <div class="embed-video">
                <iframe src="https://www.youtube.com/embed/nOCXXHGMezU" class="w-full"
                        uk-video="automute: true" frameborder="0" allowfullscreen uk-responsive></iframe>
            </div>


            <div class="uk-modal-body">
                <h3 class="text-lg font-semibold mb-2">Build Responsive Websites </h3>
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum
                    dolore
                    eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident,
                    sunt
                    in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
        </div>
    </div>
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

	});

</script>
@stop
