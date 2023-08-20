@extends('layouts.app')
@section('title','Register product for warranty | MSSSHOP')
@section('hide-scrollbar','hide-scrollbar')
@section('accountStatus','active')
@section('product-registration-active','active')

@section('content')
<div id="dashbord">

    <section class="bg-black">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    @include('user.partials.sidenav')
                </div>
                <div class="col-md-8 mt-4 mt-md-0">

                    <div class="card">
                        <div class="card-header d-flex">
                            <h5>Products registered for warranty</h5>
                            <a href="{{ route('new-product-registration', 'new') }}" class="btn btn-outline-primary ml-auto text-dark">Register product</a>

                        </div>
                        @if(count($registered_products) > 0)
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>##</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Vehicle Make and Model</th>
                                            <th>Product SKU (if known)</th>
                                            <th>Product Purchased</th>
                                            <th>location</th>
                                            <th>Additional Information</th>
                                            <th>Date of purchased</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($registered_products as $product)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $product->first_name}}</td>
                                            <td>{{ $product->last_name}}</td>
                                            <td>{{ $product->email}}</td>
                                            <td>{{ $product->make_and_model}}</td>
                                            <td>{{ $product->sku}}</td>
                                            <td>{{ $product->product_purchased}}</td>
                                            <td>{{ $product->location}}</td>
                                            <td>{{ $product->additional_info}}</td>
                                            <td>{{ $product->date_purchased->format('d-m-Y')}}</td>
                                            <td><a href="{{ route('new-product-registration', $product->slug) }}" >Edit</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                        @else
                        <div class="card-body d-flex"  style="height: 50vh;">
                            <h5 class="text-muted m-auto">No records found</h5>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
{{--  --}}
@include('includes.footer')
@endsection