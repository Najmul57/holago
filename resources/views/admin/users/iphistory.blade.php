@extends('admin.layouts.master')
@section('content')
@section('title',$title)

<div class="card mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>@lang('User')</th>
                        <th>@lang('User Type')</th>
                        <th>@lang('Login at')</th>
                        <th>@lang('IP')</th>
                        <th>@lang('Location')</th>
                        <th>@lang('Browser | OS')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loginLogs as $log)
                    <tr>
                        <td data-label="@lang('Company')">
                            <span class="font-weight-bold">
                                @if($log->company)
                                    {{ $log->company->name}}
                                @elseif($log->user)
                                    {{ $log->user->fullname}}
                                @endif
                            </span>
                            <br>
                            <span class="small"> 
                                <a href="@if($log->company) {{ route('admin.companies.details', $log->company_id) }} @elseif($log->user) {{ route('admin.users.details', $log->user_id) }} @endif">{{'@'}} 
                                    @if($log->company) 
                                        {{ $log->company->username}}
                                    @elseif($log->user)
                                        {{ $log->user->username}}
                                    @endif
                                </a> 
                            </span>
                           
                        </td>

                        <td data-label="@lang('User Type')">
                            @if ($log->user)
                             @lang('USER')
                             @elseif ($log->company)
                             @lang('COMPANY')
                            @endif
                        </td>
                        <td data-label="@lang('Login at')">
                            {{showDateTime($log->created_at) }} <br> {{diffForHumans($log->created_at) }}
                        </td>

                

                        <td data-label="@lang('IP')">
                            <span class="font-weight-bold">
                            <a href="{{route('admin.users.ip.login.history',$log->user_ip)}}">{{ $log->user_ip }}</a>
                            </span>
                        </td>

                        <td data-label="@lang('Location')">{{ __($log->city) }} <br> {{ __($log->country) }}</td>
                        <td data-label="@lang('Browser | OS')">
                            {{ __($log->browser) }} <br> {{ __($log->os) }}
                        </td>
                   	</tr>
                	@empty
	                    <tr>
	                        <td class="text-muted text-center" colspan="100%">@lang('Data not found')</td>
	                    </tr>
                	@endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@if(request()->routeIs('admin.users.ip.login.history'))
@push('top-area')
    <a href="https://www.ip2location.com/{{ $ip }}" class="btn btn-primary btn-sm" target="_blank" >@lang('Lookup IP') {{ $ip }}</a>
@endpush
@endif