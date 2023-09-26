
<ul class="nav nav-tabs flex-column mb-3">
    <li class="nav-item">
        <a class="nav-link {{ Route::is('student.dashboard') ? 'active' : '' }}" data-toggle="tab" href="{{route('student.dashboard')}}">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('profile') ? 'active' : '' }}" data-toggle="tab" href="{{route('profile')}}">View Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('student.profile-edit') ? 'active' : '' }}" data-toggle="tab" href="{{route('student.profile-edit')}}">Edit Profile</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('student.my-courses') ? 'active' : '' }}" data-toggle="tab" href="{{route('student.my-courses')}}">Enrolled courses</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('student.help') ? 'active' : '' }}" data-toggle="tab" href="{{route('student.help')}}">Help</a>
    </li>
</ul>



