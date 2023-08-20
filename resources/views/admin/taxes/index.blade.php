@extends('admin.layouts.app')
@section('title', 'Taxes | Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('product_menu_open','menu-open')
@section('taxes_active','active')

@section('content')

<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Taxes</h1>
			</div>
			<div class="col-sm-6 text-right">
				<div class="btn-group">
					
					<a href="{{route('admin.taxes.create')}}" class="btn btn-primary">
						<i class="fa fa-plus"></i>
						Add new tax
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
						<h3 class="card-title">List of taxes</h3>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<div class="table-responsive">
							<table id="productsTable" class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th>##</th>
										<th>Tax</th>
										<th>Rate</th>
										<th class="text-right">Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($taxes as $tax)
									<tr>
										<td> {{  $loop->index + 1}} </td>
										<td class="align-middle">{{ $tax->tax_name }}</td>
										<td class="align-middle">{{ number_format($tax->tax_percent, 2) }}</td>
										<td class="align-middle">
											<button type="button" class="btn btn-icon float-right m-0" data-toggle="dropdown">
												<i class="fa fa-ellipsis-h"></i>
											</button>

											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" href="{{ route('admin.taxes.edit', $tax->tax_code) }}">
													Edit
												</a>
												<div class="dropdown-divider"></div>
												<a class="dropdown-item text-danger " href="javascript:void(0)" data-slug="{{ $tax->slug }}">
													Move to bin
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

<div class="modal fade" id="shippingModal" tabindex="-1" role="dialog"
aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm modal-dialog-centered">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalCenteredLabel">Shipping countries</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body modal-body-content">

		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>
</div>
@endsection

@section('scripts')
<script src="{{asset('js/shipping.js')}}"></script>
@endsection