@extends('admin.layouts.app')
@section('title', 'New shipping cost| Dashboard')
@section('site-pages-has-treeview','has-treeview')
@section('product_menu_open','menu-open')
@section('shpping_active','active')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">New shipping cost</h1>
            </div>
            <div class="col-sm-6 text-right">
                <div class="btn-group">
                    <a href="{{route('admin.shipping')}}" type="button" class="btn btn-primary">
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
                        <h3 class="card-title">Add shipping</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ route('admin.shipping.create') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="shipping_location">Shipping location</label>
                                    <input type="text" class="form-control" name="shipping_location" value="{{ old('shipping_location') }}" required="">
                                    @error('shipping_location')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="charge_type">Charge type</label>
                                    <select class="form-control select2 " name="charge_type"required>
                                        <option value="percentage"{{ old('charge_type') == 'percentage' ? 'selected' : '' }}>Percentage</option>                                     
                                        <option value="flat" {{ old('charge_type') == 'flat' ? 'selected' : '' }}>Flat</option>                                     
                                    </select>
                                    @error('charge_type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                            <div class="row">
                               <div class="form-group col-md-6">
                                <label for="shipping_fee">Shipping amount/Percentage</label>
                                <input type="number" class="form-control" name="shipping_fee" min="0" value="{{ old('shipping_fee')}}" required>
                                @error('shipping_fee')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="shipping_countries">Select Applicable countries</label>
                                <select class="form-control select2 " name="shipping_countries[]" multiple="" required>
                                    <optgroup label="All country shipping" class="text-muted">
                                        <option value="worldwide">Worldwide</option>
                                    </optgroup>

                                    <optgroup label="Selected country shipping" class="text-muted">
                                        @foreach($countries as $country)
                                        <option value="{{$country->id}}" {{ is_array(old('shipping_countries')) && in_array($country->id, old('shipping_countries')) ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach  
                                    </optgroup>

                                </select>
                                @error('shipping_countries')
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