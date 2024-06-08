@extends('admin.layouts.master')
@section('content')
@section('title','Profile')

<!--start content--> 
<div class="profile-cover bg-dark"></div>
  <div class="row">
    <div class="col-12 col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <form action="{{ route('admin.profile.update')}}" method="post" enctype="multipart/form-data">
          @csrf
          <h5 class="mb-0">@lang('My Account')</h5>
          <hr>
          <div class="card shadow-none border">
            <div class="card-header">
              <h6 class="mb-0">@lang('USER INFORMATION')</h6>
            </div>
            <div class="card-body">
              <div class="row g-3">
                <div class="col-md-8">
                  <div class="form-group mb-3">
                    <label class="form-label">@lang('First Name')</label>
                    <input type="text" name="first_name" class="form-control" value="{{__($admin->first_name)}}" placeholder="First Name">
                  </div>
                  <div class="form-group mb-3">
                      <label class="form-label">@lang('Last Name')</label>
                      <input type="text" name="last_name" class="form-control" value="{{__($admin->last_name)}}" placeholder="Last Name">
                  </div>
                  <div class="form-group mb-3">
                    <label class="form-label">@lang('Username')</label>
                      <input type="text" name="username" class="form-control" value="{{__($admin->username)}}" placeholder="Username" readonly>
                  </div>
                  <div class="form-group mb-3">
                    <label class="form-label">@lang('Email address')</label>
                    <input type="email" name="email" class="form-control" value="{{__($admin->email)}}" placeholder="Email Address">
                  </div>
                  <div class="form-group mb-3">
                    <label class="form-label">@lang('Position')</label>
                    <input type="text" name="position" class="form-control" value="{{__($admin->position)}}" placeholder="Position">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group mt-4">
                    <div class="image-upload-area">
                      <img id="preview" src="{{ displayImage('assets/admin/images/'.$admin->image) }}" alt="ggg"/>
                      <div class="custom-file">
                        <input type="file" name="image" class="custom-file-input upload-image" id="upload">
                        <label class="pick-image" for="upload">@lang('Upload Image')</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card shadow-none border">
            <div class="card-header">
              <h6 class="mb-0">@lang('CONTACT INFORMATION')</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 mb-3">
                  <label class="form-label">@lang('Address')</label>
                  <input type="text" name="address" class="form-control" value="{{__($admin->address)}}" placeholder="Address">
                </div>
                <div class="col-6 mb-3">
                  <label class="form-label">@lang('City')</label>
                  <input type="text" name="city" class="form-control" value="{{__($admin->city)}}" placeholder="City">
                </div>
                <div class="col-6 mb-3">
                  <label class="form-label">@lang('Country')</label>
                  <input type="text" name="country" class="form-control" value="{{__($admin->country)}}" placeholder="Country">
                </div>
                <div class="col-12 mb-3">
                  <label class="form-label">@lang('About Me')</label>
                  <textarea class="form-control" name="about_me" rows="4" cols="4" placeholder="Describe yourself...">{{__($admin->about_me)}}</textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-primary px-4 w-100">@lang('Save Changes')</button>
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