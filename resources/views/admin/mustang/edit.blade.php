@extends('dashboard.layouts.app')
@section('title', 'Edit mustang label | Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('product_menu_open','menu-open')
@section('mustang_active','active')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit mustang label</h1>
            </div>
            <div class="col-sm-6 text-right">
                <div class="btn-group">
                    <a href="{{route('admin.mustang')}}" type="button" class="btn btn-primary">
                        <i class="fa fa-previous"></i>
                        Back
                    </a>
                </div>
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
                        <h3 class="card-title">Edit {{ $label->name }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ route('admin.mustang.edit', $label->code) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') ?? $label->name}}" required="">
                                    @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="reload">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="code" class=" d-flex">Code                                     
                                            {{-- <small class="ml-auto"><a href="javascript:void(0)" class="generate">Generate</a></small> --}}
                                        </label>
                                        <input type="text" class="form-control" name="code"  value="{{ old('code') ?? $label->code ?? get_mustang_code()}}" required readonly>
                                        @error('code')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 mt-2">
                                    <div class="custom-control custom-checkbox  {{ count($label->products) > 0 ? 'inactive' : '' }}">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" {{ old('status') ?? $label->status == 1 ? 'checked' : '' }} value="{{ $label->status }}">
                                        <label class="custom-control-label" for="status">Make label active</label>
                                    </div>
                                    @if( count($label->products) > 0)
                                    <span class="text-danger">This code protects {{ count($label->products) }} products and therefore can not be disabled. All associated products must be removed first before it can be disabled. </span>
                                    @endif

                                    @error('status')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6 d-flex">
                                <button class="btn  btn-primary ml-auto">Submit</button>
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
<script type="text/javascript">
    $(function(){
        $(document).on('click', '.generate', function(){
            $('.reload').load(location.href + ' .reload');
        })
    })
</script>
@endsection