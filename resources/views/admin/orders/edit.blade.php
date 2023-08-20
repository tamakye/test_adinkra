@extends('admin.layouts.app')
@section('title', 'Edit order')
@section('orders_active','active')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit order</h1>
            </div>
            <div class="col-sm-6 text-right">
             <a href="{{route('orders', ['type' => 'orders'])}}" type="button" class="btn btn-outline-primary">
                <i class="fa fa-chevron-left"></i>
                back
            </a>
        </div>
    </div>
</div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit order #{{ $order->order_number }}</h3>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <form id="orderForm" class="orderForm" action="{{ route('orders.update', $order->order_number) }}" method="post">
            @csrf
            <input type="hidden" name="order_number" value=" {{ $order->order_number }} " id="order_number">
            <input type="hidden" name="address_slug" value="{{ !empty($order) ? $order->addresses->slug : '' }}">
            <div class="row">
                <div class="col-md-9">
                    @include('admin.orders.order-top') 
                </div>

                <div class="col-md-3">
                    @include('admin.orders.order-sidebar')

                </div>
            </div>
        </form>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card mt-5">
                    <div class="card-header">
                        <h5 class="font-weight-bolder">Add items</h5>
                    </div>

                    <div class="card-body">
                        <table id="orderProductTable" class="table col-sm-12 table-condensed cf">
                            <thead>
                                <tr>
                                    <th>
                                        PRODUCT
                                    </th>
                                    <th>
                                        PRICE
                                    </th>
                                    <th class="text-center">
                                        QUANTITY
                                    </th>
                                    <th class="text-right">
                                        SUBTOTAL
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <form class="basketForm">
                                    <input type="hidden" class="product_content" value="{{ Cart::session(get_order_number())->getTotalQuantity() }}">

                                    @foreach($order->products as $product)
                                    <tr class="">
                                        <input type="hidden" class="items" name="items[]" value="{{  $product->id }}">
                                        <td class="d-flex align-items-center pl-0 pb-0">
                                            <span>
                                                <button type="button" class="btn btn-icon remove_item" disabled data-item={{ $product->id }}>
                                                    <i class="fa fa-times text-danger"></i>
                                                </button>
                                            </span>
                                            <span class="mr-2">
                                                <img src="{{asset(get_product_thumbnail($product->thumbnail))}}" width="50px;" alt="" />
                                            </span>
                                            <span>
                                                {{ $product->name }}
                                            </span>
                                        </td>
                                        <td class="vertical-align-center">
                                            <span>{{ config('adinkra.currency_code') }}{{ number_format($product->pivot->price, 2) }}</span>
                                        </td>
                                        <td class="">
                                            <input class="col-4 basket_quantity form-control m-auto" autocomplete="off" min="1" name="quantity[]" type="number" disabled="" value="{{ $product->pivot->quantity }}">

                                        </td>
                                        <td class="text-right">
                                            {{ config('adinkra.currency_code') }}{{ number_format($product->pivot->price, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach

                                </form>
                            </tbody>
                        </table>

                        <div class="col-md-4 offset-8 bg-light">
                          <ul class="list-group reload-total" >
                              <li class="list-group-item d-flex justify-content-between">
                                  <span class="font-weight-bold">Items Subtotal:</span>
                                  <span class="font-weight-bolder">{{ config('adinkra.currency_code') }}{{ number_format($order->subtotal, 2) }}</span>
                              </li>

                              <li class="list-group-item d-flex justify-content-between">
                                <span class="font-weight-bold">Vat:</span>
                                <span class="font-weight-bolder">{{ config('adinkra.currency_code') }}{{  number_format($order->vat, 2) }}
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span class="font-weight-bold">{{$order->shipping_method ?? 'Free shipping'}}:</span>
                                <span class="font-weight-bolder">{{ config('adinkra.currency_code') }}{{  number_format($order->shipping_amount, 2) }}
                                </span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span class="font-weight-bold">Order Total:</span>
                                <span class="font-weight-bolder">{{ config('adinkra.currency_code') }}{{  number_format($order->grand_total, 2) }} </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card-footer bg-white border-top d-flex justify-content-between">
                    <input type="hidden" name="order" value="{{ $order->order_number }}" id="order">

                    @if($order->status == 'refunded')
                    <p class="text-danger"><i class="fas fa-undo"></i> Order refunded on {{ $order->refunded_at->format('d-m-Y') }}</p>
                    @else
                    <button type="button" class="btn btn-sm btn-outline-primary update_order" data-status="refunded">Refund</button>
                    @endif
                    <p class="text-muted">This order can not be edited</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">

        </div>
    </div>
</div>
</div>


{{-- modals --}}
<!-- Modal -->
<div class="modal" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productModalLabel">Add product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <form class="addProductForm" action="" method="post">
    @csrf
    <input type="hidden" name="order_number" value=" {{ get_order_number() }} ">

    <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-8">
                <label>Product</label>
            </div>
            <div class="form-group col-md-4">
                <label>quantity:</label>
            </div>
        </div>
        <hr>

        <div class="product_box" id="product_box">
            <div class="row product_row">
                <div class="form-group col-md-8">
                    <select class="product form-control @error('products') is-invalid @enderror" name="products[]" style="width: 100%;">
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <input type="number" min="0" class="form-control product_quantity" name="quantity[]">
                </div>
            </div>
        </div>
        <a href="javascript:void(0)" class="add_product_field">New field</a>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_product_to_order">Add product</button>
    </div>
</form>
</div>
</div>
</div>

<div class="modal" id="taxModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productModalLabel">Add tax</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body">
   <input type="hidden" name="order_number" value=" {{ get_order_number() }} ">
   <table class="table table-striped table-hover">
    <thead>
        <tr>
            <th></th>
            <th>Tax name</th>
            <th>Tax class</th>
            <th>Tax code</th>
            <th>Tax rate</th>
        </tr>
    </thead>
    <tbody>
        @foreach($taxes as $tax)
        <tr>
            <td>
                <div class="custom-control custom-radio">
                    <input type="radio" id="{{ $tax->id }}" name="tax" class="custom-control-input order_tax" value="{{ $tax->id }}">
                    <label class="custom-control-label" for="{{ $tax->id }}"></label>
                </div>
            </td>
            <td>{{ $tax->tax_name }}</td>
            <td>{{ $tax->tax_class }}</td>
            <td>{{ $tax->tax_code }}</td>
            <td>{{ $tax->tax_percent }}%</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary add_tax">Add</button>
</div>
</div>
</div>
</div>

@endsection

@section('scripts')
<script src="{{asset('dashboard/js/order.js')}}"></script>
@endsection