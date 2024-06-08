@extends('admin.layouts.master')
@section('content')
@section('title','Email Template')

 <div class="card mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Subject')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($allData as $template)
                        <tr>
                            <td>{{ __($template->name) }}</td>
                            <td>{{ $template->subj }}</td>
                            <td>
                                @if($template->email_status == 1)
                                    <span class="badge badge-pill bg-gradient-success">@lang('Active')</span>
                                @else
                                    <span class="badge badge-pill bg-gradient-danger">@lang('Disabled')</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.email.edit',$template->id)}}" class="btn bg-gradient-info btn-sm icon-btn ml-1"><i class="las la-edit"></i></a>
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
</div>

@endsection