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

                        <!-- cart -->
                        @if(optional(Sentinel::getUser()->roles()->first())->slug == App\Models\Role::STUDENT)
                        <a href="#" class="header_widgets">
                            <ion-icon name="cart-outline" class="is-icon"></ion-icon>
                            <span>{{$cartCourseCount}}</span>
                        </a>

                        <div uk-drop="mode: click" class="dropdown_cart">
                            @if($cartDiscountedCourses->count() > 1)
                                <div style="background: red;" class="font-semibold rounded border-b text-sm py-2 px-2 flex justify-between items-center">
                                    <div class="text-white">
                                        <i class="fa fa-exclamation-triangle text-base mr-1" aria-hidden="true"></i> 
                                        <span>Your cart has invalid items !</span>  
                                    </div>
                                    <div>
                                        {{-- <a href="" class="text-blue-500">Rest cart</a> --}}
                                    </div>
                                </div>
                            @endif

                            <div class="cart-headline">
                                <div>My Cart</div>
                                {{-- 
                                <a href="#" class="checkout inline-block bg-red-500 hover:bg-red-600 text-white hover:text-white py-1 px-2 rounded text-base">Checkout</a> 
                                --}}
                                <a href="{{route('view-cart')}}" class="font-medium text-sm text-blue-500">
                                    {{($cartDiscountedCourses->count() > 1) ? 'Rest my cart' : 'View my cart'}}                                    
                                </a>
                            </div>
                                                        
                            <!--  <h4 class="cart-headline"> My Cart </h4>-->
                            <ul class="dropdown_cart_scrollbar" data-simplebar 
                                style="max-height:{{($cartDiscountedCourses->count() > 1) ? '380px':'420px'}}">
                                <?php //dump($cartDiscountedCourses->pluck('course_id')) ?>
                                
                                @foreach($cartCourses as $course)
                                <li class="@if(!($loop->last)) border-b-2 border-gray-200 @endif">
                                    <div class="cart_avatar">
                                        <img src="{{$course['image']}}" alt="">                                        
                                    </div>
                                    <div class="cart_text">
                                        <!-- <h4>{{$course['name']}}</h4> -->
                                        <a href="{{route('course-single',$course['slug'])}}">{{$course['name']}}</a>
                                    </div>
                                    <div class="cart_price">
                                        <span class="text-base">{{$course['revised_price']}}</span>
                                        
                                        @if($cartDiscountedCourses->pluck('course_id')->contains($course['id']))
                                            <span class="line-through text-gray-500 font-normal">{{$course['price']}}</span>
                                        @endif
                                        
                                        <!-- <button class="type"> Remove</button> -->
                                        <form action="{{route('remove-cart',$course['id'])}}" method="post" class=''>
                                            {{csrf_field ()}}
                                            <div class="mt-4">
                                                <button type="submit" class="">Remove</button>
                                            </div>
                                            <input type="hidden" name="page" value="">
                                        </form>
                                    </div>
                                </li>
                                @endforeach
                                <!-- 
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
                                -->
                            </ul>
                            <div class="cart_footer row">
                                <div class="col-md-5 text-left">Subtotal :</div>
                                <div class="col-md-7 text-right"><span>Rs {{$cartTotal}}</span></div>
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
                                                <img src="{{Sentinel::getUser()->profile_pic}}" class="" alt="">
                                            @else
                                                @if( optional(Sentinel::getUser()->roles()->first())->slug == App\Models\Role::STUDENT)
                                                    <img src="{{asset('images/default-images/student.png')}}" class="" alt="">
                                                @elseif( optional(Sentinel::getUser()->roles()->first())->slug == App\Models\Role::TEACHER)
                                                    <img src="{{asset('images/default-images/teacher.png')}}" class="" alt="">
                                                @elseif( optional(Sentinel::getUser()->roles()->first())->slug == App\Models\Role::MARKETER)
                                                    <img src="{{asset('images/default-images/marketer.png')}}" class="" alt="">
                                                @elseif( optional(Sentinel::getUser()->roles()->first())->slug == App\Models\Role::EDITOR)
                                                    <img src="{{asset('images/default-images/editor.png')}}" class="" alt="">
                                                @elseif( optional(Sentinel::getUser()->roles()->first())->slug == App\Models\Role::ADMIN)
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
                                            <span class="text-base">({{optional(Sentinel::getUser()->roles()->first())->slug}})</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <hr>
                                </li>


                                @if(optional(Sentinel::getUser()->roles()->first())->slug == App\Models\Role::STUDENT)
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
                                        <a href="{{route('profile')}}">
                                            <ion-icon name="person-circle" class="is-icon"></ion-icon> <span>My profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('student.profile-edit')}}"><ion-icon name="settings" class="is-icon"></ion-icon> <span>Account Settings</span></a>
                                    </li>
                                    <li>
                                        <a href="{{route('student.help')}}"><ion-icon name="help-circle" class="is-icon"></ion-icon> <span>Help</span></a>
                                    </li>
                                    

                                @elseif(optional(Sentinel::getUser()->roles()->first())->slug == App\Models\Role::TEACHER)
                                    
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
                                        <a href="{{route('profile')}}">
                                            <ion-icon name="person-circle" class="is-icon"></ion-icon> <span>My profile</span>
                                        </a>
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

                                @elseif(optional(Sentinel::getUser()->roles()->first())->slug == App\Models\Role::MARKETER)
                                    {{--todo create routes for marketer dashboard, and other pages--}}
                                    <li>
                                        <a href="{{route('admin.dashboard')}}" class="is-link"><ion-icon name="reader" class="is-icon"></ion-icon> <span class="font-semibold">Admin Panel <small>(Dashboard)</small></span></span></a>
                                    </li><li><hr></li>                                    
                                    <li>
                                        <a href="{{route('admin.profile')}}">
                                            <ion-icon name="person-circle" class="is-icon"></ion-icon> <span>My profile</span>
                                        </a>
                                    </li>

                                @elseif(optional(Sentinel::getUser()->roles()->first())->slug == App\Models\Role::EDITOR)
                                    {{--todo create route for editor dashboard, and other pages--}}
                                    <li>
                                        <a href="{{route('admin.dashboard')}}" class="is-link"><ion-icon name="reader" class="is-icon"></ion-icon> <span class="font-semibold">Admin Panel <small>(Dashboard)</small></span></span></a>
                                    </li><li><hr></li>
                                    <li>
                                        <a href="{{route('admin.profile')}}">
                                            <ion-icon name="person-circle" class="is-icon"></ion-icon> <span>My profile</span>
                                        </a>
                                    </li>

                                @elseif(optional(Sentinel::getUser()->roles()->first())->slug == App\Models\Role::ADMIN)
                                    <li>
                                        <a href="{{route('admin.dashboard')}}" class="is-link"><ion-icon name="reader" class="is-icon"></ion-icon> <span class="font-semibold">Admin Panel <small>(Dashboard)</small></span></span></a>
                                    </li><li><hr></li>
                                    <li>
                                        <a href="{{route('profile')}}">
                                            <ion-icon name="person-circle" class="is-icon"></ion-icon> <span>My profile</span>
                                        </a>
                                    </li>

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
