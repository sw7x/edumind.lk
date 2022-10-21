@extends('layouts.master')
@section('title','Search page')




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

                    <!--
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

                                    <span class="star-rating leading-4">
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> (320)
                                    </span>

                                </label>
                            </div>
                            <br>
                            <div class="radio">
                                <input id="course-rate-2" name="radio" type="radio">
                                <label for="course-rate-2"><span class="radio-label"></span>

                                    <span class="star-rating leading-4">
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> (160)
                                    </span>

                                </label>
                            </div>
                            <br>
                            <div class="radio">
                                <input id="course-rate-3" name="radio" type="radio">
                                <label for="course-rate-3"><span class="radio-label"></span>

                                    <span class="star-rating leading-4">
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> (120)
                                    </span>

                                </label>
                            </div>
                            <br>
                            <div class="radio">
                                <input id="course-rate-4" name="radio" type="radio">
                                <label for="course-rate-4"><span class="radio-label"></span>

                                    <span class="star-rating leading-4">
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> (50)
                                    </span>

                                </label>
                            </div>
                            <br>
                            <div class="radio">
                                <input id="course-rate-5" name="radio" type="radio">
                                <label for="course-rate-5"><span class="radio-label"></span>

                                    <span class="star-rating leading-4">
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> <ion-icon name="star"></ion-icon>
                                        <ion-icon name="star"></ion-icon> (50)
                                    </span>

                                </label>
                            </div>
                        </form>

                    </div>-->

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

                    <div class="md:flex justify-between items-center mb-0">
                        <div class="">
                            <!-- <div class="text-xl font-semibold"> Web Development Courses </div>
                            <div class="text-sm mt-2 font-medium text-gray-500 leading-6">10 Results</div>
                            <h4 class="font-semibold text-base mb-2">10 Results</h4>-->
                            <div class="text-xl font-semibold mb-2">Search</div>
                        </div>
                        <!--
                        <div class="flex items-center space-x-3 justify-end">

                            <div class="flex space-x-1 bg-gray-100 rounded-md p-1 text-lg">
                                <a href="courses.php" class="py-1.5 px-3 rounded-md" data-tippy-placement="top" title="Grid view">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                                </a>
                                <a href="#" class="py-1.5 px-3 rounded-md bg-white shadow" data-tippy-placement="top" title="List view">
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
                        -->
                    </div>

                    <div class="course-search-bar main-search-bar wrapper">
                        <!-- <div class="label">Learn how to create an animated search form with CSS.</div> -->
                        <div class="searchBar">
                            <form>
                                <input id="searchQueryInput" type="text" name="searchQueryInput" placeholder="Search for anything" value="" />
                                <button id="searchQuerySubmit" type="submit" name="searchQuerySubmit">
                                    <svg style="" viewBox="0 0 24 24">
                                        <path fill="#666666" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- <h4 class="font-semibold text-base mt-2">10 Results found</h4> -->

                    <div class="tube-card mt-3 lg:mx-0 -mx-5">

                        <h4 class="py-3 px-5 border-b font-semibold text-grey-700">10 Results found</h4>

                        <div class="divide-y">

                            <div class="flex md:space-x-6 space-x-3 md:p-5 p-2 relative">
                                <a href="course-intro-2.php" class="md:w-60 md:h-36 w-28 h-20 overflow-hidden rounded-lg relative shadow-sm">
                                    <img src="{{asset('images/courses/img-5.jpg')}}" alt=""  class="w-full h-full absolute inset-0 object-cover">
                                </a>
                                <div class="flex-1 md:space-y-2 space-y-1">
                                    <a href="course-intro-2.php" class="md:text-xl font-semibold line-clamp-2"> Learn C sharp for Beginners Crash Course </a>
                                    <p class="leading-6 pr-4 line-clamp-2 md:block hidden"> Lorem ipsum dolor sit amet,
                                        consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut
                                        magna . </p>
                                    <a href="#" class="md:font-semibold block text-sm"> John Michael</a>
                                    <div class="flex items-center justify-between">
                                        <div class="flex __space-x-2 items-center text-sm">
                                            <div class="font-semibold"><span class=""><i class="align-middle icon-feather-youtube" style="font-size: 1.20rem;"></i> 15 Lessons</span></div>

                                            <div class="font-semibold ml-3"><span class=""><i class="align-middle icon icon-feather-clock" style="font-size: 1.20rem;"></i> 18 Hourse </span></div>

                                            <ul class="flex text-gray-300 gap-4 mt-4 mb-3  ml-5">
                                                <li class="flex items-center">
                                                    <span class="avg bg-yellow-500 mr-2 px-2 rounded text-white font-semiold"> 4.9 </span>
                                                    <div class="star-rating text-yellow-300">
                                                        <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon> <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                        <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon> <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                        <ion-icon name="star-half" role="img" class="md hydrated" aria-label="star half"></ion-icon>
                                                    </div>
                                                </li>
                                            </ul>

                                            <div></div>
                                        </div>
                                        <div class="text-lg font-semibold"> $11.99 </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex md:space-x-6 space-x-3 md:p-5 p-2 relative">
                                <a href="course-intro-2.php" class="md:w-60 md:h-36 w-28 h-20 overflow-hidden rounded-lg relative shadow-sm">
                                    <img src="{{asset('images/courses/img-1.jpg')}}" alt=""  class="w-full h-full absolute inset-0 object-cover">
                                </a>
                                <div class="flex-1 md:space-y-2 space-y-1">
                                    <a href="course-intro-2.php" class="md:text-xl font-semibold line-clamp-2"> Learn C sharp for Beginners Crash Course </a>
                                    <p class="leading-6 pr-4 line-clamp-2 md:block hidden"> Lorem ipsum dolor sit amet,
                                        consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut
                                        magna . </p>
                                    <a href="#" class="md:font-semibold block text-sm"> John Michael</a>
                                    <div class="flex items-center justify-between">
                                        <div class="flex __space-x-2 items-center text-sm">
                                            <div class="font-semibold"><span class=""><i class="align-middle icon-feather-youtube" style="font-size: 1.20rem;"></i> 15 Lessons</span></div>

                                            <div class="font-semibold ml-3"><span class=""><i class="align-middle icon icon-feather-clock" style="font-size: 1.20rem;"></i> 18 Hourse </span></div>

                                            <div class="flex items-center space-x-1 text-yellow-500 ml-5">
                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                <ion-icon name="star" class="text-gray-300 md hydrated" role="img" aria-label="star"></ion-icon>
                                                <div class="font-semibold ml-5 mt-1">4.0</div>
                                            </div>
                                            <div></div>
                                        </div>
                                        <div class="text-lg font-semibold"> $11.99 </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex md:space-x-6 space-x-3 md:p-5 p-2 relative">
                                <a href="course-intro-2.php" class="md:w-60 md:h-36 w-28 h-20 overflow-hidden rounded-lg relative shadow-sm">
                                    <img src="{{asset('images/courses/img-2.jpg')}}" alt=""  class="w-full h-full absolute inset-0 object-cover">
                                </a>
                                <div class="flex-1 md:space-y-2 space-y-1">
                                    <a href="course-intro-2.php" class="md:text-xl font-semibold line-clamp-2"> Learn C sharp for Beginners Crash Course </a>
                                    <p class="leading-6 pr-4 line-clamp-2 md:block hidden"> Lorem ipsum dolor sit amet,
                                        consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut
                                        magna . </p>
                                    <a href="#" class="md:font-semibold block text-sm"> John Michael</a>
                                    <div class="flex items-center justify-between">
                                        <div class="flex __space-x-2 items-center text-sm">
                                            <div class="font-semibold"><span class=""><i class="align-middle icon-feather-youtube" style="font-size: 1.20rem;"></i> 15 Lessons</span></div>

                                            <div class="font-semibold ml-3"><span class=""><i class="align-middle icon icon-feather-clock" style="font-size: 1.20rem;"></i> 18 Hourse </span></div>

                                            <div class="flex items-center space-x-1 text-yellow-500 ml-5">
                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                <ion-icon name="star" class="text-gray-300 md hydrated" role="img" aria-label="star"></ion-icon>
                                                <div class="font-semibold ml-5 mt-1">4.0</div>
                                            </div>
                                            <div></div>
                                        </div>
                                        <div class="text-lg font-semibold"> $11.99 </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex md:space-x-6 space-x-3 md:p-5 p-2 relative">
                                <a href="course-intro-2.php" class="md:w-60 md:h-36 w-28 h-20 overflow-hidden rounded-lg relative shadow-sm">
                                    <img src="{{asset('images/courses/img-3.jpg')}}" alt=""  class="w-full h-full absolute inset-0 object-cover">
                                </a>
                                <div class="flex-1 md:space-y-2 space-y-1">
                                    <a href="course-intro-2.php" class="md:text-xl font-semibold line-clamp-2"> Learn C sharp for Beginners Crash Course </a>
                                    <p class="leading-6 pr-4 line-clamp-2 md:block hidden"> Lorem ipsum dolor sit amet,
                                        consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut
                                        magna . </p>
                                    <a href="#" class="md:font-semibold block text-sm"> John Michael</a>
                                    <div class="flex items-center justify-between">
                                        <div class="flex __space-x-2 items-center text-sm">
                                            <div class="font-semibold"><span class=""><i class="align-middle icon-feather-youtube" style="font-size: 1.20rem;"></i> 15 Lessons</span></div>

                                            <div class="font-semibold ml-3"><span class=""><i class="align-middle icon icon-feather-clock" style="font-size: 1.20rem;"></i> 18 Hourse </span></div>

                                            <div class="flex items-center space-x-1 text-yellow-500 ml-5">
                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                <ion-icon name="star" class="text-gray-300 md hydrated" role="img" aria-label="star"></ion-icon>
                                                <div class="font-semibold ml-5 mt-1">4.0</div>
                                            </div>
                                            <div></div>
                                        </div>
                                        <div class="text-lg font-semibold"> $11.99 </div>
                                    </div>
                                </div>
                            </div>
                            <!-- todo - add pagination -->

                        </div>

                    </div>

                </div>

            </div>

        </div>
@stop
