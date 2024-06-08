@extends('admin.layouts.master')
@section('content')
@section('title', 'Category')
<div class='card mt-3'>
    <div class='card-body'>
        <div class='table-responsive'>
            <table class='table align-middle mb-0'>
                <thead class='table-light'>
                    <tr>
                        <th scope='col'>@lang('ID')</th>
                        <th scope='col'>@lang('name')</th>
                        <th scope='col'>@lang('meta_title')</th>
                        <th scope='col'>@lang('meta_keywords')</th>
                        <th scope='col'>@lang('top_category')</th>
                        <th scope='col'>@lang('special_category')</th>
                        <th scope='col'>@lang('Status')</th>
                        <th scope='col'>@lang('Action')</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($categories as $key => $category)
                        <tr>
                            <td scope='col'>{{ ++$key }}</td>
                            <td scope='col'>{{ __($category->name) }}</td>
                            <td scope='col'>{{ __($category->meta_title) }}</td>
                            @if (is_array($category->meta_keywords))
                                @php
                                    $metaKeywords = collect($category->meta_keywords);
                                @endphp
                            @elseif(is_string($category->meta_keywords))
                                @php
                                    $metaKeywords = collect(explode(',', $category->meta_keywords));
                                @endphp
                            @else
                                @php
                                    $metaKeywords = null;
                                @endphp
                            @endif

                            @if ($metaKeywords)
                                <td scope='col'>
                                    @foreach ($metaKeywords->take(3) as $keyword)
                                        <span class='badge badge-pill bg-gradient-info'>{{ $keyword }}</span>
                                    @endforeach
                                </td>
                            @else
                                <td></td>
                            @endif
                            <td scope='col'>
                                @if ($category->top_category == 1)
                                    <span class='badge badge-pill bg-gradient-success'>@lang('Yes')</span>
                                @else
                                    <span class='badge badge-pill bg-gradient-danger'>@lang('No')</span>
                                @endif
                            </td>
                            <td scope='col'>
                                @if ($category->special_category == 1)
                                    <span class='badge badge-pill bg-gradient-success'>@lang('Yes')</span>
                                @else
                                    <span class='badge badge-pill bg-gradient-danger'>@lang('No')</span>
                                @endif
                            </td>
                            <td scope='col'>
                                @if ($category->status == 1)
                                    <span class='badge badge-pill bg-gradient-success'>@lang('Enabled')</span>
                                @else
                                    <span class='badge badge-pill bg-gradient-danger'>@lang('Disable')</span>
                                @endif
                            </td>
                            <td scope='col'>
                                <div class="align-items-center gap-3 fs-6">
                                    <a href="{{ route('admin.category.edit', $category->id) }}"
                                        class="btn bg-gradient-info btn-sm icon-btn ml-1" title="Edit"><i
                                            class="las la-edit"></i></a>
                                    @if ($category->status == 1)
                                        <button class="btn bg-gradient-danger btn-sm icon-btn ml-1 disableBtn"
                                            data-bs-toggle="modal" data-bs-target="#disableModal"
                                            data-id="{{ __($category->id) }}">
                                            <i class="la la-eye-slash"></i>
                                        </button>
                                    @else
                                        <button class="btn bg-gradient-success btn-sm icon-btn ml-1 enableBtn"
                                            data-bs-toggle="modal" data-bs-target="#enableModal"
                                            data-id="{{ __($category->id) }}">
                                            <i class="la la-eye"></i>
                                        </button>
                                    @endif
                                    <a class="btn bg-gradient-danger btn-sm icon-btn" href="{{route('admin.category.delete',$category->id)}}">
                                        <i class="la la-trash"></i>
                                    </a>
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
@if ($categories->hasPages())
    <div class='card-footer'>
        {{ $categories->links() }}
    </div>
@endif

{{-- Enable --}}
<div id="enableModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Category Enable Confirmation')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.category.enable') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to Enable this category?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('No')</button>
                    <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Disable --}}
<div id="disableModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Category Disable Confirmation')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.category.disable') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to disable this category?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('No')</button>
                    <button type="submit" class="btn btn-primary">@lang('Yes')</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('top-area')
<a href="{{ route('admin.category.create') }}" class="btn btn-primary btn-sm"><i
        class="lab la-telegram-plane"></i>@lang('Add Category')</a>
@endpush
@push('js')
<script>
    (function($) {
        "use strict";
        $('.enableBtn').on('click', function() {
            var modal = $('#enableModal');
            modal.find('input[name=id]').val($(this).data('id'));
        });
        $('.disableBtn').on('click', function() {
            var modal = $('#disableModal');
            modal.find('input[name=id]').val($(this).data('id'));
        });
    })(jQuery);
</script>
@endpush