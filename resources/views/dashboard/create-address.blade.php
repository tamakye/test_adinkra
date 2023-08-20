@extends('dashboard.layouts.app')
@section('title','Create address')

@section('address-active','active bg-sand')


@section('homeContent')
<div class="card">
    <div class="card-header">
        <h5>Account Details</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('address.create') }}" method="post">
            @csrf
            
            <div class="row">
                <div class="col-md-6 form-group mb-3">
                    <label for="billing_first_name">First name *</label>
                    <input type="text" class="form-control" name="billing_first_name" value="{{ old('billing_first_name') }}" id="billing_first_name" required>
                    @error('billing_first_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="billing_last_name">Last name *</label>
                    <input type="text" class="form-control" name="billing_last_name" value="{{ old('billing_last_name') }}" id="billing_last_name" required>
                    @error('billing_last_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="billing_address_one">Address 1*</label>
                    <input type="text" class="form-control" name="billing_address_one" value="{{ old('billing_address_one') }}" id="billing_address_one" required>
                    <p class="m-0 p-0 text-gray"><small>Street number, street name</small></p>
                    @error('billing_address_one')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label for="billing_address_two">Address 2 *</label>
                    <input type="text" class="form-control" name="billing_address_two" value="{{ old('billing_address_two') }}" id="billing_address_two" required>
                    <p class="m-0 p-0 text-gray"><small>Apartment number, suite number or company name</small></p>
                    @error('billing_address_two')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 -group mb-4">                      
                    <label for="billing_country">Country *</label>
                    <select class="form-control select2" name="billing_country" id="billing_country" required>
                        <option value=""></option>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ old('billing_country') == $country->id ? 'selected' : '' }} >{{ $country->name }}</option>
                        @endforeach
                    </select>
                    @error('billing_country')
                    <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
                <div class=" col-md-6 form-group mb-4">                     
                    <label for="billing_region">STATE OR PROVINCE *</label>
                    <select class="form-control select2" name="billing_region" required id="billing_region">
                        <option value=""></option>
                        @if(old('billing_region') && old('billing_country'))
                        @foreach(getRegions(old('billing_country')) as $region)
                        <option value="{{ $region->id }}" {{ old('billing_region') == $region->id ? 'selected' : '' }} >{{ $region->name }}</option>
                        @endforeach
                        @endif
                    </select>
                    @error('billing_region')
                    <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="billing_city">City *</label>
                    <input type="text" class="form-control" name="billing_city" value="{{ old('billing_city') }}" id="billing_city" required>
                    @error('billing_city')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="billing_zip_code">Zip/Postal Code*</label>
                    <input type="text" class="form-control" name="billing_zip_code" value="{{ old('billing_zip_code') }}" id="billing_zip_code" required>
                    @error('billing_zip_code')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="billing_phone">Phone no.*</label>
                    <input type="text" class="form-control" name="billing_phone" value="{{ old('billing_phone') }}" id="billing_phone" required>
                    <p class="m-0 p-0 text-gray"><small>Example +233 234 3245 5324</small></p>
                    @error('billing_phone')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 form-group mb-3">
                    <label for="billing_email">Email*</label>
                    <input type="email" class="form-control" name="billing_email" value="{{ old('billing_email') }}" id="billing_email" required>
                    <p class="m-0 p-0 text-gray"><small>info@example.com</small></p>
                    @error('billing_email')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group d-flex">
                <button class="btn btn-primary bg-gray border-0 ms-auto text-white">Save address</button>
            </div>
        </form>
    </div>
</div>
@endsection
