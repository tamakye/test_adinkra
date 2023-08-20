@extends('dashboard.layouts.app')
@section('title', 'Preview upload | Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('users_menu_open','menu-open')
@section('end_user_active','active')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> Upload preview</h1>
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
                        <h3 class="card-title"> Import customers from CSV</h3>
                        <h5 class="text-muted">A CSV (comma-separated values) file is a spreadsheet file that is used to import users.

                        </h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">  
                        <form action="{{route('admin.users.process-upload')}}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <small class="text-muted">
                                    Showing {{count($csv_data)}} of {{count($data)}} entries in the CSV. Does your data look correct?
                                </small>
                                <div class="table-responsive mt-3">
                                    <table class="table table-hover bg-deep-grey">
                                        <thead>
                                            <th>First name</th>
                                            <th>Last name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($csv_data as $row)
                                            <tr>
                                                @foreach ($row as $key => $value)
                                                <td>{{ $value }}</td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        </tbody>

                             {{--    <tr>
                                    @foreach ($csv_data[0] as $key => $value)
                                    <td>
                                        <select name="fields[{{ $key }}]">
                                            @foreach (get_db_fields() as $db_field)
                                            <option value="{{ $loop->index }}">{{ $db_field }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    @endforeach
                                </tr> --}}
                            </table>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{route('admin.users.create')}}" class="btn btn-secondary">No, try again</a>
                        <button class="btn btn-primary" type="submit">Proceed with import</button>
                    </div>
                </form>                
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
</div>
</div>

@endsection


@section('footerContent')

@endsection