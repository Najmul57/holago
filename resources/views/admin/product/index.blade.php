@extends('admin.layouts.master')
@section('content')
@section('title', 'Product')

@push('css')
<style>
    td.holago__stock span {
    color: #000 !important;
    font-weight: bolder;
    font-size: 14px !important;
}
</style>
@endpush

<div class='card mt-3'>
    <div class='card-body'>
        <div class='table-responsive'>
            <table class='table align-middle mb-0'>
                <thead class='table-light'>
                    <tr>
                        <th scope='col'>@lang('ID')</th>
                        <th scope='col'>@lang('Image')</th>
                        <th scope='col'>@lang('Name')</th>
                        <th scope='col'>@lang('In Stock')</th>
                        <th scope='col'>@lang('product_model')</th>
                        <th scope='col'>@lang('Regular Price')</th>
                        <th scope='col'>@lang('Discount Price')</th>
                        <th scope='col'>@lang('Status')</th>
                        <th scope='col'>@lang('Action')</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $key => $product)
                        <tr>
                            <td scope='col'>{{ ++$key }}</td>
                            <td scope='col'>
                                <div class="product-box border">
                                    <img src="{{ displayImage('assets/classicmart/images/products/' . @$product->image) }}"
                                        alt="">
                                </div>
                            </td>
                            <td scope='col'>{{ shortContent($product->name, 50) }}</td>
                            <td scope='col' class="holago__stock">
                                <span
                                    class="badge badge-pill @if (optional($product->stocks)->sum('quantity') == 0) bg-gradient-danger @elseif(optional($product->stocks)->sum('quantity') < 10) bg-gradient-warning @else bg-gradient-success @endif font-weight-normal">
                                    @if ($product->track_inventory)
                                        {{ optional($product->stocks)->sum('quantity') }}
                                    @else
                                        @lang('Infinite')
                                    @endif
                                </span>
                            </td>
                            <td scope='col'>{{ __($product->product_model) }}</td>
                            <td scope='col'>{{ $setting->site_symbole }}{{ numberFormat($product->regular_price, 2) }}
                            </td>
                            <td scope='col'>
                                {{ $setting->site_symbole }}{{ numberFormat($product->discount_price, 2) }} </td>
                           <td scope='col'>
                                @if ($product->status == 1)
                               
                                    <span class="badge badge-pill bg-gradient-success ">
                                        <span style="color: black;  font-weight: 900;">@lang('Enabled')</span>
                                      </span>
                                @else
                                    
                                     <span class="badge badge-pill bg-gradient-danger">
                                        <span style="color: black;  font-weight: 900;">@lang('Disable')</span>
                                      </span>
                                @endif
                            </td>
                            <td scope='col'>
                                <div class="align-items-center gap-3 fs-6">
                                    <a href="{{ route('admin.product.edit', $product->id) }}"
                                        class="btn bg-gradient-info btn-sm icon-btn ml-1" title="Edit"><i
                                            class="las la-edit"></i></a>
                                    @if ($product->status == 1)
                                        <button class="btn bg-gradient-danger btn-sm icon-btn ml-1 disableBtn"
                                            data-bs-toggle="modal" data-bs-target="#disableModal"
                                            data-id="{{ __($product->id) }}">
                                            <i class="la la-eye-slash"></i>
                                        </button>
                                    @else
                                        <button class="btn bg-gradient-success btn-sm icon-btn ml-1 enableBtn"
                                            data-bs-toggle="modal" data-bs-target="#enableModal"
                                            data-id="{{ __($product->id) }}">
                                            <i class="la la-eye"></i>
                                        </button>
                                    @endif
                                    @if ($product->has_variants == 1)
                                        <a href="{{ route('admin.product.attribute-add', $product->id) }}"
                                            class="btn bg-gradient-info btn-sm icon-btn ml-1" title="set attribute"><i
                                                class="la la-palette"></i></a>
                                    @endif
                                    <a href="{{ route('admin.product.stock.create', $product->id) }}"
                                        class="btn bg-gradient-warning btn-sm icon-btn ml-1" data-toggle="tooltip"
                                        data-placement="top" title="@lang('Manage Inventory')"><i
                                            class="la la-database"></i></a>

                                    <a href="{{route('admin.product.delete',$product->id)}}" class="btn bg-gradient-danger btn-sm icon-btn ml-1 ">
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
@if ($products->hasPages())
    <div class='card-footer'>
        {{ $products->links() }}
    </div>
@endif
{{-- Enable --}}
<div id="enableModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Product Enable Confirmation')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.product.enable') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to Enable this product?')</p>
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
                <h5 class="modal-title">@lang('Product Disable Confirmation')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.product.disable') }}" method="POST">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <p>@lang('Are you sure to disable this product?')</p>
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
<a href="{{ route('export', ['filename' => 'product.csv']) }}" class="btn btn-primary btn-sm">Export CSV</a>
<a href="{{ route('admin.product.create') }}" class="btn btn-primary btn-sm"><i
        class="lab la-telegram-plane"></i>@lang('Add Product')</a>
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