@extends('dashboard.layouts.app')
@section('title','Edit address')

@section('address-active','active bg-sand')


@section('homeContent')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Account Details</h5>
        <div>
            <a href="{{ route('address') }}" class="btn btn-primary bg-sand border-0 text-white">Back to address</a>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('address.edit', $address->slug) }}" method="post">
            @csrf
            <div class="row mt-4">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="">First name *</label>
                        <input type="text" class="form-control required @error('billing_first_name') is-invalid @enderror" name="billing_first_name" required="" value="{{ old('billing_first_name') ?? $address->billing_first_name }}">
                        @error('billing_first_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror

                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="">Last name *</label>
                        <input type="text" class="form-control required @error('billing_last_name') is-invalid @enderror" name="billing_last_name" required="" value="{{ old('billing_last_name') ?? $address->billing_last_name }}">
                        @error('billing_last_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                 <div class="form-group ">
                    <label for="billing_address_one">Address 1*</label>
                    <input type="text" class="form-control" name="billing_address_one" value="{{ old('billing_address_one') ?? $address->billing_address_one }}" id="billing_address_one" required>
                    <p class="m-0 p-0 text-gray"><small>Street number, street name</small></p>
                    @error('billing_address_one')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-12 mb-3">
               <div class="form-group ">
                <label for="billing_address_two">Address 2 *</label>
                <input type="text" class="form-control" name="billing_address_two" value="{{ old('billing_address_two') ?? $address->billing_address_two }}" id="billing_address_two" required>
                <p class="m-0 p-0 text-gray"><small>Apartment number, suite number or company name</small></p>
                @error('billing_address_two')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="">Country *</label>
                <select name="billing_country" id="billing_country" class="form-control required select2 " required=""  style="width: 100%">
                    <option selected hidden disabled value="">Select country</option>
                    @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ old('billing_country') == $country->id ? 'selected' :  ($country->id == $address->billing_country ? 'selected' : '') }}>{{ $country->name }}</option>
                    @endforeach
                </select>
                @error('billing_country')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="">State OR Province *</label>

                <select class="form-control  billing_region_select select2 @error('billing_region') is-invalid @enderror" name="billing_region" id="billing_region" style="width: 100%">
                    <option selected hidden disabled value="">Choose region</option>
                    @foreach(get_country_region() as $region)
                    <option value="{{ $region->id }}" 
                        {{ old('billing_region') == $region->id  ? 'selected' : ($address->billing_region == $region->id? 'selected' : '') }}>
                        {{ $region->name }}
                    </option>
                    @endforeach
                </select>
                
                @error('billing_region')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="">City *</label>
                <input type="text" id="billing_city" class="form-control required @error('billing_city') is-invalid @enderror" name="billing_city" value="{{ old('billing_city') ?? $address->billing_city}}" required="">
                @error('billing_city')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="">ZIP/Postal Code*</label>
                <input type="text" id="billing_zip_code" class="form-control required @error('billing_zip_code') is-invalid @enderror" name="billing_zip_code" value="{{ old('billing_zip_code') ?? $address->billing_zip_code }}" required="">
                @error('billing_zip_code')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="">Phone *</label>
                <input type="tel" class="form-control required @error('billing_phone') is-invalid @enderror" name="billing_phone" value="{{ old('billing_phone') ?? $address->billing_phone }}" required="">
                @error('billing_phone')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="">Email address *</label>
                <input type="email" class="form-control required @error('billing_email') is-invalid @enderror" name="billing_email" value="{{ old('billing_email') ?? $address->billing_email}}" required="">
                @error('billing_email')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-group mt-3 d-flex">
        <button class="btn btn-primary bg-gray border-0 ms-auto text-white">Save changes</button>
    </div>
</form>
</div>
</div>
@endsection