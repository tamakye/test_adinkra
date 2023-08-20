@extends('admin.layouts.app')
@section('title', 'End users')
@section('site-pages-has-treeview','has-treeview')
@section('users_menu_open','menu-open')
@section('end_user_active','active')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> End users </h1>
            </div>
       {{--      <div class="col-sm-6 text-right">
                <div class="btn-group">
                    <a href="{{route('admin.users.create')}}" type="button" class="btn btn-outline-primary">
                        <i class="fa fa-plus"></i>
                        Add new user
                    </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-icon"
                        data-toggle="dropdown">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item in-active" href="{{route('admin.users.create')}}">
                            <i class="fa fa-upload"></i>
                            Upload CSV file
                        </a>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">End user list</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if(!empty(session('old_records')))
                        <div class="alert alert-info">
                            The following records are found to be duplicate<a href="#!" class="clear-session">Clear</a>
                            <table class="table">
                                @foreach(session('old_records') as $records)
                                <tr>
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                </tr>
                                <tbody>
                                    <tr>
                                        <td>{{  $records['first_name'] }}</td>
                                        <td>{{  $records['last_name'] }}</td>
                                        <td>{{  $records['email'] }}</td>
                                        <td>{{  $records['phone'] }}</td>  
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                        <div class="table-responsive">
                            <table id="distributorTable" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>## </th>
                                        <th>End user</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>User type</th>
                                        <th>Status</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $user->first_name.' '.$user->lasr_name }}</td>
                                        <td>
                                            <span>{{ $user->email }}</span>
                                        </td>
                                        <td>
                                            <span>{{ $user->phone }}</span>
                                        </td>
                                        <td>
                                           {{ $user->access_level }}
                                       </td>
                                       <td>
                                           {{ $user->status }}
                                       </td>
                               {{--         <td class="align-middle">
                                        <button type="button" class="btn btn-icon float-right m-0" data-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item"
                                            href="#!">
                                            <i class="far fa-edit"></i> Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item distributor_actions text-danger" href="#!" data-slug="{{ $user->slug }}" data-status="delete">
                                            Delete
                                        </a>
                                    </div>
                                </td> --}}
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
<script src="{{ asset('dashboard/js/distributor.js') }}"></script>
<script>
    $(function () {
        $(document).on('click', '.clear-session', function(){
            @php
            session()->forget('old_records')
            @endphp

            window.location.reload();
        })
    })
</script>
@endsection