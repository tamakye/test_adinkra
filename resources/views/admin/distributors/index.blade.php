@extends('dashboard.layouts.app')
@section('title', 'Distributors | Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('users_menu_open','menu-open')
@section('distributors_active','active')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> Distributors </h1>
            </div>
            <div class="col-sm-6 text-right">
                <div class="btn-group">
                    <a href="{{route('admin.distributors.create')}}" type="button" class="btn btn-outline-primary">
                        <i class="fa fa-plus"></i>
                        Add new distributor
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-icon"
                        data-toggle="dropdown">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{route('admin.distributors.create')}}">
                            <i class="fa fa-plus"></i>
                            Add new distributor
                        </a>
                        {{-- <a class="dropdown-item in-active" href="#!">
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
                        <h3 class="card-title">Distributors</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="distributorTable" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>## </th>
                                        <th>Distributor</th>
                                        <th>Location</th>
                                        <th>Contact</th>
                                        <th>Status</th>
                                        <th>Profile</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($distributors as $distributor)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $distributor->name }}</td>
                                        <td>{{ $distributor->address_address }} - {{ $distributor->country }}</td>
                                        <td  class="d-flex flex-column text-center">
                                            <span>{{ $distributor->email }}</span>
                                            <span>{{ $distributor->phone }}</span>
                                        </td>
                                        <td>
                                            {{ ucfirst($distributor->status) }}
                                        </td>
                                        <td>
                                            @if(!empty($distributor->companies))
                                            <span class="badge badge-success">Completed</span>
                                            @else
                                            <span class="badge badge-danger">incomplete</span>
                                            @endif
                                        </td>
                                    {{-- <td class="text-center">
                                        <a href="{{ route('admin.distributors.edit', $distributor->slug) }}"><i class="fas fa-edit"></i></a>
                                    </td> --}}
                                    <td class="align-middle">
                                        <button type="button" class="btn btn-icon float-right m-0" data-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('admin.distributors.edit', $distributor->slug) }}">
                                                <i class="far fa-edit"></i> Edit
                                            </a>

                                            @if($distributor->status == 'active')
                                            <a data-toggle="modal" data-target="#distModal" class="dropdown-item distributor_actions" href="#!" data-status="inactive" data-action="Ban" data-route="{{ route('admin.distributors.toggle-status', $distributor->slug) }}">
                                                <i class="fas fa-ban text-danger"></i> Ban
                                            </a>
                                            @else
                                            <a data-toggle="modal" data-target="#distModal" class="dropdown-item distributor_actions" href="#!" data-status="active" data-action="Approve" data-route="{{ route('admin.distributors.toggle-status', $distributor->slug) }}">
                                                <i class="far fa-check-circle text-success"></i> Approve
                                            </a>
                                            @endif
                                            <div class="dropdown-divider"></div>
                                            <a data-toggle="modal" data-target="#distModal" class="dropdown-item distributor_actions text-danger" data-action="Delete"data-route="{{ route('admin.distributors.toggle-status', $distributor->slug) }}" data-slug="{{ $distributor->slug }}" data-status="delete">
                                                <i class="fas fa-trash text-danger"></i> Delete
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
<script src="{{ asset('js/distributor.js') }}"></script>
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