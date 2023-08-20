@extends('layouts.app')
@section('title','Support tickets | MSSSHOP')
@section('hide-scrollbar','hide-scrollbar')
@section('accountStatus','active')
@section('tickets-active','active')

@section('content')
<div id="dashbord">
    <section class="bg-black support">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('user.partials.sidenav')
                </div>
                <div class="col-md-8 mt-4 mt-md-0">
                    <div class="card">
                        <div class="card-header d-flex">
                            <h5>Help center</h5>

                            <a href="{{ route('new-tickets') }}" class="btn btn-outline-primary ml-auto text-dark">Open a ticket</a>
                        </div>
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
                                            <a class="text-primary" href="{{ route('view-ticket', $ticket->ticket_id) }}">{{ $ticket->title }}</a>
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
                </div>
            </div>
        </div>
    </div>
</section>
</div>
{{-- footer --}}
@include('includes.footer')
@endsection

@section('script')

@endsection