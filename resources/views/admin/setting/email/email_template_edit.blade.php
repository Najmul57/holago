@extends('admin.layouts.master')
@section('content')
@section('title',$title)

<div class="row mt-3">
    <div class="col-md-12">
      	<div class="card shadow-sm border-0">
        	<div class="card-body">
          		<form action="{{ route('admin.email.update', $editData->id)}}" method="post" enctype="multipart/form-data">
          			@csrf
          			<div class="card shadow-none border">
            			<div class="card-header header-area">
              				<h6 class="mb-0">@lang('Edit Template')</h6>
            			</div>
			            <div class="card-body">
			            	<div class="mb-3">
								<ul class="list-group">
									@forelse($editData->shortcodes as $shortcode => $key)
								  		<li class="list-group-item p-3"><span class="float-start">@php echo "{{". $shortcode ."}}"  @endphp</span>
								  		 <span class="float-end">{{ __($key) }}</span></li>
								  	@empty
		                                <li>
		                                    <span colspan="100%" class="text-muted text-center">@lang('No shortcode available')</span>
		                                </li>
		                            @endforelse
								</ul>
							</div>
							<div class="form-group row g-3 mb-3">
								<div class="col-md-8">
									<label class="form-label fw-bold">@lang('Subject')</label>
									<input type="text" name="subject" class="form-control" value="{{__($editData->subj)}}">
								</div>
								<div class="col-md-4">
									<label class="form-label fw-bold">@lang('Status')</label>
	                    			<input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="@lang('Send Email')" data-off="@lang("Don't Send")" @if(@$editData->email_status) checked @endif name="email_status">
								</div>
							</div>
			              	<div class="form-group row g-3">
				              	<div class="col-md-12 summertext-area">
				                	<label class="form-label fw-bold">@lang('Email Body')</label>
				                	<textarea class="form-control summerNote" name="email_body">@php echo $editData->email_body @endphp</textarea>
				              	</div>
              				</div>
            			</div>
          			</div>
          			<div class="row">
          				<div class="col-md-12">
          					<div class="form-group">
            					<button type="submit" class="btn btn-primary w-100"><i class="far fa-check-circle"></i> @lang('Save')</button>
          					</div>
          				</div>
          			</div>
        		</form>
        	</div>
      	</div>
    </div>
</div>

@endsection

@push('top-area')
<a href="{{ route('admin.email.index')}}" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"><i class="las la-angle-double-left"></i>@lang('Go Back')</a>
@endpush
