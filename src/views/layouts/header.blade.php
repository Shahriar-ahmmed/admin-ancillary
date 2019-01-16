<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light" role="navigation">

        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="{{url('/admin/home')}}">
                <!-- Logo icon -->
                <b>
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <img src="{{url(URL::asset('public/admin-ancillary/css/images/logo-icon.png'))}}" alt="homepage" class="dark-logo" />
                    <!-- Light Logo icon -->
                    <img src="{{url(URL::asset('public/admin-ancillary/css/images/logo-light-icon.png'))}}" alt="homepage" class="light-logo" />
                </b>
                <!--End Logo icon -->
                <!-- Logo text --><span>
                         <!-- dark Logo text -->
                         <img src="{{url(URL::asset('public/admin-ancillary/css/images/logo-text.png'))}}" alt="homepage" class="dark-logo" />
                    <!-- Light Logo text -->
                         <img src="{{url(URL::asset('public/admin-ancillary/css/images/logo-light-text.png'))}}" class="light-logo" alt="homepage" /></span>
            </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->

        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto mt-md-0">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="fa fa-align-justify"></i></a> </li>
            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">

                <!-- ============================================================== -->
                <!-- Profile -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{url(URL::asset('public/admin-ancillary/css/images/profile.png'))}}" alt="user" class="profile-pic" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right scale-up">
                        <ul class="dropdown-user">
                            <li>
                                <div class="dw-user-box text-center">
                                    <div class="u-img"><img src="{{url(URL::asset('public/admin-ancillary/css/images/profile.png'))}}" alt="user"></div>
                                    <div class="u-text">
                                        <h4>{{Auth::user()->name}}</h4>
                                        <p class="text-muted">{{Auth::user()->email}}</p>
                                        <a href="{{url('/admin/user_profile/'.Auth::user()->id)}}" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{url('/admin/edit_profile/'.Auth::user()->id)}}"><i class="fa fa-edit"></i> Edit Profile</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{url('/admin/change_password/'.Auth::user()->id)}}"><i class="fa fa-key"></i> Change Password</a></li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <form class="" id="" role="form" method="POST" action="{{ url('/logout') }}">
                                    {{ csrf_field() }}
                                    <a href="javascript:void(0);" onclick="parentNode.submit();">
                                        <i class="fa fa-power-off"></i> Logout </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- ============================================================== -->

            </ul>
        </div>
    </nav>
</header>


