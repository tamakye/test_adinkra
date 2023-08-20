@extends('admin.layouts.app')
@section('title', 'Coupons')
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
				<div class="btn-group" >
					<a href="{{route('admin.coupons.create')}}" class="btn btn-primary">
						<i class="fa fa-plus"></i>
						Add new coupon
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
						<h3 class="card-title">List of coupons</h3>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<div class="table-responsive">
							<table id="couponTable" class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th>##</th>
										<th>Coupon</th>
										<th>Discount</th>
										<th>Quantity</th>
										<th>Start Date</th>
										<th>End Date</th>
										<th>Apply to</th>
										<th class="text-right">Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($coupons as $coupon)
									<tr>
										<td> {{  $loop->index + 1}} </td>
										<td class="align-middle">{{ $coupon->coupon }}</td>
										<td class="align-middle">{{ number_format($coupon->discount, 2) }}%</td>
										<td class="align-middle">
											@if($coupon->unlimited == 'yes')
											Unlimited
											@else
											{{ $coupon->quantity }}
											@endif
										</td>
										<td class="align-middle">{{ $coupon->start_date->format('d-m-Y H:m') }}</td>
										<td class="align-middle">
											@if($coupon->expires == 'yes')
											Never expired
											@else
											{{ $coupon->end_date->format('d-m-Y H:m') }}
											@endif
										</td>
										<td class="align-middle">
											@if($coupon->apply_on == 'order_amount')
											{{ $coupon->apply_on }} from £{{ $coupon->min_order_amount }}
											@elseif( $coupon->apply_on == 'product')
											{{ $coupon->apply_on }} > <small>{{ $coupon->products->name }}</small>
											@elseif( $coupon->apply_on == 'user')
											{{ $coupon->apply_on }} > <small>{{ $coupon->users->full_name }}</small>
											@elseif( $coupon->apply_on == 'categories')
											{{ $coupon->apply_on }} > <small>{{ $coupon->categories->name }}</small>
											@else
											{{ $coupon->apply_on }}
											@endif
										</td>

										<td class="align-middle">
											<button type="button" class="btn btn-icon float-right m-0" data-toggle="dropdown">
												<i class="fa fa-ellipsis-h"></i>
											</button>

											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" href="{{ route('admin.coupons.edit', $coupon->coupon) }}">
													Edit
												</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item delete-coupon" href="javascript:void(0)" data-coupon="{{ $coupon->coupon }}">
													Delete
												</a>
											</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					<!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog"
aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm modal-dialog-centered">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="deleteModalLabel">Delete coupon</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body modal-body-content">
			<h5>Are you sure you want to delete the coupon <b class="coupon-value"></b></h5>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary proceed-delete" >Proceed!</button>
		</div>
	</div>
</div>
</div>
@endsection

@section('scripts')
<script src="{{asset('dashboard/js/coupons.js')}}"></script>
@endsection