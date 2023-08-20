@extends('dashboard.layouts.app')
@section('title', 'Tickets categories | Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('tickets_menu_open','menu-open')
@section('tickets_category_active','active')


@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"> Tickets categories </h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Add new category</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ route('admin.tickets.categories') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ !empty($category) ? $category->id : '' }}">
                            <div class="form-group">
                                <label for="category">
                                    Name
                                </label>
                                <input type="text" class="form-control" name="category" value="{{  old('category') ? old('category') :  (!empty($category) ? $category->name : '') }}" required="">
                                @error('category')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Categories</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="ticketsTable" class="table table-bordered table-hover table-striped display">
                                <thead>
                                    <tr class="text-center">
                                        <th>## </th>
                                        <th>Category</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-icon float-right m-0" data-toggle="dropdown">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="{{ route('admin.tickets.categories', ['q' => $category->id]) }}">
                                                    Edit
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger " href="{{ route('admin.tickets.delete-categories', $category->id) }}">
                                                    Delete
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
@endsection


@section('scripts')
<script type="text/javascript">
    $(function(){
        $('table.display').DataTable();
    })
</script>
@endsection