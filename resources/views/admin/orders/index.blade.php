@extends('admin.layouts.app')
@section('title', 'Order management')
@section('orders_active','active')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Orders</h1>
            </div>
            <div class="col-sm-6 text-right">
                <div class="btn-group inactive">
                    {{-- {{route('orders.create')}} --}}
                    <a href="#!" type="button" class="btn btn-outline-primary">
                        <i class="fa fa-plus"></i>
                        Add new order
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-icon"
                        data-toggle="dropdown">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#!">
                            <i class="fa fa-plus"></i>
                            Add new order
                        </a>
                     {{--    <a class="dropdown-item in-active" href="#!">
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
                        <h3 class="card-title">Customer orders</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="w-50 mb-2">
                            <ul class="d-flex list-unstyled justify-content-around">
                                <li><a href="{{ route('orders', ['type' => 'orders', 'q' => request()->q]) }}"  class="{{ $type == 'orders' ? 'active_order_tab' : '' }}">All <span class="text-muted">{{count($all_orders) }}</span></a> </li> 
                                <span>|</span>
                                <li><a href="{{ route('orders', ['type' => 'trash', 'q' => request()->q]) }}"  class="{{ $type == 'trash' ? 'active_order_tab' : '' }}">Bin <span class="text-muted">{{ count($bin)}}</span></a></li>
                                <span>|</span>
                                <li><a href="{{ route('orders', ['type' => 'pending', 'q' => request()->q]) }}"  class="{{ $type == 'pending' ? 'active_order_tab' : '' }}">Pending <span class="text-muted">{{ count($pending)}}</span></a></li>
                                <span>|</span>
                                <li><a href="{{ route('orders', ['type' => 'processing', 'q' => request()->q]) }}"  class="{{ $type == 'processing' ? 'active_order_tab' : '' }}">Processing <span class="text-muted">{{ count($processing)}}</span></a></li>
                                <span>|</span>
                                <li><a href="{{ route('orders', ['type' => 'completed', 'q' => request()->q]) }}"  class="{{ $type == 'completed' ? 'active_order_tab' : '' }}">Completed <span class="text-muted">{{ count($completed) }}</span></a></li>
                                <span>|</span>
                                <li><a href="{{ route('orders', ['type' => 'cancelled', 'q' => request()->q]) }}"  class="{{ $type == 'cancelled' ? 'active_order_tab' : '' }}">Cancelled <span class="text-muted">{{ count($cancelled) }}</span></a></li>
                                <span>|</span>
                                <li><a href="{{ route('orders', ['type' => 'on-hold', 'q' => request()->q]) }}"  class="{{ $type == 'on-hold' ? 'active_order_tab' : '' }}">On-hold <span class="text-muted">{{ count($on_hold) }}</span></a></li>
                                <span>|</span>
                                <li><a href="{{ route('orders', ['type' => 'refunded', 'q' => request()->q]) }}"  class="{{ $type == 'refunded' ? 'active_order_tab' : '' }}">Refunded <span class="text-muted">{{ count($refunded) }}</span></a></li>
                                <span>|</span>
                                <li><a href="{{ route('orders', ['type' => 'failed', 'q' => request()->q]) }}"  class="{{ $type == 'failed' ? 'active_order_tab' : '' }}">Failed <span class="text-muted">{{ count($failed) }}</span></a></li>
                            </ul>
                        </div>

                        <div class="row mb-5"> 
                            <div class="form-group col-md-3 d-flex">
                                <select class="form-control select2 bulk_order_update" id="bulkAction"  disabled>
                                    <option  disabled selected hidden>Bulk action</option>
                                    @if($type == 'trash')
                                    <option class="dropdown-item bulk_order_update" data-status="restore" href="#!">Restore</option>
                                    <option class="dropdown-item bulk_order_update" data-status="delete" href="#!">Delete permanently</option>
                                    @else
                                    <option class="dropdown-item bulk_order_update" data-status="trash" href="#!">Move to bin</option>
                                    @endif
                                    <option class="dropdown-item bulk_order_update" data-status="pending" href="#!">Change status to Pending</option>
                                    <option class="dropdown-item bulk_order_update" data-status="processing" href="#!">Change status to Processing</option>
                                    <option class="dropdown-item bulk_order_update" data-status="on-hold" href="#!">Change status to On-hold</option>
                                    <option class="dropdown-item bulk_order_update" data-status="completed" href="#!">Change status to Completed</option>
                                </select>
                                <button class="btn btn-outline-primary btn-small ml-2" id="apply_button" disabled>Apply</button>
                            </div>
                            <div class="col-2"></div>
                            <div class="form-group col-md-4">
                             <form class="d-flex" action="{{ route('orders', ['type' => request()->type]) }}">
                                <input type="hidden" class="form-control" name="type" value="{{ request()->type }}">
                                <input type="text" class="form-control" name="q" value="{{ request()->q }}" id="search_input" placeholder="Search by order no., customer name, email, product name, etc.">
                                <button type="submit" class="btn btn-outline-primary btn-small ml-2" id="search_button" @if(empty(request()->q)) disabled @endif>Search</button>
                            </form>
                        </div>

                        @if($type == 'trash')
                        <div class="col-md-3">
                            <button class="btn btn-outline-primary btn-small float-right" id="empty_bin" @if(count($bin) == 0) disabled @endif>Empty bin</button>
                        </div>
                        @endif
                    </div>

                    <table id="productsTable" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>
                                    <div class="custom-control custom-checkbox">
                                      <input type="checkbox" class="custom-control-input" id="checkAll">
                                      <label class="custom-control-label" for="checkAll"></label>
                                  </div>
                              </th>
                              <th>Order</th>
                              <th>Date</th>
                              <th class="align-middle">Status</th>
                              <th class="align-middle">Payment</th>
                              <th>Subtotal</th>
                              <th>Discount</th>
                              <th>Vat</th>
                              <th>Grand total</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($orders as $order) <tr>
                            <td class="text-center" style="padding-right: 10px !important">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input single_check" id="single_check{{$order->id}}" data-order="{{ $order->order_number }}">
                                    <label class="custom-control-label" for="single_check{{$order->id}}"></label>
                                </div>

                            </td>
                            <td class="align-middle d-flex justify-content-between">
                                <a  href="{{ route('orders.edit', $order->order_number) }}">#{{ $order->order_number.' '. $order->addresses->billing_first_name .' '. $order->addresses->billing_last_name }}
                                </a> 

                                @if($order->status != 'trash')
                                <a  href="javascript:void(0)" class="view_order" data-slug="{{ $order->order_number }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @endif
                            </td>
                            <td class="align-middle">
                                {{ $order->order_date->diffForHumans() }}
                            </td>
                            <td class="align-middle">
                                <span class="badge {{ get_order_status_color($order->status) }}"> {{ ucfirst(($order->status)) }}</span>
                            </td>
                            <td class="align-middle">
                                @if($order->isPaid)
                                <span class="badge badge-success">Paid</span>
                                @elseif($order->status == 'refunded')
                                <span class="badge badge-info">Refunded</span>
                                @else
                                <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>
                             <td class="align-middle">
                                 {{ config('adinkra.currency_code') }}{{ number_format($order->subtotal, 2) }}
                            </td>
                            <td class="align-middle">
                                @if(!empty($order->coupon_amount)) 
                                {{ config('adinkra.currency_code') }}{{ number_format($order->coupon_amount, 2) }}
                                @else
                                -
                                @endif
                            </td>
                            <td class="align-middle">
                                {{ config('adinkra.currency_code') }}{{ number_format($order->vat, 2) }}
                            </td>
                            <td class="align-middle">
                                {{ config('adinkra.currency_code') }}{{ number_format($order->grand_total, 2) }}
                                  {{--   <button type="button" class="btn btn-icon float-right m-0"
                                    data-toggle="dropdown">
                                    <i class="fa fa-ellipsis-h"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="{{route('edit-product',['GSX 5887 L'])}}">
                                        View
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="#">
                                        Delete
                                    </a>
                                </div> --}}
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
</div>
</div>


@include('admin.orders.order-modal')
@endsection

@section('scripts')
<script src="{{asset('dashboard/js/order.js')}}"></script>
@endsection