<!--start top header-->
<header class="top-header wrapper">
    <nav class="navbar navbar-expand">
        <div class="mobile-toggle-icon d-xl-none">
            <i class="las la-bars"></i>
        </div>
        <div class="top-navbar-right ms-3">
            <ul class="navbar-nav align-items-center text-center">
                <li class="">
                    <a class="nav-link" id="DarkTheme" title="Dark">
                        <div class="icon-area">
                            <i class="las la-moon"></i>
                        </div>
                    </a>
                </li>
                <li class="">
                    <a class="nav-link" id="LightTheme" title="Light">
                        <div class="icon-area">
                            <i class="las la-sun"></i>
                        </div>
                    </a>
                </li>
                <li class="">
                    <a class="nav-link" id="SemiDarkTheme" title="Semi Dark">
                        <div class="icon-area">
                            <i class="las la-adjust"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item dropdown dropdown-large">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="{{ route('admin.profile')}}" data-bs-toggle="dropdown">
                        <div class="profile-setting d-flex align-items-center gap-1">
                            <img src="{{ displayImage('assets/admin/images/'.auth()->guard('admin')->user()->image) }}" class="user-img" alt="">
                            <div class="profile-name d-none d-sm-block">{{auth()->guard('admin')->user()->username}}</div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.profile')}}">
                                <div class="d-flex align-items-center">
                                    <img src="{{ displayImage('assets/admin/images/'.auth()->guard('admin')->user()->image) }}" alt="" class="rounded-circle">
                                    <div class="ms-3">
                                        <h6 class="mb-0">{{auth()->guard('admin')->user()->first_name}} {{auth()->guard('admin')->user()->last_name}}</h6>
                                        <small class="mb-0 text-secondary">{{auth()->guard('admin')->user()->position}}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.profile')}}">
                                <div class="d-flex align-items-center">
                                    <div class="sign-icon"><i class="las la-user"></i></div>
                                    <div class="sign-text ms-3"><span>@lang('Profile')</span></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.password.change')}}">
                                <div class="d-flex align-items-center">
                                    <div class="sign-icon"><i class="las la-key"></i></div>
                                    <div class="sign-text ms-3"><span>@lang('Password')</span></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.logout')}}">
                                <div class="d-flex align-items-center">
                                    <div class="sign-icon"><i class="las la-sign-out-alt"></i></div>
                                    <div class="sign-text ms-3"><span>@lang('Logout')</span></div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!--end top header-->