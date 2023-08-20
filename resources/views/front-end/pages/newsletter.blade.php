@extends('front-end.layouts.app')

@section('title', 'Subscribe for our newslettersa')

@section('meta_keywords', 'Subscribe to our mailing list to receive newslettersa')
@section('meta_description', 'adinkra, adinkra newslettersa')

@section('newsletteStatus', 'active')

@section('styles')
<style>
	label{
		display: initial;
	}
</style>
@endsection

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
				<h5 class="title text-gray text-uppercase">Discover the 3dinkra world with </h5>
				<p class="sub-title text-gray">Keep up-to-date with our unique collection and new launches.</p>
			</div>
		</div>


		<form action="{{ route("newsletter") }}" method="post">
			@csrf

			<div class="row justify-content-center mb-5">
				<div class="col-md-8 row">
					<div class="form-group col-md-12 mb-3">
						<label for="title">Title*</label>
						<div class="d-flex justify-content-between">
							<div class="custom-control custom-radio">
								<input type="radio" id="customRadio1" name="title" class="custom-control-input" value="Ms.">
								<label class="custom-control-label" for="customRadio1">Ms.</label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" id="customRadio2" name="title" class="custom-control-input" value="Mr.">
								<label class="custom-control-label" for="customRadio2">Mr.</label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" id="customRadio3" name="title" class="custom-control-input" value="Mrs.">
								<label class="custom-control-label" for="customRadio3">Mrs.</label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" id="customRadio4" name="title" class="custom-control-input" value="Prefer not to say">
								<label class="custom-control-label" for="customRadio4">Prefer not to say</label>
							</div>
							<div class="custom-control custom-radio">
								<input type="radio" id="customRadio4" name="title" class="custom-control-input" value="MX">
								<label class="custom-control-label" for="customRadio4">MX</label>
							</div>
						</div>
						@error('title')
						<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group col-md-6 mb-3">
						<label class="text-uppercase">First name*</label>
						<input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required>
						@error('first_name')
						<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group col-md-6 mb-3">
						<label class="text-uppercase"> last name*</label>
						<input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required>
						@error('last_name')
						<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group col-md-6 mb-3">
						<label class="text-uppercase">email*</label>
						<input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
						@error('email')
						<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group col-md-6 mb-3">
						<label class="text-uppercase">country*</label>
						<select class="form-control select2" name="country" required>
							<option></option>
							@foreach($countries as $country)
							<option value="{{ $country->id }}" {{ old('country') == $country->id ? 'selected' : ''}}>{{ $country->name }}</option>
							@endforeach
						</select>
						@error('country')
						<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
					<div class="form-group col-md-12 mb-3">
						<p>Having analyzed and understood the Privacy Information Notice, I declare that I am over 16 years of age and:</p>

						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" name="agreed" id="agreed"  @checked(old('agreed'))>
							<label class="custom-control-label" for="agreed">I agree to the analysis of my interest, preferences and purchasing habits based on my purchases made at 3DINKRA.</label>
						</div>

						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" name="consent" id="consent" @checked(old('consent'))>
							<label class="custom-control-label" for="consent">I consent to the receiving marketing communications from 3DINKRA regarding product care, services, events and new collections.*</label>
						</div>
						@error('consent')
						<span class="invalid-feedback">{{ $message }}</span>
						@enderror

					</div>

					
					<div class="form-group col-md-12 mb-3 mt-4 text-center">
						<button type="submit" class="btn btn-primary w-50 bg-gray border-0">SUBMIT</button>
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