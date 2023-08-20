<div class="card bg-lightgray mt-4" style="padding-top: 1.9rem!important;">
	<div class="card-header bg-transparent border-bottom">
		<h5 class="text-end title text-gray">ORDER SUMMERY</h5>
	</div>
	<div class="card-body refresh-item">
		@forelse($products as $product)
		<div class="row mb-4 pt-4  border-bottom pb-3 cart-item">
			<div class="col-md-4 ">
				<div class="cart-image">
					<img src="{{ asset(get_product_thumbnail($product->model->thumbnail)) }}" class="w-100" alt="Product image">
				</div>
			</div>
			<div class="col-md-5 pt-0">
				<h6 class="title mb-4 text-gray text-capitalize">{{ Str::limit($product->model->name, 11) }}</h6>
				<p class="text-gray mb-0">{{ $product->model->materials->name }}</p>
				@if(count($product->attributes) > 0)
				<p class="text-gray">{{ $product->attributes->name }}: {{ $product->attributes->title }}</p>
				@endif
			</div>
			<div class="col-md-3">
				<div class="d-flex  justify-content-end">
					<p class="text-gray segoe-bold">{{ config('adinkra.currency_code') }}{{ number_format($product->price, 2) }}</p>
				</div>
			</div>
		</div>
		@empty
		<small class="text-muted mb-4">No product found in cart</small>
		@endforelse

		<div class="row justify-content-between mb-2">
			<span class="col-sm-6 text-gray">SUB-TOTAL</span>
			<span class="col-sm-6 text-gray text-end segoe-bold">{{ config('adinkra.currency_code') }}{{ number_format(getsubTotalAmount(), 2) }}</span>
		</div>
		<div class="row justify-content-between mb-2">
			<span class="col-sm-6 text-gray">TAX</span>
			<span class="col-sm-6 text-gray text-end segoe-bold">{{ !empty(getVatValue()) ? number_format(getVatValue(), 2) : '-' }}</span>
		</div>
		<div class="row justify-content-between border-bottom pb-3 mb-2">
			<div class="col-sm-6 shipping-box">
				<span class="text-gray">SHIPPING</span><br>
				<small class="update-shipping-cost text-info"></small>
			</div>
			<div class="col-sm-6 text-gray text-end segoe-bold">
				<div class=" refresh-shipping">
					<span>
						@if(!empty(getShippingCondition()) && getShippingValue() > 0)
						{{ config('adinkra.currency_code') }}{{ number_format(getShippingValue(), 2) }}
						@else
						-
						@endif
					</span>
				</div>
			</div>
		</div>
		@if(!empty(getCouponCondition()))
		<div class="row justify-content-between border-bottom pb-3 mb-2">
			<span class="col-sm-6 text-gray">Discount</span>
			<span class="col-sm-6 text-gray text-end segoe-bold">
				{{ config('adinkra.currency_code') }}{{ number_format(getCouponValue(), 2) }} 
				{{-- ({{ getCouponCondition()->getAttributes()['discount'] }}%) --}}
			</span>
		</div>
		@endif
		<div class="row justify-content-between mb-2 border-bottom pb-3">
			<span class="col-sm-6 text-gray">TOTAL</span>
			<span class="col-sm-6 text-gray  text-end segoe-bold">{{ config('adinkra.currency_code') }}{{ number_format(Cart::session(get_cart_id())->getTotal(), 2) }}</span>
		</div>
		<div class="d-flex justify-content-between mt-4">
			<a href="https://wa.me/14802971375"  target="_blank"  class="d-flex flex-column justify-content-between text-center text-gray text-decoration-none"><i class="fab fa-whatsapp text-dark"></i> WhatsApp Us</a>
			<a href="tel:+2330000000" class="d-flex flex-column justify-content-between text-center text-gray text-decoration-none"><i class="fas fa-phone text-dark"></i> Call Us</a>
			<a href="{{ route('contact') }}" class="d-flex flex-column justify-content-between text-center text-gray text-decoration-none"><i class="fas fa-comments text-dark"></i> Chat With Us</a>
		</div>
	</div>
</div>