@extends('layouts.master')
@section('title','Teacher profile')



@section('content')
    <div class="main-container container">
        <div class="max-w-5xl md:p-5 mx-auto">

            @if(isset($userData) && is_array($userData))
                <div class="lg:flex lg:space-x-10 bg-white rounded-md shadow max-w-3x  mx-auto md:p-8 p-3 mb-3">
                    {{--  gender, dob_year, last_login, created_at  --}}
                    <div class="lg:w-1/3 w-full">
                        <div class="md:block flex space-x-4" uk-sticky="offset: 91;bottom: true">
                            <div>
                                <img src="{{$userData['profilePic']}}" class="shadow-lg rounded-md w-32 md:w-full" alt="">
                            </div>

                            <div class="flex-1">
                                <ul class="my-5 text-sm space-y-2">

                                    @if($userData['createdAt'])
                                        <li>Registed : {{$userData['createdAtAgo']}}</li>
                                    @endif
                                    {{-- todo total courses --}}
                                    {{-- todo subjects --}}

                                    @if($userData['dobYear'])
                                        <li> Year of Birth : {{$userData['dobYear']}}</li>
                                    @endif

                                    <li> Profile ID : {{$userData['username'] }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="lg:w-2/3 flex-shrink-0 mt-10 lg:m-0">
                        <div>
                            <h2 class="font-semibold mb-3 text-xl lg:text-3xl">{{$userData['fullName']}}</h2>
                            <hr class="mb-5">

                            <div class="space-y-2">
                                {!! $userData['eduQualifications'] !!}
                            </div>
                            <hr class="mt-3 mb-3">
                            <div>
                                <h4 class="font-semibold mb-0 text-base">Contact Information</h4>
                                <p class="mb-0"><strong>Email</strong>: {{$userData['email']}}</p>
                                <p class="mt-0"><strong>Phone</strong>: {{$userData['phone']}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php //var_dump($teacher_courses->count())?>
                @if(isset($teacher_courses) && is_array($teacher_courses))

                    @if(!empty($teacher_courses) )
                        <div class="tube-card mt-3 lg:mx-0 -mx-5">
                            <h4 class="py-3 px-5 border-b font-semibold text-grey-700">
                                <ion-icon name="book" role="img" class="md book" aria-label="star"></ion-icon> Featured courses </h4>

                            <div class="divide-y">
                                @foreach ($teacher_courses as $course)
                                    <div class="flex md:space-x-6 space-x-3 md:p-5 p-2 relative">
                                        <a href="{{route('courses.show',$course['slug'])}}" class="md:w-60 md:h-36 w-28 h-20 overflow-hidden rounded-lg relative shadow-sm">
                                            <img src="{{$course['image']}}" class="w-full h-full absolute inset-0 object-cover" alt="">
                                        </a>
                                        <div class="flex-1 md:space-y-2 space-y-1">
                                            <a href="{{route('courses.show',$course['slug'])}}" class="md:text-xl font-semibold line-clamp-2">{{$course['name']}}</a>
                                            <p class="leading-6 pr-4 line-clamp-2 md:block hidden">{{$course['headingText']}}</p>

                                            <a href="{{route('subjects.show',$course['subjectSlug'])}}" class="md:font-semibold block text-base">
                                                {{$course['subjectName']}}
                                            </a>


                                            <div class="flex items-center justify-between">
                                                <div class="flex __space-x-2 items-center text-sm">

                                                    <div class="font-semibold">
                                                        <span class="">
                                                            <i class="align-middle icon-feather-youtube" style="font-size: 1.20rem;"></i>
                                                            {{$course['videoCount']}} lectures
                                                        </span>
                                                    </div>

                                                    <div class="font-semibold ml-3">
                                                        <span class="">
                                                            <i class="align-middle icon icon-feather-clock" style="font-size: 1.20rem;"></i>
                                                            {{$course['duration']}}
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
                                                    <div class="text-lg font-semibold">{{ $course['price'] == 0 ? "Free" : 'Rs '.$course['price'] }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

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
                    @else
                        <x-flash-message 
                            class="flash-info"  
                            title="No courses" 
                            message=""  
                            message2=""  
                            :canClose="false" />                    
                    @endif
                @else
                    <x-flash-message 
                        class="flash-danger"  
                        title="Error!" 
                        message="Courses data is not available or not in correct format"  
                        message2=""  
                        :canClose="false" />
                @endif
            @else
                <div class="my-5">
                    <x-flash-message 
                        class="flash-danger"  
                        title="Data not available!" 
                        message="Profile data is not available or not in correct format"  
                        message2=""  
                        :canClose="false" />
                </div>
            @endif
            
        </div>
    </div>
@stop
