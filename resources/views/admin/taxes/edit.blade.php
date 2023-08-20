@extends('admin.layouts.app')
@section('title', 'Edit tax | Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('product_menu_open','menu-open')
@section('taxes_active','active')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit tax</h1>
            </div>
            <div class="col-sm-6 text-right">
                <div class="btn-group">
                    <a href="{{route('admin.taxes')}}" type="button" class="btn btn-primary">
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
                        <h3 class="card-title">Edit {{ $tax->tax_name }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ route('admin.taxes.create') }}" method="POST">
                            @csrf
                            <input type="hidden" name="tax_code" value="{{ $tax->tax_code }}">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="tax_name">Tax name</label>
                                    <input type="text" class="form-control" name="tax_name" value="{{ old('tax_name') ?? $tax->tax_name}}" required="">
                                    @error('tax_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="rate">Rate</label>
                                    <input type="number" class="form-control" name="rate" min="0.01" step="0.01" value="{{ old('rate') ?? number_format($tax->tax_percent, 2) }}" required>
                                    @error('rate')
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