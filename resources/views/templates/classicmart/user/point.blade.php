@extends($template.'layouts.master')
@section('content')

<!-- account start -->
<div class="account-area section-padding">
    <div class="container">
        <div class="row user-dashboard align-items-start">
        	@include($templateUserInclude.'sidebar')
            <div class="col-xl-10 col-lg-8 col-md-7">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="account-point">
                        <div class="user-dashboard-content ">
                            <div class="point-level text-end">
                                <img src="img/level-default.png" alt="">
                            </div>
                            <div class="point-content text-center mb-4">
                                <h3 class="mb-2">Available Points</h3>
                                <div class="semi-donut mb-3" style="--percentage : 80; --fill: #589BF2 ;">
                                    <div class="earn-point">
                                        <h2>{{__($user->points)}}</h2>
                                        <h6>HOLAGO CLUB POINTS</h6>
                                    </div>
                                </div>
                                <span>From 2000</span>

                                <h5>Another 1000 HOLAGO CLUB POINTS needed until you unlock "ROOKIE" level!</h5>
                                <p>Also you can use 1000 HOLAGO CLUB POINTS to get ৳100.00 anytime. It will not
                                    downgrade your level.
                                    Hurry up! 1000 HOLAGO CLUB POINTS will expire in 349 days.</p>
                            </div>

                            <div class="point-table">
                                <h4>My Rewards & Achievements</h4>

                                <ul>
                                    <li>
                                        <i class="fa fa-check"></i>
                                        <span>BASIC</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check"></i>
                                        <span>Create an account to get 1000 HOLAGO CLUB POINTS.</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check"></i>
                                        <span> Write your first review to get 500 HOLAGO CLUB POINTS.</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check"></i>
                                        <span>Get 100 HOLAGO CLUB POINTS for every additional review.</span>
                                    </li>
                                    <li>
                                        <i class="fa fa-gift"></i>
                                        <span>Get 500 Point Gift Every Birthday.</span>
                                    </li>
                                    @if(!$user->dateofbirth)
                                    <li>
                                        <form method="post" action="{{ route('user.birthday.update')}}">
                                            @csrf
                                            <input type="date" name="dateofbirth">
                                            <button type="submit">Save</button>
                                        </form>
                                    </li>
                                    @endif
                                    <li>&nbsp;&nbsp;&nbsp;
                                        <span>Recommend our website to a friend and earn 500 HOLAGO CLUB POINTS
                                            (friend has to make an order).</span>
                                    </li>
                                    <li>
                                        <input type="text" value="https://holago.com.bd?wc-recommended=U2RIVC9sWThMQk9LOWh2aTVDTkdxZz09" class="w-100">
                                    </li>
                                </ul>
                                <p>You can collect points by review, register list them here.</p>
                            </div>
                            <div class="point-table">
                                <h4>Your Earned Points</h4>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">@lang('Date')</th>
                                                <th scope="col">@lang('HOLAGO CLUB POINTS')</th>
                                                <th scope="col">@lang('Message')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{showDateTime($user->updated_at,'d M, Y')}}</td>
                                                <td>{{__($user->points)}}</td>
                                                <td>Earned {{__($user->points)}} HOLAGO CLUB POINTS upon account creation.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- account end -->

@endsection
