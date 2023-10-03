
<ul class="nav nav-tabs flex-column mb-3">
    <li class="nav-item">
        <a  class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}" 
            data-toggle="tab" href="{{route('dashboard')}}">
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
                <ion-icon name="settings" class="is-icon text-xl mr-3"></ion-icon> <span>Edit my profile</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('enrolled-courses') ? 'active' : '' }}" 
            data-toggle="tab" href="{{route('enrolled-courses')}}">
                <ion-icon name="documents" class="is-icon text-xl mr-3"></ion-icon> <span>My Courses</span>
        </a>
    </li>
</ul>


