<!--start sidebar -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ displayImage($templateAssets.'images/logo/logo.png') }}" class="site-logo" alt="@lang('Favicon')">
        </div>
        <div>
            <h4 class="site-name">{{__($setting->site_name)}}</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class="las la-bars"></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="sidebar-menu" id="menu">
        <li class="sidebar-menu-item">
            <a href="{{route('admin.dashboard')}}" class="{{ menuActive('admin.dashboard')[0] }}">
                <i class="las la-home"></i>
                <span class="menu-title">@lang('Dashboard')</span>
            </a>
        </li>
        <li class="menu-label">@lang('MANAGE USERS')</li>
        <li class="has-child-menu {{ menuActive('admin.users.*')[2] }}">
            <a class="has-arrow {{ menuActive('admin.users.*')[0] }}">
                <i class="las la-user"></i>
                <span class="menu-title">@lang('Manage Users')</span>
            </a>
            <ul class="menu-li menu-li-active {{ menuActive('admin.users.*')[1] }}">
                <li class="{{ menuActive('admin.users.list')[2] }} {{ menuActive('admin.users.details')[2] }}">
                    <a href="{{ route('admin.users.list') }}" class="{{ menuActive('admin.users.list')[0] }} {{ menuActive('admin.users.details')[0] }}">
                        <i class="las la-arrow-right"></i>@lang('All Users')
                    </a>
                </li>
                <li class="{{ menuActive('admin.users.active')[2] }}">
                    <a href="{{ route('admin.users.active')}}" class="{{ menuActive('admin.users.active')[0] }}">
                        <i class="las la-arrow-right"></i>@lang('Active Users')
                    </a>
                </li>
                <li class="{{ menuActive('admin.users.banned')[2] }}">
                    <a href="{{ route('admin.users.banned')}}" class="{{ menuActive('admin.users.banned')[0] }}">
                        <i class="las la-arrow-right"></i>@lang('Banned Users')
                    </a>
                </li>
                <li class="{{ menuActive('admin.users.unverified')[2] }}">
                    <a href="{{ route('admin.users.unverified')}}" class="{{ menuActive('admin.users.unverified')[0] }}">
                        <i class="las la-arrow-right"></i>@lang('Un-verified Users')
                    </a>
                </li>
            </ul>
        </li>
        <li class="has-child-menu {{ menuActive('admin.category.*')[2] }}">
            <a class="has-arrow {{ menuActive('admin.category.*')[0] }}">
                <i class="lab la-mendeley"></i>
                <span class="menu-title">@lang('Manage Category')</span>
            </a>
            <ul class="menu-li menu-li-active {{ menuActive('admin.category.*')[1] }}">
                <li class="{{ menuActive('admin.category.index')[2] }} {{ menuActive('admin.category.create')[2] }} {{ menuActive('admin.category.edit')[2] }}">
                    <a href="{{ route('admin.category.index') }}" class="{{ menuActive('admin.category.index')[0] }} {{ menuActive('admin.category.create')[0] }} {{ menuActive('admin.category.edit')[0] }}">
                        <i class="las la-arrow-right"></i>@lang('Category')
                    </a>
                </li>
                <li class="{{ menuActive('admin.sub_category.index')[2] }} {{ menuActive('admin.sub_category.create')[2] }} {{ menuActive('admin.sub_category.edit')[2] }}">
                    <a href="{{ route('admin.sub_category.index') }}" class="{{ menuActive('admin.sub_category.index')[0] }} {{ menuActive('admin.sub_category.create')[0] }} {{ menuActive('admin.sub_category.edit')[0] }}">
                        <i class="las la-arrow-right"></i>@lang('Sub Category')
                    </a>
                </li>
            </ul>
        </li>

        <li class="sidebar-menu-item {{ menuActive('admin.attribute.create')[2] }} {{ menuActive('admin.attribute.edit')[2] }} ">
            <a href="{{ route('admin.attribute.index')}}" class="{{ menuActive('admin.attribute.index')[0] }} {{ menuActive('admin.attribute.create')[0] }} {{ menuActive('admin.attribute.edit')[0] }}">
                <div class="menu-icon"><i class="las la-paperclip"></i>
                </div>
                <div class="menu-title">@lang('Attribute')</div>
            </a>
        </li>
        <li class="has-child-menu {{ menuActive('admin.category.*')[2] }}">
            <a class="has-arrow {{ menuActive('admin.category.*')[0] }}">
                <i class="lab la-dropbox"></i>
                <span class="menu-title">@lang('Manage Product')</span>
            </a>
            <ul class="menu-li menu-li-active {{ menuActive('admin.product.*')[1] }}">
                <li class="{{ menuActive('admin.product.index')[2] }} {{ menuActive('admin.product.create')[2] }} {{ menuActive('admin.product.edit')[2] }}">
                    <a href="{{ route('admin.product.index') }}" class="{{ menuActive('admin.product.index')[0] }} {{ menuActive('admin.product.create')[0] }} {{ menuActive('admin.product.edit')[0] }}">
                        <i class="las la-arrow-right"></i>@lang('Product')
                    </a>
                </li>
            </ul>
        </li>

        <li class="has-child-menu {{ menuActive('admin.order.*')[2] }}">
            <a class="has-arrow {{ menuActive('admin.order.*')[0] }}">
                <i class="lab la-dropbox"></i>
                <span class="menu-title">@lang('Manage Order')</span>
            </a>
            <ul class="menu-li menu-li-active {{ menuActive('admin.order.*')[1] }}">
                <li class="{{ menuActive('admin.order.index')[2] }} {{ menuActive('admin.order.index')[2] }} {{ menuActive('admin.order.index')[2] }}">
                    <a href="{{ route('admin.order.index') }}" class="{{ menuActive('admin.order.index')[0] }} {{ menuActive('admin.order.index')[0] }} {{ menuActive('admin.order.index')[0] }}">
                        <i class="las la-arrow-right"></i>@lang('Order List')
                    </a>
                </li>
            </ul>
        </li>

        <li class="has-child-menu {{ menuActive('admin.coupon.*')[2] }}">
            <a class="has-arrow {{ menuActive('admin.coupon.*')[0] }}">
                <i class="lab la-dropbox"></i>
                <span class="menu-title">@lang('Manage Coupon')</span>
            </a>
            <ul class="menu-li menu-li-active {{ menuActive('admin.coupon.*')[1] }}">
                <li class="{{ menuActive('admin.coupon.index')[2] }} {{ menuActive('admin.coupon.index')[2] }} {{ menuActive('admin.coupon.index')[2] }}">
                    <a href="{{ route('admin.coupon.index') }}" class="{{ menuActive('admin.coupon.index')[0] }} {{ menuActive('admin.coupon.index')[0] }} {{ menuActive('admin.coupon.index')[0] }}">
                        <i class="las la-arrow-right"></i>@lang('Coupon List')
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-label">@lang('PAYMENTS HISTORY')</li>
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.payment.history')}}" class="{{ menuActive('admin.payment.history')[0] }}">
                <div class="menu-icon"><i class="las la-file-invoice"></i>
                </div>
                <div class="menu-title">@lang('Payment')</div>
            </a>
        </li>

        <li class="sidebar-menu-item">
            <a href="{{ route('admin.subscriber.index')}}" class="{{ menuActive('admin.subscriber.index')[0] }}">
                <div class="menu-icon"><i class="las la-envelope-open-text"></i>
                </div>
                <div class="menu-title">@lang('Subscribers')</div>
            </a>
        </li>
             <li class="sidebar-menu-item">
            <a href="{{ route('admin.review.index')}}" class="{{ menuActive('admin.review.index')[0] }}">
                <div class="menu-icon"><i class="las la-envelope-open-text"></i>
                </div>
                <div class="menu-title">@lang('Rating & Review')</div>
            </a>
        </li>
        <li class="has-child-menu {{ menuActive('admin.theme.*')[2] }}">
            <a class="has-arrow {{ menuActive('admin.theme.*')[0] }}">
                <i class="las la-puzzle-piece"></i>
                <span class="menu-title">@lang('Manage Section')</span>
            </a>
            <ul class="menu-li menu-li-active {{ menuActive('admin.theme.*')[1] }}">
                @foreach ($tempBars as $key => $bar)
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.theme.item', $key) }}"
                            class="@if (route('admin.theme.item', $key) == url()->current()) sidebar-menu-active @endif">
                            <span class="sidebar-menu-title"><i class="la la-chevron-right mr-0"></i>
                                {{ __($bar['name']) }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
        <li class="menu-label">@lang('SETTING')</li>
        <li class="sidebar-menu-item">
            <a href="{{ route('admin.setting.index')}}" class="{{ menuActive('admin.setting.index')[0] }}">
                <div class="menu-icon"><i class="las la-sliders-h"></i>
                </div>
                <div class="menu-title">@lang('Site Setting')</div>
            </a>
        </li>
        <li class="sidebar-menu-item" class="{{ menuActive('admin.setting.logfav')[0] }}">
            <a href="{{ route('admin.setting.logfav')}}">
                <div class="menu-icon"><i class="las la-images"></i>
                </div>
                <div class="menu-title">@lang('Logo & Favicon')</div>
            </a>
        </li>
        <li class="sidebar-menu-item" class="{{ menuActive('admin.setting.extensions.index')[0] }}">
            <a href="{{ route('admin.setting.extensions.index')}}">
                <div class="menu-icon"><i class="las la-cogs"></i>
                </div>
                <div class="menu-title">@lang('Extensions')</div>
            </a>
        </li>
        <li class="sidebar-menu-item" class="{{ menuActive('admin.setting.seo')[0] }}">
            <a href="{{ route('admin.setting.seo')}}">
                <div class="menu-icon"><i class="las la-chart-area"></i>
                </div>
                <div class="menu-title">@lang('SEO Manager')</div>
            </a>
        </li>

        <li class="sidebar-menu-item">
            <a href="{{ route('admin.language.index')}}" class="{{ menuActive('admin.language*')[0] }}">
                <div class="menu-icon"><i class="las la-language"></i>
                </div>
                <div class="menu-title">@lang('Language')</div>
            </a>
        </li>

        <li class="menu-label">@lang('OTHER')</li>

        <li class="sidebar-menu-item">
            <a href="{{ route('admin.optimize')}}" class="{{ menuActive('admin.optimize')[0] }}">
                <div class="menu-icon"><i class="las la-broom"></i>
                </div>
                <div class="menu-title">@lang('Clear Capcha')</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar -->