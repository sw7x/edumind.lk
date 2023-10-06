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

                                @if(isset($subject_info) && isNotEmptyArray($subject_info))
                                    <li class="uk-parent">
                                        <a href="#">Courses</a>
                                        <ul class="uk-nav-sub uk-nav-parent-icon" uk-nav>

                                            @foreach($subject_info as $subArr)
                                                <li><a href="{{route('subjects.show',$subArr['slug'])}}">{{$subArr['name']}}</a></li>
    											<li><hr></li>
                                            @endforeach
                                            <li><a href="{{route('subjects.index')}}">Subject List</a></li>
                                        </ul>
                                    </li>
                                @endif

                                <li><a href="{{route('instructions')}}">Teach on Udemy</a></li>

                                <li><a href="{{route('contact-us.view')}}">Contact</a></li>

                                <li class="uk-parent">
                                    <a href="#">Pages</a>
                                    <ul class="uk-nav-sub uk-nav-parent-icon" uk-nav>
                                        <li class="uk-parent">
                                            <a href="#">Student </a>
                                            <ul class="uk-nav-sub">
                                                <li><a href="{{route('dashboard')}}">dashboard</a></li>
                                                <li><a href="{{route('profile-edit')}}">profile edit</a></li>
                                                <li><a href="{{route('help')}}">help</a></li>
                                                <li><a href="{{route('enrolled-courses')}}">Enrolled courses(s)</a></li>
                                                <li><a href="{{route('students.show','student1')}}">##View Student profile</a></li>
                                                <li><a href="{{route('students.courses','student1')}}">##student enrolled courses (full-width)</a></li>
                                            </ul>
                                        </li>

                                        <li class="uk-parent">
                                            <a href="#">Teacher </a>
                                            <ul class="uk-nav-sub">
                                                <li><a href="{{route('teachers.index')}}">View all teachers</a></li>
                                                <li><a href="{{route('admin.dashboard')}}">teacher-profile-dashboard</a></li>
                                                <li><a href="{{route('admin.profile-edit')}}">profile-edit</a></li>
                                                <li><a href="{{route('help')}}">help</a></li>

                                                <li><a href="{{route('admin.my-courses')}}">teacher(my) courses</a></li>


                                                {{--<li><a href="{{route('teacher.courses','teacher1')}}">teacher-profile-courses</a></li>--}}

                                                <li><a href="{{route('admin.courses.create')}}">teacher-profile-course-create</a></li>
                                                <li><a href="{{route('admin.my-earnings')}}">teacher-profile-earnings</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="{{route('teachers.show','teacher1')}}">view teacher profile</a></li>
                                        <li><a href="{{route('courses.index')}}">All courses</a></li>
                                        <li><a href="{{route('courses.search')}}">Course search</a></li>                                       
                                        <li><a href="{{route('courses.watch')}}">--course watch</a></li>
                                        {{-- <li><a href="{{route('view-cart')}}">My Cart</a></li>
                                        <li><a href="{{route('bill-info')}}">bill-info</a></li>
                                         --}}<li><a href="{{route('subjects.index')}}">subject list</a></li>
                                        <li><a href="{{route('contact-us.view')}}">contact</a></li>
                                        <li><a href="{{route('courses.show',App\Models\Course::first()->slug)}}">course single</a></li>
                                    </ul>
                                </li>

                                <li class="uk-parent">
                                    <a href="#">Important</a>
                                    <ul class="uk-nav-sub uk-nav-parent-icon" uk-nav>
                                        <li><a href="{{route('about-us')}}">EDUMIND අපි</a></li><li><hr></li>
                                        {{-- todo <li><a href="{{route('privacy-policy')}}">Privacy policy</a></li><li><hr></li>--}}
                                        <li><a href="{{route('terms-and-services')}}">ලබාගත හැකි ආදායම</a></li><li><hr></li>
                                        <li><a href="{{route('why-choose-us')}}">ප්රතිලාභ</a></li><li><hr></li>
                                        <li><a href="{{route('instructions')}}">Teach on Udemy</a></li>
                                    </ul>
                                </li>

                                @if(!Sentinel::check())
                                    <li class="uk-parent">
                                        <a href="#">Register</a>
                                        <ul class="uk-nav-sub uk-nav-parent-icon" uk-nav>
                                            <li><a href="{{route('auth.register')}}">Register as Student</a></li><li><hr></li>
                                            <li><a href="{{route('auth.teacher-register')}}">Register as Teacher</a></li>
                                        </ul>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </div>


                    <nav class="header_menu">
                        <ul class="uk-nav uk-nav-default">
                            
                            {{--<li><a href="{{route('home')}}">Home</a></li>--}}
                            
                            @if(isset($subject_info) && isNotEmptyArray($subject_info))
                                <li>
                                    <a href="#">Coursess</a>
                                    <div uk-drop="mode:hover;animation:uk-animation-slide-top-medium" class="xdropdown">
                                        <ul>
                                            @foreach($subject_info as $subArr)
                                                <li><a href="{{route('subjects.show',$subArr['slug'])}}">{{$subArr['name']}}</a></li>
                                                @if($loop->last)
                                                    <li><hr></li>
                                                @endif
                                            @endforeach
                                            <li><a href="{{route('subjects.index')}}">Subject List</a></li>
                                        </ul>
                                    </div>
                                </li>
                            @endif

                            <li><a href="{{route('instructions')}}">Teach on Udemy</a></li>
                            
                            @unless(Sentinel::check() && optional(Sentinel::getUser()->roles()->first())->slug == App\Models\Role::ADMIN)
                                <li><a href="{{ route('contact-us.view') }}">Contact</a></li>
                            @endunless
                            
                            <li>
                                <a href="#">Pages</a>
                                <div uk-drop="mode:hover;animation:uk-animation-slide-top-medium" class="xdropdown">
                                    <ul>
                                        <li><a href="#">Student </a>
                                            <div class="xdropdown" uk-drop="mode: hover;pos:right-top;animation: uk-animation-slide-right-small">
                                                <ul>
                                                    <li><a href="{{route('dashboard')}}">Dashboard</a></li>
                                                    <li><a href="{{route('profile')}}">Profile</a></li>
                                                    <li><a href="{{route('profile-edit')}}">Profile edit</a></li>
                                                    <li><a href="{{route('help')}}">Help</a></li>
                                                    <li><a href="{{route('enrolled-courses')}}">Enrolled courses(s)</a></li>
                                                    <li><a href="{{route('students.show','student1')}}">##View Student profile</a></li>
                                                    <li><a href="{{route('students.courses','student1')}}">##student enrolled courses (full-width)</a></li>
                                                </ul>
                                            </div>
                                        </li>

                                        <li><a href="#">Teacher </a>
                                            <div class="xdropdown" uk-drop="mode: hover;pos:right-top;animation: uk-animation-slide-right-small">
                                                <ul>                                                    
                                                    <li><a href="{{route('admin.dashboard')}}">dashboard</a></li>
                                                    <li><a href="{{route('profile')}}">Profile</a></li>
                                                    <li><a href="{{route('admin.profile-edit')}}">profile-edit</a></li>
                                                    <li><a href="{{route('help')}}">Help</a></li>

                                                    <li><a href="{{route('admin.my-courses')}}">My courses(t)</a></li>


                                                    {{--<li><a href="{{route('teacher.courses','teacher1')}}">--teacher-profile-courses</a></li>--}}

                                                    <li><a href="{{route('admin.courses.create')}}">Course create</a></li>
                                                    <li><a href="{{route('admin.my-earnings')}}">My earnings</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li><a href="{{route('teachers.index')}}">View all teachers</a></li>                                                
                                        <li><a href="{{route('teachers.show','teacher1')}}">View teacher profile</a></li>
                                        <li><a href="{{route('courses.index')}}">All courses</a></li>
                                        <li><a href="{{route('courses.search')}}">Search</a></li>                                        
                                        <li><a href="{{route('courses.watch')}}">--course watch</a></li>
                                        <li><a href="{{route('help')}}">Help</a></li>

                                        <li><a href="#">Cart</a>
                                            <div class="xdropdown" uk-drop="mode: hover;pos:right-top;animation: uk-animation-slide-right-small">
                                                <ul>
                                                    <li><a href="{{route('view-cart')}}">Cart page</a></li>
                                                    {{-- <li><a href="{{route('bill-info')}}">billing info</a></li>
                                                    <li><a href="{{route('credit-pay')}}">credit card pay</a></li> --}}
                                                    <li><a href="{{route('checkout-complete')}}">checkout complete</a></li>
                                                    <li><a href="{{route('payment-failed')}}">Payment failed</a></li>
                                                </ul>
                                            </div>
                                        </li>

                                        
                                        @php 
                                            //dump(App\Models\Course::first()->slug);
                                        @endphp

                                        <li><a href="{{route('subjects.index')}}">subject list</a></li>
                                        <li><a href="{{route('contact-us.view')}}">contact</a></li>
                                        <li><a href="{{route('courses.show',App\Models\Course::first()->slug)}}">course single</a></li>
                                        <li><a href="{{route('profile')}}">profile</a></li>

                                    </ul>
                                </div>
                            </li>

                            <li>
                                <a href="#">Important</a>
                                <div uk-drop="mode: hover;animation:uk-animation-slide-top-medium" class="xdropdown">
                                    <ul>
                                        <li><a href="{{route('about-us')}}">EDUMIND අපි</a></li>
                                        {{-- todo <li><a href="{{route('privacy-policy')}}">Privacy policy</a></li>--}}
                                        <li><a href="{{route('terms-and-services')}}">ලබාගත හැකි ආදායම</a></li>
                                        <li><a href="{{route('why-choose-us')}}">ප්රතිලාභ</a></li>
                                        <li><a href="{{route('instructions')}}">Teach on Udemy</a></li>
                                    </ul>
                                </div>
                            </li>

                            @if(!Sentinel::check())
                                <li>
                                    <a href="#">Register</a>
                                    <div uk-drop="mode: hover;animation:uk-animation-slide-top-medium" class="xdropdown">
                                        <ul>
                                            <li><a href="{{route('auth.register')}}">Register as Student</a></li>
                                            <li><a href="{{route('auth.teacher-register')}}">Register as Teacher</a></li>
                                        </ul>
                                    </div>
                                </li>
                            @endif

                            @if(Sentinel::check())
                                @if(Sentinel::getUser()->isUserCanAccessAdminPanel())
                                    <li><a href="{{route('admin.dashboard')}}">Admin panel</a></li>
                                @endif
                            @endif

                            
                        {{--
                            @can('is_admin')
                            <li>eeeeeeeeeeeee</li>
                            @endcan
                             
                            @can('viewAny','App\Models\ContactUs')                            
                            <li>ffff</li>
                            @endcan

                            @can('viewAny',App\Models\ContactUs::class)                            
                            <li>gggg</li>
                            @endcan 
                        --}}

                        </ul>
                    </nav>

                </div>
