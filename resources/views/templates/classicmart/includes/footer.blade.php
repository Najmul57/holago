@php
    $footer = App\Models\Template::where('template_name',$setting->template)->where('name','footer')->where('is_multiple',0)->first();
    $contact = App\Models\Template::where('template_name',$setting->template)->where('name','contact')->where('is_multiple',0)->first();
    $social_account = App\Models\Template::where('template_name',$setting->template)->where('name','social_account')->where('is_multiple',1)->get();
    $links = App\Models\Template::where('template_name',$setting->template)->where('name','usefull_links')->where('is_multiple',1)->get();
@endphp
<footer>
    <div class="footer-area pt-5 pb-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="footer-widget">
                        <a href="{{Url('/')}}">
                            <img src="{{ displayImage($templateAssets.'img/holago.svg') }}" alt="">
                        </a>
                        <ul class="footer-address">
                            <li class="position-relative">
                                <div class="footer-left-item d-inline-block">
                                    <div class="footer-item">
                                        @lang('Trade License')
                                    </div>
                                </div>
                                <p class="d-inline-block"> : {{__($contact->data->trade_license)}}</p>
                            </li>
                            <li class="position-relative">
                                <div class="footer-left-item d-inline-block">
                                    <div class="footer-item">
                                        @lang('Email') </div>
                                </div>
                                <a class="d-inline-block" href="mailto:{{$contact->data->email}}"> : {{__($contact->data->email)}}</a>
                            </li>
                            <li class="position-relative">
                                <div class="footer-left-item d-inline-block">
                                    <div class="footer-item">
                                        @lang('Shop Location')  </div>
                                </div>
                                <p class="d-inline-block"> : {{__($contact->data->address)}}</p>
                            </li>
                            <li class="d-flex align-items-center gap-3 mt-2">
                                <div class="footer-left-item">
                                    <div class="footer-item">
                                        @lang('Social') </div>
                                </div>
                                <p>
                                <div class="footer-social">
                                    @foreach($social_account as $social)
                                        <a href="{{url($social->data->link)}}" target="_blank">@php echo $social->data->icon @endphp</a>
                                    @endforeach
                                </div>
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="footer-widget d-flex justify-content-around">
                        <ul class="footer-menu">
                            <h5>Customer Service</h5>
                            <li><a href="{{route('need-help')}}">Need Help?</a></li>
                            <li><a href="{{route('order-tracking')}}">Order Tracking</a></li>
                            <li><a href="https://m.me/holago.com.bd" target="_blank">Live Chat</a></li>
                        </ul>
                        <ul class="footer-menu">
                            <h5>Information</h5>
                            <li><a href="{{ route('about')}}">About HOLAGO</a></li>
                            <li><a href="{{ route('location')}}">Store Locator</a></li>
                            <li><a href="{{ route('holago.club')}}">HOLAGO Club</a></li>
                            <li><a href="{{ route('refund')}}">Refund and Returns</a></li>
                            <li><a href="{{ route('tou')}}">Terms of Use</a></li>
                            <li><a href="{{ route('privacy.policy')}}">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="footer-widget">
                        <div class="footer-menu">
                            <h5>Join Our Newsletter</h5>
                            <p>Subscribe to our newsletter and get regular fashion updates.</p>
                            <form action="{{route('subscribe')}}" method="post">
                                @csrf
                                <div class="form-group d-flex align-items-center position-relative">
                                    <input type="email" name="email" class="form-control"
                                           placeholder="Type your email">
                                    <button type="submit"><i class="fa fa-arrow-right-long"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright-area bg-black pt-2 pb-2">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-xxl-6 col-xl-6 col-lg-6">
                        <span class="text-white">@lang('Copyright') &copy; {{date('Y')}} {{__($setting->site_name)}}. @lang('All rights reserved'). @lang('Developed by') <a
                                target="_blank" class="text-white text-decoration-underline"
                                href="https://classicit.com.bd/">@lang('Classic IT')</a></span>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-6">
                        <div>
                            <img class="w-100" src="{{ displayImage($templateAssets.'img/ssl-commerz.webp') }}" alt="">
                        </div>
                </div>
            </div>
        </div>
    </div>
</footer>