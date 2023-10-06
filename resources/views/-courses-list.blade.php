@extends('layouts.master')
@section('title','Course list')




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


                    <div class="md:flex justify-between items-center mb-5">

                        <div class="">
                            <div class="text-xl font-semibold"> Web Development Courses </div>
                            <div class="text-sm mt-2 font-medium text-gray-500 leading-6">Choose from +10.000 courses with new  additions published every months</div>
                        </div>

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

                    </div>


                    <div class="tube-card mt-3 lg:mx-0 -mx-5">

                        <h4 class="py-3 px-5 border-b font-semibold text-grey-700"> <ion-icon name="star"></ion-icon> Featured today </h4>

                        <div class="divide-y">
                            <div class="flex md:space-x-6 space-x-3 md:p-5 p-2 relative">
                                <a href="course-intro-2.php" class="md:w-60 md:h-36 w-28 h-20 overflow-hidden rounded-lg relative shadow-sm">
                                    <img src="{{asset('images/courses/img-5.jpg')}}" alt=""  class="w-full h-full absolute inset-0 object-cover">
                                    <img src="{{asset('images/icon-play.svg')}}" class="w-12 h-12 uk-position-center" alt="">
                                </a>
                                <div class="flex-1 md:space-y-2 space-y-1">
                                    <a href="course-intro-2.php" class="md:text-xl font-semibold line-clamp-2"> Learn C sharp for Beginners Crash Course </a>
                                    <p class="leading-6 pr-4 line-clamp-2 md:block hidden"> Lorem ipsum dolor sit amet,
                                        consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut
                                        magna . </p>
                                    <a href="#" class="md:font-semibold block text-sm"> John Michael</a>
                                    <div class="flex items-center justify-between">
                                        <div class="flex space-x-2 items-center text-sm">
                                            <div> Binginner levels  </div>
                                            <div class="md:block hidden">·</div>
                                            <div class="flex items-center"> 18 Hourse </div>
                                        </div>
                                        <a href="#" class="md:flex items-center justify-center h-9 px-8 rounded-md border -mt-3.5 hidden"> Enroll Now </a>
                                    </div>

                                    <div class="absolute top-1 right-3 md:flex hidden">
                                        <a href="#" class="hover:bg-gray-200 p-1.5 inline-block rounded-full">
                                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                         </svg>
                                        </a>
                                        <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" uk-drop="mode: hover;pos: top-right">

                                            <ul class="space-y-1">
                                              <li>
                                                  <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                   <i class="uil-share-alt mr-1"></i> Share
                                                  </a>
                                              </li>
                                              <li>
                                                  <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                   <i class="uil-edit-alt mr-1"></i>  Edit Post
                                                  </a>
                                              </li>
                                              <li>
                                                  <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                   <i class="uil-comment-slash mr-1"></i>   Disable comments
                                                  </a>
                                              </li>
                                              <li>
                                                  <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                   <i class="uil-favorite mr-1"></i>  Add favorites
                                                  </a>
                                              </li>
                                              <li>
                                                <hr class="-mx-2 my-2 dark:border-gray-800">
                                              </li>
                                              <li>
                                                  <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                                   <i class="uil-trash-alt mr-1"></i>  Delete
                                                  </a>
                                              </li>
                                            </ul>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="flex md:space-x-6 space-x-3 md:p-5 p-2 relative">
                                <a href="course-intro-2.php" class="md:w-60 md:h-36 w-28 h-20 overflow-hidden rounded-lg relative shadow-sm">
                                    <img src="{{asset('images/courses/img-1.jpg')}}" alt=""  class="w-full h-full absolute inset-0 object-cover">
                                    <img src="{{asset('images/icon-play.svg')}}" class="w-12 h-12 uk-position-center" alt="">
                                </a>
                                <div class="flex-1 md:space-y-2 space-y-1">
                                    <a href="course-intro-2.php" class="md:text-xl font-semibold line-clamp-2"> Ultimate Web Developer Course  </a>
                                    <p class="leading-6 pr-4 line-clamp-2 md:block hidden"> Lorem ipsum dolor sit amet,
                                        consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut
                                        magna . </p>
                                    <a href="#" class="md:font-semibold block text-sm"> Stella Johnson</a>
                                    <div class="flex items-center justify-between">
                                        <div class="flex space-x-2 items-center text-sm">
                                            <div> Advance levels  </div>
                                            <div class="md:block hidden">·</div>
                                            <div class="flex items-center"> 13 Hourse </div>
                                        </div>
                                        <a href="#" class="md:flex items-center justify-center h-9 px-8 rounded-md border -mt-3.5 hidden"> Enroll Now </a>
                                    </div>

                                    <div class="absolute top-1 right-3 md:flex hidden">
                                        <a href="#" class="hover:bg-gray-200 p-1.5 inline-block rounded-full">
                                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                         </svg>
                                        </a>
                                        <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" uk-drop="mode: hover;pos: top-right">

                                            <ul class="space-y-1">
                                              <li>
                                                  <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                   <i class="uil-share-alt mr-1"></i> Share
                                                  </a>
                                              </li>
                                              <li>
                                                  <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                   <i class="uil-edit-alt mr-1"></i>  Edit Post
                                                  </a>
                                              </li>
                                              <li>
                                                  <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                   <i class="uil-comment-slash mr-1"></i>   Disable comments
                                                  </a>
                                              </li>
                                              <li>
                                                  <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                   <i class="uil-favorite mr-1"></i>  Add favorites
                                                  </a>
                                              </li>
                                              <li>
                                                <hr class="-mx-2 my-2 dark:border-gray-800">
                                              </li>
                                              <li>
                                                  <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                                   <i class="uil-trash-alt mr-1"></i>  Delete
                                                  </a>
                                              </li>
                                            </ul>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="flex md:space-x-6 space-x-3 md:p-5 p-2 relative">
                                <a href="course-intro-2.php" class="md:w-60 md:h-36 w-28 h-20 overflow-hidden rounded-lg relative shadow-sm">
                                    <img src="{{asset('images/courses/img-3.jpg')}}" alt=""  class="w-full h-full absolute inset-0 object-cover">
                                    <img src="{{asset('images/icon-play.svg')}}" class="w-12 h-12 uk-position-center" alt="">
                                </a>
                                <div class="flex-1 md:space-y-2 space-y-1">
                                    <a href="course-intro-2.php" class="md:text-xl font-semibold line-clamp-2"> Build Responsive Real World Websites </a>
                                    <p class="leading-6 pr-4 line-clamp-2 md:block hidden"> Lorem ipsum dolor sit amet,
                                        consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut
                                        magna . </p>
                                    <a href="#" class="md:font-semibold block text-sm"> Monroe Parker</a>
                                    <div class="flex items-center justify-between">
                                        <div class="flex space-x-2 items-center text-sm">
                                            <div> Binginner levels  </div>
                                            <div class="md:block hidden">·</div>
                                            <div class="flex items-center"> 23 Hourse </div>
                                        </div>
                                        <a href="#" class="md:flex items-center justify-center h-9 px-8 rounded-md border -mt-3.5 hidden"> Enroll Now </a>
                                    </div>

                                    <div class="absolute top-1 right-3 md:flex hidden">
                                        <a href="#" class="hover:bg-gray-200 p-1.5 inline-block rounded-full">
                                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                         </svg>
                                        </a>
                                        <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" uk-drop="mode: hover;pos: top-right">

                                            <ul class="space-y-1">
                                              <li>
                                                  <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                   <i class="uil-share-alt mr-1"></i> Share
                                                  </a>
                                              </li>
                                              <li>
                                                  <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                   <i class="uil-edit-alt mr-1"></i>  Edit Post
                                                  </a>
                                              </li>
                                              <li>
                                                  <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                   <i class="uil-comment-slash mr-1"></i>   Disable comments
                                                  </a>
                                              </li>
                                              <li>
                                                  <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                                   <i class="uil-favorite mr-1"></i>  Add favorites
                                                  </a>
                                              </li>
                                              <li>
                                                <hr class="-mx-2 my-2 dark:border-gray-800">
                                              </li>
                                              <li>
                                                  <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                                   <i class="uil-trash-alt mr-1"></i>  Delete
                                                  </a>
                                              </li>
                                            </ul>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="flex md:space-x-6 space-x-3 md:p-5 p-2 relative">
                                <a href="course-intro-2.php" class="md:w-60 md:h-36 w-28 h-20 overflow-hidden rounded-lg relative shadow-sm">
                                    <img src="{{asset('images/courses/img-4.jpg')}}" alt=""  class="w-full h-full absolute inset-0 object-cover">
                                    <img src="{{asset('images/icon-play.svg')}}" class="w-12 h-12 uk-position-center" alt="">
                                </a>
                                <div class="flex-1 md:space-y-2 space-y-1">
                                    <a href="course-intro-2.php" class="md:text-xl font-semibold line-clamp-2">
                                         Learn Angular Fundamentals to Expert  </a>
                                    <p class="leading-6 pr-4 line-clamp-2 md:block hidden"> Lorem ipsum dolor sit amet,
                                        consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut
                                        magna . </p>
                                    <a href="single-channel.php" class="md:font-semibold block text-sm"> Jesse Stevens </a>
                                    <div class="flex items-center justify-between">
                                        <div class="flex space-x-2 items-center text-sm">
                                            <div> Advance levels  </div>
                                            <div class="md:block hidden">·</div>
                                            <div class="flex items-center"> 18 Hourse </div>
                                        </div>
                                        <a href="#" class="md:flex items-center justify-center h-9 px-8 rounded-md border -mt-3.5 hidden"> Enroll Now </a>
                                    </div>

                                    <div class="absolute top-1 right-3 md:flex hidden">
                                        <a href="#" class="hover:bg-gray-200 p-1.5 inline-block rounded-full">
                                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                         </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>


        </div>
@stop

@section('css-files')
    <link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop


@section('script-files')
    <script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@stop
