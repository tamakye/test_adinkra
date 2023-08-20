@extends('admin.layouts.app')
@section('title', 'All products | Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('product_menu_open','menu-open')
@section('products_active','active')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Products</h1>
            </div>
            <div class="col-sm-6 text-right">
                <div class="btn-group">
                    <a href="{{route('add-product')}}" type="button" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        Add new product
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon"
                        data-toggle="dropdown">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{route('add-product')}}">
                            <i class="fa fa-plus"></i>
                            Add new product
                        </a>
                        {{-- <a class="dropdown-item" href="{{route('admin.products.create')}}">
                            <i class="fa fa-upload"></i>
                            Upload CSV file
                        </a> --}}
                    </div>
                </div>
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
                        <h3 class="card-title">Product list</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <strong>{{ session()->get('error') }}</strong>
                    </div>

                    @endif
                    <div class="row mb-3">
                        <div class="dropdown col-md-2 pt-1">
                            <button class="btn btn-primary btn-sm dropdown-toggle"
                            type="button" id="bulkAction" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" disabled>Bulk actions</button>
                            <div class="dropdown-menu" aria-labelledby="bulkAction">
                                <a class="dropdown-item bulkAction" href="#!" data-status="publish" data-action="publish">Publish</a>
                                <a class="dropdown-item bulkAction" href="#!" data-status="draft" data-action="draft">Mark as draft</a>
                                {{-- <a class="dropdown-item bulkAction" href="#!" data-status="protect" data-action="Password protect">Protect with code</a> --}}
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item bulkAction" href="#!" data-status="delete" data-action="delete">Delete</a>
                                {{-- <a class="dropdown-item bulkAction" href="#!" data-status="unprotect" data-action="unprotect">Remove protected code</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="productsTable" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkAll">
                                            <label class="custom-control-label" for="checkAll"></label>
                                        </div>

                                    </th>
                                    <th><i class="fas fa-photo"></i></th>
                                    <th>Product Name</th>
                                    <th>Collection</th>
                                    <th>SKU</th>
                                    <th>Stock</th>
                                    <th>Price</th>
                                    <th>Categories</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input single_check" id="single_check{{ $product->slug }}" data-id="{{ $product->id }}">
                                            <label class="custom-control-label" for="single_check{{ $product->slug }}"></label>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div style="width: 50px; height: 50px;">
                                            <img src="{{ asset(get_product_thumbnail($product->thumbnail)) }}" alt="{{ $product->name }} thumbnail" style="width: 100%">
                                        </div>
                                    </td>
                                    <td class="align-middle">{{ $product->name }}</td>
                                    <td class="align-middle">{{ $product->collections->name }}</td>
                                    <td class="align-middle">{{ $product->sku }}</td>
                                    <td class="align-middle">
                                        @if($product->quantity_in_stock > 0)
                                        <span class="text-success">In-stock</span>
                                        @else
                                        <span class="text-danger">Out-of-stock</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">{{ config('adinkra.currency_code') }}{{ number_format($product->price, 2) }}</td>
                                    <td class="align-middle">
                                        @foreach($product->categories as $category)

                                        {{  $loop->first ? $category->name : ','. $category->name}}
                                        @endforeach
                                    </td>
                                    <td class="align-middle d-flex flex-column">
                                        @if($product->status == 'published')
                                        <span class=" ">Published</span>
                                        @elseif( $product->status == 'pending')
                                        <span class=" ">Pending <span data-toggle="tooltip" data-placement="bottom" title="Upload product images" > <i class="fas fa-exclamation-circle"></i></span></span>
                                        @else
                                        <span class=" ">Draft</span>
                                        @endif
                                        {{ getCustomLocalTime($product->created_at) }}
                                    </td>
                                    <td>
                                        {{ ucfirst($product->status) }}
                                        {{-- @if($product->protected)
                                        <i class="fas fa-lock"></i>  Yes                                   
                                        @else
                                        No
                                        @endif --}}
                                    </td>
                                    <td class="align-middle">
                                        <button type="button" class="btn btn-icon float-right m-0"
                                        data-toggle="dropdown">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>

                                    <div class="dropdown-menu dropdown-menu-right">
                                        @if($product->status == 'published')
                                        <a class="dropdown-item" href="{{ route('products.single', $product->slug) }}" target="blank">
                                            View
                                        </a>
                                        @endif
                                        <a class="dropdown-item" href="{{route('edit-product', $product->slug )}}">
                                            Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger move-product-to-bin" href="javascript:void(0)" data-slug="{{ $product->slug }}">
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

{{-- action modal --}}
<div class="modal fade" id="bulkActionModal" tabindex="-1" role="dialog"
aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenteredLabel">Acton required</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <form id="toggleForm" action="{{route('admin.products.bulk-action')}}" method="POST">
      <div class="modal-body">
        <h5>Are you sure you want to <span class="action_to_perfom"></span></h5>
        @csrf
        <input type="hidden" name="status" id="status">
        <input type="hidden" name="products" id="products">

        <div class="form-group show-mustang mt-4" style="display: none;">
            <label for="mustang">Select password to apply password</label>
            @foreach($labels as $label)
            <div class="custom-control custom-radio">
                <input type="radio" id="{{ $label->id }}" name="code" class="custom-control-input" value="{{ $label->code }}">
                <label class="custom-control-label" for="{{ $label->id }}">{{ $label->code }} - {{ $label->name }}</label>
            </div>
            @endforeach
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="proceedDistAction">Proceed</button>
    </div>
</form>
</div>
</div>
</div>
@endsection

@section('scripts')
<script src="{{asset('dashboard/js/products.js')}}"></script>

@endsection