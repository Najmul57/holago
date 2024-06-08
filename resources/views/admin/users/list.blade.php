@extends('admin.layouts.master')
@section('content')
@section('title','All Users')
 <div class="card mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <table id="example" class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>@lang('ID')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Username')</th>
                        <th>@lang('Email')</th>
                        <th>@lang('Phone')</th>
                        <th>@lang('Points')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <div class="product-box border">
                                    <img src="{{ displayImage('assets/images/user/image/'.@$user->image) }}" alt="">
                                </div>
                                <div class="product-info">
                                    <span class="product-name mb-1">{{__($user->fullname())}}</span>
                                </div>
                            </div>
                        </td>
                        <td>{{'@'}}{{__($user->username)}}</td>
                        <td>{{__($user->email)}}</td>
                        <td>{{__($user->phone)}}</td>
                        <td>{{__($user->points)}}</td>
                        <td>
                            <div class="align-items-center gap-3 fs-6">
                                <a href="{{ route('admin.users.details',$user->id)}}" class="btn bg-gradient-info btn-sm icon-btn ml-1" title="Edit"><i class="las la-edit"></i></a>
                            </div>
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

    
     @push('js')
        <script>
            $(document).ready(function() {
                $('#example').DataTable({
                    language: {
                        'paginate': {
                            'previous': '<span class="prev-icon"><i class="la la-angle-left"></i></span>',
                            'next': '<span class="next-icon"><i class="la la-angle-right"</i></span>'
                        }
                    }
                });
            })
        </script>
    @endpush
</div>

@endsection