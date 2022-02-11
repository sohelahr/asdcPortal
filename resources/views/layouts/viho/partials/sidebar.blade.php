<header class="main-nav">
    <div class="sidebar-user text-center">
        <img class="img-90 rounded-circle" data-asset-url="{{asset('/')}}" src="{{asset('/storage/app/profile_photos/blankimage.png')}}" id="sidebar-img" alt="" />
        <a href="javascript:void(0);"> <h6 class="mt-3 f-14 f-w-600" id="sidebar-name" >-- -----</h6></a>
        
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
                    </li>{{-- 
                    <li class="sidebar-main-title">
                        <div>
                            <h6>Registration</h6>
                        </div>
                    </li> --}}
                    <li class="dropdown">
                        <a class="nav-link" href="{{route('user_profile')}}">
                            <i data-feather="user"></i>
                            My Profile
                        </a>  
                        <a href="{{url('/dashboard')}}" class="nav-link">
                            <i data-feather="home"></i>
                            <span>My Courses</span>
                        </a> 
                        <a href="{{route('student_feedback_view')}}" class="nav-link">
                            <i data-feather="clipboard"></i>
                            My Feedbacks</a>
                    </li>
                    {{-- <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/dashbaord') }}" href="javascript:void(0)">
                            <i data-feather="home"></i><span>Registrations</span>
                        </a>                  
                        <ul class="nav-submenu menu-content" style="display: {{ prefixBlock('/dashboard') }};">
                            <li><a href="{{url('/dashboard')}}" class="{{routeActive('/dashboard')}}">Registration</a></li>
                            <li><a href="{{route('/feedbacks')}}" class="{{routeActive('/user/feedbacks')}}">Feedbacks</a></li>
                        </ul>
                    </li> --}}
                    {{-- <li class="dropdown">
                        <a class="nav-link menu-title {{ prefixActive('/widgets') }}" href="javascript:void(0)"><i data-feather="airplay"></i><span>Widgets</span></a>
                        <ul class="nav-submenu menu-content"  style="display: {{ prefixBlock('/widgets') }};">
                            <li><a href="{{ route('general-widget') }}" class="{{routeActive('general-widget')}}">General</a></li>
                            <li><a href="{{ route('chart-widget') }}" class="{{routeActive('chart-widget')}}">Chart</a></li>
                        </ul>
                    </li> --}}
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>
