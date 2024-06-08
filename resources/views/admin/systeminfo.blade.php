@extends('admin.layouts.master')
@section('content')
@section('title','System Information')

<div class="row mt-3 justify-content-md-center">
    <div class="col-xl-12 col-lg-12 col-md-12 mb-30">
      	<div class="card b-radius--10 ">
          	<div class="card-body p-0">
            	<div class="table-responsive">
              		<table class="table align-middle">
                		<tbody>
	                      	<tr>
	                          <td class="text-muted fs-6 text-start p-4">@lang('PHP Version')</td>
	                          <td class="text-muted fs-6 text-end p-4">{{ $currentPHP }}</td>
	                      	</tr>
                      		<tr>
                          		<td class="text-muted fs-6 text-start p-4">@lang('Laravel Version')</td>
                          		<td class="text-muted fs-6 text-end p-4">{{ $laravelVersion }}</td>
                      		</tr>
                      		<tr>
                          		<td class="text-muted fs-6 text-start p-4">@lang('Server Software')</td>
                          		<td class="text-muted fs-6 text-end p-4">{{ @$serverDetails['SERVER_SOFTWARE'] }}</td>
                      		</tr>
                      		<tr>
                          		<td class="text-muted fs-6 text-start p-4">@lang('Server IP Address')</td>
                          		<td class="text-muted fs-6 text-end p-4">{{ @$serverDetails['SERVER_ADDR'] }}</td>
                      		</tr>
                      		<tr>
                          		<td class="text-muted fs-6 text-start p-4">@lang('Server Protocol')</td>
                          		<td class="text-muted fs-6 text-end p-4">{{ @$serverDetails['SERVER_PROTOCOL'] }}</td>
                      		</tr>
                      		<tr>
                          		<td class="text-muted fs-6 text-start p-4">@lang('HTTP Host')</td>
                          		<td class="text-muted fs-6 text-end p-4">{{ @$serverDetails['HTTP_HOST'] }}</td>
                      		</tr>
                      		<tr>
                          		<td class="text-muted fs-6 text-start p-4">@lang('Database Port')</td>
                          		<td class="text-muted fs-6 text-end p-4">{{ @$serverDetails['DB_PORT'] }}</td>
                      		</tr>
                      		<tr>
                          		<td class="text-muted fs-6 text-start p-4">@lang('App Environment')</td>
                          		<td class="text-muted fs-6 text-end p-4">{{ @$serverDetails['APP_ENV'] }}</td>
                      		</tr>
                      		<tr>
                          		<td class="text-muted fs-6 text-start p-4">@lang('App Debug')</td>
                          		<td class="text-muted fs-6 text-end p-4">{{ @$serverDetails['APP_DEBUG'] }}</td>
                      		</tr>
                      		<tr>
                          		<td class="text-muted fs-6 text-start p-4">@lang('Timezone')</td>
                          		<td class="text-muted fs-6 text-end p-4">{{ @$timeZone }}</td>
                      		</tr>
                    	</tbody>
              		</table><!-- table end -->
            	</div>
         	</div>
        </div>
    </div>
</div>


@endsection