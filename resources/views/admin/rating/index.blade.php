@extends('admin.layouts.master')
@section('content')
    @section('title','Product Review List')
    <div class='card mt-3'>
        <div class='card-body'>
            <div class='table-responsive'>
                <table class='table align-middle mb-0'>
                    <thead class='table-light'>
                    <tr>
                        <th scope='col'>@lang('ID')</th>
                        <th scope='col'>@lang('Product Name')</th>
                        <th scope='col'>@lang('Customer Name')</th>
                        <th scope='col'>@lang('Rating Title')</th>
                        <th scope='col'>@lang('Rating')</th>
                        <th scope='col'>@lang('Review')</th>
                        <th scope='col'>@lang('Action')</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($review_data as $key => $data)
                        <tr>
                            <td scope='col'>{{ ++$key }}</td>
                            <td scope='col'>{{__($data->product->name ??'')}}</td>
                            <td scope='col'>{{__($data->name ?? '')}}</td>
                            <td scope='col'>{{__($data->review_title ?? '')}}</td>
                            <td scope='col ' class="rating">
                                @if($data->rating == '1')
                                    <i class="la la-star"></i>
                                @elseif($data->rating == '2')
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                @elseif($data->rating == '3')
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                @elseif($data->rating == '4')
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                @elseif($data->rating == '5')
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                    <i class="la la-star"></i>
                                @else
                                    N/A
                                @endif

                            </td>
                            <td scope='col'>{{__($data->review)}}</td>
                            <td scope='col'>
                                <div class="align-items-center gap-3 fs-6">
                                    <a href="{{route('admin.review.delete',$data->id)}}" class="btn bg-gradient-danger btn-sm icon-btn ml-1" title="Edit"><i class="las la-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class='text-muted text-center' colspan='100%'>@lang('Data Not Found')</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if($review_data->hasPages())
        <div class='card-footer'>
            {{ $review_data->links() }}
        </div>
    @endif
@endsection
@push('js')

@endpush