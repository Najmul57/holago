@extends('admin.layouts.master')
@section('content')
@section('title',$title)

<div class="row mt-3">
    <div class="col-xl-12 col-lg-12 col-md-6 mb-30">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <form action="" method="post" enctype="multipart/form-data">
          @csrf
          <div class="card shadow-none border">
            <div class="card-body">
              	<div class="row g-3">
	                <div class="col-12">
	                  <label class="form-label">@lang('Subject') <span class="required-input">*</span></label>
	                  <input type="text" name="subject" class="form-control" value="" placeholder="Email Subject">
	                </div>
	                <div class="col-12">
	                  <label class="form-label">@lang('Message') <span class="required-input">*</span></label>
	                  <textarea class="form-control summerNote" name="message" rows="8"></textarea>
	                </div>
              	</div>
            </div>
          </div>
          <div class="row">
          	<div class="col-md-12">
          		<div class="form-group">
            		<button type="submit" class="btn btn-primary btn-block btn-lg w-100">@lang('Send Email')</button>
          		</div>
          	</div>
          </div>
        </form>
        </div>
      </div>
    </div>
</div>

@endsection