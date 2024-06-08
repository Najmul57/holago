@extends($template.'layouts.master')
@section('content')
    <!-- request-callback -->
    <div class="help-start text-center request-callback section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="location-content">
                        <h1>Need Help Placing Order?</h1>
                        <div class="need-wrapper">
                            <div class="video-main">
                                <div class="promo-video">
                                    <div class="waves-block">
                                        <div class="waves wave-1"></div>
                                        <div class="waves wave-2"></div>
                                        <div class="waves wave-3"></div>
                                    </div>
                                </div>
                                <a href="https://www.youtube.com/watch?v=NPjrFlpf-Rw"
                                   class="need-video video-popup mfp-iframe"><i class="fa fa-play"></i></a>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row align-items-center pt-5 pb-5 gy-4">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 com-12">
                    <div class="help-quation">Request A Callback <br>
                        For Dedicated Support</div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 com-12">
                    <div class="help-form">
                        <form action="">
                            <div class="form-group">
                                <div class="material-textfield">
                                    <input placeholder=" " type="text">
                                    <label>Name</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="material-textfield">
                                    <input placeholder=" " type="text">
                                    <label>Phone</label>
                                </div>
                            </div>
                            <button type="submit" class="btn">Request Callback</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row pt-5 pb-5 gy-4">
                <div class="col-lg-4 col-md-6 h-100">
                    <div class="single-help-information">
                        <i class="fa fa-phone"></i>
                        <h5>Need Assistance?</h5>
                        <p>Call us : <a href="tel:+880 2 4881 2182">+880 2 4881 2182</a>,
                            <a href="tel:+880 2 4881 2183">+880 2 4881 2183</a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 h-100">
                    <div class="single-help-information">
                        <i class="fa fa-truck"></i>
                        <h5>Fast Delivery</h5>
                        <p>We deliver countrywide with superfast delivery solution</p>
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 h-100">
                    <div class="single-help-information">
                        <i class="fa-brands fa-cc-visa"></i>
                        <h5>Fast Delivery</h5>
                        <p>We deliver countrywide with superfast delivery solution</p>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- request-callback -->
@endsection
