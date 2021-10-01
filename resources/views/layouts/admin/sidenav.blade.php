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
            <a class="nav-link" href="index.html">
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
                    <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('course_list')}}">Courses</a></li>
                    <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('document_list')}}">Documents Required</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{route('occupations')}}">Occupation</a></li>
                    <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{route('qualifications')}}">Qualification</a></li>
                </ul>
            </div>
        </li>
            </ul>
</nav>
