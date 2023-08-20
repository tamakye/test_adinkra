@extends('admin.layouts.app')
@section('title', 'New coupon')
@section('site-pages-has-treeview','has-treeview')
@section('product_menu_open','menu-open')
@section('coupons_active','active')

@section('content')

<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Coupons</h1>
			</div>
			<div class="col-sm-6 text-right">
				<div class="btn-group">
					<a href="{{route('admin.coupons')}}" type="button" class="btn btn-primary">
						<i class="fa fa-previous"></i>
						Back
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Create new coupon</h3>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<form action="{{ route('admin.coupons.create') }}" method="post">
							@csrf
							<div class="row">
								<div class="col-md-6">
									<div class="form-group refresh-coupon" disabled>
										<label for="coupon_code" class="d-flex justify-content-between">Coupon code <a href="javascript:void(0)" class="generate-coupon">Generate</a></label>
										<input type="text" name="coupon_code" class="form-control" value="{{ old('coupon_code') ?? get_coupon() }}" required>
										@error('coupon_code')
										<span class="invalid-feedback">
											{{ $message }}
										</span>
										@enderror
										<small class="mt-2">Customers will enter this coupon code when they checkout.</small>
									</div>

									<div class="form-group">
										<div class="custom-control custom-checkbox mb-2">
											<input type="checkbox" class="custom-control-input" id="unlimited"  name="unlimited" {{ old('unlimited') ? 'checked' : 'checked' }} value="{{ old('unlimited') ?? 'yes' }}">
											<label class="custom-control-label" for="unlimited" >Unlimited</label>
										</div>


										<div class="show-quantity" style="display: none;">
											<label for="quantity">Enter quantity</label>
											<input type="number" name="quantity" class="form-control" value="{{ old('quantity') ?? 1 }}" min="1">
											@error('quantity')
											<span class="invalid-feedback">
												{{ $message }}
											</span>
											@enderror
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-6">
											<label for="discount">Discount</label>
											<div class="input-group">
												<input type="number" class="form-control" name="discount" value="{{ old('discount') }}" min="0" step="0.01" required="">
												<div class="input-group-append">
													<span class="input-group-text">%</span>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<label for="apply_on">Apply on</label>
											<select class="form-control select2" name="apply_on" id="apply_on" required>
												<option value="all_orders">All orders</option>
												<option value="order_amount">Order amount from</option>
												<option value="product">Product</option>
												{{-- <option value="categories">Product categories</option> --}}
												<option value="user">User</option>
											</select>
										</div>
									</div>

									<div class="form-group">
										<input type="number" name="order_amount" class="form-control apply_on_fields  mb-2" value="{{ old('order_amount') ?? 0 }}" min="0" placeholder="Order amount" hidden id="order_amount">
										@error('order_amount')
										<span class="invalid-feedback">
											{{ $message }}
										</span>
										@enderror

										<div id="order_product" class="apply_on_fields" hidden >
											<select class="form-control select2 mb-2" name="product"  style="width: 100%;">
												<option value="" selected hidden disabled>Select product</option>
												@foreach($products as $product)
												<option value="{{ $product->id }}">{{ $product->name }}</option>
												@endforeach
											</select>
											@error('product')
											<span class="invalid-feedback">
												{{ $message }}
											</span>
											@enderror
										</div>

										<div id="order_category" class="apply_on_fields" hidden >
											<select class="form-control apply_on_fields select2 mb-2" name="category" style="width: 100%;">
												<option value="" selected hidden disabled>Select category</option>
												@foreach($categories as $category)
												<option value="{{ $category->id }}">{{ $category->name }}</option>
												@endforeach
											</select>
											@error('category')
											<span class="invalid-feedback">
												{{ $message }}
											</span>
											@enderror
										</div>

										<div id="user" class="apply_on_fields" hidden >
											<select class="form-control apply_on_fields select2 mb-2" name="user" style="width: 100%;">
												<option value="" selected hidden disabled>Select user</option>
												@foreach($users as $user)
												<option value="{{ $user->id }}">{{ $user->full_name }}</option>
												@endforeach
											</select>
											@error('user')
											<span class="invalid-feedback">
												{{ $message }}
											</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-1">
								</div>
								<div class="col-md-5">
									<div class="form-group row">
										<div class="col-md-6">
											<label for="start_date">Start date</label>
											<input  type="text" id="start_date" class="form-control datepicker" name="start_date" autocomplete="off" value="{{ old('start_date') }}" required>
											@error('start_date')
											<span class="invalid-feedback">
												{{ $message }}
											</span>
											@enderror
										</div>
										<div class="col-md-6">
											<label for="end_date">End date</label>
											<input  type="text" id="end_date" class="form-control datepicker" name="end_date" autocomplete="off" value="{{ old('end_date') }}" required>
											@error('end_date')
											<span class="invalid-feedback">
												{{ $message }}
											</span>
											@enderror
										</div>
									</div>

									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="expires" name="expires" value="yes" {{ old('expires') ? 'checked' : '' }}>
										<label class="custom-control-label" for="expires">Never expired</label>
									</div>

									<hr>

									<div class="form-group d-flex">
										<button type="submit" class="btn btn-primary ml-auto">Save</button>
									</div>
								</div>
							</div>
						</form>
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script src="{{asset('dashboard/js/coupons.js')}}"></script>
@endsection