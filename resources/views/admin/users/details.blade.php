@extends('admin.layouts.master')
@section('content')
@section('title','User Details')
<div class="row mt-3">
    <div class="col-xl-9 col-lg-7 col-md-7 mb-30">
      	<div class="card shadow-sm border-0">
        	<div class="card-body">
          		<form action="{{ route('admin.users.update',$user->id) }}" method="post" enctype="multipart/form-data">
          			@csrf
         			 <h5 class="mb-0">@lang('Account By') {{__($user->fullname())}}</h5>
          			<hr>
          			<div class="card shadow-none border">
            			<div class="card-header">
              				<h6 class="mb-0">@lang('USER INFORMATION')</h6>
            			</div>
            			<div class="card-body">
			              	<div class="row g-3">
				              	<div class="col-6">
				                	<label class="form-label fw-bold">@lang('Name')</label>
				                	<input type="text" name="name" class="form-control" value="{{__($user->name)}}" placeholder="Name">
				              	</div>
				              	<div class="col-6">
				                	<label class="form-label fw-bold">@lang('Email address')</label>
				                	<input type="email" name="email" class="form-control" value="{{__($user->email)}}" readonly>
				              	</div>
				              	<div class="col-6">
				                	<label class="form-label fw-bold">@lang('Mobile Number')</label>
				                	<input type="number" name="phone" class="form-control" value="{{__($user->phone)}}">
				              	</div>
                                <div class="col-6">
                                    <label class="form-label fw-bold">@lang('User Points')</label>
                                    <input type="number" name="points" class="form-control" value="{{__($user->points)}}" >
                                </div>
				                <div class="col-12">
				                  	<label class="form-label fw-bold">@lang('Address')</label>
				                  	<input type="text" name="address_details" class="form-control" value="{{__($user->address)}}" placeholder="Address">
				                </div>
				                <div class="form-group row pe-0 mt-3">
				                	<div class="form-group col-md-6 pe-0">
										<label class="form-label fw-bold">@lang('Status')</label>
										<div class="">
											<input type="checkbox" name="status" data-width="100%" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Active" data-off="Banned" data-size="normal" @if($user->status) checked @endif>
										</div>
									</div>
				                	<div class="form-group col-md-6 pe-0">
										<label class="form-label fw-bold">@lang('Email Verified')</label>
										<div class="">
											<input type="checkbox" name="email_verified" data-width="100%" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Verified" data-off="Un-Verified" data-size="normal" @if($user->email_verified) checked @endif>
										</div>
									</div>
								</div>
              				</div>
            			</div>
          			</div>
          			<div class="row">
          				<div class="col-md-12">
			          		<div class="form-group">
			            		<button type="submit" class="btn btn-primary btn-block btn-lg w-100">@lang('Save Changes')</button>
			          		</div>
          				</div>
          			</div>
        		</form>
        	</div>
      	</div>
    </div>
    <div class="col-xl-3 col-lg-5 col-md-5 mb-30">
      	<div class="card shadow-sm border-0 overflow-hidden">
        	<div class="card-body">
          		<div class="profile-avatar text-center">
            		<img src="{{ displayImage('assets/images/user/image/'.$user->image) }}" alt="">
          		</div>
          		<div class="text-center mt-4">
            		<h4 class="mb-1">{{__($user->fullname())}}</h4>
            		<span class="text--small">@lang('Joined At') <strong>{{showDateTime($user->created_at,'d M, Y h:i A')}}</strong></span>
          		</div>
        	</div>
      	</div>
      	<div class="card shadow-sm border-0 overflow-hidden">
        	<div class="card-body">
          		<h5 class="mb-4">@lang('User Activation')</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <label class="li-user">@lang('Status'):</label>
                        @if($user->status == 1)
                            <span class="badge badge-pill bg-gradient-success">@lang('Active')</span>
                        @elseif($user->status == 0)
                            <span class="badge badge-pill bg-gradient-danger">@lang('Banned')</span>
                        @endif
                    </li>
                </ul>
        	</div>
      	</div>
      	<div class="card shadow-sm border-0 overflow-hidden">
        	<div class="card-body">
          		<h5 class="mb-4">@lang('User action')</h5>
                <a href="{{ route('admin.users.login.history', $user->id) }}" class="btn bg-gradient-success w-100 mb-2">
                    @lang('Login Logs')
                </a>
               {{-- <a href="{{route('admin.users.login',$user->id)}}" target="_blank" class="btn bg-gradient-royal w-100 mb-2">
                    @lang('Login as User')
                </a>--}}
        	</div>
      	</div>
    </div>
</div>
 @endsection
