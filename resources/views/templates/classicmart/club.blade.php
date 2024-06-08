@extends($template.'layouts.master')
@section('content')
    <!-- membership start -->
    <div class="membership-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="membership-heading text-center p-3 mb-3" style="background-color: #EFEDEE;">
                        <h1>HOLA!</h1>
                        <h3>AND WELCOME TO HOLAGO’S REWARD PROGRAMME!</h3>
                        <div class="membership-auth">
                            <!-- <a href="#">CLUB SIGN-UP</a>
                            <a href="#">LOGIN</a> -->
                            <a href="{{ route('user.dashboard')}}">ACCOUNT</a>
                        </div>
                    </div>
                    <p>Through this program, you will have the privilege to earn redeemable Holago Club Points(HCP)
                        on every purchase,referral, review and many more opportunities to earn extra points. Holago
                        Club Points(HCP) earned can be redeemed for discounts on future purchases. </p>

                    <p>At Holago once you register an account with us using your phone number or email, you become
                        one of our valued members of our rewards program. Experience our unique rewards programme
                        for Fashionable and Trendy clothing for the time in Bangladesh. We are a world class
                        Lifestyle Brand for men and women. We have 4 levels of membership classes available for our
                        loyal customers. Each membership tier/level comes with perks and benefits no other fashion
                        retail company in Bangladesh provides. In addition, all HCP can be redeemed to get discounts
                        on your purchases. We have a whole bunch of benefits waiting for you depending on your
                        membership level. Please see the table below and start your journey to become one of our
                        Elite members. </p>

                    <div class="membership-faq p-3 mt-3" style="background-color: #ECECEC;">
                        <h4>Benefits And Perks as Holago Club Member:</h4>

                        <div class="accordion mt-4 mb-5" id="faq-parent">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <div class="accordion-button" type="button" data-bs-toggle="collapse"
                                         data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                                        Become a registered member and Get 1000 points
                                    </div>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse show"
                                     data-bs-parent="#faq-parent">
                                    <div class="accordion-body">
                                        Sign up for Holago Club and get 1000 HCP as a welcome gift. This can be
                                        redeemed during checkout to get 100 BDT off on your first purchase.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <dvi class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                         data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                                        Free call back service
                                    </dvi>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faq-parent">
                                    <div class="accordion-body">
                                        Request us to call you back through messenger or ‘Request Callback’ service
                                        from our website and we will ring you instantly and be at your service with
                                        our highly experienced customer representative.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <div class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                         data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                                        Earn additional points from review
                                    </div>
                                </h2>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faq-parent">
                                    <div class="accordion-body">
                                        Post your first review and get 500 points and any additional review after
                                        that gets you 100 points each for the products you have purchased.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <strong>
                            ***Please note: Your Holago Club Points(HCP) are valid for 12 months to be redeemed.
                            Your membership status will not change and will be valid for 12 months. If your account
                            is inactive for 12 months you hold a Basic membership status until further activity is
                            made.
                        </strong>
                        <br>
                        <strong class="mt-4 d-block">***10 Holago Club Points(HCP) = 1 BDT***</strong>

                    </div>

                    <div class="membership-faq p-3 mt-5" style="background-color: #ECECEC;">
                        <h4>General FAQs:</h4>

                        <div class="accordion mt-4" id="faqg-parent">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <div class="accordion-button" type="button" data-bs-toggle="collapse"
                                         data-bs-target="#faqg1" aria-expanded="true" aria-controls="faqg1">
                                        Become a registered member and Get 1000 points
                                    </div>
                                </h2>
                                <div id="faqg1" class="accordion-collapse collapse show"
                                     data-bs-parent="#faqg-parent">
                                    <div class="accordion-body">
                                        Sign up for Holago Club and get 1000 HCP as a welcome gift. This can be
                                        redeemed during checkout to get 100 BDT off on your first purchase.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <dvi class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                         data-bs-target="#faqg2" aria-expanded="false" aria-controls="faqg2">
                                        Free call back service
                                    </dvi>
                                </h2>
                                <div id="faqg2" class="accordion-collapse collapse" data-bs-parent="#faqg-parent">
                                    <div class="accordion-body">
                                        Request us to call you back through messenger or ‘Request Callback’ service
                                        from our website and we will ring you instantly and be at your service with
                                        our highly experienced customer representative.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <div class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                         data-bs-target="#faqg3" aria-expanded="false" aria-controls="faqg3">
                                        Earn additional points from review
                                    </div>
                                </h2>
                                <div id="faqg3" class="accordion-collapse collapse" data-bs-parent="#faqg-parent">
                                    <div class="accordion-body">
                                        Post your first review and get 500 points and any additional review after
                                        that gets you 100 points each for the products you have purchased.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="membership-faq p-3 mt-5" style="background-color: #ECECEC;">
                        <h4>Membership FAQs:</h4>

                        <div class="accordion mt-4" id="faqm-parent">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <div class="accordion-button" type="button" data-bs-toggle="collapse"
                                         data-bs-target="#faqm1" aria-expanded="true" aria-controls="faqm1">
                                        Become a registered member and Get 1000 points
                                    </div>
                                </h2>
                                <div id="faqm1" class="accordion-collapse collapse show"
                                     data-bs-parent="#faqm-parent">
                                    <div class="accordion-body">
                                        Sign up for Holago Club and get 1000 HCP as a welcome gift. This can be
                                        redeemed during checkout to get 100 BDT off on your first purchase.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <dvi class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                         data-bs-target="#faqm2" aria-expanded="false" aria-controls="faqm2">
                                        Free call back service
                                    </dvi>
                                </h2>
                                <div id="faqm2" class="accordion-collapse collapse" data-bs-parent="#faqm-parent">
                                    <div class="accordion-body">
                                        Request us to call you back through messenger or ‘Request Callback’ service
                                        from our website and we will ring you instantly and be at your service with
                                        our highly experienced customer representative.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <div class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                         data-bs-target="#faqm3" aria-expanded="false" aria-controls="faqm3">
                                        Earn additional points from review
                                    </div>
                                </h2>
                                <div id="faqm3" class="accordion-collapse collapse" data-bs-parent="#faqm-parent">
                                    <div class="accordion-body">
                                        Post your first review and get 500 points and any additional review after
                                        that gets you 100 points each for the products you have purchased.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- membership end -->
@endsection

