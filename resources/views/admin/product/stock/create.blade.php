@extends('admin.layouts.master')
@section('content')
@section('title',$title)
<style>
    div#editModal input {
        border-radius: 0;
        padding: 6px;
    }

    div#editModal label {
        margin-bottom: 5px;
    }

    div#editModal .form-group:not(:last-child) {
        margin-bottom: 10px;
}
</style>

<div class='row mt-3'>
    <div class='col-12 col-lg-12'>
        <div class='card shadow-sm border-0'>
            <div class="card-header">
                <h4 class="text-white">@lang('Product Name') : {{ __($product->name) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                    @if($data && $product->has_variants)
                        <div class="table-responsive-md table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class='table-light'>
                                    <tr>
                                        <th>@lang('S.N.')</th>
                                        <th>@lang('Variant')</th>
                                        <th>@lang('SKU')</th>
                                        <th>@lang('Quantity')</th>
                                        <th class="text-center">@lang('Action')</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ __($item['combination']) }}</td>
                                        <td>{{ @$item['sku'] }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-pill @if($item['quantity'] == 0) bg-gradient-danger @elseif($item['quantity'] < 10) bg-gradient-warning @else bg-gradient-success @endif font-weight-normal">{{ $item['quantity']??0 }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" data-sku="{{ $item['sku'] }}" data-price="{{ $item['price'] }}" data-attributes="{{ $item['attributes'] }}" class="btn btn-primary btn-sm icon-btn ml-1 editBtn" data-toggle="tooltip" data-title="@lang('Update Inventory')">
                                                <i class="la la-pencil-alt"></i>
                                            </a>

                                            <a href="{{route('admin.product.stock.log', $item['stock_id']??0)}}" class="btn bg-gradient-info btn-sm icon-btn ml-1" data-toggle="tooltip" data-title="@lang('See Logs')"><i class="la la-list"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif(!$data && $product->has_variants)
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class='table-light'>
                                <tr>
                                    <td colspan="100%" class="text-center"><h3 class="text--danger">@lang('You did\'t add any variant for this product yet. ')</h3>
                                        <a class="btn btn--dark mt-3" href="{{ route('admin.product.attribute-add', [$product->id]) }}">@lang('Add Variant')</a>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class='table-light'>
                                <tr>
                                    <th>@lang('SKU')</th>
                                    <th>@lang('Quantity')</th>
                                    <th class="text-center">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>

                                    <td data-label="@lang('SKU')" class="text-center">{{$product->sku}}</td>
                                    <td data-label="@lang('Quantity')" class="text-center badge badge-pill bg-gradient-success">{{ sprintf('%2d',showAvailableStock($product->id, $attr_val=null))}}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" data-sku="{{ $product->sku }}" data-attributes="0" class="btn btn-primary btn-sm icon-btn ml-1 editBtn" data-toggle="tooltip" data-title="@lang('Update Inventory')">
                                            <i class="la la-pencil-alt"></i>
                                        </a>

                                        <a href="{{route('admin.product.stock.log', $product->stocks[0]??0)}}" class="btn btn-info btn-sm icon-btn ml-1" data-toggle="tooltip" data-title="@lang('See Logs')"><i class="fas fa-list"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="editModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('Update Inventory')</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>

                    <form action="{{route('admin.product.stock.add', $product->id)}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="attr" value="">
                            <div class="form-group sku">
                                {{-- <label for="">@lang('SKU')</label> --}}
                                <input type="hidden" name="sku" id="" class="form-control" placeholder="@lang('Type Here').."/>
                            </div>

                            <label>@lang('Quantity')</label>
                            <div class="input-group">
                                <!--<div class="input-group-prepend">-->
                                <!--    <select class="btn btn-dark group-select-left" name="type">-->
                                <!--    <option value="1">+</option>-->
                                <!--    <option value="2">-</option>-->
                                <!--    </select>-->
                                <!--</div>-->
                                <input type="text" class="form-control integer-validation" name="quantity" placeholder="@lang('Type Here')...">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn btn-primary">@lang('Save')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('top-area')
<a href="{{ route('admin.product.index') }}" class="btn btn-sm btn-primary box-shadow1 text-small"><i class="las la-backward"></i>@lang('Go Back')</a>
@endpush

@push('js')
<script>
    'use strict';
    (function($) {

        $('.editBtn').on('click', function() {
            var modal = $('#editModal');
            var skuValue = $(this).data('sku');
            console.log("sku value", skuValue)
            var attrArray = $(this).data('attributes');

            modal.find('input[name=sku]').val(skuValue);

            if (skuValue === 0) {
                modal.find('.sku').hide();
                modal.find('input[name=attr]').remove();
            } else {
                modal.find('.sku').show(); // Assuming you want to show it if skuValue is not 0

                if (attrArray != 0) {
                    modal.find('input[name=attr]').val(JSON.stringify(attrArray));
                } else {
                    modal.find('input[name=attr]').remove();
                }
            }

            modal.modal('show');
        });
    })(jQuery)
</script>

@endpush
