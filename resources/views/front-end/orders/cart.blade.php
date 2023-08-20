@extends('front-end.layouts.app')

@section('title', 'Cart items')

@section('meta_keywords', 'Cart items')
@section('meta_description', 'Cart items')

@section('cartStatus', 'active')

@section('content')
<section class="cart">
	<div class="container p-80 pl-3 pr-3">
		<h5 class="title mb-4 text-gray text-uppercase refresh-cart-count">SHOPPING CART({{  Cart::session(get_cart_id())->getContent()->count() }})</h5>

		<div class="row cart-row-reverse">
			<div class="col-md-7 mb-3 ">
				<div class="refresh-cart-items">
					@forelse($products as $product)
					<input type="hidden" class="items" name="items[]" value="{{  $product->id }}">
					<div class="row mb-4 dborder-top pt-4 cart-item">
						<div class="col-md-3">
							<div class="cart-image">
								<img src="{{ asset(get_product_thumbnail($product->model->thumbnail)) }}" class="w-100" alt="product image">
							</div>
						</div>
						<div class="col-md-6 pt-0">
							<a href="{{ route('products.single', $product->model->slug) }}" class=" mb-4 text-sand text-uppercase text-decoration-none text-info mt-3" style="font-size: 1rem;">{{ $product->model->name }}</a>
							<p class="text-gray mb-0 fw-bold">{{ $product->model->materials->name }}</p>

							@if(count($product->attributes) > 0)
							<p class="text-gray">{{ $product->attributes->name }}: {{ $product->attributes->title }}</p>
							@endif

							<div class="row  mt-4">
								<div class="col-md-5 mb-3 row_quantity">
									<input class=" basket_quantity" autocomplete="off" min="1" name="quantity[]" type="hidden" value="{{ $product->quantity }}">
									<select name="quantity" class="form-control update_basket select2">
										@for($i = 1; $i <= 10; $i++)
										<option value="{{ $i }}" {{ $product->quantity == $i ? 'selected' : '' }}>{{ $i }}</option>
										@endfor
									</select>
									<small class="update-cart-info text-info"></small>
								</div>
								<div class="col-md-7 mb-3">
									<a href="#!" class="text-capitalize text-gray text-decoration-none add-to-wish-list" data-product="{{ $product->model->slug }}"> <i class="fas fa-heart"></i> Add to wishlist</a>
								</div>
							</div>

							<p class="text-gray mt-4">Product code: {{ $product->model->product_number }}</p>
						</div>
						<div class="col-md-3">
							<div class="d-flex  justify-content-between">
								<p class="text-gray fw-bold">{{  config('adinkra.currency_code') }}{{ number_format($product->price, 2) }}</p>
								<a href="#!" class="text-gray remove_item" data-item={{ $product->id }}><i class="fas fa-times"></i></a>
							</div>
						</div>
					</div>
					@empty
					<div class="border-top pt-2">
						<small class="text-gray">No items found in cart</small>
					</div>
					@endforelse
				</div>

			</div>
			<div class="col-md-1">
			</div>
			<div class="col-md-4 mb-3">
				<div class="card dborder-2 shadow-0 p-4 bg-lightgray checkoutTotalCard">
					<div class="card-header bg-transparent border-bottom">
						<h5 class="text-right title text-gray">ORDER SUMMERY</h5>
					</div>

					<div class="card-body">
						<div class=" refresh-item">

							<div class="d-flex justify-content-between mb-4">
								<span class="text-gray">TOTAL</span>
								<span class="text-gray">{{  config('adinkra.currency_code') }}{{ number_format(Cart::session(get_cart_id())->getSubTotalWithoutConditions(), 2) }}</span>
							</div>
							<div class="mb-4">
								<span class="text-gray taxes">EXCLUDING SHIPPING AND TAXES</span>
							</div>
							<div class="mb-4">
								@if(!Cart::session(get_cart_id())->isEmpty())
								<a href="{{ route('checkout') }}" class="btn btn-primary bg-dark border-0 pt-3 pb-3 w-100 border-radius-0">CHECKOUT</a>
								@endif
								<a href="/" class="btn btn-outline-primary w-100 mt-3  pt-3 pb-3 text-uppercase text-gray load-more">CONTINUE SHOPPING</a>
							</div>
							<div class="d-flex justify-content-between mb-4">
								<a href="https://wa.me/14802971375"  target="_blank"  class="d-flex flex-column justify-content-between text-center text-gray text-decoration-none"><i class="fab fa-whatsapp text-dark"></i> WhatsApp Us</a>
								<a href="tel:+2330000000" class="d-flex flex-column justify-content-between text-center text-gray text-decoration-none"><i class="fas fa-phone text-dark"></i> Call Us</a>
								<a href="{{ route('contact') }}" class="d-flex flex-column justify-content-between text-center text-gray text-decoration-none"><i class="fas fa-comments text-dark"></i> Chat With Us</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('scripts')
<script type="text/javascript">
	// $(function(){
	// })
</script>
@endsection