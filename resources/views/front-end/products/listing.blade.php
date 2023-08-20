@extends('front-end.layouts.app')

@section('title', 'Listing for '. $collection->name)

@section('meta_keywords', 'Single product')
@section('meta_description', 'Single product')

@section($collection->slug.'-status', 'active')

@section('content')
<div class="container">
	<section class="">
		<div class="cover-img">
			<img src="{{ asset('images/slider2.png') }}" class="w-100">
		</div>
	</section>

	<section class="product-listing">
		 @livewire('product-listing', ['collection' => $collection, 'materials' => $materials])
	</section>
</div>
@endsection
