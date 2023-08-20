@extends('dashboard.layouts.app')

@section('title','My wishlist')

@section('my-wishlist-active','active bg-sand')

@section('homeContent')

<div class="card">
    <div class="card-header">
        <h5>My Wishlist</h5>
    </div>
    <div class="card-body">
        <ul class="list-group list-group-flush">
            @if(count($wishes) > 0)
            @foreach($wishes as $wish)
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-8">
                        <div class="d-flex">
                            <span class="me-3 border bg-sand p-2 d-flex">
                                <img class="m-auto" src="{{ asset(get_product_thumbnail($wish->products->thumbnail)) }}" alt="Cart" width="50px" height="50px">
                            </span>
                            <span class="flex-grow-1">
                                <h6><a href="{{ route('products.single', $wish->products->slug) }}" class="text-decoration-none text-sand">{{ $wish->products->name }}</a></h6>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4 text-right">
                        <div>
                            <small class="bold text-muted">Added on <br> {{ getCustomLocalTime($wish->created_at)}}</small>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach

            @else
            <div class="row d-flex justify-content-center">
                <div class="alert alert-info">
                    <h5>No product in list.</h5>
                </div>
            </div>
            @endif
        </ul>

        <hr>
        <div class="d-flex justify-content-center mt-4">
            <div class="m-auto">{{ $wishes->links() }}</div>
        </div>
    </div>
</div>

{{-- footer --}}
{{-- @include('includes.footer') --}}
<script>
    // $('#shopItemModal').modal('show');
</script>
@endsection

@section('script')
{{-- <script src="{{ asset('js/shop.js') }}"></script> --}}
@endsection