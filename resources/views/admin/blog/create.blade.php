@extends('dashboard.layouts.app')
@section('title', 'MSSSHOP | Dashboard')
@section('blog_active','active')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item">
                        <a href="{{route('blog')}}">
                            <h1 class="text-dark m-0">Blog</h1>
                        </a></li>
                        <li class="breadcrumb-item active">Create new blog</li>
                    </ol>
                </div>
                <div class="col-sm-6 text-right">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary save_draft">
                            Save draft
                        </button>
                        <button type="button" class="btn btn-primary save_publish">
                            Publish blog
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <form id="blogForm" method="POSt" action="{{ route('create-blog') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="status" value="draft" id="status">

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Set a title for this blog..." value="{{old('title')}}" required="">
                                    @error('title') 
                                    <span class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <textarea class="editor" name="post_body" required="">{{ old('post_body') }}</textarea>
                                    @error('post_body') 
                                    <span class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group d-flex flex-column">
                                    <label for="">Thumbnail</label>
                                    {{-- <small class="text-muted">Upload clear image </small> --}}
                                    <img class="img-thumbnail m-auto" src="{{ asset('/images/placeholder.png') }}" alt="Thumbnail image" id="image_preview" width="300">
                                    <div class="custom-file  mt-4">
                                        <input type="file" name="thumbnail" class="custom-file-input" id="thumbnail" accept=".jpg, .png, .jpeg" required="">
                                        <label class="custom-file-label" for="thumbnail">Choose file</label>
                                    </div>
                                    @error('thumbnail') 
                                    <span class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                <div class="text-right">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary save_draft">
                                            Save draft
                                        </button>
                                        <button type="button" class="btn btn-primary save_publish">
                                            Publish blog
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    @endsection


    @section('scripts')
    <script src="{{asset('js/blog.js')}}"></script>
    @endsection