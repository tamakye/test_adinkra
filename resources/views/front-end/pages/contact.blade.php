@extends('front-end.layouts.app')

@section('title', 'Contact us')

@section('meta_keywords', 'Contact us')
@section('meta_description', 'Contact us')

@section('contactStatus', 'active')

@section('content')
<div class="container">
	<section class="">
		<div class="cover-img">
			<img src="{{ asset('images/hand.png') }}" class="w-100">
		</div>
	</section>

	<section>
		<div class="row justify-content-center">
			<div class="col-md-6 pt-5 pe-5 text-center">
				<h5 class="title mb-4 text-gray text-capitalize">CONTACT US</h5>
				<p class="sub-title text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.</p>
			</div>
		</div>

		<div class="row justify-content-center mt-5">
			<div class="col-md-3 text-center">
				<h5 class="title mb-4 text-gray text-capitalize">EMAIL US</h5>
				<p class="sub-title text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.</p>
			</div>
			<div class="col-md-3 text-center">
				<h5 class="title mb-4 text-gray text-capitalize">CALL US</h5>
				<p class="sub-title text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.</p>
			</div>
			<div class="col-md-3 text-center">
				<h5 class="title mb-4 text-gray text-capitalize">FIND US</h5>
				<p class="sub-title text-gray">But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.</p>
			</div>
		</div>


		<form action="{{ route("contact") }}" method="post">
			@csrf

			<div class="row justify-content-center mt-5 mb-5">
				<div class="col-md-6">
					<div class="form-group mb-4">
						<label></label>
						<input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="NAME" required>
						@error('name')
						<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group mb-4">
						<label></label>
						<input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="EMAIL" required>
						@error('email')
						<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group mb-4">
						<label></label>
						<textarea type="text" class="form-control" name="message" placeholder="MESSAGE" rows="7" required>{{ old('message') }}</textarea>
						@error('message')
						<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group mb-4">
						<button type="submit" class="btn btn-primary w-100 bg-gray border-0">SUBMIT</button>
					</div>
				</div>
			</div>
		</form>
	</section>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
	// $(function(){
	// })
</script>
@endsection