@extends('front-end.layouts.app')

@section('title', 'STORY & HERITAGE')

@section('meta_keywords', 'STORY & HERITAGE')
@section('meta_description', 'STORY & HERITAGE')

@section('heritage', 'active')

@section('content')
<section class="heritage">
	<div class="container p-80">
		<div class="row">
			<div class="col-md-3">
				<img src="{{ asset('images/antoni.png') }}" class="w-100">
			</div>
			<div class="col-md-4" id="heritage-col">
				<h5 class="title mb-4 text-gray text-capitalize">STORY & HERITAGE</h5>
				<p class="text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.</p>
			</div>
			
			<div class="col-sm-5">
				<img src="{{ asset('images/stamps.png') }}" class="w-100">
			</div>
		</div>
	</div>

	<div class="container p-50">
		<div class="row">
			<div class="col-md-6">
				<h2 class="text-gray">But I must explain to you how all this mistaken idea.</h2>
			</div>
			<div class="col-md-6">
				<p class="text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account and expound the actual teachings of the great explorer of the truth, the master builder of human happiness. No one rejects, dislikes or avoids pleasure itself, because it is pleasure but because those who do not know how pursue pleasur rotationally encounter consequencies that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</p>
			</div>
		</div>
	</div>

</section>

<section class="video-section">
	<div class="container-fluid">
		<div class="heritage-video">
			<img src="{{ asset('images/stamps.png') }}" class="w-100">
		</div>
	</div>
</section>

<section class="pt-5">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="row">
					<h6 class="text-uppercase text-gray" id="family-value">Our family value</h6>
				</div>
				<div class="row">
					<img src="{{ asset('images/von.png') }}" class="w-100">
				</div>
			</div>
			<div class="col-md-8">
				<div class="row">
					<h2 class="text-gray pb-5">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born.</h2><hr>
				</div>
				<div class="row">
					<div class="col-md-6">
						<h4 class="value-headings text-gray">Passion</h4>
						<p class="text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account and expound the actual teachings of the great explorer of the truth, the master builder of human happiness. No one rejects, dislikes or avoids pleasure itself, because it is pleasure but because those who do not know how pursue pleasur rotationally encounter consequencies that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</p>
					</div>

					<div class="col-md-6">
						<h4 class="value-headings text-gray">Trust</h4>
						<p class="text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account and expound the actual teachings of the great explorer of the truth, the master builder of human happiness. No one rejects, dislikes or avoids pleasure itself, because it is pleasure but because those who do not know how pursue pleasur rotationally encounter consequencies that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container pt-5 mt-2">
		<div class="row">
			<div class="col-md-8">
				<hr class="m-0">
				<div class="row pt-2">
					<div class="col-md-6">
						<h4 class="value-headings text-gray">Love</h4>
						<p class="text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account and expound the actual teachings of the great explorer of the truth, the master builder of human happiness. No one rejects, dislikes or avoids pleasure itself, because it is pleasure but because those who do not know how pursue pleasur rotationally encounter consequencies that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</p>
					</div>
					<div class="col-md-6">
						<h4 class="value-headings text-gray">Artistry</h4>
						<p class="text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account and expound the actual teachings of the great explorer of the truth, the master builder of human happiness. No one rejects, dislikes or avoids pleasure itself, because it is pleasure but because those who do not know how pursue pleasur rotationally encounter consequencies that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<img src="{{ asset('images/arteum.png') }}" class="w-100">
			</div>
		</div>
	</div>

	<div class="container-fluid mt-5">
		<img src="{{ asset('images/chambers.png') }}" class="w-100">
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