<!-- Logo -->
<a href="{!! url('/') !!}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>S</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>S@ifur's</b></span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- Notifications: style can be found in dropdown.less -->
            @if(env('NOTIFICATION_ENABLED') == 1)
                @php $user = Auth::user(); @endphp
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-warning">{{ count($user->unreadNotifications) }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have {{ count($user->unreadNotifications) }} notifications</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                            @foreach ($user->unreadNotifications as $notification)
                                @include('backend.layouts.partials.notification')
                            @endforeach
                            <!-- end message -->
                            </ul>
                        </li>
                        @if(count($user->unreadNotifications) > 0)
                            <li class="footer">
                                <a href="{{ route('notification-all-read') }}" class="text-bold">Mark all as read</a>
                            </li>
                        @endif
                    </ul>
                </li>
        @endif
        <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    @if(isset(auth()->user()->member_image->file_image_name))
                        <img
                            src="/{{ \Utility::$fileUploadPathMemberImage }}/{{ auth()->user()->member_image->file_image_name }}"
                            class="user-image" alt="{{auth()->user()->username}}">
                    @else
                        <img src="{{asset('/assets/dist/img/default-profile-icon-16.jpg')}}" class="user-image"
                             alt="Profile Photo">
                    @endif
                    <span class="hidden-xs">{{auth()->user()->name}}</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        @if(isset(auth()->user()->member_image->file_image_name))
                            <img
                                src="/{{ \Utility::$fileUploadPathMemberImage }}/{{ auth()->user()->member_image->file_image_name }}"
                                class="img-circle" alt="{{auth()->user()->username}}">
                        @else
                            <img src="{{asset('/assets/dist/img/default-profile-icon-16.jpg')}}" class="img-circle"
                                 alt="Profile Photo">
                        @endif
                        <p>
                            {{ auth()->user()->name }} - {{ auth()->user()->roles[0]['name'] }}
                            <small>Member since {{ auth()->user()->created_at->format('M d, Y') }}</small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <li class="user-body">
                        <div class="row">
                            <div class="col-xs-4 text-center">
                                <a href="#">Registration</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </div>
                        <!-- /.row -->
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="{{ url('/backend/user-details/' . auth()->user()->id) }}"
                               class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Sign out</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->
            <li>
                &nbsp;&nbsp;&nbsp;&nbsp;
                {{-- <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a> --}}</li>
        </ul>
    </div>
</nav>
