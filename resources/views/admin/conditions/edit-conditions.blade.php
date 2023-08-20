@extends('admin.layouts.app')
@section('title', 'Edit '.$condition->name)
@section('site-pages-has-treeview','has-treeview')
@section('filter_menu_open','menu-open')
@section('carmake_active','active')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item">
                        <a href="{{route('conditions')}}">
                            <h1 class="text-dark m-0">Conditions</h1>
                        </a>
                    </li>
                    <li class="breadcrumb-item">{{$condition->name}}</li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card col-md-6 offset-md-3">
                    <div class="card-body">

                        <form action="{{ route('edit-conditions', $condition->slug) }}"  method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="status">Status</label>

                                <select class="form-control select2" name="status" id="status">
                                    @foreach(status() as $status)
                                    <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : ($condition->status == $status ? 'selected' : '') }}>{{ $status }}</option>
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
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $condition->name  }}" required="" id="name" autocomplete="off">
                                @error('name') 
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug <small>Optional</small></label>
                                <input type="text" class="form-control slug @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug')  ?? $condition->slug }}" id="slug">
                                @error('slug') 
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                                <small>The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens</small>
                            </div>

                            <div class="form-group">
                                <label for="description">Discription</label>
                                <textarea name="description" rows="5" class="form-control  @error('description') is-invalid @enderror" id="description" required="" maxlength="500">{{ old('description')  ?? $condition->description }}</textarea>
                                @error('description') 
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                   {{--          <div class="form-group d-flex flex-column">
                                <label for="">Thumbnail</label>

                                <img class="img-thumbnail m-auto" src="{{ asset(get_condition_thumbnail($condition->thumbnail)) }}" alt="Thumbnail image" id="image_preview" width="300">
                                <div class="custom-file  mt-4">
                                    <input type="file" name="thumbnail" class="custom-file-input" id="thumbnail" accept=".png, .jpg, .jpeg">
                                    <label class="custom-file-label" for="thumbnail">Choose file</label>
                                </div>
                                @error('thumbnail') 
                                <span class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div> --}}

                            <div class="text-right">
                                <a href="{{route('conditions')}}" class="btn btn-default"> Cancel </a>
                                <button type="submit" class="btn btn-outline-primary">Save changes</button>
                            </div>
                        </form>
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