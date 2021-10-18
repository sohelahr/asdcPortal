<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="profile-image">
                    <img src="http://via.placeholder.com/40x40" alt="image"/>
                </div>
                <div class="profile-name">
                    <p class="name">
                        Welcome {{Auth::user()->name}}
                    </p>
                    <p class="designation">
                        Super Admin
                    </p>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('admin/dashboard')}}">
                <i class="fa fa-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#config-entities" aria-expanded="false" aria-controls="page-layouts">
                    <i class="fab fa-trello menu-icon"></i>
                    <span class="menu-title">Config Entities</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="config-entities">
                    <ul class="nav flex-column sub-menu">
                        @if(\App\Http\Helpers\CheckPermission::hasPermission('view.courses'))
                            <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('course_list')}}">Courses</a></li>
                        @endif
                        <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('coursebatch_list')}}">Course Batches</a></li>
                        <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('document_list')}}">Documents Required</a></li>
                        <li class="nav-item"> <a class="nav-link" href="{{route('occupations')}}">Occupation</a></li>
                        <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('qualifications')}}">Qualification</a></li>
                        
                    </ul>
                </div>
            </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#users" aria-expanded="false" aria-controls="page-layouts">
                <i class="far fa-user menu-icon"></i>
                <span class="menu-title">Users</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="users">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('user_profile_list')}}">Profiles</a></li>
                    @if(Auth::user()->user_type=='1')
                        <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('subadmin_list')}}">Sub Admins</a></li>
                    @endif
                </ul>
            </div>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#admission" aria-expanded="false" aria-controls="page-layouts">
                <i class="far fa-address-card menu-icon"></i>
                <span class="menu-title">Admission</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="admission">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('registration/')}}">Registrations</a></li>
                    <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admission/')}}">Admissions</a></li>

                </ul>
            </div>
        </li>
        </ul>
</nav>
