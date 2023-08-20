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
			<div class="card-body">
				<div class="d-flex mb-2">
					<small class="text-uppercase border-bottom title">Product attributes <span class="badge bg-dark">{{ count($product_attributes)}}</span></small>

					<a href="{{ route('attribute.create') }}" class="ml-auto btn btn-primary"><i data-feather="plus"></i> New attribute</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="content">
	<div class="container-fluid">
		
		<div class="card">
			<div class="card-header">
				<h5 class="font-weight-bolder">Attribute list</h5>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-hover display">
						<thead>
							<tr>
								<th>##</th>
								<th>Attribute</th>
								<th>Slug</th>
								<th>Values</th>
								<th>Date</th>
								<th>Status</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($product_attributes as $attribute)
							<tr>
								<td>{{ $loop->index + 1 }}</td>
								<td>
									<a href="{{ route('attributes.edit', $attribute->slug) }}">{{ $attribute->name  }}</a>
								</td>
								<td>{{ $attribute->slug }}</td>
								<td>{{ $attribute->attributevalues_count }}</td>
								<td>{{ $attribute->created_at->diffForHumans() }}</td>
								<td>{{ $attribute->status }}</td>
								<td class="text-center">
									<a href="{{ route('attributes.edit', $attribute->slug) }}" class="text-primary mr-2"><i class="fas fa-pencil"></i></a>
									{{-- <a href="javascript:void(0)" class="text-primary"><i class="fas fa-trash"></i></a> --}}
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection


@section('footerContent')

@endsection