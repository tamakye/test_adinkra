@extends('admin.layouts.app')
@section('title', 'Subscriber for news letters | Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('mailing_menu_open','menu-open')
@section('newsletter_active','active')


@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> Newsletter Subscribers </h1>
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
                        <h3 class="card-title">List of Newsletter subscribers</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="distributorTable" class="table table-bordered table-hover table-striped display">
                                <thead>
                                    <tr class="text-center">
                                        <th>## </th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Country</th>
                                        <th>Date subscribed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscribers as $subscriber)
                                    <tr class="text-center">
                                       <td>{{ $loop->index + 1 }}</td>
                                       <td>{{ $subscriber->full_name }}</td>
                                       <td>{{ $subscriber->email }}</td> </td>
                                       <td>{{ $subscriber->countries->name }}</td> </td>
                                       <td>{{ getCustomLocalTime($subscriber->created_at) }}</td>
                                     {{--   <td class="align-middle">
                                        <button type="button" class="btn btn-icon float-right m-0" data-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item distributor_actions text-danger" href="#!" data-id="{{ $subscriber->id }}" data-status="edit">
                                                Edit
                                            </a>

                                            <a class="dropdown-item distributor_actions text-danger" href="#!" data-id="{{ $subscriber->id }}" data-status="delete">
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
@endsection