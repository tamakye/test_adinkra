<div >
    {{-- <form action="#!" method="POST"> --}}
        <div class="content search-content mb-4 @if(isset($query)) content-width @endif">
          <div class="search search-box">
            <input type="search" class="form-control" placeholder="Enter an item" 
            wire:model="query"
            wire:keydown.escape="resetInput"
            wire:keydown.tab="resetInput"
            wire:keydown.ArrowUp="decrementHighlight"
            wire:keydown.ArrowDown="incrementHighlight"
            wire:keydown.enter="selectContact" style="border-radius: 0;">
        </div>
    </div>

{{-- </form> --}}

@if(!empty($query))
<div class="nav-search-result  mt-2">
    {{-- <div wire:loading class="text-center w-100">
        <small class="text-info" >Searching ...</small>
    </div> --}}
    <h5 class="text-gray text-center text-uppercase"  wire:loading.class="opacity-25">Search Results ({{ count($search_products) }})</h5>
    @if(count($search_products) > 0)
    <ul class="list-group text-left mt-3">
        @foreach($search_products as $search_product)
        <li class="list-group-item"  wire:loading.class="opacity-25">
            <a href="{{ route('products.single', [$search_product->slug]) }}" class="row text-decoration-none  text-gray">
                <div class="col-md-3 col-sm-3">
                    <img src="{{ asset(get_product_thumbnail($search_product->thumbnail)) }}" class="img-fluid" alt="{{ $search_product->name }}">
                </div>
                <div class="col-md-9 col-sm-9">
                   <h5 class="card-title">{{ ucfirst(Str::limit($search_product->name, 40)) }}</h5>
                   <p class="card-text text-gray">
                    @if($search_product->attributes_count > 0)
                    {{ config('adinkra.currency_code') }}{{ number_format(get_product__price($search_product) , 2) }}
                    @else
                    {{ config('adinkra.currency_code') }}{{ number_format($search_product->price , 2) }}
                    @endif
                </p>

            </div>
        </a>
    </li>
    @endforeach
</ul>
@else
<li class="list-item text-center pt-2 list-unstyled text-muted"  wire:loading.class="opacity-25">No results!</li>
@endif
</div>
@endif
</div>
