@extends('layouts.master')
@section('title','Course page')


@section('css-files')
    <link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('content')
        <div class="main-container container">

            <!-- Spacer -->
            <div class="page-spacer"></div>

            <div class="lg:flex lg:space-x-10">

                <div class="lg:w-3/12 space-y-4 lg:block hidden">

                    <div>
                        <h4 class="font-semibold text-base mb-2"> Categories </h4>
                        <select class="selectpicker default" data-selected-text-format="count" data-size="7"
                                title="All Categories">
                            <option> Web Development </option>
                            <option> Mobile App </option>
                            <option> Business </option>
                            <option> IT Software </option>
                            <option> Desings </option>
                            <option> Marketing </option>
                            <option> Life Style </option>
                            <option> Photography </option>
                            <option> Health Fitness </option>
                            <option> Ecommerce </option>
                            <option> Food cooking </option>
                            <option> Teaching academy </option>
                        </select>
                    </div>

                    <div>
                        <h4 class="font-semibold text-base mb-2"> Skill Levels</h4>
                        <div>
                            <div class="radio">
                                <input id="radio-1" name="radio" type="radio" checked>
                                <label for="radio-1"><span class="radio-label"></span> Beginner <span> (25) </span>
                                </label>
                            </div>
                            <br>
                            <div class="radio">
                                <input id="radio-2" name="radio" type="radio">
                                <label for="radio-2"><span class="radio-label"></span> Entermidate <span> (25) </span>
                                </label>
                            </div>
                            <br>
                            <div class="radio">
                                <input id="radio-3" name="radio" type="radio">
                                <label for="radio-3"><span class="radio-label"></span> Expert <span> (25) </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-semibold text-base mb-2"> Course rating </h4>

                        <form>
                            <div class="radio">
                                <input id="course-rate-1" name="radio" type="radio" checked>
                                <label for="course-rate-1"><span class="radio-label"></span>

                                    <div class="star-rating leading-4">
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> (320)
                                    </div>

                                </label>
                            </div>
                            <br>
                            <div class="radio">
                                <input id="course-rate-2" name="radio" type="radio">
                                <label for="course-rate-2"><span class="radio-label"></span>

                                    <div class="star-rating leading-4">
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> (160)
                                    </div>

                                </label>
                            </div>
                            <br>
                            <div class="radio">
                                <input id="course-rate-3" name="radio" type="radio">
                                <label for="course-rate-3"><span class="radio-label"></span>

                                    <div class="star-rating leading-4">
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> (120)
                                    </div>

                                </label>
                            </div>
                            <br>
                            <div class="radio">
                                <input id="course-rate-4" name="radio" type="radio">
                                <label for="course-rate-4"><span class="radio-label"></span>

                                    <div class="star-rating leading-4">
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> (50)
                                    </div>

                                </label>
                            </div>
                            <br>
                            <div class="radio">
                                <input id="course-rate-5" name="radio" type="radio">
                                <label for="course-rate-5"><span class="radio-label"></span>

                                    <div class="star-rating leading-4">
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> (50)
                                    </div>

                                </label>
                            </div>
                        </form>

                    </div>

                    <div>
                        <h4 class="font-semibold text-base mb-2"> Course type </h4>
                        <form>
                            <div class="radio">
                                <input id="course-type-1" name="radio" type="radio" checked>
                                <label for="course-type-1"><span class="radio-label"></span>Free (42) </label>
                            </div>
                            <br>
                            <div class="radio">
                                <input id="course-type-2" name="radio" type="radio">
                                <label for="course-type-2"><span class="radio-label"></span> Paid (42)</label>
                            </div>
                        </form>
                    </div>

                    <div>
                        <h4 class="font-semibold text-base mb-2"> Duration </h4>
                        <form>
                            <div class="radio">
                                <input id="course-duration-1" name="radio" type="radio" checked>
                                <label for="course-duration-1"><span class="radio-label"></span> +5 Hourse (23) </label>
                            </div>
                            <br>
                            <div class="radio">
                                <input id="course-duration-2" name="radio" type="radio">
                                <label for="course-duration-2"><span class="radio-label"></span> +10 Hourse (42)</label>
                            </div>
                            <br>
                            <div class="radio">
                                <input id="course-duration-3" name="radio" type="radio">
                                <label for="course-duration-3"><span class="radio-label"></span> +20 Hourse (42)</label>
                            </div>
                            <br>
                            <div class="radio">
                                <input id="course-duration-4" name="radio" type="radio">
                                <label for="course-duration-4"><span class="radio-label"></span> +30 Hourse (42)</label>
                            </div>
                        </form>
                    </div>

                </div>

                <div class="w-full">

                    <div class="mb-2">
                        <div class="text-xl font-semibold">  The world's largest selection of courses  </div>
                        <div class="text-sm mt-2">  Choose from 130,000 online video courses with new additions published every month </div>
                    </div>

                    <nav class="cd-secondary-nav border-b md:m-0 -mx-4 nav-small">
                        <ul>
                            <li class="active"><a href="#" class="lg:px-2">   Python </a></li>
                            <li><a href="#" class="lg:px-2"> Web development </a></li>
                            <li><a href="#" class="lg:px-2"> JavaScript  </a></li>
                            <li><a href="#" class="lg:px-2"> Softwares  </a></li>
                            <li><a href="#" class="lg:px-2"> Drawing  </a></li>
                        </ul>
                    </nav>

                    <!--  slider -->
                    <div class="mt-3">

                        <h4 class="py-3 border-b font-semibold text-grey-700  mx-1 mb-4" hidden> <ion-icon name="star"></ion-icon> Featured today </h4>

                        <div class="relative" uk-slider="finite: true">

                            <div class="uk-slider-container px-1 py-3">

                                <ul class="uk-slider-items uk-child-width-1-3@m uk-child-width-1-2@s uk-grid-small uk-grid">

                                    <li>

                                        <a href="course-intro.php" class="uk-link-reset">
                                            <div class="card uk-transition-toggle">
                                                <div class="card-media h-40">
                                                    <div class="card-media-overly"></div>
                                                    <img src="{{asset('images/courses/img-1.jpg')}}" alt="" class="">
                                                    <span class="icon-play"></span>
                                                </div>
                                                <div class="card-body p-4">
                                                    <div class="font-semibold line-clamp-2"> Learn JavaScript and Express to become a professional JavaScript developer. </div>
                                                    <div class="flex space-x-2 items-center text-sm pt-3">
                                                        <div> 13 hours  </div>
                                                        <div> · </div>
                                                        <div> 32 lectures </div>
                                                    </div>
                                                    <div class="pt-1 flex items-center justify-between">
                                                        <div class="text-sm font-medium"> John Michael </div>
                                                        <div class="text-lg font-semibold"> $14.99 </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                    </li>
                                    <li>

                                        <a href="course-intro.php" class="uk-link-reset">
                                            <div class="card uk-transition-toggle">
                                                <div class="card-media h-40">
                                                    <div class="card-media-overly"></div>
                                                    <img src="{{asset('images/courses/img-2.jpg')}}" alt="" class="">
                                                    <span class="icon-play"></span>
                                                </div>
                                                <div class="card-body p-4">
                                                    <div class="font-semibold line-clamp-2">Learn Angular Fundamentals From beginning to advance </div>
                                                    <div class="flex space-x-2 items-center text-sm pt-3">
                                                        <div>  26 hours  </div>
                                                        <div>·</div>
                                                        <div> 26 lectures </div>
                                                    </div>
                                                    <div class="pt-1 flex items-center justify-between">
                                                        <div class="text-sm font-medium"> Stella Johnson </div>
                                                        <div class="text-lg font-semibold"> $18.99  </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                    </li>
                                    <li>

                                        <a href="course-intro.php" class="uk-link-reset">
                                            <div class="card uk-transition-toggle">
                                                <div class="card-media h-40">
                                                    <div class="card-media-overly"></div>
                                                    <img src="{{asset('images/courses/img-3.jpg')}}" alt="" class="">
                                                    <span class="icon-play"></span>
                                                </div>
                                                <div class="card-body p-4">
                                                    <div class="font-semibold line-clamp-2">Responsive Web Design Essentials HTML5 CSS3 Bootstrap </div>
                                                    <div class="flex space-x-2 items-center text-sm pt-3">
                                                        <div>  18 hours  </div>
                                                        <div>·</div>
                                                        <div> 42 lectures </div>
                                                    </div>
                                                    <div class="pt-1 flex items-center justify-between">
                                                        <div class="text-sm font-medium"> Monroe Parker </div>
                                                        <div class="text-lg font-semibold"> $11.99 </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                    </li>
                                    <li>

                                        <a href="course-intro.php" class="uk-link-reset">
                                            <div class="card uk-transition-toggle">
                                                <div class="card-media h-40">
                                                    <div class="card-media-overly"></div>
                                                    <img src="{{asset('images/courses/img-1.jpg')}}" alt="" class="">
                                                    <span class="icon-play"></span>
                                                </div>
                                                <div class="card-body p-4">
                                                    <div class="font-semibold line-clamp-2"> Learn JavaScript and Express to become a professional JavaScript developer. </div>
                                                    <div class="flex space-x-2 items-center text-sm pt-3">
                                                        <div> 32 hours  </div>
                                                        <div>·</div>
                                                        <div>  lec 4 </div>
                                                    </div>
                                                    <div class="pt-1 flex items-center justify-between">
                                                        <div class="text-sm font-medium"> Jesse Stevens </div>
                                                        <div class="text-lg font-semibold"> $29.99 </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>

                                    </li>


                                </ul>

                                <!-- slide icons -->
                                <a class="absolute bg-white top-1/4 flex items-center justify-center p-2 -left-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="previous"> <i class="icon-feather-chevron-left"></i></a>
                                <a class="absolute bg-white top-1/4 flex items-center justify-center p-2 -right-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="next"> <i class="icon-feather-chevron-right"></i></a>

                            </div>
                        </div>

                    </div>

                    <!--  Categories -->
                    <div class="sm:my-6 my-3 flex items-end justify-between">
                        <div>
                            <h2 class="text-xl font-semibold"> Categories </h2>
                            <p class="font-medium text-gray-500 leading-6"> Find a topic by browsing top categories. </p>
                        </div>
                        <a href="#" class="text-blue-500 sm:block hidden"> See all </a>
                    </div>

                    <div class="relative -mt-3" uk-slider="finite: true">

                        <div class="uk-slider-container px-1 py-3">
                            <ul class="uk-slider-items uk-child-width-1-5@m uk-child-width-1-3@s uk-child-width-1-2 uk-grid-small uk-grid">
                                <li>
                                    <div class="rounded-md overflow-hidden relative w-full h-36">
                                        <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                        </div>
                                        <img src="{{asset('images/category/design.jpg')}}" class="absolute w-full h-full object-cover" alt="">
                                        <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg"> Design </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="rounded-md overflow-hidden relative w-full h-36">
                                        <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                        </div>
                                        <img src="{{asset('images/category/marketing.jpg')}}" class="absolute w-full h-full object-cover"
                                             alt="">
                                        <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg"> Marketing </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="rounded-md overflow-hidden relative w-full h-36">
                                        <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                        </div>
                                        <img src="{{asset('images/category/it-and-software.jpg')}}" class="absolute w-full h-full object-cover"
                                             alt="">
                                        <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg"> Software</div>
                                    </div>
                                </li>
                                <li>
                                    <div class="rounded-md overflow-hidden relative w-full h-36">
                                        <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                        </div>
                                        <img src="{{asset('images/category/music.jpg')}}" class="absolute w-full h-full object-cover" alt="">
                                        <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg"> Music </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="rounded-md overflow-hidden relative w-full h-36">
                                        <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                        </div>
                                        <img src="{{asset('images/category/business.jpg')}}" class="absolute w-full h-full object-cover" alt="">
                                        <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg"> Travel </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="rounded-md overflow-hidden relative w-full h-36">
                                        <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                        </div>
                                        <img src="{{asset('images/category/development.jpg')}}" class="absolute w-full h-full object-cover" alt="">
                                        <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg"> Development </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <a class="absolute bg-white top-16 flex items-center justify-center p-2 -left-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="previous"> <i class="icon-feather-chevron-left"></i></a>
                        <a class="absolute bg-white top-16 flex items-center justify-center p-2 -right-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="next"> <i class="icon-feather-chevron-right"></i></a>

                    </div>

                    <br>

                    <div class="md:flex justify-between items-center mb-5">

                        <div class="">
                            <div class="text-xl font-semibold"> Web Development Courses </div>
                            <div class="text-sm mt-2 font-medium text-gray-500 leading-6">  Choose from +10.000 courses with new  additions published every months  </div>
                        </div>

                        <div class="flex items-center space-x-3 justify-end">

                            <div class="flex space-x-1 bg-gray-100 rounded-md p-1 text-lg">
                                <a href="#" class="py-1.5 px-3 rounded-md bg-white shadow" data-tippy-placement="top" title="Grid view">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                                </a>
                                <a href="courses-list.php" class="py-1.5 px-3 rounded-md" data-tippy-placement="top" title="List view">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                </a>
                            </div>

                            <div class="w-40 lg:block hidden">
                                <select class="selectpicker ml-3" data-size="7">
                                    <option value=""> Newest </option>
                                    <option value="1">Popular</option>
                                    <option value="2">Free</option>
                                    <option value="3">Premium</option>
                                </select>
                            </div>

                        </div>

                    </div>

                    <!-- course list -->
                    <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-3">

                        <a href="course-intro.php" class="uk-link-reset">
                            <div class="card uk-transition-toggle">
                                <div class="card-media h-40">
                                    <div class="card-media-overly"></div>
                                    <img src="{{asset('images/courses/img-4.jpg')}}" alt="" class="">
                                    <span class="icon-play"></span>
                                </div>
                                <div class="card-body p-4">
                                    <div class="font-semibold line-clamp-2"> Learn Angular Fundamentals From beginning to advance lavel
                                    </div>
                                    <div class="flex space-x-2 items-center text-sm pt-3">
                                        <div> 32 hours </div>
                                        <div>·</div>
                                        <div> lec 4 </div>
                                    </div>
                                    <div class="pt-1 flex items-center justify-between">
                                        <div class="text-sm font-semibold"> Jesse Stevens  </div>
                                        <div class="text-lg font-semibold"> $29.99 </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="course-intro.php" class="uk-link-reset">
                            <div class="card uk-transition-toggle">
                                <div class="card-media h-40">
                                    <div class="card-media-overly"></div>
                                    <img src="{{asset('images/courses/img-6.jpg')}}" alt="" class="">
                                    <span class="icon-play"></span>
                                </div>
                                <div class="card-body p-4">
                                    <div class="font-semibold line-clamp-2">Build Responsive Real World Websites with HTML5 and CSS3 </div>
                                    <div class="flex space-x-2 items-center text-sm pt-3">
                                        <div> 13 hours </div>
                                        <div>·</div>
                                        <div>32 lectures </div>
                                    </div>
                                    <div class="pt-1 flex items-center justify-between">
                                        <div class="text-sm font-semibold"> John Michael </div>
                                        <div class="text-lg font-semibold"> $14.99 </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="course-intro.php" class="uk-link-reset">
                            <div class="card uk-transition-toggle">
                                <div class="card-media h-40">
                                    <div class="card-media-overly"></div>
                                    <img src="{{asset('images/courses/img-5.jpg')}}" alt="" class="">
                                    <span class="icon-play"></span>
                                </div>
                                <div class="card-body p-4">
                                    <div class="font-semibold line-clamp-2">C# Developers Double Your Coding Speed with Visual Studio </div>
                                    <div class="flex space-x-2 items-center text-sm pt-3">
                                        <div> 18 hours </div>
                                        <div>·</div>
                                        <div>42 lectures </div>
                                    </div>
                                    <div class="pt-1 flex items-center justify-between">
                                        <div class="text-sm font-semibold"> Stella Johnson  </div>
                                        <div class="text-lg font-semibold"> $18.99 </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="course-intro.php" class="uk-link-reset">
                            <div class="card uk-transition-toggle">
                                <div class="card-media h-40">
                                    <div class="card-media-overly"></div>
                                    <img src="{{asset('images/courses/img-1.jpg')}}" alt="" class="">
                                    <span class="icon-play"></span>
                                </div>
                                <div class="card-body p-4">
                                    <div class="font-semibold line-clamp-2"> Learn JavaScript and Express to become a professional
                                        JavaScript developer. </div>
                                    <div class="flex space-x-2 items-center text-sm pt-3">
                                        <div> 13 hours </div>
                                        <div>·</div>
                                        <div>32 lectures </div>
                                    </div>
                                    <div class="pt-1 flex items-center justify-between">
                                        <div class="text-sm font-semibold"> John Michael  </div>
                                        <div class="text-lg font-semibold"> $14.99 </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="course-intro.php" class="uk-link-reset">
                            <div class="card uk-transition-toggle">
                                <div class="card-media h-40">
                                    <div class="card-media-overly"></div>
                                    <img src="{{asset('images/courses/img-2.jpg')}}" alt="" class="">
                                    <span class="icon-play"></span>
                                </div>
                                <div class="card-body p-4">
                                    <div class="font-semibold line-clamp-2"> Learn and Understand AngularJS to become a professional  developer</div>
                                    <div class="flex space-x-2 items-center text-sm pt-3">
                                        <div> 26 hours </div>
                                        <div>·</div>
                                        <div>26 lectures </div>
                                    </div>
                                    <div class="pt-1 flex items-center justify-between">
                                        <div class="text-sm font-semibold"> Stella Johnson  </div>
                                        <div class="text-lg font-semibold"> $18.99 </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="course-intro.php" class="uk-link-reset">
                            <div class="card uk-transition-toggle">
                                <div class="card-media h-40">
                                    <div class="card-media-overly"></div>
                                    <img src="{{asset('images/courses/img-3.jpg')}}" alt="" class="">
                                    <span class="icon-play"></span>
                                </div>
                                <div class="card-body p-4">
                                    <div class="font-semibold line-clamp-2">Responsive Web Design Essentials HTML5 CSS3 and Bootstrap </div>
                                    <div class="flex space-x-2 items-center text-sm pt-3">
                                        <div> 18 hours </div>
                                        <div>·</div>
                                        <div>42 lectures </div>
                                    </div>
                                    <div class="pt-1 flex items-center justify-between">
                                        <div class="text-sm font-semibold"> Monroe Parker   </div>
                                        <div class="text-lg font-semibold"> $11.99 </div>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>

                    <!-- Pagination
                    <div class="flex justify-center mt-9 space-x-2 text-base font-semibold text-gray-400 items-center">
                        <a href="#" class="py-1 px-3 bg-gray-200 rounded text-gray-600"> 1</a>
                        <a href="#" class="py-1 px-2 bg-gray-200 rounded"> 2</a>
                        <a href="#" class="py-1 px-2 bg-gray-200 rounded"> 3</a>
                        <ion-icon name="ellipsis-horizontal" class="text-lg -mb-4"></ion-icon>
                        <a href="#" class="py-1 px-2 bg-gray-200 rounded"> 12</a>
                    </div>-->





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





                </div>
            </div>


        </div>
@stop





@section('script-files')
    <script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@stop
