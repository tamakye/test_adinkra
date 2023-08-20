@extends('front-end.layouts.app')

@section('title', $product->name)

@section('meta_keywords', $product->meta_keywords)
@section('meta_description', $product->meta_description)


@section('content')

<section class="single-product">

	<div class="container mt-0 mb-5">	
		<div class="card">	
			<div class="row g-0">	
				<div class="col-md-7">	
					<div class="single-md-thumbnail  p-0">
						<div class="row">
							<div class="col-md-2 p-0">
								<div class="thumbnail_images_lg">	
									<div class="row">
										<div class="col-md-12 row-item pt-1 mt-0">
											<img onclick="changeImage(this)" src="{{ asset(get_product_thumbnail($product->thumbnail)) }}">
										</div>	
										@foreach(json_decode($product->product_image) as $image)
										<div class="col-md-12 row-item">
											<img onclick="changeImage(this)" src="{{ asset(get_product_images($image)) }}">
										</div>	
										@endforeach	
									</div>
								</div>
							</div>
							<div class="col-md-10">
								<div class="main_image p-1">	
									<img src="{{ asset(get_product_thumbnail($product->thumbnail)) }}" id="main_product_image">
								</div>	
							</div>
						</div>
					</div>

					<div class="single-sm-thumbnail flex-column justify-content-center">	
						<div class="main_image">	
							<img src="{{ asset(get_product_thumbnail($product->thumbnail)) }}" id="main_sm_product_image" width="350">	
						</div>	
						<div class="thumbnail_images">	
							<ul id="thumbnail">	
								@foreach(json_decode($product->product_image) as $image)
								<li><img onclick="changeImageSm(this)" src="{{ asset(get_product_images($image)) }}" width="70"></li>	
								@endforeach
							</ul>	
						</div>	
					</div>	
				</div>	
				<div class="col-md-5">	
					<div class="right-side" style="margin-top: 3rem!important;">	
						<div class="d-flex justify-content-between align-items-center">	
							<h3 class="text-uppercase text-gray">{{ $product->name }}</h3>
						</div>	
						<div class="mt-1 pr-3 content">	
							<p class="text-gray addReadMore showlesscontent">{!! Str::limit($product->description, 130) !!}</p>	

							<div class="select-size mt-4">

								@if(count($attributes) > 0)
								<p class="text-uppercase text-gray">SELECT A SIZE</p>

								<select class="form-control select2 sizes">
									@foreach($attributes as $attribute)
									
									<option value="{{ $attribute->value_slug }}" data-price="{{  config('adinkra.currency_code') }}{{ number_format($attribute->value_price, 2) }}" {{ $attribute->value_price == $default_price ? 'selected' : '' }}>{{ $attribute->value_title }}</option>
									@endforeach
								</select>
								@else
								<p class="text-uppercase text-gray mb-0 pb-0">SELECT A SIZE</p>
								<small class="text-muted"><i>N/A</i></small>
								@endif
							</div>
						</div>

						<a href="{{ asset('documents/size-guide.pdf') }}" target="_blank" class="text-uppercase text-gray">size guide</a>

						@if(count($product->attributes) > 0)
						<h3 class="text-uppercase text-gray mt-4 product-price">{{  config('adinkra.currency_code') }}{{ number_format($default_price, 2) }}</h3>
						@else
						<h3 class="text-uppercase text-gray mt-4 product-price">{{  config('adinkra.currency_code') }}{{ number_format($product->price, 2) }}</h3>
						@endif

						<div class="row buttons  mt-4">	
							<div class="col-md-10">
								<div class="refresh-item">
									@if(isItem($product->id))
									<a href="{{ route('cart') }}" class="btn bg-gray text-white btn-block w-100" data-product={{ $product->slug }} style="padding-top: 9px;">Go to cart <i class="fa-solid fa-hand-point-right"></i></a>
									@else
									<button class="btn btn-dark btn-block w-100 add-to-cart text-white" data-product={{ $product->slug }}>Add to cart</button>
									@endif
								</div>
							</div>	
							<div class="col-md-2">
								<button type="button" class="btn btn-outline-dark w-100 add-to-wish-list" data-product={{ $product->slug }}><span class="heart"><i class='fas fa-heart'></i></span></button>	
							</div>
						</div>	
						<div class="search-option d-flex flex-column">
							<a href="tel:+2332000000000" class="text-gray text-decoration-none mt-4">
								<img src="{{ asset('images/phone.png') }}" alt="Phone" width="15px" height="15px" class="me-1"> ORDER BY PHONE</a>
								<a href="mailTo:info@adinkra.com" class="text-gray text-decoration-none mt-2"><img src="{{ asset('images/feather.png') }}" alt="Phone" width="15px" height="15px" class="me-1">  CONTACT AN AMBASSADOR</a>
							</div>	
						</div>	
					</div>	
				</div>	
			</div> 
		</div>
	</section>

	<section class="single-product-info bg-lightgray p-80">
		<div class="container">
			<div class="row">
				<div class="col-md-5 ">
					<h5 class="title text-gray text-uppercase mb-4">Poetry in Jewelry</h5>
					<p class="text-gray sub-title pe-4">
						{{  $product->poetry_in_jewelry ? $product->poetry_in_jewelry : 'No poetry in jewelry added'}}
					</p>
				</div>

				<div class="col-md-2">
					<h5 class="title sub-title text-gray text-uppercase mb-4">Details</h5>
					<p class="text-gray">
						{{ $product->details ? $product->details : 'No product details added'}}
						
					</p>
				</div>

				<div class="col-md-5">
					<h5 class="title text-gray text-uppercase mb-4">Inspiration</h5>
					<!-- <img src="{{ asset('images/hand-ring.png') }}" height="220px" width="100%"> -->
					<img src="{{ asset(get_product_inspiration($product->inspiration)) }}" height="220px" width="100%">
					
				</div>
			</div>
		</div> 
	</section>

	@if(count($related_products) > 0)
	<section class="collection single-product-collection rings single-product-related position-relative">
		<div class="container">
			<h5 class="title text-gray text-uppercase text-center mb-5">You might also like this</h5>
			{{-- @if(count($related_products) > 0) --}}
			<div class="rings-swiper swiper">
				<div class="swiper-wrapper justify-content-center">
					@foreach($related_products as $related_product)
					<a href="{{ route('products.single', $related_product->slug) }}"  class="ring-box swiper-slide text-decoration-none text-dark">
						<div class="card border-0" style="width: 17rem;">
							<img src="{{ asset(get_product_thumbnail($related_product->thumbnail)) }}" class="card-img-top" alt="Silver plated ring">
							<div class="card-body text-center">
								<h5 class="card-title">{{ Str::limit($related_product->name, 24) }}</h5>
								<p class="card-text">
									@if($related_product->attributes_count > 0)
									{{ config('adinkra.currency_code') }}{{ number_format(get_product_attribute_price($related_product) , 2) }}
									@else
									{{ config('adinkra.currency_code') }}{{ number_format($product->price , 2) }}
									@endif
								</p>
							</div>
						</div>
					</a>
					@endforeach
				</div>
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
			</div>
		{{-- 	@else
			<div class="rings-swiper swiper">
				<div class="swiper-wrapper justify-content-center" style="left: 0;">
					<h6>No records found</h6>
				</div>
			</div>
			@endif --}}
		</div>
	</section>
	@endif
	
	@include('front-end.partials.info')

	@include('front-end.partials.subscribe')

	@endsection

	@section('scripts')
	<script type="text/javascript">
		function changeImage(element) {

			var main_prodcut_image = document.getElementById('main_product_image');
			main_prodcut_image.src = element.src;

		}

		function changeImageSm(element) {

			var main_prodcut_image = document.getElementById('main_sm_product_image');
			main_prodcut_image.src = element.src;

		}

	// function AddReadMore() {
        //This limit you can set after how much characters you want to show Read More.
		var carLmt = 80;
        // Text to show when text is collapsed
		var readMoreTxt = " ... Read More";
        // Text to show when text is expanded
		var readLessTxt = " Read Less";


        //Traverse all selectors with this class and manupulate HTML part to show Read More
		$(".addReadMore").each(function() {
			if ($(this).find(".firstSec").length)
				return;

			var allstr = $(this).text();
			if (allstr.length > carLmt) {
				var firstSet = allstr.substring(0, carLmt);
				var secdHalf = allstr.substring(carLmt, allstr.length);
				var strtoadd = firstSet + "<span class='SecSec'>" + secdHalf + "</span><span class='readMore'  title='Click to Show More'>" + readMoreTxt + "</span><span class='readLess' title='Click to Show Less'>" + readLessTxt + "</span>";
				$(this).html(strtoadd);
			}

		});
        //Read More and Read Less Click Event binding
		$(document).on("click", ".readMore,.readLess", function() {
			$(this).closest(".addReadMore").toggleClass("showlesscontent showmorecontent");
		});
	// }

		$(function(){
		//Calling function after Page Load
		// AddReadMore();

			$(document).on('change', '.sizes', function(){
				$('.product-price').html($(this).find('option:selected').data('price'));
			})

		})

	</script>
	@endsection