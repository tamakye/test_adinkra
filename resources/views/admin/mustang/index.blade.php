@extends('dashboard.layouts.app')
@section('title', 'Mustang labels | Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('product_menu_open','menu-open')
@section('mustang_active','active')

@section('content')

<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Mustang labels</h1>
			</div>
			<div class="col-sm-6 text-right">
				<div class="btn-group">
					<a href="{{route('admin.mustang.create')}}" type="button" class="btn btn-primary">
						<i class="fa fa-plus"></i>
						Add new label
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
						<h3 class="card-title">List of labels</h3>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<div class="table-responsive">
							<table id="productsTable" class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th>##</th>
										<th>Lable name</th>
										<th>Code</th>
										<th>Protected products</th>
										<th>Status</th>
										<th class="text-right">Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($labels as $label)
									<tr>
										<td> {{  $loop->index + 1}} </td>
										<td class="align-middle">{{ $label->name }}</td>
										<td class="align-middle">{{ $label->code }}</td>
										<td>
											{{ count($label->products) }}
										</td>
										<td class="align-middle">
											@if($label->status)
											Active
											@else
											disabled
											@endif
										</td>
										<td class="align-middle">
											<button type="button" class="btn btn-icon float-right m-0" data-toggle="dropdown">
												<i class="fa fa-ellipsis-h"></i>
											</button>

											<div class="dropdown-menu dropdown-menu-right">
												<a class="dropdown-item" href="{{ route('admin.mustang.edit', $label->code) }}">
													Edit
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