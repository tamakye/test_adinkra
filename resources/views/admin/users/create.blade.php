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
                <h1 class="m-0 text-dark"> Upload Users</h1>
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
                        <h3 class="card-title">Upload Products</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">  
                        <div class="row">
                            <div class="col-md-3">
                                Bulk uploads
                                <ul>
                                    <li>Download <a href="{{ asset(get_end_user_template()) }}" target="_blank">End user template</a></li>
                                    <li>Ensure all data are filled in correctly</li>
                                    <li>Do not remove the header in the csv file</li>
                                    <li>Make sure there are no duplicates in the csv. You can  check and remove duplicate by using excell remove duplicate function.</li>
                                    <li>A maximum of 1000 records can be imported at a time.</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <form action="{{ route('admin.users.upload') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">
                                            Upload (CSV) file *
                                        </label>
                                        <input type="file" name="csv_file"  class="form-control @error('csv_file') is-invalid @enderror" required="" accept=".csv">
                                        @error('csv_file')
                                        <span class="invalid-feedback">
                                            {{$message}}
                                        </span>
                                        @enderror

                                        <small class="mt-5 text-muted">Maximum 10MB file size. CSV file type only.</small>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{route('admin.users')}}" class="btn btn-secondary">Cancel</a>
                                        <button class="btn btn-primary" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
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

@section('scripts')
@endsection