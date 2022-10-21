                <div class="right-side">


                    <a href="{{route('search2')}}" class="-mr-2 text-2xl header_widgets text-blue-700" title="search">
                        <i class="icon-feather-search font-semibold" aria-hidden="true"></i>
                    </a>
                    


                    <!--
                    <a href="" title="search" class="text-2xl icon-feather-search"></a>

                    <div class="nav-search">
                    <a class="searchbox-icon"><i class="fa fa-search" aria-hidden="true"></i></span>
                    </div>
                    -->


                    <!-- <div class="nav-search">
                        <form class="searchbox">
                            <input type="search" placeholder="Search......" name="search" class="searchbox-input" onkeyup="buttonUp();" required>
                            <input type="submit" class="searchbox-submit" value="">
                            <span class="searchbox-icon"><i class="fa fa-search" aria-hidden="true"></i></span>
                        </form>
                    </div> -->

                    @if(Sentinel::check())

                        @if(Sentinel::getUser()->roles()->first()->slug == 'student')
                        <!-- cart -->
                        <a href="#" class="header_widgets">
                            <ion-icon name="cart-outline" class="is-icon"></ion-icon>
                            <span>4</span>
                        </a>

                        <div uk-drop="mode: click" class="dropdown_cart">
                            <!-- <h4 class="cart-headline"> My Cart </h4> -->
                            <ul class="dropdown_cart_scrollbar" data-simplebar>
                                <li>
                                    <div class="cart_avatar">
                                        <img src="{{asset('images/courses/img-1.jpg')}}" alt="">
                                    </div>
                                    <div class="cart_text">
                                        <h4>  Become a Web Developer from Scratch to Advanced </h4>
                                    </div>
                                    <div class="cart_price">
                                        <span> $19.99 </span>
                                        <button class="type"> Remove</button>
                                    </div>
                                </li>
                                <li>
                                    <div class="cart_avatar">
                                        <img src="{{asset('images/courses/img-2.jpg')}}" alt="">
                                    </div>
                                    <div class="cart_text">
                                        <h4> Angular Fundamentals for Beginner to advance </h4>
                                    </div>
                                    <div class="cart_price">
                                        <span> $12.99 </span>
                                        <button class="type"> Remove</button>
                                    </div>
                                </li>
                                <li>
                                    <div class="cart_avatar">
                                        <img src="{{asset('images/courses/img-3.jpg')}}" alt="">
                                    </div>
                                    <div class="cart_text">
                                        <h4> Ultimate Web Developer Course for Beginners 2020</h4>
                                    </div>
                                    <div class="cart_price">
                                        <span> $14.99 </span>
                                        <button class="type"> Remove</button>
                                    </div>
                                </li>
                                <li>
                                    <div class="cart_avatar">
                                        <img src="{{asset('images/courses/img-4.jpg')}}" alt="">
                                    </div>
                                    <div class="cart_text">
                                        <h4> The Complete JavaScript From beginning to advance </h4>
                                    </div>
                                    <div class="cart_price">
                                        <span> $16.99 </span>
                                        <button class="type"> Remove</button>
                                    </div>
                                </li>
                                <li>
                                    <div class="cart_avatar">
                                        <img src="{{asset('images/courses/img-5.jpg')}}" alt="">
                                    </div>
                                    <div class="cart_text">
                                        <h4> Become a Web Developer from Scratch to Advanced</h4>
                                    </div>
                                    <div class="cart_price">
                                        <span> $12.99 </span>
                                        <button class="type"> Remove</button>
                                    </div>
                                </li>
                                <li>
                                    <div class="cart_avatar">
                                        <img src="{{asset('images/courses/img-4.jpg')}}" alt="">
                                    </div>
                                    <div class="cart_text">
                                        <h4> The Complete JavaScript From beginning to advance </h4>
                                    </div>
                                    <div class="cart_price">
                                        <span> $16.99 </span>
                                        <button class="type"> Remove</button>
                                    </div>
                                </li>
                                <li>
                                    <div class="cart_avatar">
                                        <img src="{{asset('images/courses/img-5.jpg')}}" alt="">
                                    </div>
                                    <div class="cart_text">
                                        <h4> Become a Web Developer from Scratch to Advanced</h4>
                                    </div>
                                    <div class="cart_price">
                                        <span> $12.99 </span>
                                        <button class="type"> Remove</button>
                                    </div>
                                </li>
                                <li>
                                    <div class="cart_avatar">
                                        <img src="{{asset('images/courses/img-4.jpg')}}" alt="">
                                    </div>
                                    <div class="cart_text">
                                        <h4> The Complete JavaScript From beginning to advance </h4>
                                    </div>
                                    <div class="cart_price">
                                        <span> $16.99 </span>
                                        <button class="type"> Remove</button>
                                    </div>
                                </li>
                                <li>
                                    <div class="cart_avatar">
                                        <img src="{{asset('images/courses/img-5.jpg')}}" alt="">
                                    </div>
                                    <div class="cart_text">
                                        <h4> Become a Web Developer from Scratch to Advanced</h4>
                                    </div>
                                    <div class="cart_price">
                                        <span> $12.99 </span>
                                        <button class="type"> Remove</button>
                                    </div>
                                </li>
                                <li>
                                    <div class="cart_avatar">
                                        <img src="{{asset('images/courses/img-4.jpg')}}" alt="">
                                    </div>
                                    <div class="cart_text">
                                        <h4> The Complete JavaScript From beginning to advance </h4>
                                    </div>
                                    <div class="cart_price">
                                        <span> $16.99 </span>
                                        <button class="type"> Remove</button>
                                    </div>
                                </li>
                                <li>
                                    <div class="cart_avatar">
                                        <img src="{{asset('images/courses/img-5.jpg')}}" alt="">
                                    </div>
                                    <div class="cart_text">
                                        <h4> Become a Web Developer from Scratch to Advanced</h4>
                                    </div>
                                    <div class="cart_price">
                                        <span> $12.99 </span>
                                        <button class="type"> Remove</button>
                                    </div>
                                </li>
                            </ul>

                            <div class="cart_footer row">
                                <div class="col-md-6 text-left"><a href="{{route('cart')}}" class="text-blue-500">View cart</a></div>
                                <div class="col-md-6 text-right"><span>Subtotal : $ 320</span></div>
                                <!-- <h2> Total :  <strong> $ 320</strong> </h2> -->
                            </div>
                        </div>
                        
                        @endif


                        <!-- profile -->
                        <a href="#">
                            <img src="{{asset('images/avatars/placeholder.png')}}" class="header_widgets_avatar" alt="">
                        </a>

                        <div uk-drop="mode: hover;animation:uk-animation-slide-top-medium;offset:5" class="header_dropdown profile_dropdown">
                            <ul>
                                <li>
                                    <a href="#" class="user">
                                        <div class="user_avatar">
                                            @if(Sentinel::getUser()->profile_pic)
                                                <img src="{{URL('/')}}/storage/{{Sentinel::getUser()->profile_pic}}" class="" alt="">
                                            @else
                                                @if(Sentinel::getUser()->roles()->first()->slug == 'student')
                                                    <img src="{{asset('images/default-images/student.png')}}" class="" alt="">
                                                @elseif(Sentinel::getUser()->roles()->first()->slug == 'teacher')
                                                    <img src="{{asset('images/default-images/teacher.png')}}" class="" alt="">
                                                @elseif(Sentinel::getUser()->roles()->first()->slug == 'marketer')
                                                    <img src="{{asset('images/default-images/marketer.png')}}" class="" alt="">
                                                @elseif(Sentinel::getUser()->roles()->first()->slug == 'editor')
                                                    <img src="{{asset('images/default-images/editor.png')}}" class="" alt="">
                                                @elseif(Sentinel::getUser()->roles()->first()->slug == 'admin')
                                                    <img src="{{asset('images/default-images/admin.png')}}" class="" alt="">
                                                @else
                                                    <img src="{{asset('images/default-images/user.png')}}" class="" alt="">
                                                @endif
                                            @endif
                                            {{--<img src="{{asset('images/avatars/avatar-2.jpg')}}" alt="">--}}
                                        </div>
                                        <div class="user_name">
                                            <div>{{Sentinel::getUser()->full_name}}</div>
                                            <span class="text-base">{{Sentinel::getUser()->username}}</span>
                                            <span class="text-base">({{Sentinel::getUser()->roles()->first()->slug}})</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <hr>
                                </li>


                                @if(Sentinel::getUser()->roles()->first()->slug == 'student')
                                    <li>
                                        <a href="{{route('student.my-courses')}}"><ion-icon name="documents" class="is-icon"></ion-icon> <span>My Courses</span></a>
                                    </li>

                                    {{-- todo-undo--}}
                                    <li>
                                        <a href="{{route('student.dashboard')}}" class="is-link"><ion-icon name="reader" class="is-icon"></ion-icon> <span>Dashboard</span></a>
                                    </li>
                                    <li><hr></li>
                                    <li>
                                        <a href="{{route('student.my-courses')}}"><ion-icon name="documents" class="is-icon"></ion-icon> <span>My Courses(full-width)</span></a>
                                    </li>
                                    <li>
                                        <a href="{{route('student.my-profile')}}"><ion-icon name="person-circle" class="is-icon"></ion-icon> <span>My Account</span></a>
                                    </li>
                                    <li>
                                        <a href="{{route('student.profile-edit')}}"><ion-icon name="settings" class="is-icon"></ion-icon> <span>Account Settings</span></a>
                                    </li>
                                    <li>
                                        <a href="{{route('student.help')}}"><ion-icon name="help-circle" class="is-icon"></ion-icon> <span>Help</span></a>
                                    </li>
                                    

                                @elseif(Sentinel::getUser()->roles()->first()->slug == 'teacher')
                                    
                                    <li>
                                        <a href="{{route('teacher.dashboard')}}" class="is-link"><ion-icon name="reader" class="is-icon"></ion-icon> <span class="font-semibold">Admin Panel <small>(Dashboard)</small></span></a>
                                    </li><li><hr></li>
                                    {{-- todo-undo--}}
                                    <li>
                                        <a href="{{route('teacher.my-courses',Sentinel::getUser()->username)}}"><ion-icon name="documents" class="is-icon"></ion-icon> <span>My Courses</span></a>
                                    </li>
                                    <li>
                                        <a href="{{route('teacher.course-create')}}"><ion-icon name="duplicate" class="is-icon"></ion-icon> <span>Add Course</span></a>
                                    </li>
                                    <li>
                                        <a href="{{route('teacher.my-profile')}}"><ion-icon name="person-circle" class="is-icon"></ion-icon> <span>My Account</span></a>
                                    </li>
                                    <li>
                                        <a href="{{route('teacher.profile-edit')}}"><ion-icon name="settings" class="is-icon"></ion-icon> <span>Account Settings</span></a>
                                    </li>
                                    <li>
                                        <a href="{{route('teacher.help')}}"><ion-icon name="help-circle" class="is-icon"></ion-icon> <span>Help</span></a>
                                    </li>
                                    <li>
                                        <a href="{{route('teacher.earnings')}}"><ion-icon name="cash" class="is-icon"></ion-icon> <span>My Earnings</span></a>
                                    </li>

                                @elseif(Sentinel::getUser()->roles()->first()->slug == 'marketer')
                                    {{--todo create routes for marketer dashboard, and other pages--}}
                                    <li>
                                        <a href="{{route('admin.dashboard')}}" class="is-link"><ion-icon name="reader" class="is-icon"></ion-icon> <span class="font-semibold">Admin Panel <small>(Dashboard)</small></span></span></a>
                                    </li><li><hr></li>

                                @elseif(Sentinel::getUser()->roles()->first()->slug == 'editor')
                                    {{--todo create route for editor dashboard, and other pages--}}
                                    <li>
                                        <a href="{{route('admin.dashboard')}}" class="is-link"><ion-icon name="reader" class="is-icon"></ion-icon> <span class="font-semibold">Admin Panel <small>(Dashboard)</small></span></span></a>
                                    </li><li><hr></li>

                                @elseif(Sentinel::getUser()->roles()->first()->slug == 'admin')
                                    <li>
                                        <a href="{{route('admin.dashboard')}}" class="is-link"><ion-icon name="reader" class="is-icon"></ion-icon> <span class="font-semibold">Admin Panel <small>(Dashboard)</small></span></span></a>
                                    </li><li><hr></li>

                                @else

                                @endif
                                <li><hr></li>

                                <li>
                                    <a href="{{route('auth.change-password')}}"><ion-icon name="lock-open" class="is-icon"></ion-icon> <span>Change Password</span></a>
                                </li>

                                <li><hr></li>

                                {{--
                                <li>
                                    <a href="#" id="night-mode" class="btn-night-mode" onclick="UIkit.notification({ message: 'Hmm...  <strong> Night mode </strong> feature is not available yet. ' , pos: 'bottom-right'  })">
                                        <ion-icon name="moon-outline" class="is-icon"></ion-icon>
                                        Night mode
                                        <span class="btn-night-mode-switch">
                                            <span class="uk-switch-button"></span>
                                        </span>
                                    </a>
                                </li>
                                --}}

                                <li>
                                    <form action="{{route('auth.logout')}}" method="post" class='logout-form'>
                                        {{csrf_field ()}}
                                        <a href="">
                                            <ion-icon name="log-out" class="is-icon" ></ion-icon>
                                            Log Out
                                        </a>
                                    </form>
                                </li>

                            </ul>
                        </div>
                    @endif


                    @if(Sentinel::check())
                        <form action="{{route('auth.logout')}}" method="post" class='logout-form'>
                            {{csrf_field ()}}
                            <a href="" class="text-blue-400 font-semibold ml-3">Log Out</a>
                        </form>
                    @else
                        <a href="{{route('auth.login')}}" class="text-blue-400 font-semibold ml-3">Login</a>
                    @endif

                    <button class="toggle-btn-div">
                        <div class="one"></div>
                        <div class="two"></div>
                        <div class="three"></div>
                    </button>

                </div>
