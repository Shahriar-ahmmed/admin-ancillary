@inject('commonLibInstance', 'Ahmmed\AdminAncillary\CommonLib')


<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile" style="background: #26c6da;">
            <!-- User profile image -->
            <div class="profile-img">
                <img src="{{url(URL::asset('public/admin-ancillary/css/images/profile.png'))}}" alt="user">
            </div>
            <!-- User profile text-->
            <div class="profile-text">
                <a href="#" class="" >{{Auth::user()->name}}</a>
            </div>
        </div>
        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                {!! $commonLibInstance->initiateMenu(app('Illuminate\Http\Request')->path()) !!}

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->

</aside>
