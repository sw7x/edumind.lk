                <div class="left-side">

                    <!-- Logo -->
                    <div id="logo">
                        <a href="{{route('home')}}" title="Edumind - Home page">
                            <img src="{{asset('images/logo.png')}}" alt="">
                            <img src="{{asset('images/logo-light.png')}}" class="logo_inverse" alt="">
                            <img src="{{asset('images/logo-mobile.png')}}" class="logo_mobile" alt="">
                        </a>
                    </div>

                    <!-- <a href="#mobile-nav-slide" class="_uk-button _uk-button-default" uk-toggle>M</a> -->

                    <!-- {{-- only visible when width <= 1024 --}} -->
                    <div id="mobile-nav-slider" uk-offcanvas="overlay: true;mode:slide">
                        <div class="uk-offcanvas-bar">

                            <button class="text-white uk-offcanvas-close" type="button" uk-close></button><br>

                            <ul class="uk-nav mobile-nav __uk-nav-default __uk-nav-divider uk-nav-parent-icon uk-nav-offcanvas" data-uk-nav>

                                <li><a href="{{route('home')}}">Home</a></li>

                                <li class="uk-parent">
                                    <a href="#">Courses</a>
                                    <ul class="uk-nav-sub uk-nav-parent-icon" uk-nav>

                                        @foreach($subject_info as $subArr)
                                            <li><a href="{{route('viewTopic',$subArr['slug'])}}">{{$subArr['name']}}</a></li>
											<li><hr></li>
                                        @endforeach
                                        <li><a href="{{route('viewAllTopic')}}">Subject List</a></li>
                                    </ul>
                                </li>

                                <li><a href="{{route('teacher.instructions')}}">Teach on Udemy</a></li>

                                <li><a href="{{route('contact.index')}}">Contact</a></li>

                                <li class="uk-parent">
                                    <a href="#">Pages</a>
                                    <ul class="uk-nav-sub uk-nav-parent-icon" uk-nav>
                                        <li class="uk-parent">
                                            <a href="#">Student </a>
                                            <ul class="uk-nav-sub">
                                                <li> <a href="{{route('student.dashboard')}}">Student profile dashboard</a></li>
                                                <li> <a href="{{route('student.profile-edit')}}">Student profile edit</a></li>
                                                <li> <a href="{{route('student.help')}}">Student profile-help</a></li>
                                                <li> <a href="{{route('student.my-profile')}}">Student(my) profile</a></li>
                                                <li> <a href="{{route('student.my-courses')}}">student(my) courses</a></li>
                                                <li> <a href="{{route('student.view-profile','dasun50')}}">View Student profile</a></li>
                                                <li> <a href="{{route('student.courses','dasun50')}}">student enrolled courses (full-width)</a></li>
                                            </ul>
                                        </li>

                                        <li class="uk-parent">
                                            <a href="#">Teacher </a>
                                            <ul class="uk-nav-sub">
                                                <li> <a href="{{route('teacher.view-all')}}">View all teachers</a></li>
                                                <li> <a href="{{route('teacher.dashboard')}}">teacher-profile-dashboard</a></li>
                                                <li> <a href="{{route('teacher.profile-edit')}}">teacher-profile-edit</a></li>
                                                <li> <a href="{{route('teacher.help')}}">teacher-profile-help</a></li>

                                                <li> <a href="{{route('teacher.my-profile')}}">teacher(my) profile</a></li>
                                                <li> <a href="{{route('teacher.my-courses')}}">teacher(my) courses</a></li>

                                                <li> <a href="{{route('teacher.course-add-content')}}">teacher course edit</a></li>

                                                <li> <a href="{{route('teacher.view-profile','lasantha50')}}">view teacher profile</a></li>
                                                {{--<li> <a href="{{route('teacher.courses','lasantha50')}}">teacher-profile-courses</a></li>--}}

                                                <li> <a href="{{route('teacher.course-create')}}">teacher-profile-course-create</a></li>
                                                <li> <a href="{{route('teacher.earnings')}}">teacher-profile-earnings</a></li>
                                            </ul>
                                        </li>

                                        <li class="uk-parent">
                                            <a href="#">Content Pages</a>
                                            <ul class="uk-nav-sub">
                                                <li> <a href="{{route('404')}}">404</a></li>
                                                <li> <a href="{{route('about-us')}}">about-us</a></li>
                                                {{-- todo <li> <a href="{{route('privacy-policy')}}">privacy policy</a></li>--}}
                                                <li> <a href="{{route('default-page')}}">default-page</a></li>
                                                <li> <a href="{{route('faq')}}">pages-faq</a></li>
                                                <li> <a href="{{route('empty')}}">empty</a></li>
                                                <li> <a href="{{route('help')}}">help</a></li>
                                                <li> <a href="{{route('terms-and-services')}}">terms and services</a></li>
                                                <li> <a href="{{route('why-choose-us')}}">Why choose us</a></li>
                                                <li> <a href="{{route('teacher.instructions')}}">teacher-instruction</a></li>
                                            </ul>
                                        </li>

                                        <li> <a href="{{route('search')}}">search</a></li>
                                        <li> <a href="{{route('search2')}}">search2</a></li>
                                        <li> <a href="{{route('courses-list')}}">courses-list</a></li>
                                        <li> <a href="{{route('course-watch')}}">course-watch</a></li>
                                        <li> <a href="{{route('cart')}}">cart</a></li>
                                        <li> <a href="{{route('bill-info')}}">bill-info</a></li>
                                        <li> <a href="{{route('viewAllTopic')}}">subject list</a></li>
                                        <li> <a href="{{route('contact.index')}}">contact</a></li>
                                        <li> <a href="{{route('course-single')}}">course-intro-3</a></li>
                                        <li> <a href="{{route('courses')}}">courses</a></li>
                                    </ul>
                                </li>

                                <li class="uk-parent">
                                    <a href="#">Important</a>
                                    <ul class="uk-nav-sub uk-nav-parent-icon" uk-nav>
                                        <li><a href="{{route('about-us')}}">EDUMIND අපි</a></li><li><hr></li>
                                        {{-- todo <li> <a href="{{route('privacy-policy')}}">Privacy policy</a></li><li><hr></li>--}}
                                        <li> <a href="{{route('terms-and-services')}}">ලබාගත හැකි ආදායම</a></li><li><hr></li>
                                        <li> <a href="{{route('why-choose-us')}}">ප්රතිලාභ</a></li><li><hr></li>
                                        <li> <a href="{{route('teacher.instructions')}}">Teach on Udemy</a></li>
                                    </ul>
                                </li>

                                @if(!Sentinel::check())
                                <li class="uk-parent">
                                    <a href="#">Register</a>
                                    <ul class="uk-nav-sub uk-nav-parent-icon" uk-nav>
                                        <li> <a href="{{route('auth.register')}}">Register as Student</a></li><li><hr></li>
                                        <li> <a href="{{route('auth.teacher-register')}}">Register as Teacher</a></li>
                                    </ul>
                                </li>
                                @endif

                            </ul>
                        </div>
                    </div>


                    <nav class="header_menu">
                        <ul class="uk-nav uk-nav-default">

                            {{--
                            <li> <a href="{{route('home')}}">Home</a></li>
                            --}}

                            <li>
                                <a href="#">Coursess</a>
                                <div uk-drop="mode:hover;animation:uk-animation-slide-top-medium" class="xdropdown">
                                    <ul>
                                        @foreach($subject_info as $subArr)
                                            <li><a href="{{route('viewTopic',$subArr['slug'])}}">{{$subArr['name']}}</a></li>
                                            @if($loop->last)
                                                <li><hr></li>
                                            @endif
                                        @endforeach
                                        <li> <a href="{{route('viewAllTopic')}}">Subject List</a></li>
                                    </ul>
                                </div>
                            </li>

                            <li> <a href="{{route('teacher.instructions')}}">Teach on Udemy</a></li>
                            <li> <a href="{{route('contact.index')}}">Contact</a></li>

                            <li>
                                <a href="#">Pages</a>
                                <div uk-drop="mode:hover;animation:uk-animation-slide-top-medium" class="xdropdown">
                                    <ul>
                                        <li> <a href="#">Student </a>
                                            <div class="xdropdown" uk-drop="mode: hover;pos:right-top;animation: uk-animation-slide-right-small">
                                                <ul>
                                                    <li> <a href="{{route('student.dashboard')}}">Student profile dashboard</a></li>
                                                    <li> <a href="{{route('student.profile-edit')}}">Student profile edit</a></li>
                                                    <li> <a href="{{route('student.help')}}">Student profile-help</a></li>
                                                    <li> <a href="{{route('student.my-profile')}}">Student(my) profile</a></li>
                                                    <li> <a href="{{route('student.my-courses')}}">student(my) courses</a></li>
                                                    <li> <a href="{{route('student.view-profile','dasun50')}}">View Student profile</a></li>
                                                    <li> <a href="{{route('student.courses','dasun50')}}">student enrolled courses (full-width)</a></li>
                                                </ul>
                                            </div>
                                        </li>

                                        <li> <a href="#">Teacher </a>
                                            <div class="xdropdown" uk-drop="mode: hover;pos:right-top;animation: uk-animation-slide-right-small">
                                                <ul>
                                                    <li> <a href="{{route('teacher.view-all')}}">View all teachers</a></li>
                                                    <li> <a href="{{route('teacher.dashboard')}}">teacher-profile-dashboard</a></li>
                                                    <li> <a href="{{route('teacher.profile-edit')}}">teacher-profile-edit</a></li>
                                                    <li> <a href="{{route('teacher.help')}}">teacher-profile-help</a></li>

                                                    <li> <a href="{{route('teacher.my-profile')}}">teacher(my) profile</a></li>
                                                    <li> <a href="{{route('teacher.my-courses')}}">teacher(my) courses</a></li>

                                                    <li> <a href="{{route('teacher.course-add-content')}}">teacher course edit</a></li>

                                                    <li> <a href="{{route('teacher.view-profile','lasantha50')}}">view teacher profile</a></li>
                                                    {{--<li> <a href="{{route('teacher.courses','lasantha50')}}">teacher-profile-courses</a></li>--}}

                                                    <li> <a href="{{route('teacher.course-create')}}">teacher-profile-course-create</a></li>
                                                    <li> <a href="{{route('teacher.earnings')}}">teacher-profile-earnings</a></li>
                                                </ul>
                                            </div>
                                        </li>

                                        <li> <a href="#">Content Pages</a>
                                            <div class="xdropdown" uk-drop="mode: hover;pos:right-top;animation: uk-animation-slide-right-small">
                                                <ul>
                                                    <li> <a href="{{route('404')}}">404</a></li>
                                                    <li> <a href="{{route('about-us')}}">about-us</a></li>
                                                    {{-- todo <li><a href="{{route('privacy-policy')}}">privacy policy</a></li>--}}
                                                    <li> <a href="{{route('default-page')}}">default-page</a></li>
                                                    <li> <a href="{{route('faq')}}">pages-faq</a></li>
                                                    <li> <a href="{{route('empty')}}">empty</a></li>
                                                    <li> <a href="{{route('help')}}">help</a></li>
                                                    <li> <a href="{{route('terms-and-services')}}">terms and services</a></li>
                                                    <li> <a href="{{route('why-choose-us')}}">Why choose us</a></li>
                                                    <li> <a href="{{route('teacher.instructions')}}">teacher-instruction</a></li>
                                                </ul>
                                            </div>
                                        </li>

                                        <li> <a href="{{route('search')}}">search</a></li>
                                        <li> <a href="{{route('search2')}}">search2</a></li>
                                        <li> <a href="{{route('courses-list')}}">courses-list</a></li>
                                        <li> <a href="{{route('course-watch')}}">course-watch</a></li>
                                        <li> <a href="{{route('cart')}}">cart</a></li>
                                        <li> <a href="{{route('bill-info')}}">bill-info</a></li>
                                        <li> <a href="{{route('viewAllTopic')}}">subject list</a></li>
                                        <li> <a href="{{route('contact.index')}}">contact</a></li>
                                        <li> <a href="{{route('course-single')}}">course-intro-3</a></li>
                                        <li> <a href="{{route('courses')}}">courses</a></li>
                                    </ul>
                                </div>
                            </li>

                            <li>
                                <a href="#">Important</a>
                                <div uk-drop="mode: hover;animation:uk-animation-slide-top-medium" class="xdropdown">
                                    <ul>
                                        <li> <a href="{{route('about-us')}}">EDUMIND අපි</a></li>
                                        {{-- todo <li> <a href="{{route('privacy-policy')}}">Privacy policy</a></li>--}}
                                        <li> <a href="{{route('terms-and-services')}}">ලබාගත හැකි ආදායම</a></li>
                                        <li> <a href="{{route('why-choose-us')}}">ප්රතිලාභ</a></li>
                                        <li> <a href="{{route('teacher.instructions')}}">Teach on Udemy</a></li>
                                    </ul>
                                </div>
                            </li>

                            @if(!Sentinel::check())
                            <li>
                                <a href="#">Register</a>
                                <div uk-drop="mode: hover;animation:uk-animation-slide-top-medium" class="xdropdown">
                                    <ul>
                                        <li> <a href="{{route('auth.register')}}">Register as Student</a></li>
                                        <li> <a href="{{route('auth.teacher-register')}}">Register as Teacher</a></li>
                                    </ul>
                                </div>
                            </li>
                            @endif

                            @if(Sentinel::check())
                                @if(Sentinel::getUser()->roles()->first()->slug != 'student')
                                <li> <a href="{{route('admin.dashboard')}}">Admin panel</a></li>
                                @endif
                            @endif
                        </ul>
                    </nav>

                </div>
