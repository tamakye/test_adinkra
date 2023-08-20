@extends('dashboard.layouts.app')
@section('title', 'MSSSHOP | Dashboard')
@section('blog_active','active')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Blog</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('create-blog')}}" type="button" class="btn btn-primary">
                    <i class="fa fa-plus"></i>
                    Create new blog
                </a>
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
                        <h3 class="card-title">All blogs</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="blogTable" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Date created</th>
                                        <th>Date published</th>
                                        <th>Status</th>
                                        {{-- <th>Car Type</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>

                                        @foreach($posts as $post)
                                        
                                        <td class="align-middle">{{ $post->title }}</td>
                                        <td class="align-middle"> {{ getCustomLocalTime($post->created_at) }}  </td>
                                        <td class="align-middle">{{!empty($post->published_at) ? getCustomLocalTime($post->published_at) : '-' }} </td>
                                        <td class="align-middle text-success">
                                            @if(empty($post->published_at))
                                            <span class="text-dark">Draft</span>
                                            @else
                                            <span class="text-success">Published</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-icon float-right m-0"
                                            data-toggle="dropdown">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item"
                                            href="{{route('edit-blog', $post->slug)}}">
                                            Edit
                                        </a>
                                        <a class=" dropdown-item" href="{{ route('blog-item', $post->slug) }}" target="_blank">
                                            Preview
                                            <i class="fa fa-external-link-alt"></i>
                                        </a>
                                        @if(!empty($post->published_at))
                                        <a class="dropdown-item blog_actions" href="#!" data-slug="{{ $post->slug }}"  data-status="unpublish">
                                            Unpublish
                                        </a>
                                        @else
                                        <a class="dropdown-item blog_actions" href="#!" data-slug="{{ $post->slug }}"  data-status="publish">
                                            Publish
                                        </a>
                                        @endif
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item blog_actions text-danger" href="#!" data-slug="{{ $post->slug }}" data-status="delete">
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

<div class="modal fade blodModal" tabindex="-1" role="dialog"
aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenteredLabel">Acton required</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body">
    <h5>Are you sure you want to <span class="action_to_perfom"></span> this blog?</h5>
    <input type="hidden" name="blog_status" id="blog_status">
    <input type="hidden" name="blog_slug" id="blog_slug">
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="proceedBlogAction">Proceed</button>
</div>
</div>
</div>
</div>

@endsection



@section('scripts')
<script src="{{asset('js/blog.js')}}"></script>
@endsection