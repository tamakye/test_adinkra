@extends('dashboard.layouts.app')
@section('title', 'Support Tickets | Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('tickets_menu_open','menu-open')
@section('tickets_active','active')


@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> Support Tickets </h1>
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
                        <h3 class="card-title">Tickets</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                     <div class="table-responsive">
                        <table id="ticketsTable" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>Status</th>
                                    <th>Ticket ID</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Creation date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                <tr>
                                    <td>
                                        @if ($ticket->status === 'open')
                                        <span class="label label-success">{{ ucfirst($ticket->status) }}</span>
                                        @else
                                        <span class="label label-danger">{{ ucfirst($ticket->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $ticket->ticket_id }}</td>
                                    <td>
                                        <a href="{{ route('admin.tickets.view', $ticket->ticket_id) }}">{{ $ticket->title }}</a>
                                    </td>
                                    <td>{{ $ticket->ticketcategories->name }}</td>
                                    <td>{{ $ticket->updated_at }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $tickets->links() }}
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