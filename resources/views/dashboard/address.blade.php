@extends('dashboard.layouts.app')
@section('title','My addresses')

@section('address-active','active bg-sand')


@section('homeContent')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>My address</h5>
       <div>
            <a href="{{ route('address.create') }}" class="btn btn-primary bg-sand border-0 text-white">Add new address</a>
       </div>
    </div>
    <div class="card-body">
        @forelse($addresses->chunk(2) as $chunked_address)
        <div class="row address">
            @foreach($chunked_address as $address)
            <div class="col-md-6  mb-3 ">
                <div class="card p-2 h-100">
                    <div class="card-body">
                        <div class="row flex-column address-items">
                            <h6>{{$address->billing_first_name." ".$address->billing_last_name}}</h6>
                            <p><small>{{$address->billing_email}}</small></p>
                            <p><small>{{$address->billing_phone}}</small></p>
                            <p><small>{{$address->billing_address_one}}</small></p>
                            <p><small>{{$address->billing_address_two}}</small></p>
                            <p><small>{{$address->billing_city}}</small></p>
                            <p><small>{{$address->billing_zip_code}}</small></p>
                            <p><small>{{$address->billing_region}}, {{$address->billing_country}}</small></p>
                        </div>
                    </div>
                    <div class="card-footer bg-white d-flex">
                        @if($address->default == 1)
                        <small class="text-muted"><i class="fas fa-check-circle"></i> Default address</small>
                        @endif
                        <a href="{{ route('address.edit', $address->slug) }}" class="text-sand ms-auto"> <i class="fas fa-edit"></i> </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @empty
        <div class="row d-flex justify-content-center">
            <div class="card p-4">
                <div class="alert alert-info">
                    <h5>No address found. <a href="{{ route('address.create') }}">Click here to add new address</a></h5>
                </div>
            </div>
        </div>

        @endforelse
    </div>
</div>
@endsection
