
<div class="col-xl-2 col-lg-4 col-md-5">
    <ul class="account-links-sidebar user-account">
        <li class="nav-link @if(Route::currentRouteName() =='user.dashboard') active @endif"><a href="{{ route('user.dashboard')}}"><i class="fa fa-gauge"></i>@lang('Account Dashboard')</a></li>
        <li class="nav-link @if(Route::currentRouteName() =='user.edit.profile') active @endif "><a href="{{ route('user.edit.profile')}}"><i class="fa fa-user"></i>@lang('Account Information')</a></li>
{{--        <li class="nav-link @if(Route::currentRouteName() =='user.address.update') active @endif"><a href="{{ route('user.address.update')}}"><i class="fa fa-map-marker"></i>@lang('Address Book')</a></li>--}}
        <li class="nav-link @if(Route::currentRouteName() =='user.my.order') active @endif"><a href="{{ route('user.my.order')}}"><i class="fa fa-shopping-cart"></i>@lang('My Orders')</a></li>
        <li class="nav-link @if(Route::currentRouteName() =='user.my.points') active @endif"><a href="{{ route('user.my.points')}}"><i class="fa fa-award"></i>@lang('My Points & Rewards')</a></li>
        <li class="nav-link @if(Route::currentRouteName() =='user.logout') active @endif"><a href="{{ route('user.logout')}}"><i class="fa fa-arrow-right-from-bracket"></i>@lang('Logout')</a></li>
    </ul>
</div>
