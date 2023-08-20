@extends('dashboard.layouts.app')
@section('title','Dashboard')

@section('my-account-active', 'active bg-sand')

@section('homeContent')

<div class="card h-100">
	<div class="card-header">
		<h5>Welcome to your dashboard {{ Auth::user()->first_name }}</h5>
	</div>
	<div class="card-body pb-5 d-flex  flex-column justify-content-center align-items-center text-center">

		<h5 class="m-auto"> You have placed {{ $orders }} order(s) so far.</h5>

		<div class="d-flex">
			<a href="/" class="btn btn-primary border-0 bg-gray mt-4 me-2">SHOP HERE</a> 
			<span class="pt-3 m-auto">OR</span> 	
			<a href="{{ route('my-orders') }}" class="btn btn-primary ms-2 border-0 bg-gray mt-4">VIEW MY ORDERS</a>
		</div>

		<br><br>
		<h5 class="m-auto"> Don't know where to start, you can </h5>

		<a href="{{ asset('documents/size-guide.pdf') }}" target="_blank" class="btn btn-primary border-0 bg-gray mt-4">DOWNLOAD OUR SIZE  GUIDE </a>

	</div>
</div>

<!-- Modal -->
{{-- @include('partials.shop-modal') --}}

@endsection

@section('script')
@endsection