@extends($template.'layouts.master')
@section('content')
<!-- account start -->
<div class="account-area section-padding">
    <div class="container">
        <div class="row user-dashboard align-items-start">
        	@include($templateUserInclude.'sidebar')
            <div class="col-xl-10 col-lg-8 col-md-7">
                <div class="account-information">
                    <div class="user-dashboard-content">
                        <form action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <div class="material-textfield">
                                            <input name="name" type="text" value="{{__($user->name)}}">
                                            <label>@lang('Name') </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <div class="material-textfield">
                                            <input type="number" name="phone" value="{{__($user->phone)}}">
                                            <label>@lang('Phone Number')</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <div class="material-textfield">
                                            <input type="email" value="{{__($user->email)}}" name="email" disabled>
                                            <label>@lang('Email')</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <div class="material-textfield mb-0">
                                            <input value="{{__($user->division)}}" name="division" type="text">
                                            <label>@lang('Division')</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 mb-3">
                                    <div class="form-group">
                                        <div class="material-textfield mb-0">
                                            <input value="{{__($user->address)}}" name="address" type="text">
                                            <label>@lang('Address')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--

                            <label for="diff_password" class="mb-3 mt-2">
                                <strong>Change Password</strong>
                                <input type="checkbox" class="form-check-input" id="diff_password" />
                            </label> <br>

                            <div id="diff_password_area" style="display: none">

                                <div class="row">
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group">
                                            <div class="material-textfield">
                                                <input placeholder=" " type="password">
                                                <label>Current password </label>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group">
                                            <div class="material-textfield">
                                                <input placeholder=" " type="password">
                                                <label>New password </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group">
                                            <div class="material-textfield">
                                                <input placeholder=" " type="password">
                                                <label>Confirm new password </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div> -->
                            <button type="submit" class="btn">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- account end -->

@endsection
