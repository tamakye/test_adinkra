@extends('front-end.layouts.app')

@section('title', 'House of Adinkra')

@section('meta_keywords', 'House of Adinkra')
@section('meta_description', 'House of Adinkra')

@section('house-of-adinkra', 'active')

@section('content')
<section class="house-of-adinkra">
	<div class="container p-80" id="house-adinkra">
		<div class="row" id="house">
			<div class="col-md-8">
				<img src="{{ asset('/images/karly.png') }}" id="img_karly" class="w-100">
			</div>
			<div class="col-md-4" id="house_of_adinkra">
				<h5 class="title text-gray text-uppercase">House of Adinkra</h5>
				<p class="text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.</p>
			</div>
		</div>
	</div>
</section>

<section class="Adinkra-Collection">
	<div class="container mt-5" id="adinkra">
		<div class="row">
			<div class="col-md-5" id="adinkra-text">
				<h4 class="text-uppercase text-gray">Adinkra Collection</h4>
				<p class="text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account and expound the actual teachings of the great explorer of the truth, the master builder of human happiness. No one rejects, dislikes or avoids pleasure itself, because it is pleasure but because those who do not know how pursue pleasur rotationally encounter consequencies that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</p>
				<button class="text-white" id="discover-button">DISCOVER</button>
			</div>
			<div class="col-md-3" id="adinkra-images-col">
				<div class="row">
					<img src="{{ asset('images/alvaro.png') }}" class="w-100" height="280px">
				</div>
				<div class="row" style="padding-top: 20px;">
					<img src="{{ asset('images/lewis.png') }}" width="300px" height="241px">
				</div>
			</div>

			<div class="col-md-4">
				<img src="{{ asset('images/scott.png') }}" class="w-100">
			</div>
		</div>
	</div>
</section>

<section class="Fashion-Jewelry">
	<div class="container-fluid mt-5">
		<div class="row">
			<div class="col-md-7">
				<img src="{{ asset('images/kateryna.png') }}" class="w-100">
			</div>
			<div class="col-md-5" id="fashion-jewelry-text">
				<h4 class="text-uppercase text-gray">Fashion Jewelry</h4>
				<p class="text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account and expound the actual teachings of the great explorer of the truth, the master builder of human happiness. No one rejects, dislikes or avoids pleasure itself, because it is pleasure but because those who do not know how pursue pleasur rotationally encounter consequencies that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</p>
				<button class="text-white" id="discover-button">DISCOVER</button>
			</div>
		</div>
	</div>

</section>

<section>
	<div class="container mt-5" id="customer-jewelry">
		<div class="row">
			<div class="col-md-5" id="customer-jewelry-text">
				<h4 class="text-uppercase text-gray">Custom Jewelry</h4>
				<p class="text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account and expound the actual teachings of the great explorer of the truth, the master builder of human happiness. No one rejects, dislikes or avoids pleasure itself, because it is pleasure but because those who do not know how pursue pleasur rotationally encounter consequencies that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</p>
				<button class="text-white" id="discover-button">DISCOVER</button>
			</div>
			<div class="col-md-7">
				<div class="row">
					<div class="col-md-6" id="ringer">
						<div class="ringer-fixed">
							<img src="{{ asset('images/maksim.png') }}" class="w-100" height="280px">
						</div>
					</div>

					<div class="col-md-6">
						<div class="ringer-fixed">
							<img src="{{ asset('images/daniela.png') }}" class="w-100" height="280px">
						</div>
					</div>
				</div>
				<div class="row pt-4">
					<img src="{{ asset('images/bulbul.png') }}" class="w-100">
				</div>
			</div>
		</div>
	</div>
</section>

<section class="art-piece-section">
	<div class="container mt-5" id="art-piece">
		<div class="row">
			<div class="col-md-5" id="art-piece-col">
				<h4 class="text-uppercase text-gray">Art Pieces</h4>
				<p class="text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account and expound the actual teachings of the great explorer of the truth, the master builder of human happiness. No one rejects, dislikes or avoids pleasure itself, because it is pleasure but because those who do not know how pursue pleasur rotationally encounter consequencies that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</p>
				<button class="text-white" id="discover-button">DISCOVER</button>
			</div>
			<div class="col-md-7">
				<img src="{{ asset('images/kutsaiev.png') }}" class="w-100">
			</div>
		</div>
	</div>

</section>

@include('front-end.partials.info')
@include('front-end.partials.subscribe')

@endsection

@section('scripts')
<script type="text/javascript">
	// $(function(){
	// })
</script>
@endsection