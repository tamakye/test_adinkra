@extends('admin.layouts.app')
@section('title', 'Shipping cost | Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('product_menu_open','menu-open')
@section('shpping_active','active')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Shipping cost</h1>
            </div>
            <div class="col-sm-6 text-right">
                <div class="btn-group">
                    <a href="{{route('admin.shipping.create')}}" type="button" class="btn btn-primary">
                        <i class="fa fa-plus"></i>
                        Add new shipping
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
                        <h3 class="card-title">List of shipping costs</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                         <table id="productsTable" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>##</th>
                                    <th>Shipping location</th>
                                    <th>Charge type</th>
                                    <th>Shipping fee</th>
                                    <th>Supported countries</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shippings as $shipping)
                                <tr>
                                    <td> {{  $loop->index + 1}} </td>
                                    <td >{{ $shipping->shipping_location }}</td>
                                    <td >{{ ucfirst($shipping->charge_type) }}</td>
                                    <td >
                                        @if($shipping->charge_type == 'flat')
                                        {{ config('adinkra.currency_code') }}{{ $shipping->shipping_fee }}
                                        @else
                                        {{ $shipping->shipping_fee }}%
                                    </td>
                                    @endif
                                    <td class="text-center">
                                        <a href="#!" class="view_coutries" data-id="{{ $shipping->id }}">
                                            <span class="badge bg-dark pt-1">
                                                @if(count($shipping->countries) > 0)
                                                {{ count($shipping->countries) }}
                                                @else
                                                Worldwide
                                                @endif
                                            </span>
                                        </a>
                                    </td>
                                    <td class="align-middle">
                                        <button type="button" class="btn btn-icon float-right m-0" data-toggle="dropdown">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('admin.shipping.edit', $shipping->slug) }}">
                                                Edit
                                            </a>
                                            <div class="dropdown-divider"></div>
                                           {{--  <a class="dropdown-item text-danger " href="javascript:void(0)" data-slug="{{ $shipping->slug }}">
                                                Move to bin
                                            </a> --}}
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