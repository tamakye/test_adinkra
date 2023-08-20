@extends('front-end.layouts.app')

@section('title', 'Checkout')

@section('checkoutStatus', 'active')

@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/bs-stepper/css/bs-stepper.min.css') }}">
@endsection


@section('content')
<section class="cart checkout">
	<div class="container p-60">
		<h5 class="title mb-4 text-gray text-capitalize text-center">Checkout</h5>

		<div id="stepper" class="bs-stepper p-0">
			<div class="bs-stepper-header" role="tablist">
				<!-- your steps here -->
				<div class="step" data-target="#billing">
					<button type="button" class="step-trigger" role="tab" aria-controls="billing" id="billing-trigger">
						<span class="bs-stepper-circle">1</span>
						<span class="bs-stepper-label">BILLING</span>
					</button>
				</div>
				<div class="line"></div>
				<div class="step" data-target="#shipping">
					<button type="button" class="step-trigger" role="tab" aria-controls="shipping" id="shipping-trigger">
						<span class="bs-stepper-circle">2</span>
						<span class="bs-stepper-label">SHIPPING</span>
					</button>
				</div>
				<div class="line"></div>
				<div class="step" data-target="#summary">
					<button type="button" class="step-trigger" role="tab" aria-controls="summary" id="summary-trigger">
						<span class="bs-stepper-circle">3</span>
						<span class="bs-stepper-label">SUMMARY</span>
					</button>
				</div>
			</div>
			<form id="checkoutForm" action="{{ route('checkout') }}" method="POST" data-parsley-validate>
				@csrf

				<div class="bs-stepper-content p-0">
					<!-- your steps content here -->
					<div class="row">
						<div class="col-md-8">							
							<div id="billing" class="content h-100" role="tabpanel" aria-labelledby="billing-trigger">
								<div class="d-flex flex-column h-100">
									@if(!empty($address))
									<div class="row p-3">
										<div class="card col-md-6">
											<div class="card-body">
												<div class="row flex-column">
													<h6>{{$address->billing_first_name." ".$address->billing_last_name}}</h6>
													<span><small>{{$address->billing_email}}</small></span>
													<span><small>{{$address->billing_phone}}</small></span>
													<span><small>{{$address->billing_address_one}}</small></span>
													<span><small>{{$address->billing_city}}</small></span>
													<span><small>{{$address->billing_region}}, {{$address->billing_country}}</small></span>
												</div>
												<input type="hidden" name="slug" value="{{ $address->slug }}" id="address_slug" disabled>
											</div>
											<div class="card-footer bg-white d-flex">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" id="choose_address" value="{{ $address->user_id }}">
													<label class="form-check-label" for="choose_address" style="padding-top: 4px;">
														Use address
													</label>
												</div>
											</div>
										</div>
									</div>
									@endif

									<div class="row">
										<div class="col-md-6 form-group mb-3">
											<label for="billing_first_name">First name *</label>
											<input type="text" class="form-control" name="billing_first_name" value="{{ old('billing_first_name') }}" id="billing_first_name" required>
											@error('billing_first_name')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
										<div class="col-md-6 form-group mb-3">
											<label for="billing_last_name">Last name *</label>
											<input type="text" class="form-control" name="billing_last_name" value="{{ old('billing_last_name') }}" id="billing_last_name" required>
											@error('billing_last_name')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
										<div class="col-md-12 form-group mb-3">
											<label for="billing_address_one">Address 1*</label>
											<input type="text" class="form-control" name="billing_address_one" value="{{ old('billing_address_one') }}" id="billing_address_one" required>
											<p class="m-0 p-0 text-gray"><small>Street number, street name</small></p>
											@error('billing_address_one')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
										<div class="col-md-12 form-group mb-3">
											<label for="billing_address_two">Address 2 *</label>
											<input type="text" class="form-control" name="billing_address_two" value="{{ old('billing_address_two') }}" id="billing_address_two" required>
											<p class="m-0 p-0 text-gray"><small>Apartment number, suite number or company name</small></p>
											@error('billing_address_two')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
										<div class="col-md-6 -group mb-4">						
											<label for="billing_country">Country *</label>
											<select class="form-control select2" name="billing_country" id="billing_country" required>
												<option value=""></option>
												@foreach($countries as $country)
												<option value="{{ $country->id }}" {{ old('billing_country') == $country->id ? 'selected' : '' }} >{{ $country->name }}</option>
												@endforeach
											</select>
											@error('billing_country')
											<small class="invalid-feedback">{{ $message }}</small>
											@enderror
										</div>
										<div class=" col-md-6 form-group mb-4">						
											<label for="billing_region">STATE OR PROVINCE *</label>
											<select class="form-control select2" name="billing_region" required id="billing_region">
												<option value=""></option>
												@if(old('billing_region') && old('billing_country'))
												@foreach(getRegions(old('billing_country')) as $region)
												<option value="{{ $region->id }}" {{ old('billing_region') == $region->id ? 'selected' : '' }} >{{ $region->name }}</option>
												@endforeach
												@endif
											</select>
											@error('billing_region')
											<small class="invalid-feedback">{{ $message }}</small>
											@enderror
										</div>
										<div class="col-md-6 form-group mb-3">
											<label for="billing_city">City *</label>
											<input type="text" class="form-control" name="billing_city" value="{{ old('billing_city') }}" id="billing_city" required>
											@error('billing_city')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
										<div class="col-md-6 form-group mb-3">
											<label for="billing_zip_code">Zip/Postal Code*</label>
											<input type="text" class="form-control" name="billing_zip_code" value="{{ old('billing_zip_code') }}" id="billing_zip_code" required>
											@error('billing_zip_code')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
										<div class="col-md-6 form-group mb-3">
											<label for="billing_phone">Phone no.*</label>
											<input type="text" class="form-control" name="billing_phone" value="{{ old('billing_phone') }}" id="billing_phone" required>
											<p class="m-0 p-0 text-gray"><small>Example +233 234 3245 5324</small></p>
											@error('billing_phone')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
										<div class="col-md-6 form-group mb-3">
											<label for="billing_email">Email*</label>
											<input type="email" class="form-control" name="billing_email" value="{{ old('billing_email') }}" id="billing_email" required>
											<p class="m-0 p-0 text-gray"><small>info@example.com</small></p>
											@error('billing_email')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>

									<div class="form-group mt-auto prev-next mt-4 d-flex justify-content-between">
										<button type="button" class="btn btn-primary btn-prev w-100" onclick="stepper.next()">Next <i class="fa fa-chevron-right"></i></button>
									</div>
								</div>	
							</div>

							<div id="shipping" class="content h-100" role="tabpanel" aria-labelledby="shipping-trigger">
								<div class=" d-flex flex-column h-100">
									<div class="form-group mb-3">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="new_address" value="yes" id="new_address" @if($errors->any() && old('shipping_first_name') && old('shipping_last_name')) checked @endif>
											<label class="form-check-label" for="new_address" style="padding-top: 4px;">
												DELIVER TO A DIFFERENT ADDRESS?
											</label>
										</div>
									</div>
									<div class="row shipping-box" @if($errors->any() && old('shipping_first_name') && old('shipping_last_name'))@else style="display:none;"@endif>
										<div class="col-md-6 form-group mb-3">
											<label for="shipping_first_name">First name *</label>
											<input type="text" class="form-control shipping_items" name="shipping_first_name" value="{{ old('shipping_first_name') }}" id="shipping_first_name">
											@error('shipping_first_name')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
										<div class="col-md-6 form-group mb-3">
											<label for="shipping_last_name">Last name *</label>
											<input type="text" class="form-control shipping_items" name="shipping_last_name" value="{{ old('shipping_last_name') }}" id="shipping_last_name">
											@error('shipping_last_name')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
										<div class="col-md-12 form-group mb-3">
											<label for="shipping_address_one">Address 1*</label>
											<input type="text" class="form-control shipping_items" name="shipping_address_one" value="{{ old('shipping_address_one') }}" id="shipping_address_one">
											<p class="m-0 p-0 text-gray"><small>Street number, street name</small></p>
											@error('shipping_address_one')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
										<div class="col-md-12 form-group mb-3">
											<label for="shipping_address_two">Address 2 *</label>
											<input type="text" class="form-control shipping_items" name="shipping_address_two" value="{{ old('shipping_address_two') }}" id="shipping_address_two">
											<p class="m-0 p-0 text-gray"><small>Apartment number, suite number or company name</small></p>
											@error('shipping_address_two')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
										<div class="col-md-6 -group mb-4">						
											<label for="shipping_country">Country *</label>
											<select class="form-control shipping_items select2 country_select" name="shipping_country" id="shipping_country">
												<option value=""></option>
												@foreach($countries as $country)
												<option value="{{ $country->id }}" {{ old('shipping_country') == $country->id ? 'selected' : '' }} >{{ $country->name }}</option>
												@endforeach
											</select>
											@error('shipping_country')
											<small class="invalid-feedback">{{ $message }}</small>
											@enderror
										</div>
										<div class=" col-md-6 form-group mb-4">						
											<label for="shipping_region">STATE OR PROVINCE *</label>
											<select class="form-control shipping_items select2" name="shipping_region" id="shipping_region">
												<option value=""></option>
												@if(old('shipping_region') && old('shipping_country'))
												@foreach(getRegions(old('shipping_country')) as $region)
												<option value="{{ $region->id }}" {{ old('shipping_region') == $region->id ? 'selected' : '' }} >{{ $region->name }}</option>
												@endforeach
												@endif
											</select>
											@error('shipping_region')
											<small class="invalid-feedback">{{ $message }}</small>
											@enderror
										</div>
										<div class="col-md-6 form-group mb-3">
											<label for="shipping_city">City *</label>
											<input type="text" class="form-control shipping_items" name="shipping_city" value="{{ old('shipping_city') }}" id="shipping_city">
											@error('shipping_city')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
										<div class="col-md-6 form-group mb-3">
											<label for="shipping_zip_code">Zip/Postal Code*</label>
											<input type="text" class="form-control shipping_items" name="shipping_zip_code" value="{{ old('shipping_zip_code') }}" id="shipping_zip_code">
											@error('shipping_zip_code')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
										<div class="col-md-6 form-group mb-3">
											<label for="shipping_phone">Phone no.*</label>
											<input type="text" class="form-control shipping_items" name="shipping_phone" value="{{ old('shipping_phone') }}" id="shipping_phone">
											<p class="m-0 p-0 text-gray"><small>Example +233 234 3245 5324</small></p>
											@error('shipping_phone')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
										<div class="col-md-6 form-group mb-3">
											<label for="shipping_email">Email*</label>
											<input type="email" class="form-control shipping_items" name="shipping_email" value="{{ old('shipping_email') }}" id="shipping_email">
											<p class="m-0 p-0 text-gray"><small>Example +233 234 3245 5324</small></p>
											@error('shipping_email')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>

									<div class="form-group mt-auto prev-next mt-4 d-flex justify-content-between">
										<button type="button" class="btn btn-primary btn-next w-100 me-2" onclick="stepper.previous()"><i class="fa fa-chevron-left"></i> Previous</button>
										<button type="button" class="btn btn-primary btn-prev w-100" onclick="stepper.next()">Next <i class="fa fa-chevron-right"></i></button>
									</div>
								</div>
							</div>

							<div id="summary" class="content h-100" role="tabpanel" aria-labelledby="summary-trigger">
								<div class="d-flex flex-column h-100">
									<div class="row">
										<div class="col-md-12 form-group mb-3">
											<label for="note">Note</label>
											<textarea type="text" class="form-control" name="note" rows="6">{{ old('note') }}</textarea>
											@error('note')
											<span class="invalid-feedback">{{ $message }}</span>
											@enderror
										</div>
									</div>

									<hr>
									<div class="bg-transparent-black mb-3 p-2 border-radius">
										<span class="">
											<span class="bold">Have a coupon?</span>
											<br>
											Please apply it below.
										</span>
										<div class="form-group mt-2 mb-0">
											<div class="input-group">
												<input type="text" placeholder="" class="form-control" id="coupon">
												<div class="input-group-append">
													<button type="button" class="btn btn-primary bg-gray apply_coupon border-0" style="border-radius: 0;">Apply coupon</button>
												</div>
											</div>
										</div>
									</div>
									<hr>
									<small class="text-gray text-uppercase">Choose payment method <span>*</span></small>

									<div class="row justify-content-center mt-4">
										
										@if(config('adinkra.cash_status') == true)
										<div class="col-md-4 mb-3 checkbox-item">
											<input type="radio" name="payment_type" class="payment_type" id="cash_on_delivery"  value="cash_on_delivery" {{ old('payment_type') && old('payment_type') == 'cash_on_delivery' ? 'checked' : '' }}  style="display: none;">
											<label for="cash_on_delivery" class="w-100 payment_method" data-payment="cash_on_delivery">
												<div class="card border bg-white d-flex justify-content-center p-2 mb-2 cursor  cash_on_delivery_method {{ old('payment_type') && old('payment_type') == 'cash_on_delivery' ? 'bg-gray' : '' }}"  style="position: relative;">
													<img src="{{ asset('images/partners/cash-on-delivery.png') }}" class="m-auto" alt="cash on delivery" width="100" style="height: 50px; object-fit: contain;">
													<div class="text-center cart-loader" >
														<i class="fas fa-spin fa-spinner mt-4 text-white" ></i>
													</div>
												</div>
											</label>
										</div>
										@endif

										@if(config('adinkra.paystack_status') == true)
										<div class="col-md-4 mb-3  checkbox-item">
											<input type="radio" name="payment_type" class="payment_type" id="paystack"  value="paystack" {{ old('payment_type') && old('payment_type') == 'paystack' ? 'checked' : '' }}  style="display: none;">
											<label for="paystack" class="w-100 payment_method" data-payment="paystack">
												<div class="card border bg-white d-flex justify-content-center p-2 mb-2 cursor  paystack_method {{ old('payment_type') && old('payment_type') == 'paystack' ? 'bg-gray' : '' }}">
													<img src="{{ asset('images/partners/paystack.png') }}" class="m-auto" alt="paystack" width="100" style="height: 50px; object-fit: contain;">
													<div class="text-center cart-loader" >
														<i class="fas fa-spin fa-spinner mt-4 text-white" ></i>
													</div>
												</div>
											</label>
										</div>
										@endif

										@if(config('adinkra.bank_status') == true)
										<div class="col-md-4 mb-3  checkbox-item">
											<input type="radio" name="payment_type" class="payment_type" id="bank" value="bank"  {{ old('payment_type') && old('payment_type') == 'bank' ? 'checked' : '' }} style="display: none;">
											<label for="bank" class="w-100 payment_method" data-payment="bank">
												<div class="card border bg-white d-flex justify-content-center p-2 mb-2 cursor  bank_method {{ old('payment_type') && old('payment_type') == 'bank' ? 'bg-gray' : '' }}">
													<img src="{{ asset('images/partners/bank.png') }}" class="m-auto" alt="bank transfer" width="100" style="height: 50px; object-fit: contain;">
													<div class="text-center cart-loader" >
														<i class="fas fa-spin fa-spinner mt-4 text-white" ></i>
													</div>
												</div>
											</label>
										</div>
										@endif
									</div>

									<div class="form-group mt-auto prev-next mt-4 d-flex justify-content-between">
										<button type="button" class="btn btn-primary w-100 me-2 btn-next" onclick="stepper.previous()"><i class="fa fa-chevron-left"></i> Previous</button>
										@if(old('payment_type'))
										<button type="submit" class="btn btn-primary w-100 btn-prev">Place order <i class="fa fa-paper-plane"></i></button>
										@else
										<button type="submit" class="btn btn-primary w-100 btn-prev checkout-btn" disabled="">Place order <i class="fa fa-paper-plane"></i></button>
										@endif
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							@include('front-end.orders.checkout-summary')
						</div>
					</div>

				</div>
			</form>
		</div>
	</div>
</section>

@endsection

@section('scripts')
<script src="{{ asset('plugins/parsley/parsley.min.js') }}"></script>
<script src="{{ asset('plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<script>
	var stepper = new Stepper(document.querySelector('#stepper'), {
		animation: true
	})

	$('#checkoutForm').parsley();

	// document.addEventListener('DOMContentLoaded', function () {
	// 	var stepperEl = new Stepper(document.querySelector('.bs-stepper'))

	// 	// var stepperEl = document.getElementById('stepper');
	// 	var stepper = new Stepper(stepperEl);

	// 	stepper.addEventListener('show.bs-stepper', function (event) {
  	// 		// You can call prevent to stop the rendering of your step
	// 		event.preventDefault();

	// 		console.warn(event.detail.indexStep)
	// 	})
	// })



</script>
@endsection