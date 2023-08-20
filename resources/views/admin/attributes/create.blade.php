@extends('admin.layouts.app')
@section('title', 'Product Attributes')

@section('site-pages-has-treeview','has-treeview')
@section('product_menu_open','menu-open')
@section('attributes_active','active')

{{-- main content --}}
@section('content')
<div class="content-header">
	<div class="container-fluid">
		<div class="card">
			<div class="card-body d-flex mb-2">
				<small class="text-uppercase border-bottom title">Product attributes</small>

				<a href="{{ route('attributes') }}" class="btn btn-primary btn-sm ml-auto"><i data-feather="corner-down-left"></i> Back</a>
			</div>
		</div>
	</div>
</div>
<div class="content">
	<div class="container-fluid">
		
		<form id="attributesForm" action="{{ route('attributes.save') }}"  method="post" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="button_type" id="save_status" value="save">

			<div class="row flex-column-reverse flex-md-row flex-lg-row">

				<div class="col-md-9">
					<div class="card" id="add-new-attribute">
						@if($errors->any())
						<div class="alert alert-danger pt-3">
							<ul class="">
								<i class="fas fa-times-circle"></i> All fields are required. The name, titles, slugs, colours and thumbnail fields are required.
						{{-- @foreach($errors->all()  as $error)
						<li>{{ $error }}</li>
						@endforeach --}}
					</ul>
				</div>
				@else
				<div class="alert alert-info pt-3">
					<ul class="">
						<i class="fas fa-exclamation-triangle"></i> All fields are required. The name, titles, slugs, colours and thumbnail fields are required.
					</ul>
				</div>
				@endif

				<div class="card-header">
					<h5 class="font-weight-bolder">New attribute</h5>
				</div>
				<div class="card-body">

					<div class="form-group mb-2">
						<label class="form-label" for="name">Name</label>
						<input type="text" class="form-control seo_name @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required="" id="name">
						@error('name') 
						<span class="invalid-feedback">
							{{ $message }}
						</span>
						@enderror
					</div>

					<div class="form-group mb-2">
						<label class="form-label" for="attribute_slug">Slug <small>Optional</small></label>
						<input type="text" class="form-control slug  @error('attribute_slug') is-invalid @enderror" name="attribute_slug" value="{{ old('attribute_slug') }}" id="attribute_slug">
						@error('attribute_slug') 
						<span class="invalid-feedback">
							{{ $message }}
						</span>
						@enderror
						<small>The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens</small>
					</div>

					<div class="row flex-column mt-4">
						<div class="table-responsive"> 
							<table id="attributeTable" class="table table-bordered"> 
								<thead class="bg-primary text-white"> 
									<tr> 
										<th class="text-center">#</th> 
										<th class="text-center">Is default</th> 
										<th class="text-center">Title</th> 
										<th class="text-center">Slug</th> 
										<th class="text-center">Colour</th> 
										<th class="text-center">Image</th> 
										<th class="text-center">Remove </th> 
									</tr> 
								</thead> 
								<tbody id="tbody"> 
									<input type="hidden" class="count_values" value="{{ old('title') ? count(old('title')) : 0 }}">

									@if(count($errors) > 0)
									@for($i = 0; $i < count(old('title')); $i++)
									<tr class="tableRow" id="{{$i}}">
										<td class="row-index"> <span>{{$i + 1}}</span></td>
										<td class="text-center">
											<div class="custom-control custom-radio">
												<input type="radio" id="${rowIndex}" name="default" class="custom-control-input default" 
												{{ $i == old('default') ? 'checked' : ($i + 1 == 1 ? 'checked' : '') }}
												value="{{$i}}">
												<label class="custom-control-label" for="{{ $i }}"></label>
											</div>
										</td>
										<td><input type="text" name="title[]" class="form-control" value="{{ old('title')[$i] }}"></td>
										<td><input type="text" name="slug[]" class="form-control slug" id="{{ $i }}" value="{{ old('slug')[$i] }}"></td>
										<td><input type="color" name="colour[]" class="form-control" value="{{ old('colour')[$i] }}"></td>
										<td>
											<div class="preview m-auto"  style="width: 50px !important">
												<img class="img-thumbnail cursor image_preview" src="{{ asset(default_placeholder()) }}" alt="Thumbnail image" >
											</div>
											<div class="custom-file  mt-4" style="display: none;">
												<input type="file" name="thumbnail[]" class="custom-file-input thumbnail" accept=".png, .jpg, .jpeg" disabled="">
											</div>
										</td>
										<td class="text-center">
											<a href="javascript:void(0)" class="text-danger removeRow"><i class="fas fa-trash"></i></a>
										</td>
									</tr>
									@endfor
									@endif
								</tbody> 
							</table> 
						</div> 
						<div>
							<button type="button" class="btn btn-sm btn-primary float-left" id="addBtn" > 
								Add new attribute 
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card mb-2 pb-2">
				<div class="card-header descriptions">
					Publish
				</div>
				<div class="d-flex justify-content-between  m-2">
					<button type="submit" class="btn btn-sm btn-primary save_btn" data-status="save"> <i data-feather="save"></i> Save</button>
					<button type="submit" class="btn btn-sm btn-success ml-auto save_btn" data-status="edit"> <i data-feather="edit"></i>  Save & Continue</button>
				</div>
			</div>

			<div class="card mb-2 pb-2">
				<div class="card-header descriptions">
					Status
				</div>

				<div class="m-2">
					<select class="form-control select2" name="status" id="status" required="">
						@foreach(status() as $status)
						<option value="{{ $status }}" {{ old('status' == $status ? 'selected' : '') }}>{{ $status }}</option>
						@endforeach>
					</select>
					@error('status') 
					<span class="invalid-feedback">
						{{ $message }}
					</span>
					@enderror
				</div>
			</div>
		</div>
	</div>
</form>

</div>
</div>
@endsection


@section('scripts')
<script src="{{ asset('dashboard/js/products.js') }}" type="text/javascript"></script>
<script src="{{ asset('dashboard/js/attribute.js') }}" type="text/javascript"></script>
@endsection