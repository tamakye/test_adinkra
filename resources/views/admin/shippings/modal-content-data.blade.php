<h5>List of countries for {{$shipping->shipping_location}}</h5>
<ul class="list-group">
	@foreach($shipping->countries as $country)
	<li class="list-group-item">{{ $country->name }}</li>
	@endforeach
</ul>