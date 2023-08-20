@extends('admin.layouts.app')
@section('title', 'Product conditions')
@section('site-pages-has-treeview','has-treeview')
@section('filter_menu_open','menu-open')
@section('conditions_active','active')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item">
                        <a href="{{route('conditions')}}">
                            <h1 class="text-dark m-0">Filters</h1>
                        </a></li>
                        <li class="breadcrumb-item active">conditions</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class=" col-md-4">
                 <div class="card">
                    <div class="card-body">
                        <form action="{{ route('conditions') }}"  method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="status">Status</label>

                                <select class="form-control select2" name="status" id="status">
                                    @foreach(status() as $status)
                                    <option value="{{ $status }}" {{ old('status' == $status ? 'selected' : '') }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                                @error('status') 
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required="" id="name" autocomplete="off">
                                @error('name') 
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug <small>Optional</small></label>
                                <input type="text" class="form-control slug @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') }}" id="slug">
                                @error('slug') 
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                                <small>The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens</small>
                            </div>

                            <div class="form-group">
                                <label for="description">Discription</label>
                                <textarea name="description" rows="5" class="form-control  @error('description') is-invalid @enderror" id="description" required="" maxlength="500">{{ old('description') }}</textarea>
                                @error('description') 
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
              {{--               <div class="form-group d-flex flex-column">
                                <label for="">Thumbnail</label>
                                <img class="img-thumbnail m-auto" src="{{ asset('/images/placeholder.png') }}" alt="Thumbnail image" id="image_preview" width="300">
                                <div class="custom-file  mt-4">
                                    <input type="file" name="thumbnail" class="custom-file-input" id="thumbnail" required="">
                                    <label class="custom-file-label" for="thumbnail">Choose file</label>
                                </div>
                                @error('thumbnail') 
                                <span class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div> --}}


                            <div class="text-right">
                                <button type="submit" class="btn btn-outline-primary">Add new condition</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class=" col-md-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped table-hover display">
                            <thead>
                                <tr>
                                    <th>##</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                    <th>Product count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($conditions as $condition)
                                <tr>
                                    <td>
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td>
                                        <a href="{{ route('edit-conditions', $condition->slug) }}">{{ $condition->name }}</a>
                                    </td>
                                    <td>{{ $condition->slug }}</td>
                                    <td>{{ $condition->status }}</td>
                                    <td>{{ 0 }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="{{asset('dashboard/js/filters.js')}}"></script>
@endsection