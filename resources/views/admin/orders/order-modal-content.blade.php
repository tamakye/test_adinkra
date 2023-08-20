<div class="modal-header d-flex">
    <h5 class="modal-title font-weight-bolder" id="orderModalLabel">
        Order #{{ $order->order_number }}
    </h5>
    <div>
        <span class="badge {{ get_order_status_color($order->status) }} ml-auto">{{ ucfirst($order->status) }}</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
</div>

<div class="modal-body order-modal-content"> 

  <div class="bg-transparent-black p-2">
    <div class="row ">
        <div class="col-md-6">
            <h4>Billing details</h4>
            <address  class="d-flex flex-column">
                <span>{{ ucfirst($order->addresses->billing_first_name).' '. ucfirst($order->addresses->billing_last_name) }}</span>
                <span>{{ ucfirst($order->addresses->billing_email) }}</span>
                <span>{{ ucfirst($order->addresses->billing_phone) }}</span>
                <span>{{ ucfirst(orderCountry($order->addresses->billing_country)->name) }}</span>
                <span>{{ ucfirst($order->addresses->billing_address_one) }}</span>
                <span>{{ ucfirst($order->addresses->billing_address_two) }}</span>
                <span>{{ ucfirst($order->addresses->billing_city) }}</span>
                <span>{{ ucfirst(orderRegion($order->addresses->billing_region)->name) }}</span>
                <span>{{ ucfirst($order->addresses->billing_zip_code) }}</span>
            </address>
        </div>
        <div class="col-md-6">
            <h4>Shipping details</h4>
            <address  class="d-flex flex-column">
                <span>{{ ucfirst($order->addresses->shipping_first_name).' '. ucfirst($order->addresses->shipping_last_name) }}</span>
                <span>{{ ucfirst($order->addresses->shipping_email) }}</span>
                <span>{{ ucfirst($order->addresses->shipping_phone) }}</span>
                <span>{{ ucfirst(orderCountry($order->addresses->shipping_country)->name) }}</span>
                <span>{{ ucfirst($order->addresses->shipping_address_one) }}</span>
                <span>{{ ucfirst($order->addresses->shipping_address_two) }}</span>
                <span>{{ ucfirst($order->addresses->shipping_city) }}</span>
                <span>{{ ucfirst(orderRegion($order->addresses->shipping_region)->name) }}</span>
                <span>{{ ucfirst($order->addresses->shipping_zip_code) }}</span>
            </address>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mt-2">
            <h6 class="font-weight-bolder">Email</h6>
            <a href="mailTo:{{$order->addresses->billing_email}}">{{$order->addresses->billing_email}}</a>
        </div>
        <div class="col-md-6 mt-2">
            <h6 class="font-weight-bolder">Shipping method</h6>
            <p>{{$order->shipping_method}}</p>
        </div>
        <div class="col-md-6 mt-2">
            <h6 class="font-weight-bolder">Phone</h6>
            <a href="tel:{{$order->addresses->billing_phone}}">{{$order->addresses->billing_phone}}</a>
        </div>
        <div class="col-md-6 mt-2">
            <h6 class="font-weight-bolder">Payment via</h6>
            <p>
                {{ $order->payment_method }}
            </p>
        </div>
        <div class="col-md-6 mt-2">
            <h6 class="font-weight-bolder">Order notes</h6>
            <p>{{ $order->order_notes ?? '-'}}</p>
        </div>
    </div>
</div>

<h4 class="mt-3 bold text-primary">ORDER DETAILS</h4>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
      @foreach($order->products as $product)
      <tr>
        <td> {{ $product->product_name }} <span class="bold">×
            {{ $product->pivot->quantity }}</span>
        </td>
        <td>{{ config('adinkra.currency_code') }}{{ number_format($product->pivot->price, 2) }}</td>
        <td>{{ config('adinkra.currency_code') }}{{ number_format(($product->pivot->price *  $product->pivot->quantity), 2) }}</td>
    </tr>
    @endforeach
</tbody>
</table>

</div>
<div class="modal-footer d-flex justify-content-between">
    <input type="hidden" name="order" value="{{ $order->order_number }}" id="order">
    <div>
        @if($order->status != 'refunded')
        @if($order->status != 'cancelled' && $order->status != 'completed' && $order->status != 'draft')
        @if($order->status != 'processing')
        <button type="button" class="btn btn-outline-primary update_order" data-status="processing">Processing</button>
        @endif
        @if($order->status != 'completed')
        <button type="button" class="btn btn-outline-primary update_order" data-status="completed">Completed</button>
        @endif
        @endif

        @else
        
        <p class="text-danger"><i class="fas fa-undo"></i> Order refunded on {{ $order->refunded_at->format('d-m-Y') }}</p>
        @endif
    </div>

    <a href="{{ route('orders.edit', $order->order_number) }}" class="btn btn-outline-primary">Edit</a>
</div>
