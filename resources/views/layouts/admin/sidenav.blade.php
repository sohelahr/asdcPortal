<header class="main-nav">
    <div class="sidebar-user text-center">
        <img class="img-90 rounded-circle" src="{{asset('/storage/app/profile_photos/blankimage.png')}}" alt="" />
        <a href="javascript:void(0);"> <h6 class="mt-3 f-14 f-w-600" >{{Auth::user()->name}}</h6></a>
        
        <div class="setting-primary logout-primary ">
            <form method="POST" action="{{ route('logout') }}" id="loggingout">
                @csrf
                <a href="javascript:void(0);" onclick="document.getElementById('loggingout').submit();">
                    <i class=" icofont icofont-power" ></i>
                </a>
            </form>
        </div>
        {{-- <p class="mb-0 font-roboto">Human Resources Department</p> --}}
        {{-- <ul>
            <li>
                <span><span class="counter">19.8</span>k</span>
                <p>Follow</p>
            </li>
            <li>
                <span>2 year</span>
                <p>Experince</p>
            </li>
            <li>
                <span><span class="counter">95.2</span>k</span>
                <p>Follower</p>
            </li>
        </ul> --}}
    </div>
    <nav>
        <div class="main-navbar">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link" href="{{url('/admin/dashboard')}}">
                            <i data-feather="home"></i>
                            Dashboard
                        </a> 
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i data-feather="sliders"></i>
                            <span>Config Entities</span>
                        </a>
                    <ul class="nav-submenu menu-content">
                        @if(\App\Http\Helpers\CheckPermission::hasPermission('view.courses'))
                            <li><a href="{{route('course_list')}}">Courses</a></li>
                        @endif
                        @if(\App\Http\Helpers\CheckPermission::hasPermission('view.coursebatch'))
                            <li><a href="{{route('coursebatch_list')}}">Course Batches</a></li>
                        @endif
                        @if(\App\Http\Helpers\CheckPermission::hasPermission('view.documents'))
                            <li><a href="{{route('document_list')}}">Documents Required</a></li>
                        @endif
                        @if(\App\Http\Helpers\CheckPermission::hasPermission('view.occupations'))
                            <li><a href="{{route('occupations')}}">Occupation</a></li>
                        @endif    
                        @if(\App\Http\Helpers\CheckPermission::hasPermission('view.qualifications'))
                            <li><a href="{{route('qualifications')}}">Qualification</a></li>
                        @endif
                    </ul>
                  </li>
                  <li class="dropdown">
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i data-feather="user"></i>
                            <span>Profiles</span>
                        </a>
                    <ul class="nav-submenu menu-content">
                        @if(\App\Http\Helpers\CheckPermission::hasPermission('list.profiles'))
                            <li><a href="{{route('user_profile_list')}}">Students</a></li>
                        @endif
                        @if(Auth::user()->user_type=='1')
                            <li><a href="{{route('subadmin_list')}}">Staff</a></li>
                        @endif
                    </ul>
                  </li>
                  <li class="dropdown">
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i data-feather="credit-card"></i>
                            <span>Admission</span>
                        </a>
                    <ul class="nav-submenu menu-content">
                        @if(\App\Http\Helpers\CheckPermission::hasPermission('view.registrations'))
                            <li><a href="{{url('registration/')}}">Registrations</a></li>
                        @endif
                        @if(\App\Http\Helpers\CheckPermission::hasPermission('list.admissions'))
                            <li><a href="{{url('admission/')}}">Admissions</a></li>
                        @endif
                    </ul>
                  </li>
                  <li class="dropdown">
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i data-feather="percent"></i>
                            <span>Assessments</span>
                        </a>
                    <ul class="nav-submenu menu-content">
                        @if(\App\Http\Helpers\CheckPermission::hasPermission('list.admissions'))
                            <li> <a href="{{url('assessment/')}}">Assessments</a></li>
                        @endif
                    </ul>
                  </li> 
                  <li class="dropdown">
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i data-feather="list"></i>
                            <span>Attendance</span>
                        </a>
                    <ul class="nav-submenu menu-content">
                        <li> <a href="{{url('attendance/')}}">Attendance</a></li>
                        {{-- <li> <a href="{{url('attendance/import_summaries')}}">Import Summaries</a></li> --}}
                    </ul>
                  </li>
                  <li class="dropdown">
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i data-feather="user-check"></i>
                            <span>Employments</span>
                        </a>
                    <ul class="nav-submenu menu-content">
                        @if(\App\Http\Helpers\CheckPermission::hasPermission('list.student_employment'))
                            <li> <a href="{{url('studentemployment/')}}">Employments</a></li>
                        @endif
                    </ul>
                  </li> 
                  <li class="dropdown">
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i data-feather="archive"></i>
                            <span>Instructor</span>
                        </a>
                    <ul class="nav-submenu menu-content">
                        @if(\App\Http\Helpers\CheckPermission::hasPermission('list.student_employment'))
                            <li> <a href="{{url('instructor/')}}">Instructors</a></li>
                        @endif
                    </ul>
                  </li> 
                  <li class="dropdown">
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i data-feather="trending-up"></i>
                            <span>Feedbacks</span>
                        </a>
                    <ul class="nav-submenu menu-content">
                        @if(\App\Http\Helpers\CheckPermission::hasPermission('list.admissions'))
                            <li> <a href="{{url('feedback/')}}">Feedbacks</a></li>
                        @endif
                    </ul>
                  </li> 
                  <li class="dropdown">
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i data-feather="file-text"></i>
                            <span>Reports</span>
                        </a>
                    <ul class="nav-submenu menu-content">
                        @if(\App\Http\Helpers\CheckPermission::hasPermission('list.admissions'))
                            <li> <a href="{{url('report/')}}">Reports</a></li>
                        @endif
                    </ul>
                  </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>
