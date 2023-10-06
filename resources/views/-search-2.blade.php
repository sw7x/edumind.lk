@extends('layouts.master')
@section('title','Search page')



@section('content')
        <div class="main-container container">

            <!-- Spacer -->
            <div class="page-spacer"></div>

            <!--
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
                            <div class="text-xl font-semibold mb-2">Subject One</div>
                        </div>
                    </div>

                    <h4 class="font-semibold text-base mt-2">10 Results found</h4>

                    <div class="__tube-card mt-3 lg:mx-0 -mx-5">

                        <div class="divide-y">

                            <div class="flex md:space-x-6 space-x-3 md:p-5 p-2 relative">
                                <a href="course-intro-2.php" class="md:w-60 md:h-36 w-28 h-20 overflow-hidden rounded-lg relative shadow-sm">
                                    <img src="./assets/images/courses/img-5.jpg" alt=""  class="w-full h-full absolute inset-0 object-cover">
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
                                    <img src="./assets/images/courses/img-1.jpg" alt=""  class="w-full h-full absolute inset-0 object-cover">
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
                                    <img src="./assets/images/courses/img-2.jpg" alt=""  class="w-full h-full absolute inset-0 object-cover">
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
                                    <img src="./assets/images/courses/img-3.jpg" alt=""  class="w-full h-full absolute inset-0 object-cover">
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








                        </div>

                    </div>


                </div>

            </div> -->


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
                        <div class="mb-2">
                            <div class="text-2xl font-semibold"><h1>Search</h1></div>
                        </div>
                    </div>

                    <div class="course-search-bar main-search-bar wrapper mb-5">
                        <!-- <div class="label">Learn how to create an animated search form with CSS.</div> -->

                        <form class="expanding-search-form">
                            <div class="search-dropdown">
                                <button class="button dropdown-toggle" type="button">
                                    <span class="toggle-active">Everything</span>
                                    <span class="fa fa-caret-left toggle-icon"></span>
                                </button>
                                <ul class="dropdown-menu font-semibold">
                                    <li class="menu-active"><a href="#">Everything</a></li>
                                    <li><a href="#">Courses</a></li>
                                    <li><a href="#">Teachers</a></li>
                                    <li><a href="#">Subjects</a></li>
                                </ul>
                            </div>

                            <input class="search-input" id="global-search" type="search" placeholder="Search for Everything here">

                            <label class="search-label" for="global-search">
                                <span class="sr-only">Global Search</span>
                            </label>

                            <button class="button search-button" type="button">
                                    <span class="fa fa-search">
                                        <span class="sr-only">Search</span>
                                    </span>
                            </button>
                        </form>

                        {{--<div class="searchBar">
                            <form>
                                <input id="searchQueryInput" type="text" name="searchQueryInput" placeholder="Search for course" value="" />
                                <button id="searchQuerySubmit" type="submit" name="searchQuerySubmit">
                                    <svg style="" viewBox="0 0 24 24">
                                        <path fill="#666666" d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                                    </svg>
                                </button>
                            </form>
                        </div>--}}

                    </div>

                    <div class="md:flex justify-between items-center mb-3">
                        <div><h2 class="font-semibold text-xl">Search result for "food"</h2></div>
                        <div><h4 class="text-base">10 Results found</h4></div>
                    </div>


                    <div class="__tube-card mt-3 lg:mx-0 -mx-5">
                        <?php
                        for ($x=1; $x < 5; $x++):
                            $imgSrc = asset('images/courses/img-').$x.".jpg";
                        ?>
                        <div class="horizontal-course-item bg-white md:flex shadow-sm rounded-lg uk-transition-toggle mb-5">

                            <div class="md:w-5/12 md:h-60 h-40 overflow-hidden rounded-l-lg relative">
                                <a href="">
                                    <img src='<?php echo $imgSrc; ?>' alt="" class="w-full h-full absolute inset-0 object-cover">
                                </a>
                            </div>

                            <div class="flex-1 md:p-6 p-4">

                                <div class="font-semibold line-clamp-2 md:text-xl md:leading-relaxed">
                                    <a href="">Build Responsive Web Design Essentials HTML5 CSS3</a>
                                </div>
                                <div class="line-clamp-2 mt-2 md:block hidden">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam</div>
                                <div class="font-semibold mt-3"><a href="">John Michael</a></div>

                                <div class="flex items-center justify-between">
                                    <div class="flex __space-x-2 items-center text-sm">
                                        <div class="font-semibold">
                                            <span class=""><i class="align-middle icon-feather-youtube" style="font-size: 1.20rem;"></i> 15 Lessons</span>
                                        </div>
                                        <div class="font-semibold ml-3">
                                            <span class=""><i class="align-middle icon icon-feather-clock" style="font-size: 1.20rem;"></i> 18 Hourse </span>
                                        </div>
                                        <ul class="flex text-gray-300 gap-4 mt-4 mb-3  ml-5">
                                            <li class="flex items-center">
                                                <span class="avg bg-yellow-500 mr-2 px-2 rounded text-white font-semiold"> 4.9 </span>
                                                <div class="star-rating text-yellow-300">
                                                    <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon> <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                    <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon> <ion-icon name="star" role="img" class="md hydrated" aria-label="star"></ion-icon>
                                                    <ion-icon name="star-half" role="img" class="md hydrated" aria-label="star half"></ion-icon>
                                                </div>
                                                <!-- <span>(1,873 ratings)</span> -->
                                            </li>
                                        </ul>
                                        <div></div>
                                    </div>
                                    <div class="text-lg font-semibold"> $11.99 </div>
                                </div>

                            </div>

                        </div>
                        <?php endfor;?>



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

        </div>
@stop


@section('javascript')
<script type="text/javascript">

    $('.expanding-search-form .dropdown-toggle').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
		$(this).find('.fa').toggleClass("fa-caret-left fa-caret-down");

        $(this).closest('.search-dropdown').toggleClass('open');
    });

    $('.expanding-search-form .dropdown-menu > li > a').click(function(e) {
        e.preventDefault();
        var clicked = $(this);
        clicked.closest('.dropdown-menu').find('.menu-active').removeClass('menu-active');
        clicked.parent('li').addClass('menu-active');

        var newLabel = clicked.html();
        clicked.closest('.search-dropdown').find('.toggle-active').html(newLabel);
		clicked.closest('.search-dropdown').find('.toggle-icon').toggleClass("fa-caret-down fa-caret-left");
		clicked.closest('.expanding-search-form').find('#global-search').attr("placeholder", `Search for ${newLabel} here`);

    });

    $(document).click(function() {
        $('.expanding-search-form .search-dropdown.open').removeClass('open');
    });

</script>
@stop
