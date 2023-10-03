
<ul class="nav nav-tabs flex-column mb-3">
    <li class="nav-item">
        <a  class="nav-link {{ Route::is('teacher.dashboard') ? 'active' : '' }}" 
            data-toggle="tab" href="{{route('teacher.dashboard')}}">
                <ion-icon name="reader" class="is-icon text-xl mr-3"></ion-icon> <span>Dashboard</span>
        </a>
    </li>        
    <li class="nav-item">
        <a  class="nav-link {{ Route::is('profile') ? 'active' : '' }}" 
            data-toggle="tab" href="{{route('profile')}}">
            <ion-icon name="person-circle" class="is-icon text-xl mr-3"></ion-icon> <span>My profile</span>        
        </a>
    </li>
    <li class="nav-item">
        <a  class="nav-link {{ Route::is('profile-edit') ? 'active' : '' }}" 
            data-toggle="tab" href="{{route('profile-edit')}}">
                <ion-icon name="settings" class="is-icon text-xl mr-3"></ion-icon> <span>Edit Profile</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('teacher.my-courses') ? 'active' : '' }}" 
            data-toggle="tab" href="{{route('teacher.my-courses')}}">
                <ion-icon name="documents" class="is-icon text-xl mr-3"></ion-icon> <span>My Courses(published)</span>
        </a>
    </li>
    <li class="nav-item">
        <a  class="nav-link {{ Route::is('help') ? 'active' : '' }}" 
            data-toggle="tab" href="{{route('help')}}">
            <ion-icon name="help-circle" class="is-icon text-xl mr-3"></ion-icon> <span>Help</span>
        </a>
    </li>    

    <li class="nav-item">
        <a  class="nav-link {{ Route::is('student.earnings') ? 'active' : '' }}" 
            data-toggle="tab" href="{{route('student.earnings')}}">
            <ion-icon name="help-circle" class="is-icon text-xl mr-3"></ion-icon> <span>Earnings</span>
        </a>
    </li>
</ul>