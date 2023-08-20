@extends('dashboard.layouts.app')
@section('title', 'Categories | Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('product_menu_open','menu-open')
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
                        <li class="breadcrumb-item active">Tags</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class=" col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Thumbnail</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Slug</th>
                                        <th>Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 @foreach($tags as $category)
                                 <tr>
                                    <td>
                                        <img width="50" src="{{asset('/images/'.$category->car_image)}}" alt="{{ $category->car_make }} photo">
                                    </td>
                                    <td>{{ $category->car_make }}</td>
                                    <td>{{ $category->car_make }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ count($category->products) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class=" col-md-4">
               <div class="card">
                <div class="card-body">
                    <form action="{{ route('tags') }}"  method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="category_name">Name</label>
                            <input type="text" class="form-control @error('category_name') is-invalid @enderror" name="category_name" value="{{ old('category_name') }}" required="" id="category_name">
                            @error('category_name') 
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug <small>Optional</small></label>
                            <input type="text" class="form-control  @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') }}" id="slug">
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
                                <option value="none">Audi</option>
                                <option value="">&nbsp;&nbsp;fsdfsdf</option>
                                <option value="">&nbsp;&nbsp;fsdfsdf</option>
                                <option value="none">Mercedis</option>
                                <option value="">&nbsp;&nbsp;fsdfsdf</option>
                                <option value="">&nbsp;&nbsp;fsdfsdf</option>
                                <option value="">&nbsp;&nbsp;fsdfsdf</option>
                                <option value="">&nbsp;&nbsp;fsdfsdf</option>
                            </select>
                            @error('parent_category') 
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Discription</label>
                            <textarea rows="5" class="form-control  @error('description') is-invalid @enderror" id="description" required="">{{ old('description') }}</textarea>
                            @error('description') 
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Thumbnail</label>
                            <img class="img-thumbnail" src="{{ asset('/images/placeholder.png') }}" alt="Thumbnail image" id="image_preview">
                            <div class="custom-file">
                                <input type="file" name="thumbnail" class="custom-file-input" id="thumbnail" required="">
                                <label class="custom-file-label" for="thumbnail">Choose file</label>
                            </div>
                            @error('thumbnail') 
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-outline-primary">Add new tag</button>
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