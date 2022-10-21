<ul class="nav nav-tabs flex-column mb-3">

    <li class="nav-item">
        <a class="nav-link {{ Route::is('teacher.dashboard') ? 'active' : '' }}" data-toggle="tab" href="{{route('teacher.dashboard')}}">Dashboard(T)</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('teacher.my-profile') ? 'active' : '' }}" data-toggle="tab" href="{{route('teacher.my-profile')}}">View Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('teacher.profile-edit') ? 'active' : '' }}" data-toggle="tab" href="{{route('teacher.profile-edit')}}">Edit Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('teacher.my-courses') ? 'active' : '' }}" data-toggle="tab" href="{{route('teacher.my-courses')}}">View courses</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('teacher.course-create') ? 'active' : '' }}" data-toggle="tab" href="{{route('teacher.course-create')}}">Create courses</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('teacher.course-add-content') ? 'active' : '' }}" data-toggle="tab" href="{{route('teacher.course-add-content')}}">---edit courses</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('teacher.earnings') ? 'active' : '' }}" data-toggle="tab" href="{{route('teacher.earnings')}}">Earnings</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('teacher.help') ? 'active' : '' }}" data-toggle="tab" href="{{route('teacher.help')}}">Help</a>
    </li>
</ul>




