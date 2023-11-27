@php    
    use App\Permissions\Abilities\ContactUsAbilities;
    use App\Permissions\Abilities\SubjectAbilities;
    use App\Permissions\Abilities\SettingsAbilities;
    use App\Permissions\Abilities\UserManageAbilities;
    use App\Permissions\Abilities\CourseAbilities;    
@endphp

    <nav class="sidebar navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">


                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <img alt="image" class="_bg-white _rounded-circle" src="{{asset('admin/img/3logo.png')}}"/>                        
                        @if(Sentinel::check())
                            <a class="dropdown-toggle" href="#">
                                <span class="mt-1 text-white text-center text-lg __text-muted text-xs block">{{optional($currentUser)->username}}</span>
                            </a>
                            <div class="text-center">
                                <small class="text-white">( {{$currentUserRole}} )</small>
                            </div>                        
                        @endif                       
                    </div>
                    <div class="logo-element"><small>Edumind</small></div>
                </li>


                <li class="{{ Route::is('admin.dashboard') ? 'active current' : '' }}">
                    <a href="{{route('admin.dashboard')}}"><i class="fa fa-desktop text-lg"></i> <span class="nav-label">Dashboard</span></a>
                </li>

                
                @canany([                   
                    SubjectAbilities::ADMIN_PANEL_VIEW_SUBJECT_LIST,
                    SubjectAbilities::CREATE_SUBJECTS,
                ])
                <li class="{{ \Str::is('admin.subjects.*', Route::currentRouteName()) ? 'active current' : '' }}">
                    <a href="#" class="" aria-expanded="{{ \Str::is('admin.subjects.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <i class="fa fa-book"></i><span class="nav-label">Subject</span> <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level" aria-expanded="{{ \Str::is('admin.subjects.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        @can(SubjectAbilities::ADMIN_PANEL_VIEW_SUBJECT_LIST)
                            <li class="{{ Route::is('admin.subjects.index') ? 'current' : '' }}"><a href="{{route('admin.subjects.index')}}">Subject list</a></li>
                        @endcan                       
                        
                        @can(SubjectAbilities::CREATE_SUBJECTS)
                            <li class="{{ Route::is('admin.subjects.create') ? 'current' : '' }}"><a href="{{route('admin.subjects.create')}}">Create subject</a></li>
                        @endcan
                        
                        <li class=""><a href="{{route('admin.subjects.create')}}">#Approve subject</a></li>
                        <li class=""><a href="{{route('admin.subjects.create')}}">#Approve subject changes</a></li>
                    </ul>
                </li>
                @endcanany

                
                @canany([                   
                    UserManageAbilities::ADMIN_PANEL_VIEW_USER_LIST,
                    UserManageAbilities::VIEW_CREATE_PAGE,
                ])
                <li class="{{ \Str::is('admin.users.*', Route::currentRouteName()) ? 'active current' : '' }}">
                    <a href="" aria-expanded="{{ \Str::is('admin.users.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <i class="fa fa-user-circle-o"></i><span class="nav-label">Users</span> <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.users.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        @can(UserManageAbilities::ADMIN_PANEL_VIEW_USER_LIST)
                            <li class="{{ Route::is('admin.users.index') ? 'current' : '' }}"><a href="{{route('admin.users.index')}}">User list</a></li>
                        @endcan

                        @can(UserManageAbilities::VIEW_CREATE_PAGE)
                            <li class="{{ Route::is('admin.users.create') ? 'current' : '' }}"><a href="{{route('admin.users.create')}}">Add user</a></li>
                        @endcan

                        <li class="{{ Route::is('admin.users.un-approved-teachers-list') ? 'current' : '' }}"><a href="{{route('admin.users.un-approved-teachers-list')}}">Approve teachers</a></li>
                        <li class="{{ Route::is('admin.users.changes-approve') ? 'current' : '' }}"><a href="{{route('admin.users.changes-approve')}}"># Approve user changes</a></li>
                    </ul>
                </li>
                @endcanany
                
                
                @canany([                   
                    CourseAbilities::ADMIN_PANEL_VIEW_COURSE_LIST,
                    CourseAbilities::CREATE_COURSES,
                ])
                <li class="{{ \Str::is('admin.courses.*', Route::currentRouteName()) ? 'active current' : '' }}">
                    <a href="" aria-expanded="{{ \Str::is('admin.courses.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <i class="fa fa-graduation-cap"></i><span class="nav-label">Course</span> <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.courses.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        @can(CourseAbilities::ADMIN_PANEL_VIEW_COURSE_LIST)
                            <li class="{{ Route::is('admin.courses.index') ? 'current' : '' }}"><a href="{{route('admin.courses.index')}}">Course list</a></li>
                        @endcan

                        @can(CourseAbilities::CREATE_COURSES)
                            <li class="{{ Route::is('admin.courses.create') ? 'current' : '' }}"><a href="{{route('admin.courses.create')}}">Add course</a></li>
                        @endcan
                        {{--                        
                        <li class="{{ Route::is('admin.courses.content') ? 'current' : '' }}"><a href="{{route('admin.courses.content')}}">Course content (Add/Edit)</a></li>
                        --}}

                        <li><a href="">#Approve course</a></li>
                        <li><a href="">#Approve course changes</a></li>
                        <li class="{{ Route::is('admin.courses.enrollement-list') ? 'current' : '' }}"><a href="{{route('admin.courses.enrollement-list')}}">Enrollments</a></li>
                        <li class="{{ Route::is('admin.courses.complete-list') ? 'current' : '' }}"><a href="{{route('admin.courses.complete-list')}}">Completions</a></li>
                    </ul>
                </li>
                @endcanany

                
                <li class="{{ \Str::is('admin.revenue.*', Route::currentRouteName()) ? 'active current' : '' }}">
                    <a href="" aria-expanded="{{ \Str::is('admin.revenue.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <i class="fa fa-usd"></i> <span class="nav-label">Revenue</span> <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.revenue.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <li class="{{ Route::is('admin.revenue.checkouts') ? 'current' : '' }}"><a href="{{route('admin.revenue.checkouts')}}">View checkouts</a></li>
						<li class="{{ Route::is('admin.revenue.all-earnings') ? 'current' : '' }}"><a href="{{route('admin.revenue.all-earnings')}}">Earnings</a></li>
                        <li class="{{ Route::is('admin.revenue.course-earnings') ? 'current' : '' }}"><a href="{{route('admin.revenue.course-earnings')}}">Earnings - courses</a></li>
                        <li class="{{ Route::is('admin.revenue.teacher-earnings') ? 'current' : '' }}"><a href="{{route('admin.revenue.teacher-earnings')}}">Earnings - teachers</a></li>
                    </ul>
                </li>

				
                <li class="{{ \Str::is('admin.salary.*', Route::currentRouteName()) ? 'active current' : '' }}">
					<a href="" aria-expanded="{{ \Str::is('admin.salary.*', Route::currentRouteName()) ? 'true' : 'false' }}">
						<i class="fa fa-money"></i><span class="nav-label">Paying</span> <span class="fa arrow"></span>
					</a>
					<ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.salary.*', Route::currentRouteName()) ? 'true' : 'false' }}">
						<li class="{{ Route::is('admin.salary.pay-teacher') ? 'current' : '' }}"><a href="{{route('admin.salary.pay-teacher')}}">Pay salary <small class="text-yellow-200 italic text-xs font-semibold">(Teacher)</small></a></li>
						<li class="{{ Route::is('admin.salary.pay-marketer') ? 'current' : '' }}"><a href="{{route('admin.salary.pay-marketer')}}">Pay commission <small class="text-yellow-200 italic text-xs font-semibold">(Marketer)</small></a></li>
                        <li class="{{ Route::is('admin.salary.teacher-salary-slip') ? 'current' : '' }}"><a href="{{route('admin.salary.teacher-salary-slip')}}">Salary slip</a></li>
                        <li class="{{ Route::is('admin.salary.marketer-salary-slip') ? 'current' : '' }}"><a href="{{route('admin.salary.marketer-salary-slip')}}">Commission slip</a></li>
                    </ul>
				</li>


                <li class="{{ \Str::is('admin.coupon-codes.*', Route::currentRouteName()) ? 'active current' : '' }}">
                    <a href="" aria-expanded="{{ \Str::is('admin.coupon-codes.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <i class="fa fa-credit-card"></i> <span class="nav-label">Coupon code</span> <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.coupon-codes.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <li class="{{ Route::is('admin.coupon-codes.create') ? 'current' : '' }}"><a href="{{route('admin.coupon-codes.create')}}">Add coupon code</a></li>
                        <li class="{{ Route::is('admin.coupon-codes.marketers') ? 'current' : '' }}"><a href="{{route('admin.coupon-codes.marketers')}}">Marketer coupon list</small></a></li>
                        <li class="{{ Route::is('admin.coupon-codes.teachers') ? 'current' : '' }}"><a href="{{route('admin.coupon-codes.teachers')}}">Teacher coupon list</a></li>
                        <li class="{{ Route::is('admin.coupon-codes.show','0NY27X') ? 'current' : '' }}"><a href="{{route('admin.coupon-codes.show','0NY27X')}}">Single coupon Code</a></li>
                        <li class="{{ Route::is('admin.coupon-codes.new') ? 'current' : '' }}"><a href="{{route('admin.coupon-codes.new')}}">New Coupon Codes</a></li>
                        <li class="{{ Route::is('admin.coupon-codes.usage') ? 'current' : '' }}"><a href="{{route('admin.coupon-codes.usage')}}">Used coupon Code</a></li>
                        {{--
                        <li class="{{ Route::is('admin.coupon-codes.marketers') ? 'current' : '' }}"><a href="{{route('admin.coupon-codes.marketers')}}">Coupon code - marketers</a></li>
                        <li class="{{ Route::is('admin.coupon-codes.courses') ? 'current' : '' }}"><a href="{{route('admin.coupon-codes.courses')}}">Coupon code - courses</a></li>
                        --}}
                    </ul>
                </li>
                      

                @canany([                   
                    ContactUsAbilities::VIEW_GUEST_MESSAGES,
                    ContactUsAbilities::VIEW_STUDENT_MESSAGES,
                    ContactUsAbilities::VIEW_TEACHER_MESSAGES,
                    ContactUsAbilities::VIEW_OTHER_USER_MESSAGES
                ])
                    <li class="{{ \Str::is('admin.feedbacks.*', Route::currentRouteName()) ? 'active current' : '' }}">
                        <a href="#" aria-expanded="{{ \Str::is('admin.feedbacks.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                            <i class="fa fa-comment-o"></i><span class="nav-label">Contact us</span> <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.feedbacks.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                            @can(ContactUsAbilities::VIEW_GUEST_MESSAGES)
                                <li class="{{ Route::is('admin.feedbacks.guest') ? 'current' : '' }}"><a href="{{route('admin.feedbacks.guest')}}">Guest - Messages</a></li>
                            @endcan                        
                            
                            @can(ContactUsAbilities::VIEW_STUDENT_MESSAGES)
                                <li class="{{ Route::is('admin.feedbacks.student') ? 'current' : '' }}"><a href="{{route('admin.feedbacks.student')}}">Student - Messages</a></li>
                            @endcan
                            
                            @can(ContactUsAbilities::VIEW_TEACHER_MESSAGES)
                                <li class="{{ Route::is('admin.feedbacks.teacher') ? 'current' : '' }}"><a href="{{route('admin.feedbacks.teacher')}}">Teacher - Messages</a></li>
                            @endcan
                            
                            @can(ContactUsAbilities::VIEW_OTHER_USER_MESSAGES)
                                <li class="{{ Route::is('admin.feedbacks.other-user') ? 'current' : '' }}"><a href="{{route('admin.feedbacks.other-user')}}">Other User Messages</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                
                
                @canany([
                    SettingsAbilities::VIEW_GENERAL_SETTINGS,
                    SettingsAbilities::VIEW_ADVANCED_SETTINGS
                ])  
                <li class="{{ \Str::is('admin.settings.*', Route::currentRouteName()) ? 'active current' : '' }}">
                    <a aria-expanded="{{ \Str::is('admin.settings.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <i class="fa fa-wrench"></i><span class="nav-label">Settings</span> <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.settings.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        @can(SettingsAbilities::VIEW_GENERAL_SETTINGS)
                            <li class="{{ Route::is('admin.settings.general') ? 'current' : '' }}"><a href="{{route('admin.settings.general')}}">General - Settings</a></li>
                        @endcan
                        
                        @can(SettingsAbilities::VIEW_ADVANCED_SETTINGS)
                            <li class="{{ Route::is('admin.settings.advanced') ? 'current' : '' }}"><a href="{{route('admin.settings.advanced')}}">Advanced - Settings</a></li>
                        @endcan
                    </ul>
                </li>
                @endcanany


                <li class="back-to-home">
                    <a href="{{route('home')}}" class="bg-red-900 hover:bg-red-100"><i class="fa fa-external-link _text-xl _mr-3"></i> <span class="nav-label">Back to site Home</span></a>
                </li>

				<li class="{{ \Str::is('admin.teacher.*', Route::currentRouteName()) ? 'active current' : '' }}">
					<a href="#" aria-expanded="{{ \Str::is('admin.teacher.*', Route::currentRouteName()) ? 'true' : 'false' }}">
						<span class="nav-label">Teacher</span> <span class="fa arrow"></span>
					</a>
					<ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.teacher.*', Route::currentRouteName()) ? 'true' : 'false' }}">
						<li class="{{ Route::is('admin.profile-edit') ? 'current' : '' }}"><a href="{{route('admin.profile-edit')}}">Edit My Profile</a></li>
						<li class="{{ Route::is('admin.my-earnings') ? 'current' : '' }}"><a href="{{route('admin.my-earnings')}}">My Earnings</a></li>
						<li class="{{ Route::is('admin.my-courses') ? 'current' : '' }}"><a href="{{route('admin.my-courses')}}">My Courses</a></li>
						<li class="{{ Route::is('admin.enrollments') ? 'current' : '' }}"><a href="{{route('admin.enrollments')}}">Enrollements for my courses</a></li>
                        <li class="{{ Route::is('admin.course-completions') ? 'current' : '' }}"><a href="{{route('admin.course-completions')}}">Completions of my courses</a></li>
						<li class="{{ Route::is('admin.coupon-codes.my-coupons') ? 'current' : '' }}"><a href="{{route('admin.coupon-codes.my-coupons')}}">My coupon codes</a></li>
                        <li class="{{ Route::is('admin.my-salaries') ? 'current' : '' }}"><a href="{{route('admin.my-salaries')}}">My salaries</a></li>
                    </ul>
                </li>


				<li class="{{ \Str::is('admin.coupon-codes.*', Route::currentRouteName()) ? 'active current' : '' }}">
					<a href="#" aria-expanded="{{ \Str::is('admin.coupon-codes.*', Route::currentRouteName()) ? 'true' : 'false' }}">
						<span class="nav-label">Marketer</span> <span class="fa arrow"></span>
					</a>
					<ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.coupon-codes.*', Route::currentRouteName()) ? 'true' : 'false' }}">
						<li class="{{ Route::is('admin.coupon-codes.my-coupons') ? 'current' : '' }}"><a href="{{route('admin.coupon-codes.my-coupons')}}">My Coupon Codes</a></li>
                        <li class="{{ Route::is('admin.my-earnings') ? 'current' : '' }}"><a href="{{route('admin.my-earnings')}}">My Earnings</a></li>
						
                        <li class="{{ Route::is('admin.my-commissions') ? 'current' : '' }}"><a href="{{route('admin.my-commissions')}}">My commissions</a></li>   
                    </ul>
				</li>

                               

                <li class="{{ Route::is('admin.profile') ? 'active current' : '' }}">
                    <a href="{{route('admin.profile')}}"><i class="fa fa-id-card text-lg"></i> <span class="nav-label">Profile</span></a>
                </li>
				

                
            </ul>

        </div>
    </nav>
