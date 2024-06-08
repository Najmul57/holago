@extends('admin.layouts.master') 
@section('content')
@section('title','General Email Setting')

<div class="row mt-3">
    <div class="col-md-6">
      	<div class="card shadow-sm border-0">
        	<div class="card-body">
          		<form action="" method="post" enctype="multipart/form-data">
          			@csrf
          			<div class="card shadow-none border">
            			<div class="card-header header-area">
              				<h6 class="mb-0">@lang('General Email Template')</h6>
            			</div>
			            <div class="card-body">
			            	<div class="mb-3">
								<ul class="list-group">
								  	<li class="list-group-item"><p class="float-start">@lang('{:fullname:}')</p> <p class="float-end">@lang('Full Name. System will take from database')</p>
								  	</li>
								  	<li class="list-group-item"><p class="float-start">@lang('{:username:}')</p> <p class="float-end">@lang('User Name. System will take from database')</p>
								  	</li>
								  	<li class="list-group-item"><p class="float-start">@lang('{:message:}')</p> <p class="float-end">@lang('Main message of users')</p>
								  	</li>
								</ul>
							</div>
			              	<div class="form-group row g-3">
				              	<div class="col-md-12 summerNote_email_body">
				                	<label class="form-label fw-bold">@lang('Email Body')</label>
				                	<textarea class="form-control summerNote" name="email_template">@php echo $setting->email_template @endphp</textarea>
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
	<div class="col-md-6">
	  	<div class="card shadow-sm border-0">
	    	<div class="card-body">
	      		<form action="{{ route('admin.email.setting')}}" method="post">
					@csrf
					<div class="card shadow-none border">
						<div class="card-header header-area">
              				<h6 class="mb-0">@lang('General Email Setting')</h6>
            			</div>
            			<div class="card-body">
			              	<div class="row g-3">
				              	<div class="col-6">
				                	<label class="form-label fw-bold">@lang('Host name')</label>
				                	<input type="text" name="host" class="form-control" placeholder="@lang('e.g. yourdomain.com')" value="{{ @$setting->mail->host }}" required>
				              	</div>
				              	<div class="col-6">
				                  	<label class="form-label fw-bold">@lang('Port')</label>
				                  	<input type="text" name="port" class="form-control" placeholder="@lang('e.g. 465')" value="{{ @$setting->mail->port }}" required>
				              	</div>
				              	<div class="col-6">
				                	<label class="form-label fw-bold">@lang('Encryption')</label>
				                	<div class="form-group">
										<select class="form-control" name="encryption" required>
											<option value="ssl">@lang('SSL')</option>
											<option value="tls">@lang('TLS')</option>
										</select>
									</div>
				              	</div>
				              	<div class="col-6">
				                	<label class="form-label fw-bold">@lang('Username')</label>
				                	<input type="text" name="username" class="form-control" placeholder="@lang('e.g. mail@domain.com')" value="{{ @$setting->mail->username }}" required>
				              	</div>
				                <div class="col-6">
				                  	<label class="form-label fw-bold">@lang('Password')</label>
				                  	<input name="password" class="form-control" placeholder="@lang('Password of mail')" value="{{ @$setting->mail->password }}" required>
				                </div>
				                <div class="col-6">
				                  	<label class="form-label fw-bold">@lang('Email From')</label>
				                  	<input name="email_from" class="form-control" placeholder="@lang('Email From')" value="{{ @$setting->mail->email_from }}" required>
				                </div>
			              	</div>
			            </div>
					</div>
					<div class="text-end">
						<button type="submit" class="btn btn-primary w-100"><i class="far fa-check-circle"></i> @lang('Update')</button>
					</div>
				</form>
	    	</div>
	  	</div>
	  	<div class="card shadow-sm border-0">
	    	<div class="card-body">
	      		<form action="{{ route('admin.email.method')}}" method="post">
					@csrf
					<div class="card shadow-none border">
						<div class="card-header header-area">
              				<h6 class="mb-0">@lang('Email Configuration')</h6>
            			</div>
            			<div class="card-body">
			              	<div class="row g-3 d-flex align-items-center">
				              	<div class="col-md-6">
				                	<label class="form-label fw-bold">@lang('Email Send Method')</label>
				                	<div class="form-group">
										<select class="form-select" name="email_method" required>
		                                    <option value="smtp" @if(@$setting->mail_config->name == 'smtp') selected @endif>@lang('SMTP')</option>
										</select>
									</div>
				              	</div>
				              	<div class="col-md-6 text-end pt-35">
				              		<button type="button" data-bs-target="#testMailModal" data-bs-toggle="modal" class="btn bg-gradient-info">@lang('Send Test Mail')</button>
				              	</div>
			              	</div>
	                        <div class="row mt-3 d-none configForm" id="mailjet">
	                            <div class="col-md-12">
	                                <h6 class="mb-2">@lang('Mailjet API Configuration')</h6>
	                            </div>
	                            <div class="form-group col-md-6">
	                                <label class="font-weight-bold">@lang('Api Public Key')</label>
	                                <input type="text" class="form-control" placeholder="@lang('Mailjet Api Public Key')" name="public_key" value="{{ json_decode($setting->mail_config)->public_key ?? '' }}"/>
	                            </div>
	                            <div class="form-group col-md-6">
	                                <label class="font-weight-bold">@lang('Api Secret Key')</label>
	                                <input type="text" class="form-control" placeholder="@lang('Mailjet Api Secret Key')" name="secret_key" value="{{ json_decode($setting->mail_config)->secret_key ?? '' }}">
	                            </div>
	                        </div>
			            </div>
					</div>
					<div class="text-end">
						<button type="submit" class="btn btn-primary w-100"><i class="far fa-check-circle"></i> @lang('Update')</button>
					</div>
				</form>
	    	</div>
	  	</div>
	</div>
</div>

{{-- TEST MODAL --}}
<div id="testMailModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Test Mail Setup')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.email.test.mail')}}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>@lang('Sent to')</label>
                            <input type="text" name="email" class="form-control" placeholder="@lang('Email Address')">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-success">@lang('Send')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('js')
    <script>
        (function ($) {
            "use strict";

            var method = '{{ json_decode($setting->mail_config)->name }}';
            emailMethod(method);
            $('select[name=email_method]').on('change', function() {
                var method = $(this).val();
                emailMethod(method);
            });

            function emailMethod(method){
                $('.configForm').addClass('d-none');
                if(method != 'php') {
                    $(`#${method}`).removeClass('d-none');
                }
            }

        })(jQuery);

    </script>
@endpush