@extends('dashboard.layouts.app')
@section('title', 'Warranties registered | Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('product_menu_open','menu-open')
@section('warranties_active','active')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Warranties registered</h1>
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
                        <h3 class="card-title">List of registered warranties</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                           <table id="productsTable" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>##</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Make & model</th>
                                    <th>SKU</th>
                                    <th>Product purchased</th>
                                    <th>Date purchased</th>
                                    <th>Location</th>
                                    <th>Additional info</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($warranties as $warrant)
                                <tr>
                                    <td> {{  $loop->index + 1}} </td>
                                    <td class="align-middle">{{ $warrant->first_name.' '.$warrant->last_name }}</td>
                                    <td class="align-middle">{{ $warrant->email }}</td>
                                    <td class="align-middle">{{ $warrant->make_and_model }}</td>
                                    <td class="align-middle">{{ $warrant->sku }}</td>
                                    <td class="align-middle">{{ $warrant->product_purchased }}</td>
                                    <td class="align-middle">{{ $warrant->date_purchased->format('d-m-Y') }}</td>
                                    <td class="align-middle">{{ $warrant->location }}</td>
                                    <td class="align-middle">{{ $warrant->additional_info }}</td>
                                    <td class="align-middle">
                                        <button type="button" class="btn btn-icon float-right m-0" data-toggle="dropdown">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>

                                        <div class="dropdown-menu dropdown-menu-right">
                                         <a class="dropdown-item" href="#!">
                                            Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger " href="javascript:void(0)" data-slug="{{ $warrant->slug }}">
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
@endsection

@section('scripts')
{{-- <script src="{{asset('js/products.js')}}"></script> --}}
@endsection