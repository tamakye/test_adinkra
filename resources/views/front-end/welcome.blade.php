@extends('front-end.layouts.app')

@section('title', 'Welcome to Adinkra')

@section('homeActive', 'active')

@section('carousel')
<div class="container carousel-wrapper mt-0">
	<div id="landinCarousel" class="carousel slide" data-bs-ride="carousel">
		<div class="carousel-inner">
			<div class="carousel-item active">
				<img src="{{ asset('images/slider1.png') }}" class="d-block w-100" alt="Slider one">
			</div>
			<div class="carousel-item">
				<img src="{{ asset('images/slider2.png') }}" class="d-block w-100" alt="Slider two">
			</div>
			<div class="carousel-item">
				<img src="{{ asset('images/slider3.png') }}" class="d-block w-100" alt="Slider three">
			</div>
		</div>
		<button class="carousel-control-prev" type="button" data-bs-target="#landinCarousel" data-bs-slide="prev" style="width: 70px !important;">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Previous</span>
		</button>
		<button class="carousel-control-next" type="button" data-bs-target="#landinCarousel" data-bs-slide="next" style="width: 70px !important;">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="visually-hidden">Next</span>
		</button>
	</div>
</div>
@endsection

@section('content')

<section class="collection-1">
	<div class="container">
		<div class="heading-text d-flex flex-column text-center position-relative">
			<h3 class="text-uppercase title mb-4 mt-6">ADINKRA COLLECTION</h3>
			<p class="sub-title w-55 m-auto">{{ !empty($page) ? $page->adinkra_text : 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.' }}</p>
		</div>
	</div>      
</section>

<section class="collection swipper-collection" style="height: 600px;">
	<div class="container h-100">
		<div class="slider-bg position-relative">
			<div class="collection-swiper h-100">
				<div class="content-wrapper  position-relative h-100 ">
					<div class="content-body h-100 mb-5">
						<div class="row position-relative h-100">
							<div class="col-md-6">
								<div class="overlay-left-box">
									<img src="{{ asset('images/ring1_left.png') }}"  class="img-fluid" alt="overlay image">
								</div>
							</div>
							<div class="col-md-6 d-flex justify-content-center flex-column text-center h-100">
								<div class="overlay-right-box">
									<img src="{{ asset('images/ring1.png') }}"  class="img-fluid" alt="Ring image">
								</div>
								<div class="text-overlay m-auto">
									<h3 class="title mb-4 mt-8">{{ !empty($page) ? $page->adinkra_image_heading : 'STONE OF AGES' }}</h3>
									<p class="sub-title  ps-4 pe-4 m-auto mb-1">{{ !empty($page) ? $page->adinkra_image_text : 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.' }}</p>

									<a href="{{ route('products.listing', 'adinkra-jewelry') }}" class="text-sand sweetsand-bold text-uppercase text-decoration-none">Discover</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>   
</section>


<section class="collection rings position-relative">
	<div class="container">
		<div class="rings-swiper swiper">
			<div class="swiper-wrapper justify-content-center">

				@foreach($products as $product)
				<a href="{{ route('products.single', $product->slug) }}"  class="ring-box swiper-slide text-decoration-none text-dark">
					<div class="card border-0" style="width: 17rem;">
						<img src="{{ asset(get_product_thumbnail($product->thumbnail)) }}" class="card-img-top" alt="{{ $product->name }}">
						<div class="card-body text-center">
							<h5 class="card-title sweetsand-regular">{{ Str::limit($product['name'], 22) }}</h5>
							<p class="card-text sweetsand-regular">
								@if($product->attributes_count > 0)
								{{ config('adinkra.currency_code') }}{{ number_format(get_product_attribute_price($product) , 2) }}
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
	</div>
</section>


<section class="collection pt-2">
	<div class="container h-100">
		<div class="row justify-content-center" style="margin-bottom: 10rem!important;">
			<div class="col-md-6 text-center">
				<h5 class="title sweetsand-bold text-gray mb-4">LEGACY JEWELRY COLLECTION</h5>
				<p class="text-gray sweetsand-regular">{{ !empty($page) ? $page->legacy_text : 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.' }}</p>
			</div>
		</div>

		<div class="slider-bg position-relative">
			<div class="collection-swiper swiper h-100">
				<div class="swiper-wrapper">
					<div class="swiper-slide">
						<div class="content-wrapper  position-relative h-100 ">
							<div class="content-body h-100 mb-5">
								<div class="row position-relative h-100">
									<div class="col-md-6">
										<div class="overlay-left-box">
											<img src="{{ asset('images/ring1_left.png') }}"  class="img-fluid" alt="overlay image">
										</div>
									</div>
									<div class="col-md-6 d-flex justify-content-center flex-column text-center h-100">
										<div class="overlay-right-box">
											<img src="{{ asset('images/ring1.png') }}"  class="img-fluid" alt="Ring image">
										</div>
										<div class="text-overlay m-auto">
											<h3 class="title mb-4 mt-8">{{ !empty($page) ? $page->legacy_image_heading : 'STONE OF AGES' }}</h3>
											<p class="sub-title  ps-4 pe-4 m-auto mb-1">{{ !empty($page) ? $page->legacy_image_text : 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.' }}</p>

											<a href="{{ route('products.listing', 'legacy-jewelry') }}" class="text-sand  sweetsand-bold text-uppercase text-decoration-none">Discover</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
{{-- 
					<div class="swiper-slide">
						<div class="content-wrapper  position-relative h-100 ">
							<div class="content-body h-100 mb-5">
								<div class="row position-relative h-100">
									<div class="col-md-6">
										<div class="overlay-left-box">
											<img src="{{ asset('images/rind2_left.png') }}"  class="img-fluid" alt="overlay image">
										</div>
									</div>
									<div class="col-md-6 d-flex justify-content-center flex-column text-center h-100">
										<div class="overlay-right-box">
											<img src="{{ asset('images/flip_ring.png') }}"  class="img-fluid" alt="Ring image">
										</div>
										<div class="text-overlay m-auto">
											<h3 class="title mb-4 mt-8">Best Gold Jewel</h3>
											<p class="sub-title  ps-4 pe-4 m-auto mb-1">{{ !empty($page) ? $page->legacy_image_text : 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.' }}</p>

											<a href="{{ route('products.listing', 'legacy-jewelry') }}" class="text-sand  sweetsand-bold text-uppercase text-decoration-none">Discover</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="swiper-slide">
						<div class="content-wrapper  position-relative h-100 ">
							<div class="content-body h-100 mb-5">
								<div class="row position-relative h-100">
									<div class="col-md-6">
										<div class="overlay-left-box">
											<img src="{{ asset('images/ring3_left.jpg') }}"  class="img-fluid" alt="overlay image">
										</div>
									</div>
									<div class="col-md-6 d-flex justify-content-center flex-column text-center h-100">
										<div class="overlay-right-box">
											<img src="{{ asset('images/ring_down.png') }}"  class="img-fluid" alt="Ring image">
										</div>
										<div class="text-overlay m-auto">
											<h3 class="title mb-4 mt-8">Silver of live</h3>
											<p class="sub-title  ps-4 pe-4 m-auto mb-1">{{ !empty($page) ? $page->legacy_image_text : 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.' }}</p>

											<a href="{{ route('products.listing', 'legacy-jewelry') }}" class="text-sand  sweetsand-bold text-uppercase text-decoration-none">Discover</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> --}}
				</div>

				<div class="swiper-pagination"></div>
			</div>
		</div>
	</div>   
</section>

@if(count($legacyProducts) > 0)
<section class="collection rings position-relative">
	<div class="container">
		<div class="rings-swiper swiper">
			<div class="swiper-wrapper justify-content-center">

				@foreach($legacyProducts as $product)
				<a href="{{ route('products.single', $product->slug) }}"  class="ring-box swiper-slide text-decoration-none text-dark">
					<div class="card border-0" style="width: 17rem;">
						<img src="{{ asset(get_product_thumbnail($product->thumbnail)) }}" class="card-img-top" alt="{{ $product->name }}">
						<div class="card-body text-center">
							<h5 class="card-title sweetsand-regular">{{ Str::limit($product['name'], 22) }}</h5>
							<p class="card-text sweetsand-regular">
								@if($product->attributes_count > 0)
								{{ config('adinkra.currency_code') }}{{ number_format(get_product_attribute_price($product) , 2) }}
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
	</div>
</section>
@endif


<section class=" custom-jewlry">
	<div class="container h-100">
		<div class="row justify-content-center h-100">
			<div class="col-md-3 position-relative">
				<div class="jewlry-box jewlry-box1 ">
					<img src="{{ asset('images/daniela.png') }}" class="img-fluid">
				</div>
				<div class="jewlry-box jewlry-box2 ">
					<img src="{{ asset('images/arteum.png') }}" class="img-fluid">
				</div>
				<div class="jewlry-box jewlry-box3 ">
					<img src="{{ asset('images/bulbul.png') }}" class="img-fluid">
				</div>
			</div>
			<div class="col-md-6 h-100">
				<div class=" d-flex flex-column text-center h-100">
					<span class=" m-auto">
						<h5 class="title text-white text-uppercase mb-4">Custom Jewelry</h5>
						<p class="text-white mb-5 sweetsand-regular">{{ !empty($page) ? $page->custom_text : 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.' }}</p>

						<a href="{{ route('custom-jewelry') }}" class="text-uppercase btn btn-create sweetsand-bold">Create now</a>
					</span>
				</div>
			</div>
			<div class="col-md-3 position-relative">
				<div class="jewlry-box jewlry-box4 ">
					<img src="{{ asset('images/mothers_pride.png') }}" class="img-fluid">
				</div>
				<div class="jewlry-box jewlry-box5 ">
					<img src="{{ asset('images/single3.png') }}" class="img-fluid">
				</div>
				<div class="jewlry-box jewlry-box6 ">
					<img src="{{ asset('images/fire_ring.png') }}" class="img-fluid">
				</div>
			</div>
		</div>
	</div>
</section>

<section class="p-100 mt-5 mb-5 art">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6 text-center">
				<h5 class="title text-gray">ART AND SCULPTURE COLLECTION</h5>
				<p class="text-gray sub-title">{{ !empty($page) ? $page->art_text : 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.' }}</p>
			</div>
		</div>
		<div class="slider-bg position-relative" style="margin: 120px auto;">
			<div class="collection-swiper  h-100">
				<div class="content-wrapper  position-relative h-100 ">
					<div class="content-body h-100 mb-5">
						<div class="row position-relative h-100">
							<div class="col-md-6 d-flex justify-content-center flex-column text-center h-100">
								<div class="overlay-left-box">
									<img src="{{ asset('images/flip_ring.png') }}"  class="img-fluid" alt="Ring image">
								</div>
								<div class="text-overlay m-auto">
									<h3 class="title mb-4 mt-6">{{ !empty($page) ? $page->art_image_heading : 'STONE OF AGES' }}</h3>
									<p class="sub-title  ps-4 pe-4 m-auto mb-1">{{ !empty($page) ? $page->art_image_text : 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.' }}</p>

									<a href="{{ route('products.listing', 'art-pieces') }}" class="text-sand sweetsand-bold text-uppercase text-decoration-none">Discover</a>
								</div>
							</div>
							<div class="col-md-6">
								<div class="overlay-right-box">
									<img src="{{ asset('images/ring1_left.png') }}"  class="img-fluid" alt="overlay image">
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

		</div>

		<div class="row justify-content-center" hidden>
			<div class="col-md-4">
				<div class="card border-0">
					<img src="{{ asset('images/mothers_pride.png') }}" class="card-img-top" alt="Silver plated ring">
					<div class="card-body text-center">
						<h5 class="card-title text-uppercase sweetsand-bold">MOTHERS PRIDE</h5>
						<a href="{{ route('products.listing', 'art-pieces') }}" class="card-text text-decoration-none text-sand text-uppercase sweetsand-regular">Discover</a>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card border-0">
					<img src="{{ asset('images/golden_head.png') }}" class="card-img-top" alt="Silver plated ring">
					<div class="card-body text-center">
						<h5 class="card-title text-uppercase sweetsand-bold">GOLDEN HEAD</h5>
						<a href="{{ route('products.listing', 'art-pieces') }}" class="card-text text-decoration-none text-sand text-uppercase sweetsand-regular">Discover</a>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card border-0">
					<img src="{{ asset('images/fire_ring.png') }}" class="card-img-top" alt="Silver plated ring">
					<div class="card-body text-center">
						<h5 class="card-title text-uppercase sweetsand-bold">Silver plated ring</h5>
						<a href="{{ route('products.listing', 'art-pieces') }}" class="card-text text-decoration-none text-sand text-uppercase sweetsand-regular">Discover</a>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>


@if(count($product_bottom) > 0)
<section class="rings position-relative">
	<div class="container">
		<div class="rings-swiper swiper">
			<div class="swiper-wrapper justify-content-center">
				@foreach($product_bottom as $p_bottom)
				<a href="{{ route('products.single', $p_bottom->slug) }}"  class="ring-box swiper-slide text-decoration-none text-dark">
					<div class="card border-0" style="width: 18rem;">
						<img src="{{ asset(get_product_thumbnail($p_bottom->thumbnail)) }}" class="card-img-top" alt="{{ $p_bottom->name }}">
						<div class="card-body text-center">
							<h5 class="card-title sweetsand-bold">{{ Str::limit($p_bottom['name'], 22) }}</h5>
							<p class="card-text sweetsand-regular">
								@if($p_bottom->attributes_count > 0)
								{{ config('adinkra.currency_code') }}{{ number_format(get_product_attribute_price($p_bottom) , 2) }}
								@else
								{{ config('adinkra.currency_code') }}{{ number_format($p_bottom->price , 2) }}
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
	</div>
</section>
@endif

<section class="digital p-100">
	<div class="container">
		<div class="row">
			<div class="col-md-6 pt-6 pe-5 col-left">
				<h5 class="title mb-4 text-gray text-end">DIGITAL COLLECTION</h5>
				<div class="text-end">
					<p class="sub-title w-50 text-gray  float-end ">{{ !empty($page) ? $page->digital_text : 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.' }}</p>
				</div>
				<div class="clearfix text-end">
					<a href="{{ route('products.listing', 'digital-collections') }}" class="text-uppercase btn btn-outline-primary mt-3 ps-5 pe-5 text-gray sweetsand-bold dborder border-radius-0">Discover</a>
				</div>
			</div>
			<div class="col-md-6 col-right">
				<div class="row mb-3">
					<div class="col-md-5">
						<img src="{{ asset('images/mothers_pride.png') }}" class="img-fluid">
					</div>
					<div class="col-md-5">
						<img src="{{ asset('images/single2.png') }}" class="img-fluid">
					</div>
				</div>
				<div class="row mb-3">
					<div class="col-md-5">
						<img src="{{ asset('images/single-product.png') }}" class="img-fluid">
					</div>
					<div class="col-md-5">
						<img src="{{ asset('images/single3.png') }}" class="img-fluid">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@include('front-end.partials.info')

@include('front-end.partials.subscribe')

@endsection