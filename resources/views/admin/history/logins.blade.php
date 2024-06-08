@extends('admin.layouts.master')
@section('content')
@section('title','User Login History')

<div class="card mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>@lang('User')</th>
                        <th>@lang('Login at')</th>
                        <th>@lang('IP')</th>
                        <th>@lang('Location')</th>
                        <th>@lang('Browser | OS')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loginLogs as $log)
                    <tr>

                        <td data-label="@lang('User')">
                            <span class="font-weight-bold">
                                @if($log->user)
                                    {{ $log->user->fullname() }}
                                @else
                                    {{ @$log->company->name }}
                                @endif
                        </span>
                            <br> 
                            <span class="small">
                                @if($log->user)
                                    <a href="{{ route('admin.users.details', $log->user_id) }}"><span>@</span>{{ @$log->user->username }}</a> 
                                @elseif($log->company)
                                    <a href="{{ route('admin.companies.details', $log->company_id) }}"><span>@</span>{{ @$log->company->username }}</a> 
                                @endif
                            </span>
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
	                        <td class="text-muted text-center" colspan="100%">@lang('No users login found.')</td>
	                    </tr>
                	@endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($loginLogs->hasPages())
    <div class="card-footer">
        {{ $loginLogs->links() }}
    </div>
    @endif
</div>

@endsection