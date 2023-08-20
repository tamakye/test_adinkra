@extends('dashboard.layouts.app')

@section('title','My Orders')

@section('my-orders-active','active bg-sand')

@section('homeContent')

<div class="card">
    <div class="card-header">
        <h5>Orders</h5>
    </div>
    <div class="card-body">
        <ul class="list-group list-group-flush">
            @if(count($orders) > 0)
            @foreach($orders as $order)
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-8">
                        <div class="d-flex">
                            <span class="me-3 border bg-sand p-2 d-flex">
                                <img class="m-auto" src="{{asset('images/shopping-cart.svg')}}" alt="Cart" width="50px" height="50px">
                            </span>
                            <span class="flex-grow-1">
                                <h6>Shiping to <span class="font-weight-bolder">{{ $order->addresses->shipping_first_name. ' '. $order->addresses->shipping_last_name }}</span></h6>
                                <div class="text-muted">Order #{{ $order->order_number}}</div>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4 text-right">
                        <div>
                            <small class="badge bg-sand">Status: {{ strtoupper($order->status) }}</small><br>
                            <small class="bold text-muted">On {{ getCustomLocalTime($order->order_date)}}</small>
                        </div>
                        <a href="{{ route('order-details', $order->order_number) }}" class=" btn-outline-primary">See Details</a>
                    </div>
                </div>
            </li>
            @endforeach
            @else
            <div class="row d-flex justify-content-center">
                <div class="alert alert-info">
                    <h5>No orders found.</h5>
                </div>
            </div>
            @endif

        </ul>

        <hr>
        <div class="d-flex justify-content-center mt-4">
            <div class="m-auto">{{ $orders->links() }}</div>
        </div>
    </div>
</div>

{{-- footer --}}
{{-- @include('includes.footer') --}}
<script>
    // $('#shopItemModal').modal('show');
</script>
@endsection

@section('script')
{{-- <script src="{{ asset('js/shop.js') }}"></script> --}}
@endsection