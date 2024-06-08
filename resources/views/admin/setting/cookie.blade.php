@extends('admin.layouts.master')
@section('content')
@section('title','GDPR Cookie')

<div class="row mt-3 justify-content-md-center">
    <div class="col-xl-12 col-lg-12 col-md-12 mb-30">
      	<div class="card shadow-sm border-0">
        	<div class="card-body">
          		<form action="" method="post">
            		@csrf
            		<div class="card-body">
              			<div class="row">
                			<div class="col-md-6">
                  				<div class="form-group">
                    				<label>@lang('Policy Link')</label>
                      				<input type="text" name="link" class="form-control" value="{{ @$cookie->data_values->link }}" placeholder="@lang('Policy Link')">
                  				</div>
                			</div>
	                		<div class="col-md-6">
	                  			<div class="form-group">
	                    			<label>@lang('Status')</label>
	                    			<input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disabled')" @if(@$cookie->data_values->status) checked @endif name="status">
	                  			</div>
	                		</div>
	              		</div>
                		<div class="form-group">
                  			<label>@lang('Description')</label>
                    		<textarea class="form-control summerNote" rows="10" name="description" placeholder="@lang('Description')">@php echo @$cookie->data_values->description @endphp</textarea>
                		</div>
            		</div>
		            <div class="card-footer text-end">
		                <button type="submit" class="btn btn-primary btn-block w-100">@lang('Submit')</button>
		            </div>
        		</form>
        	</div>
      	</div>
    </div>
</div>

@endsection