@extends('admin.layouts.master')
@section('content')
@section('title','Change Password')

<!--start content--> 
<div class="profile-cover bg-dark"></div>
  <div class="row">
    <div class="col-12 col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <form action="{{ route('admin.password.update')}}" method="post" enctype="multipart/form-data">
          @csrf
          <h5 class="mb-0">@lang('Password Setting')</h5>
          <hr>
          <div class="card shadow-none border">
            <div class="card-header">
              <h6 class="mb-0">@lang('Change Password')</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 mb-3">
                  <label class="form-label">@lang('Old Password')</label>
                  <input type="password" name="old_password" class="form-control" placeholder="Old Password">
                </div>
                <div class="col-12 mb-3">
                  <label class="form-label">@lang('New Password')</label>
                  <input type="password" name="password" class="form-control" placeholder="New Password">
                </div>
                <div class="col-12 mb-3">
                  <label class="form-label">@lang('Confirm Password')</label>
                  <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                </div>
              </div>
            </div>
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">@lang('Save Changes')</button>
          </div>
        </form>
        </div>
      </div>
    </div>
    <div class="col-12 col-lg-4">
      <div class="card shadow-sm border-0 overflow-hidden">
        <div class="card-body">
          <div class="profile-avatar text-center">
            <img src="{{ displayImage('assets/admin/images/'.$admin->image) }}" class="rounded-circle shadow" width="120" height="120" alt="">
          </div>
          <div class="text-center mt-4">
            <h4 class="mb-1">{{__($admin->first_name)}} {{__($admin->last_name)}}</h4>
            <p class="mb-0 text-secondary">@lang('@'){{__($admin->username)}}</p>
            <div class="mt-4"></div>
            <h6 class="mb-1">{{__($admin->position)}} - {{ $setting->site_name }}</h6>
            <p class="mb-0 text-secondary">{{__($admin->address)}}</p>
          </div>
          <hr>
          <div class="text-start">
            <h5 class="">@lang('About')</h5>
            <p class="mb-0">{{__($admin->about_me)}}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
<!--end page main-->

@endsection