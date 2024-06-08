@extends($template.'layouts.master')
@section('content')

<!-- account start -->
<div class="account-area section-padding">
    <div class="container">
        <div class="row user-dashboard align-items-start">
        	@include($templateUserInclude.'sidebar')
            <div class="col-xl-10 col-lg-8 col-md-7">
                <div class="account-dashboard">
                    <div class="user-dashboard-content">
                        <h3 class="fw-normal">Welcome back {{__($user->name)}}</h3>
                        <span>From your account dashboard you can view your <a title="Your Orders" href="#">recent
                                orders</a>,
                            manage your <a title="Billing Addess" href="#">shipping and billing addresses</a>, and <a
                                href="#" title="Account details">edit
                                your password and account details</a>.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- account end -->

@endsection