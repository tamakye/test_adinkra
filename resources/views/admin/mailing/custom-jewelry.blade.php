@extends('admin.layouts.app')
@section('title', 'Custom Jewelries | Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('mailing_menu_open','menu-open')
@section('newsletter_active','active')


@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> Custom jewelry requests </h1>
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
                        <h3 class="card-title">Custom jewelry </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="distributorTable" class="table table-bordered table-hover table-striped display">
                                <thead>
                                    <tr class="">
                                        <th>## </th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Country</th>
                                        <th>Appointment</th>
                                        <th>Submitted on</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customjewelries as $subscriber)
                                    <tr class="">
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>
                                            <a href="{{ route('admin.mailing.custom-jewelry.show', $subscriber->slug) }}">{{ $subscriber->full_name }}</a>
                                        </td>
                                        <td>{{ $subscriber->phone }}</td> </td>
                                        <td>{{ $subscriber->countries->name }}</td> </td>
                                        <td>{{ $subscriber->appointment ? $subscriber->appointment?->format('d-m-y H:i') : '-' }}</td> </td>
                                        <td>{{ getCustomLocalTime($subscriber->created_at) }}</td>
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