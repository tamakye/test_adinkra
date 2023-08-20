@extends('dashboard.layouts.app')
@section('title','Order '. $order->order_number)

@section('my-orders-active','active bg-sand')

@section('homeContent')
<div class="card">
    <div class="card-header d-flex ">
        <h5 class="me-auto">Order  #{{ $order->order_number }} <small>on</small> {{ getCustomLocalTime($order->order_date)}}</h5>

        <div>
            <a href="{{ route('my-orders') }}" class="btn btn-primary btn-sm bg-sand text-white border-0"><i class="fas fa-chevron-left"></i> Back to orders</a>
        </div>
    </div>
    <div class="card-body">
        Status: <span class="border p-2 mb-2 text-center font-weight-bolder">{{ strtoupper($order->status) }}</span>

        <table id="orderProductTable" class="table col-sm-12 table-condensed cf mt-4">
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
                @foreach($order->products as $product)
                <tr class="">
                    <input type="hidden" class="items" name="items[]" value="{{  $product->id }}">
                    <td class="d-flex align-items-center pl-0 pb-0">
                        <span class="mr-2">
                            <img src="{{asset(get_product_thumbnail($product->thumbnail))}}" width="50px;" alt="" />
                        </span>
                        <span>
                            {{ $product->name }}
                        </span>
                    </td>
                    <td class="vertical-align-center">
                        <span>{{  config('adinkra.currency_code') }}{{ number_format($product->price, 2) }}</span>
                    </td>
                    <td class="">
                        {{ $product->pivot->quantity }}
                    </td>
                    <td class="text-right">
                        {{  config('adinkra.currency_code') }}{{ number_format(($product->quantity*$product->price), 2) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="col-md-6 offset-6 bg-light">
          <ul class="list-group reload-total" >
              <li class="list-group-item d-flex justify-content-between">
                <span class="font-weight-bold">Subtotal:</span>
                <span class="font-weight-bolder">{{  config('adinkra.currency_code') }}{{ number_format($order->subtotal, 2) }}</span>
            </li>

            <li class="list-group-item d-flex justify-content-between">
                <span class="font-weight-bold">Vat:</span>
                <span class="font-weight-bolder">{{  config('adinkra.currency_code') }}{{  number_format($order->vat, 2) }}
                </span>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span class="font-weight-bold">Shipping:</span>
                <span class="font-weight-bolder d-flex flex-column">
                  {{--   <span>
                        @if(!empty($order->shipping_method))
                        {{ $order->shipping_method}}
                        @else
                        Free 
                        @endif
                    </span> --}}
                    <span class="ms-auto">  {{  config('adinkra.currency_code') }}{{  number_format($order->shipping_amount, 2) }}</span>
                </span>
            </li>

            <li class="list-group-item d-flex justify-content-between">
                <span class="font-weight-bold">Order Total:</span>
                <span class="font-weight-bolder">{{  config('adinkra.currency_code') }}{{  number_format($order->grand_total, 2) }} </span>
            </li>
        </ul>
    </div>

    <hr>
    <div class="row">
        <div class="col-md-6">
            <h5>Billing address</h5>
            <div class="d-flex flex-column address-items">
                <h6>{{$order->addresses->billing_first_name." ".$order->addresses->billing_last_name}}</h6>
                <p><small>{{$order->addresses->billing_email}}</small></p>
                <p><small>{{$order->addresses->billing_phone}}</small></p>
                <p><small>{{$order->addresses->billing_address_one}}</small></p>
                <p><small>{{$order->addresses->billing_address_two}}</small></p>
                <p><small>{{$order->addresses->billing_city}}</small></p>
                <p><small>{{$order->addresses->billing_zip_code }}</small></p>
                <p><small>{{$order->addresses->billing_region}}, {{$order->addresses->billing_country}}</small></p>
            </div>
        </div>
        <div class="col-md-6">
            <h5>Shipping to</h5>
            <div class="d-flex flex-column address-items">
                <h6>{{$order->addresses->shipping_first_name." ".$order->addresses->shipping_last_name}}</h6>
                <p><small>{{$order->addresses->shipping_email}}</small></p>
                <p><small>{{$order->addresses->shipping_phone}}</small></p>
                <p><small>{{$order->addresses->shipping_address_one}}</small></p>
                <p><small>{{$order->addresses->shipping_address_two}}</small></p>
                <p><small>{{$order->addresses->shipping_city}}</small></p>
                <p><small>{{$order->addresses->shipping_zip_code  }}</small></p>
                <p><small>{{$order->addresses->shipping_region}}, {{$order->addresses->shipping_country}}</small></p>
            </div>
        </div>
    </div>

    <hr>
    <div class="row">
        <div class="col-md-6">
            <small>
                PAYMENT METHOD:
            </small>
            <h6 class="bold">
                @if($order->payment_type == 'card')
                {{ 'Credit card' }}
                @else
                Direct bank transfer
                @endif
            </h6>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Transaction id/PO Number: </label><br>
                <span>{{ $order->transaction_id }}</span>
            </div>

        </div>
    </div>
</div>
</div>

@endsection

@section('script')
{{-- <script src="{{ asset('js/shop.js') }}"></script> --}}
@endsection