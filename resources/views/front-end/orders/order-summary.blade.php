@extends('front-end.layouts.app')

@section('title','Order summary')

@section('checkoutStatus', 'active')

@section('content')
<div id="checkout-pages">

    <section class="order-details checkout">
        <div class="container">

         <h1 class="bold mt-5">
            Order summary
        </h1>

        <div class="card">
         <div class="card-body">
            <h4 class="mb-3">
                Thank you. Your order has been received. A copy has been sent to your email address.
            </h4>
            <div class="bg-transparent-black p-2">
                <div class="row ">
                    <div class="col-6 col-md-3">
                        <small>
                            ORDER NUMBER:
                        </small>
                        <h6 class="bold">
                            {{ $order->order_number }}
                        </h6>
                    </div>
                    <div class="col-6 col-md-3">
                        <small>
                            DATE:
                        </small>
                        <h6 class="bold">
                            {{-- {{ $order->created_at->format('js') }} --}}
                            {{ get_order_date( $order) }}
                        </h6>
                    </div>
                    <div class="col-6 col-md-3">
                        <small>
                            TOTAL:
                        </small>
                        <h6 class="bold">
                            {{ config('adinkra.currency_code') }}{{ number_format($order->grand_total, 2) }}
                        </h6>
                    </div>
                    <div class="col-6 col-md-3">
                        <small>
                            PAYMENT METHOD:
                        </small>
                        <h6 class="bold">
                            {{ ucfirst($order->payment_method) }} via
                            {{ ucfirst($order->payment_type) }}
                        </h6>
                    </div>
                </div>

                @if($order->payment_type == 'bank')
                <h5 class="bold mt-3">
                    OUR BANK DETAILS
                </h5>

                <div class="row ">
                    <div class="col-12 col-md-3">
                        <small>
                            ACCOUNT NAME:
                        </small>
                        <h6 class="bold">
                            ADINKRA
                        </h6>
                    </div>
                    <div class="col-12 col-md-3">
                        <small>
                            BANK:
                        </small>
                        <h6 class="bold">
                            GCB BANK LTD
                        </h6>
                    </div>
                    <div class="col-12 col-md-3">
                        <small>
                            ACCOUNT NUMBER:
                        </small>
                        <h6 class="bold">
                            81995694
                        </h6>
                    </div>
                    <div class="col-12 col-md-3">
                        <small>
                            SORT CODE:
                        </small>
                        <h6 class="bold">
                            09-01-28
                        </h6>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <small>
                            IBAN:
                        </small>
                        <h6 class="bold">
                            GB17ABBY09012881995694
                        </h6>
                    </div>
                    <div class="col-12 col-md-3">
                        <small>
                            BIC:
                        </small>
                        <h6 class="bold">
                            ABBYGB2LXXX
                        </h6>
                    </div>
                </div>
                @endif
            </div>

            <h4 class="mt-5 bold">ORDER DETAILS</h4>
            <div class="row">
                <div class="col-md-6 mb-5">
                    <ul class="list-group">
                        @foreach($order->products as $product)
                        <li class="list-group-item d-flex justify-content-between">
                            <span class="col-md-8 p-0">
                                {{ $product->name }} <span class="bold">×  {{ $product->pivot->quantity }}</span>
                            </span>
                            <span class="col-md-4">
                                <span class="float-end">
                                    {{ config('adinkra.currency_code') }}{{ number_format(($product->pivot->price *  $product->pivot->quantity), 2) }}
                                </span>
                            </span>
                        </li>
                        @endforeach


                        <li class="list-group-item d-flex justify-content-between bold">
                            <span class="col-md-8 p-0">
                                Subtotal:
                            </span>
                            <span class="col-md-4">
                                <span class="float-end">
                                    {{ config('adinkra.currency_code') }}{{ number_format($order->subtotal, 2) }}
                                </span>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bold">
                            <span class="col-md-8 p-0">
                                Shipping:
                            </span>
                            <span class="col-md-4">
                                <span class="float-end">
                                    @if($order->shipping_amount  > 0)
                                    {{ config('adinkra.currency_code') }}{{ number_format($order->shipping_amount, 2) }}
                                    @else
                                    Free shipping
                                    @endif
                                </span>
                            </span>
                        </li>
                        @if(!empty($order->coupon))
                        <li class="list-group-item d-flex justify-content-between bold">
                            <span class="col-md-8 p-0">
                                Discount:
                            </span>
                            <span class="col-md-4">
                                <span class="float-end">
                                    {{ config('adinkra.currency_code') }}{{ number_format($order->coupon_amount, 2) }}
                                </span>
                            </span>
                        </li>
                        @endif

                        <li class="list-group-item d-flex justify-content-between bold">
                            <span class="col-md-8 p-0">
                                VAT:
                            </span>
                            <span class="col-md-4">
                                <span class="float-end">
                                    {{ config('adinkra.currency_code') }}{{ number_format($order->vat, 2) }}
                                </span>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bold">
                            <span class="col-md-8 p-0">
                                Payment method:
                            </span>
                            <span class="col-md-4">
                                <span class="float-end">
                                    {{ $order->payment_method }}
                                </span>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between bold">
                            <span class="col-md-8 p-0">
                                Total:
                            </span>
                            <span class="col-md-4">
                                <span class="float-end">
                                    {{ config('adinkra.currency_code') }}{{ number_format($order->grand_total, 2) }}
                                </span>
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="text-muted">Billing address</h4>
                            <address  class="d-flex flex-column">
                                <span>{{ ucfirst($order->addresses->billing_first_name).' '. ucfirst($order->addresses->billing_last_name) }}</span>
                                <span>{{ ucfirst($order->addresses->billing_email) }}</span>
                                <span>{{ ucfirst($order->addresses->billing_phone) }}</span>
                                <span>{{ ucfirst($order->addresses->billing_country) }}</span>
                                <span>{{ ucfirst($order->addresses->billing_address_one) }}</span>
                                <span>{{ ucfirst($order->addresses->billing_address_two) }}</span>
                                <span>{{ ucfirst($order->addresses->billing_city) }}</span>
                                <span>{{ ucfirst($order->addresses->billing_region) }}</span>
                                <span>{{ ucfirst($order->addresses->billing_zip_code) }}</span>
                            </address>
                        </div>
                        <div class="col-md-6">
                            <h4 class="text-muted">Shipping address</h4>
                            <address  class="d-flex flex-column">
                                <span>{{ ucfirst($order->addresses->shipping_first_name).' '. ucfirst($order->addresses->shipping_last_name) }}</span>
                                <span>{{ ucfirst($order->addresses->shipping_email) }}</span>
                                <span>{{ ucfirst($order->addresses->shipping_phone) }}</span>
                                <span>{{ ucfirst($order->addresses->shipping_country) }}</span>
                                <span>{{ ucfirst($order->addresses->shipping_address_one) }}</span>
                                <span>{{ ucfirst($order->addresses->shipping_address_two) }}</span>
                                <span>{{ ucfirst($order->addresses->shipping_city) }}</span>
                                <span>{{ ucfirst($order->addresses->shipping_region) }}</span>
                                <span>{{ ucfirst($order->addresses->shipping_zip_code) }}</span>
                            </address>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                <a href="/" type="button" class="btn btn-primary bg-gray border-0">Finish</a>
            </div>
        </div>
    </div>
</div>
</section>

</div>

<!-- Login modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header border-0">
            <h5 class="modal-title" id="loginModalLabel">Login</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="">
            <div class="modal-body">
                <span class="">
                    If you have shopped with us before, please enter your details below. If you are a new customer,
                    please <a data-dismiss="modal" href="">proceed to the Billing section</a>.
                </span>
                <div class="form-group mt-5">
                    <label for="">Username or email *</label>
                    <input type="text" class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control">
                </div>

                <div class="d-flex">
                    <div class="form-check pl-4">
                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                        <label class="form-check-label" for="defaultCheck1">
                            Remember me
                        </label>
                    </div>

                    <a class="ml-auto" href="#">Lost your password?</a>
                </div>

            </div>

            <div class="modal-footer border-0">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                <button type="button" class="btn btn-outline-primary text-dark px-5">Login</button>
            </div>
        </form>
    </div>
</div>
</div>

@endsection

@section('scripts')
{{-- <script type="text/javascript" src="{{asset('js/card.js')}}"></script> --}}
<script>

</script>
@endsection