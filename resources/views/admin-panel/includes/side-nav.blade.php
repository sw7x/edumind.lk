    <nav class="sidebar navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">


                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <img alt="image" class="_bg-white _rounded-circle" src="{{asset('admin/img/3logo.png')}}"/>                        
                        @if(Sentinel::check() && (Sentinel::getUser()->roles()->first()->slug != 'student'))
                        <a class="dropdown-toggle" href="#">
                            <span class="mt-1 text-white text-center text-lg __text-muted text-xs block">{{Sentinel::getUser()->username}}</span>
                        </a>
                        @endif                        
                    </div>
                    <div class="logo-element"><small>Edumind</small></div>
                </li>


                <li class="{{ Route::is('admin.dashboard') ? 'active current' : '' }}">
                    <a href="{{route('admin.dashboard')}}"><i class="fa fa-desktop text-lg"></i> <span class="nav-label">Dashboard</span></a>
                </li>


                <li class="{{ \Str::is('admin.subject.*', Route::currentRouteName()) ? 'active current' : '' }}">
                    <a href="#" class="" aria-expanded="{{ \Str::is('admin.subject.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <i class="fa fa-book"></i><span class="nav-label">Subject</span> <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level" aria-expanded="{{ \Str::is('admin.subject.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <li class="{{ Route::is('admin.subject.index') ? 'current' : '' }}"><a href="{{route('admin.subject.index')}}">Subject list</a></li>
                        <li class="{{ Route::is('admin.subject.create') ? 'current' : '' }}"><a href="{{route('admin.subject.create')}}">Create subject</a></li>
                        <li class=""><a href="{{route('admin.subject.create')}}">#Approve subject</a></li>
                        <li class=""><a href="{{route('admin.subject.create')}}">#Approve subject changes</a></li>
                    </ul>
                </li>


                <li class="{{ \Str::is('admin.user.*', Route::currentRouteName()) ? 'active current' : '' }}">
                    <a href="" aria-expanded="{{ \Str::is('admin.user.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <i class="fa fa-user-circle-o"></i><span class="nav-label">Users</span> <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.user.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <li class="{{ Route::is('admin.user.index') ? 'current' : '' }}"><a href="{{route('admin.user.index')}}">User list</a></li>
                        <li class="{{ Route::is('admin.user.create') ? 'current' : '' }}"><a href="{{route('admin.user.create')}}">Add user</a></li>
                        <li class="{{ Route::is('admin.user.un-approved-teachers-list') ? 'current' : '' }}"><a href="{{route('admin.user.un-approved-teachers-list')}}">Approve teachers</a></li>
                        <li class="{{ Route::is('admin.user.changes-approve') ? 'current' : '' }}"><a href="{{route('admin.user.changes-approve')}}"># Approve user changes</a></li>
                    </ul>
                </li>


                <li class="{{ \Str::is('admin.course.*', Route::currentRouteName()) ? 'active current' : '' }}">
                    <a href="" aria-expanded="{{ \Str::is('admin.course.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <i class="fa fa-graduation-cap"></i><span class="nav-label">Course</span> <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.course.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <li class="{{ Route::is('admin.course.index') ? 'current' : '' }}"><a href="{{route('admin.course.index')}}">Course list</a></li>
                        <li class="{{ Route::is('admin.course.create') ? 'current' : '' }}"><a href="{{route('admin.course.create')}}">Add course</a></li>
                        
                        {{--                        
                        <li class="{{ Route::is('admin.course.content') ? 'current' : '' }}"><a href="{{route('admin.course.content')}}">Course content (Add/Edit)</a></li>
                        --}}

                        <li><a href="">#Approve course</a></li>
                        <li><a href="">#Approve course changes</a></li>
                        <li class="{{ Route::is('admin.course.enrollement-list') ? 'current' : '' }}"><a href="{{route('admin.course.enrollement-list')}}">Enrollments</a></li>
                        <li class="{{ Route::is('admin.course.complete-list') ? 'current' : '' }}"><a href="{{route('admin.course.complete-list')}}">Completions</a></li>
                    </ul>
                </li>


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
						<i class="fa fa-money"></i><span class="nav-label">Pay salary</span> <span class="fa arrow"></span>
					</a>
					<ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.salary.*', Route::currentRouteName()) ? 'true' : 'false' }}">
						<li class="{{ Route::is('admin.salary.pay-teacher') ? 'current' : '' }}"><a href="{{route('admin.salary.pay-teacher')}}">Pay Teacher salary</a></li>
						<li class="{{ Route::is('admin.salary.pay-marketer') ? 'current' : '' }}"><a href="{{route('admin.salary.pay-marketer')}}">Pay Marketer salary</a></li>
                        <li class="{{ Route::is('admin.salary.salary-slip') ? 'current' : '' }}"><a href="{{route('admin.salary.salary-slip')}}">Salary slip(single)</a></li>
                    </ul>
				</li>


                <li class="{{ \Str::is('admin.cupon-code.*', Route::currentRouteName()) ? 'active current' : '' }}">
                    <a href="" aria-expanded="{{ \Str::is('admin.cupon-code.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <i class="fa fa-credit-card"></i> <span class="nav-label">Cupon code</span> <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.cupon-code.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <li class="{{ Route::is('admin.cupon-code.add') ? 'current' : '' }}"><a href="{{route('admin.cupon-code.add')}}">Add cupon code</a></li>
                        <li class="{{ Route::is('admin.cupon-code.marketers') ? 'current' : '' }}"><a href="{{route('admin.cupon-code.marketers')}}">Cupon code list - (Marketer)</a></li>
                        <li class="{{ Route::is('admin.cupon-code.teachers') ? 'current' : '' }}"><a href="{{route('admin.cupon-code.teachers')}}">Cupon code list - (Teacher)</a></li>
                        {{--
                        <li class="{{ Route::is('admin.cupon-code.marketers') ? 'current' : '' }}"><a href="{{route('admin.cupon-code.marketers')}}">Cupon code - marketers</a></li>
                        <li class="{{ Route::is('admin.cupon-code.courses') ? 'current' : '' }}"><a href="{{route('admin.cupon-code.courses')}}">Cupon code - courses</a></li>
                        --}}
                    </ul>
                </li>


                <li class="{{ \Str::is('admin.feedback.*', Route::currentRouteName()) ? 'active current' : '' }}">
                    <a href="#" aria-expanded="{{ \Str::is('admin.feedback.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <i class="fa fa-comment-o"></i><span class="nav-label">Contact us</span> <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.feedback.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <li class="{{ Route::is('admin.feedback.guests') ? 'current' : '' }}"><a href="{{route('admin.feedback.guests')}}">Guest - Messages</a></li>
                        <li class="{{ Route::is('admin.feedback.students') ? 'current' : '' }}"><a href="{{route('admin.feedback.students')}}">Student - Messages</a></li>
                        <li class="{{ Route::is('admin.feedback.teachers') ? 'current' : '' }}"><a href="{{route('admin.feedback.teachers')}}">Teacher - Messages</a></li>
                        <li class="{{ Route::is('admin.feedback.other-users') ? 'current' : '' }}"><a href="{{route('admin.feedback.other-users')}}">Other User Messages</a></li>
                    </ul>
                </li>
                
                <li class="{{ \Str::is('admin.settings.*', Route::currentRouteName()) ? 'active current' : '' }}">
                    <a aria-expanded="{{ \Str::is('admin.settings.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <i class="fa fa-wrench"></i><span class="nav-label">Settings</span> <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.settings.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <li class="{{ Route::is('admin.settings.general') ? 'current' : '' }}"><a href="{{route('admin.settings.general')}}">General - Settings</a></li>
                        <li class="{{ Route::is('admin.settings.advanced') ? 'current' : '' }}"><a href="{{route('admin.settings.advanced')}}">Advanced - Settings</a></li>
                    </ul>
                </li>

                <li class="{{ \Str::is('admin.feedback.*', Route::currentRouteName()) ? 'active current' : '' }}">
                    <a href="#" aria-expanded="{{ \Str::is('admin.feedback.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <i class="fa fa fa-comment-o"></i><span class="nav-label">Contact us</span> <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.feedback.*', Route::currentRouteName()) ? 'true' : 'false' }}">
                        <li class="{{ Route::is('admin.feedback.guests') ? 'current' : '' }}"><a href="{{route('admin.feedback.guests')}}">Guest - Messages</a></li>
                        <li class="{{ Route::is('admin.feedback.students') ? 'current' : '' }}"><a href="{{route('admin.feedback.students')}}">Student - Messages</a></li>
                        <li class="{{ Route::is('admin.feedback.teachers') ? 'current' : '' }}"><a href="{{route('admin.feedback.teachers')}}">Teacher - Messages</a></li>
                        <li class="{{ Route::is('admin.feedback.other-users') ? 'current' : '' }}"><a href="{{route('admin.feedback.other-users')}}">Other User Messages</a></li>
                    </ul>
                </li>






                <li class="back-to-home">
                    <a href="{{route('home')}}" class="bg-red-900 hover:bg-red-100"><i class="fa fa-external-link _text-xl _mr-3"></i> <span class="nav-label">Back to site Home</span></a>
                </li>

				<li class="{{ \Str::is('admin.teacher.*', Route::currentRouteName()) ? 'active current' : '' }}">
					<a href="#" aria-expanded="{{ \Str::is('admin.teacher.*', Route::currentRouteName()) ? 'true' : 'false' }}">
						<span class="nav-label">Teacher</span> <span class="fa arrow"></span>
					</a>
					<ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.teacher.*', Route::currentRouteName()) ? 'true' : 'false' }}">
						<li class="{{ Route::is('admin.teacher.profile-edit') ? 'current' : '' }}"><a href="{{route('admin.teacher.profile-edit')}}">Edit Profile</a></li>
						<li class="{{ Route::is('admin.teacher.earnings') ? 'current' : '' }}"><a href="{{route('admin.teacher.earnings')}}">My Earnings</a></li>
						<li class="{{ Route::is('admin.teacher.my-courses') ? 'current' : '' }}"><a href="{{route('admin.teacher.my-courses')}}">My Courses</a></li>
						<li class="{{ Route::is('admin.teacher.dashboard') ? 'current' : '' }}"><a href="{{route('admin.teacher.dashboard')}}">Dashboard</a></li>

                        <li class="{{ Route::is('admin.teacher.enrollments') ? 'current' : '' }}"><a href="{{route('admin.teacher.enrollments')}}">My Courses enrollments</a></li>
                        <li class="{{ Route::is('admin.teacher.completions') ? 'current' : '' }}"><a href="{{route('admin.teacher.completions')}}">My Courses completions</a></li>
						<li class="{{ Route::is('admin.cupon-code.teacher-view') ? 'current' : '' }}"><a href="{{route('admin.cupon-code.teacher-view')}}">My cupon codes</a></li>

                        <li class="{{ Route::is('admin.teacher.my-salary') ? 'current' : '' }}"><a href="{{route('admin.teacher.my-salary')}}">My salary</a></li>
					</ul>
				</li>


				<li class="{{ \Str::is('admin.cupon-code.*', Route::currentRouteName()) ? 'active current' : '' }}">
					<a href="#" aria-expanded="{{ \Str::is('admin.cupon-code.*', Route::currentRouteName()) ? 'true' : 'false' }}">
						<span class="nav-label">Marketer</span> <span class="fa arrow"></span>
					</a>
					<ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.cupon-code.*', Route::currentRouteName()) ? 'true' : 'false' }}">
						<li class="{{ Route::is('admin.cupon-code.view') ? 'current' : '' }}"><a href="{{route('admin.cupon-code.view')}}">My Cupon Codes</a></li>
                        <li class="{{ Route::is('admin.cupon-code.earnings') ? 'current' : '' }}"><a href="{{route('admin.cupon-code.earnings')}}">My Earnings</a></li>
						<li class="{{ Route::is('admin.cupon-code.new') ? 'current' : '' }}"><a href="{{route('admin.cupon-code.new')}}">New Cupon Codes</a></li>
						<li class="{{ Route::is('admin.cupon-code.usage') ? 'current' : '' }}"><a href="{{route('admin.cupon-code.usage')}}">Used cupon Code</a></li>
                        <li class="{{ Route::is('admin.cupon-code.dashboard') ? 'current' : '' }}"><a href="{{route('admin.cupon-code.dashboard')}}">Dashboard</a></li>
						<li class="{{ Route::is('admin.cupon-code.single') ? 'current' : '' }}"><a href="{{route('admin.cupon-code.single')}}">Single cupon Code</a></li>
					    <li class="{{ Route::is('admin.cupon-code.my-salary') ? 'current' : '' }}"><a href="{{route('admin.cupon-code.my-salary')}}">My salary</a></li>   
                    </ul>
				</li>


				<li class="{{ \Str::is('admin.editor.*', Route::currentRouteName()) ? 'active current' : '' }}">
					<a href="#" aria-expanded="{{ \Str::is('admin.editor.*', Route::currentRouteName()) ? 'true' : 'false' }}">
						<span class="nav-label">Editor</span> <span class="fa arrow"></span>
					</a>
					<ul class="nav nav-second-level collapse" aria-expanded="{{ \Str::is('admin.editor.*', Route::currentRouteName()) ? 'true' : 'false' }}">
						<li class="{{ Route::is('admin.editor.dashboard') ? 'current' : '' }}"><a href="{{route('admin.editor.dashboard')}}">Dashboard</a></li>
					</ul>
				</li>

            </ul>

        </div>
    </nav>
