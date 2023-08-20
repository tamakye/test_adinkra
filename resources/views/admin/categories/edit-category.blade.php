@extends('admin.layouts.app')
@section('title', 'Edit '. $category->name.' | Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('filter_menu_open','menu-open')
@section('categories_active','active')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item">
                        <a href="{{route('products')}}">
                            <h1 class="text-dark m-0">Products</h1>
                        </a></li>
                        <li class="breadcrumb-item active">Categories / Edit {{ $category->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">

                <div class=" col-md-6">
                   <div class="card">
                    <div class="card-body">
                        <form action="{{ route('categories.update', $category->slug) }}"  method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="status">Status</label>

                                <select class="form-control select2" name="status" id="status">
                                    @foreach(status() as $status)
                                    <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : ($category->status == $status ? 'selected' : '') }}>{{ $status }}</option>
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
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $category->name }}" required="" id="name">
                                @error('name') 
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug <small>Optional</small></label>
                                <input type="text" class="form-control  @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') ?? $category->slug }}" id="slug">
                                @error('slug') 
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                                <small>The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens</small>
                            </div>

                            <div class="form-group">
                                <label for="parent_category">Parent</label>

                                <select class="form-control select2" name="parent_category" id="parent_category">
                                    <option value="none">None</option>
                                    @foreach($categories as $p_category)
                                    @isParent($p_category)
                                    <option value="{{ $p_category->id }}" {{ $p_category->id == $category->category_id ? 'selected' : '' }}>
                                        {{ $p_category->name }}

                                        @foreach(get_children($p_category) as $child_category)
                                        <option value="{{ $child_category->id }}" {{ $child_category->id == $category->category_id ? 'selected' : '' }}>
                                            &nbsp;&nbsp;{{ $child_category->name }}
                                        </option>
                                        @endforeach

                                    </option>
                                    @endisParent
                                    @endforeach
                                </select>
                                @error('parent_category') 
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Discription</label>
                                <textarea rows="5" class="form-control  @error('description') is-invalid @enderror" id="description" >{{ old('description') ?? $category->description }}</textarea>
                                @error('description') 
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                            <div class="form-group d-flex flex-column">
                                <label for="">Thumbnail</label>
                                @if(!empty($category->thumbnail))
                                <img class="img-thumbnail m-auto" src="{{ asset(get_category_thumbnail($category->thumbnail)) }}" alt="Thumbnail image" id="image_preview" width="300">
                                @else
                                <img class="img-thumbnail m-auto" src="{{ asset(default_placeholder()) }}" alt="Thumbnail image" id="image_preview" width="300">
                                @endif
                                <div class="custom-file  mt-4">
                                    <input type="file" name="thumbnail" class="custom-file-input" id="thumbnail">
                                    <label class="custom-file-label" for="thumbnail">Choose file</label>
                                </div>
                                @error('thumbnail') 
                                <span class="invalid-feedback" style="display: block;">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                            <div class="text-right">
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
<script src="{{asset('js/products.js')}}"></script>
@endsection