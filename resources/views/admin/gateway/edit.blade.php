@extends('admin.layouts.master')
@section('content')
@section('title',$title)

<div class="row mt-3">
    <div class="col-md-12 mb-30">
      	<div class="card shadow-sm border-0">
        	<div class="card-body">
          		<form action="{{ route('admin.gateway.method.update',$gateways->id) }}" method="post" enctype="multipart/form-data">
          			@csrf
          			<div class="card shadow-none border">
            			<div class="card-body">
			              	<div class="row g-3">
				              	<div class="col-md-9">
				              		<div class="form-group mb-3">
					                	<label class="form-label fw-bold">@lang('Gateway Name')</label>
					                	<input type="text" name="name" class="form-control" value="{{__($gateways->name)}}" placeholder="Gateway Name">
					                </div>
					              	@foreach($gateways->setting as $key => $methodSetting)
									<div class="form-group row mb-3">
										<label class="col-md-3 form-label fw-bold">
							                {{ __(strtoupper(str_replace('_', ' ', $key))) }}
										</label>
					                	<div class="requirments">
					                		<div class="input-group @if($loop->last) @endif">
					                			<input type="text" name="setting[{{ $key }}]" class="form-control" value="{{ $methodSetting }}" required>
					                		</div>
					                	</div>
						            </div>
					              @endforeach
				              	</div>
				              	<div class="col-md-3">
		                            <div class="form-group">
		                                <div class="image-upload-area">
		                                    <img id="preview" src="{{ displayImage('assets/images/paymentGateway/'.$gateways->image) }}" alt="Gateway Image"/>
		                                    <div class="custom-file">
		                                        <input type="file" name="image" class="custom-file-input upload-image" id="upload1">
		                                        <label class="pick-image" for="upload1">@lang('Upload')</label>
		                                    </div>
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
		<div class="card">
			<div class="card-header">
				<div class="row align-items-center">
		          	<div class="col-6">
		              	<h6 class="mb-0">{{__($gateways->name)}} @lang(' Currencies List')</h6>
		          	</div>
		    	</div>
			</div>
		    <div class="card-body">
		        <div class="table-responsive">
		            <table class="table align-middle mb-0">
		                <thead class="table-light">
		                    <tr>
		                        <th>Currency Name</th>
		                        <th>Currency Symbol</th>
		                        <th>Convert Rate</th>
		                        <th>Status</th>
		                        <th>Actions</th>
		                    </tr>
		                </thead>
		                <tbody class="currency-body">
		                	@forelse($gateway_currency as $currency)
		                    <tr>
		                    	<td>{{__($currency->currency_name)}}</td>
		                    	<td>{{__($currency->currency)}}</td>
		                    	<td>{{__($currency->conversion_rate)}}</td>
		                    	<td>
		                    		@if($currency->status == 1)
		                                <span class="badge badge-pill bg-gradient-success">@lang('Active')</span>
		                            @else
		                                <span class="badge badge-pill bg-gradient-danger">@lang('Disabled')</span>
		                            @endif
		                    	</td>
		                    	<td>
		                    		<a href="{{ route('admin.gateway.method.currencies.update',$currency->id) }}" class="btn bg-gradient-info btn-sm"><i class="las la-edit"></i></a>
		                    	</td>
		                    </tr>
		                    @empty
		                        <tr>
		                            <td class="text-center" colspan="100%">@lang('Data not found')</td>
		                        </tr>
		                    @endforelse
		                </tbody>
		            </table>
		        </div>
		    </div>
		    @if($gateway_currency->hasPages())
		    <div class="card-footer">
		        {{ $gateway_currency->links() }}
		    </div>
		    @endif
		</div>
    </div>
</div>

@endsection