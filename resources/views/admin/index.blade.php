@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('dashboard_active','active')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div>
            {{-- <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Starter Page</li>
                </ol>
            </div> --}}
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-black">
                    <div class="inner">
                        <h3 class="text-primary">{{ count($orders) }}</h3>
                        <p>New Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('orders', ['type' => 'pending']) }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-black">
                    <div class="inner">
                        <h3 class="text-primary">{{ $published_products }}</h3>
                        <p>Products published</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('products') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-black">
                    <div class="inner">
                        <h3 class="text-primary">{{ $draft_products }}</h3>
                        <p>Products in Draft</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-black">
                    <div class="inner">
                        <h3 class="text-primary">
                            {{ $users }}
                        </h3>

                        <p>Users</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#!" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        {{-- table --}}
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pending orders</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="ordersTable" class="table table-bordered table-hover table-striped display">
                                <thead>
                                    <tr class="text-center">
                                        <th>## </th>
                                        <th>Order number</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Payment type</th>
                                        <th>Transaction ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order) <tr>
                                        <td class="text-center">
                                          {{ $loop->index + 1 }}
                                        </td>
                                        <td class="align-middle d-flex justify-content-between">
                                            <a  href="{{ route('orders.edit', $order->order_number) }}">#{{ $order->order_number.' '. $order->addresses->billing_first_name .' '. $order->addresses->billing_last_name }}
                                            </a> 
                                        </td>
                                        <td class="align-middle">
                                            {{ $order->order_date->diffForHumans() }}
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge {{ get_order_status_color($order->status) }}"> {{ ucfirst(($order->status)) }}</span>
                                        </td>
                                        <td class="align-middle">
                                            {{ config('adinkra.currency_code') }}{{ number_format($order->grand_total, 2) }}
                                        </td>
                                        <td class="align-middle">
                                            {{ $order->payment_type }}
                                        </td>
                                        <td class="align-middle">
                                            {{ $order->transaction_id }}
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
<div class="modal fade" id="distModal" tabindex="-1" role="dialog"
aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenteredLabel">Acton required</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body">
    <h5>Are you sure you want to <span class="action_to_perfom"></span> this Distributor?</h5>
    <form id="toggleForm" action="" method="POST">
        @csrf
        <input type="hidden" name="dist_status" id="dist_status">
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="proceedDistAction">Proceed</button>
</div>
</div>
</div>
</div>
@endsection

@section('scripts')
<script>
    $(function () {
        $('.distributor_actions').each((index, element) => {
            $(element).on('click', function(e) {
                $('#dist_status').val($(this).attr('data-status'))
                $('.action_to_perfom').text($(this).attr('data-action'))
                $('#toggleForm').attr('action', $(this).attr('data-route'))
            })
        })
        // submit form
        $('#proceedDistAction').on('click', function(e){
            $('#toggleForm').submit()
        })
    })
</script>
@endsection
