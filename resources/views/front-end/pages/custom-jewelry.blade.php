@extends('front-end.layouts.app')

@section('title', 'Custom jewelry')

@section('meta_keywords', 'Custom jewelry, adinkra')
@section('meta_description', 'Custom jewelry')

@section('custom-jewelry-status', 'active')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/jquery-upload/image-uploader.min.css') }}">
@endsection

@section('content')

<section class="jewelry">
	<div class="container">
		<div class="row top mb-4">
			<div class="col-md-4 mb-4 " id="heritage-col">
				<h1 class="title mb-4 text-gray text-capitalize">CRAFT YOUR CUSTOM JEWELRY</h1>
				<p class="text-gray">{{ !empty($page) ? $page->custom_text : 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I.' }}</p>
			</div>
			
			<div class="col-sm-8 mb-4 img-col p-0">
				<img src="{{ asset('images/jewelry.png') }}" class="w-100">
			</div>
		</div>

		<form action="{{ route("custom-jewelry") }}" method="post" enctype="multipart/form-data">
			@csrf
			<div class="row">
				<div class="col-md-7 mb-3">
					<div class="row justify-content-center mb-5">
						<div class="form-group col-md-6 mb-3">
							<label class="text-uppercase text-start">First name*</label>
							<input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
							@error('first_name')
							<span class="invalid-feedback">{{ $message }}</span>
							@enderror
						</div>
						<div class="form-group col-md-6 mb-3">
							<label class="text-uppercase text-start"> last name*</label>
							<input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
							@error('last_name')
							<span class="invalid-feedback">{{ $message }}</span>
							@enderror
						</div>
						
						<div class="form-group col-md-6 mb-3">
							<label class="text-uppercase text-start">country*</label>
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
						<div class="form-group col-md-6 mb-3">
							<label class="text-uppercase text-start">Phone</label>
							<input type="tel" class="form-control" name="phone" value="{{ old('phone') }}">
							@error('phone')
							<span class="invalid-feedback">{{ $message }}</span>
							@enderror
						</div>

						<div class="form-group col-md-12 mb-3">
							<label class="text-uppercase">Schedule appointment</label>
							<input type="text" class="form-control datetime" name="appointment" required value="{{ old('appointment') }}" autocomplete="off">
							@error('appointment')
							<span class="invalid-feedback">{{ $message }}</span>
							@enderror
						</div>
						<div class="form-group col-md-12 mb-3">
							<label class="text-uppercase text-start">Other details</label>
							<textarea class="form-control" name="other_details" rows="4">{{ old('other_details') }}</textarea>
							@error('other_details')
							<span class="invalid-feedback">{{ $message }}</span>
							@enderror
						</div>

						<div class="form-group col-md-12 mb-3 mt-4 text-center">
							<button type="submit" class="btn btn-primary w-100 bg-gray border-0">SUBMIT</button>
						</div>
					</div>
				</div>
				<div class="col-md-5 mb-3">
					<div class="box">
						<h6 class=" text-gray">UPLOAD YOUR SKETCHES</h6>

						<div class="input-images-1" style="padding-top: .5rem;"></div>

						{{-- <div class="box-body">
							<div class="needsclick dropzone" id="document-dropzone">
								<div class="fallback">
									<input name="file" type="file" multiple />
								</div>
							</div>
						</div> --}}
						<small class="text-muted">You can select multiple files. Click on <i>submit</i> to upload.</small><br>
						@error('images')
						<span class="invalid-feedback">{{ $message }}</span>
						@enderror
					</div>
				</div>
			</div>

		</form>
	</div>

</section>


@endsection

@section('scripts')
<script src="{{ asset('plugins/jquery-upload/image-uploader.min.js') }}"></script>

<script type="text/javascript">

	$('.input-images-1').imageUploader({
		extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg'],
		mimes: ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'],
		maxFiles: 5
	});
	$('.upload-text').html('<i class="fas fa-upload"></i> <span class="text-uppercase text-center">Drag &amp; Drop files here <br> or <br> <span class="bg-gray text-white pt-1 pb-1">browse</span> </span>').addClass('text-muted');
</script>
@endsection