@extends('front-end.layouts.app')

@section('title', 'House of Adinkra')

@section('meta_keywords', 'House of Adinkra')
@section('meta_description', 'House of Adinkra')

@section('house-of-adinkra-status', 'active')

@section('content')

<section class="heritage">
	<div class="container">
		<div class="row">
			<div class="col-md-3 mb-4">
				<img src="{{ asset('images/antoni.png') }}" class="w-100">
			</div>
			<div class="col-md-4 mb-4 p2-80" id="heritage-col">
				<h5 class="title mb-4 text-gray text-capitalize">STORY & HERITAGE</h5>
				<p class="text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.</p>
			</div>
			
			<div class="col-sm-5 mb-4 img-col">
				<img src="{{ asset('images/stamps.png') }}" class="w-100">
			</div>
		</div>
	</div>

	<div class="container heritage-2 p-50">
		<div class="row">
			<div class="col-md-6 mb-3">
				<h1 class="text-gray pe-5  fw-normal">But I must explain to you how all this mistaken idea</h1>
			</div>
			<div class="col-md-6 mb-3">
				<p class="text-gray ps-2">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account and expound the actual teachings of the great explorer of the truth, the master builder of human happiness. No one rejects, dislikes or avoids pleasure itself, because it is pleasure but because those who do not know how pursue pleasur rotationally encounter consequencies that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</p>
			</div>
		</div>
	</div>

</section>

<section class="video-section">
	<div class="elementor-widget-container" data-aos="fade-up" data-aos-duration="3000">
		<div class="ct-video-player btn-video-style1 meta-active " data-wow-delay="ms">
			<div class="ct-video-box w-100">
				<div class="act-video-holder bg-dark"> 
					<img class="img-fluid" decoding="async" src="{{ asset('images/play-bg.png') }}" title="thumbnail" alt="Experience">
				</div> 
				<a class="ct-video-button img-active style1 videoTrigger" src="{{ generateVideoEmbedUrl('https://www.youtube.com/watch?v=6jLUqlUEJhg') }}" data-bs-target="#videoTriggerModal" data-bs-toggle="modal" href="javascript:void(0)"> <i class="fas fa-play"></i></a>
			</div>
		</div>
	</div>
</section>

<section class="pt-5">
	<div class="container">
		<div class="row">
			<div class="col-md-5 mb-3">
				<div class="row">
					<h6 class="text-uppercase text-gray  fw-normal" id="family-value">Our family value</h6>
				</div>
				<div class="row">
					<img src="{{ asset('images/von.png') }}" class="w-100">
				</div>
			</div>
			<div class="col-md-7 mb-3">
				<div class="row">
					<h2 class="text-gray pb-5  fw-normal">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born.</h2><hr>
				</div>
				<div class="row">
					<div class="col-md-6 mb-3">
						<h4 class="value-headings fw-normal text-gray">Passion</h4>
						<p class="text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account and expound the actual teachings of the great explorer of the truth, the master builder of human happiness. No one rejects, dislikes or avoids pleasure itself, because it is pleasure but because those who do not know how pursue pleasur rotationally encounter consequencies that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</p>
					</div>

					<div class="col-md-6 mb-3">
						<h4 class="value-headings fw-normal text-gray">Trust</h4>
						<p class="text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account and expound the actual teachings of the great explorer of the truth, the master builder of human happiness. No one rejects, dislikes or avoids pleasure itself, because it is pleasure but because those who do not know how pursue pleasur rotationally encounter consequencies that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container pt-5 mt-2">
		<div class="row">
			<div class="col-md-8 mb-3">
				<hr class="m-0" style="border:1px solid #70707094;">
				<div class="row pt-2">
					<div class="col-md-6 mb-3">
						<h4 class="value-headings fw-normal text-gray">Love</h4>
						<p class="text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account and expound the actual teachings of the great explorer of the truth, the master builder of human happiness. No one rejects, dislikes or avoids pleasure itself, because it is pleasure but because those who do not know how pursue pleasur rotationally encounter consequencies that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</p>
					</div>
					<div class="col-md-6 mb-3">
						<h4 class="value-headings fw-normal text-gray">Artistry</h4>
						<p class="text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account and expound the actual teachings of the great explorer of the truth, the master builder of human happiness. No one rejects, dislikes or avoids pleasure itself, because it is pleasure but because those who do not know how pursue pleasur rotationally encounter consequencies that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself.</p>
					</div>
				</div>
			</div>
			<div class="col-md-4 mb-3" style="height: 25.5rem;">
				<img src="{{ asset('images/arteum.png') }}" class="w-100" style="height: 100%; object-fit: cover;">
			</div>
		</div>
	</div>

	<div class="container-fluid mt-5 p-0">
		<img src="{{ asset('images/chambers.png') }}" class="w-100">
	</div>

</section>


@include('front-end.partials.info')
@include('front-end.partials.subscribe')

<div class="modal fade" id="videoTriggerModal" tabindex="-1" role="dialog" aria-labelledby="videoTriggerModal" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<button type="button" class="close btn-round btn-primary" data-bs-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<div class="embed-responsive-frame">
				<iframe class="embed-responsive-item" src="" allowfullscreen></iframe>
			</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	$(function(){
		$(document).on('click', '.videoTrigger', function(e){
			e.preventDefault();
			var theModal = $(this).data("bs-target");
			var videoSRC = $(this).attr("src");
			var videoSRCauto = videoSRC + "?autoplay=1";
			$(theModal + ' iframe').attr('src', videoSRCauto);
			$(theModal).on('hidden.bs.modal', function(e) {
				$(theModal + ' iframe').attr('src', '');
			});
		})
	})
</script>
@endsection