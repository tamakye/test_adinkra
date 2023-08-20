<div>

    <div class="row pt-4 pb-4">
        <div class="col-md-3 filter-sidebar">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-gray sweetsand-regular">HOME</a></li>
                    <li class="breadcrumb-item active sweetsand-regular" aria-current="page">{{ strtoupper($collection->name) }}</li>
                </ol>
            </nav>
            <div class="border-top filter-top mt-5 pt-4">
                <div class="sort-by mb-5">
                    <p class="text-gray">SORT BY</p>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" id="low_to_high" value="low_to_high" wire:model="searchByPrice">
                        <label class="form-check-label" for="low_to_high">
                            PRICE LOW TO HIGH
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" id="high_to_low" value="high_to_low" wire:model="searchByPrice">
                        <label class="form-check-label" for="high_to_low">
                            PRICE HIGH TO LOW 
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" value="RECOMMENDED" wire:model="searchByPrice"  id="recommended">
                        <label class="form-check-label" for="recommended">
                            RECOMMENDED
                        </label>
                    </div>
                </div>
                <div class="filter-by mb-5">
                    <p class="text-gray">FILTER BY</p>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="Online"  wire:model="searchByFilter"  id="online">
                        <label class="form-check-label" for="online">
                            AVAILABLE ONLINE
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="New"  wire:model="searchByFilter"  id="new">
                        <label class="form-check-label" for="new">
                            NEW 
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="Must Have"  wire:model="searchByFilter"  id="must_have">
                        <label class="form-check-label" for="must_have">
                            MUST HAVE 
                        </label>
                    </div>
                </div>
                <div class="category mb-5">
                    <p class="text-gray">CATEGORY</p>
                    @foreach($collection->categories as $category)
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" wire:model="searchByCategories" value="{{  $category->id }}" id="cat{{ $category->slug }}">
                        <label class="form-check-label" for="cat{{ $category->slug }}">
                            {{ strtoupper($category->name) }}
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="selection mb-5">
                    <p class="text-gray">SELECTION FOR</p>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="Her"  wire:model="searchBySelection"  id="her">
                        <label class="form-check-label" for="her">
                            HER
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="Him" wire:model="searchBySelection"  id="him">
                        <label class="form-check-label" for="him">
                            HIM 
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="Children" wire:model="searchBySelection"  id="children">
                        <label class="form-check-label" for="children">
                            CHILDREN
                        </label>
                    </div>
                </div>
                <div class="collections mb-5">
                    <p class="text-gray">COLLECTION</p>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="collection" value="{{ $collection->slug }}" id="collection" checked disabled="">
                        <label class="form-check-label" for="collection">
                            {{ $collection->name }}
                        </label>
                    </div>
                </div>
                <div class="metal mb-5">
                    <p class="text-gray">METAL</p>
                    @foreach($materials as $material)
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" wire:model="searchByMaterials" value="{{  $material->id }}" id="cat{{ $material->slug }}" >
                        <label class="form-check-label" for="cat{{ $material->slug }}">
                            {{ strtoupper($material->name) }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-9 filter-list">

            <div class="row justify-content-between top-row mb-3">
                <div class="col-md-6">
                    {{-- <span class="text-gray sweetsand-regular">205  Models</span> --}}
                </div>
                <div class="col-md-6  text-end">
                    <span class="text-gray sweetsand-regular">Showing {{ $pageNumber + 1 }} of {{ $products->lastPage() }} pages;</span>
                </div>
            </div>
            <section class="collection single-product-collection rings position-relative pt-0 mt-5">
                <div class="container p-0" wire:loading.class.delay="opacity-50">

                    <a class="btn btn-primary bg-gray border-0 mb-3 filter-button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="fas fa-filter"></i> Filter</a>

                    <div class="row justify-content-center align-items-center">
                        {{-- @if($total_products > 0) --}}
                        @forelse($products as $product)
                        <a href="{{ route('products.single', $product['slug']) }}"  class="col-md-4 mb-2 text-decoration-none text-dark">
                            <div class="card border-0" >
                                <img src="{{ asset(get_product_thumbnail($product['thumbnail'])) }}" class="card-img-top" alt="{{ $product['name'] }}">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ Str::limit($product['name'], 20) }}</h5>
                                    <p class="card-text">
                                        @if($product['attributes_count'] > 0)
                                        {{ config('adinkra.currency_code') }}{{ number_format(get_product__price($product) , 2) }}
                                        @else
                                        {{ config('adinkra.currency_code') }}{{ number_format($product['price'] , 2) }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div  class="col-md-4 mb-2 text-decoration-none text-dark text-center">
                            <h6 class="text-muted sweetsand-regular">No records found</h6>
                        </div>
                        @endif
                    </div>

                    <div class="d-flex  flex-column justify-content-center mt-4">
                        <div class="col-md-4 mb-3 m-auto text-center border-top pt-3">
                            <p class="text-gray sweetsand-regular">Showing {{ $products->count() }} of {{ number_format($products->total()) }} items</p>
                        </div>

                        @if ($hasMorePages)
                        <div class="col-md-4 mb-2 m-auto text-center">
                            <a href="#!" class="btn btn-outline-primary w-100 text-uppercase text-gray sweetsand-regular load-more" wire:click="loadProducts">load more</a>
                        </div>
                        @endif
                    </div>
                </div>
            </section>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
              <div class="offcanvas-header">
                <h5 class="offcanvas-title text-gray sweetsand-regular" id="offcanvasRightLabel"> <i class="fas fa-filter"></i> Search Filters</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
               <div class="border-top filter-top pt-4">
                <div class="sort-by mb-5">
                    <p class="text-gray sweetsand-regular">SORT BY</p>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" id="low_to_high" value="low_to_high" wire:model="searchByPrice">
                        <label class="form-check-label" for="low_to_high">
                            PRICE LOW TO HIGH
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" id="high_to_low" value="high_to_low" wire:model="searchByPrice">
                        <label class="form-check-label" for="high_to_low">
                            PRICE HIGH TO LOW 
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" value="RECOMMENDED" wire:model="searchByPrice"  id="recommended">
                        <label class="form-check-label" for="recommended">
                            RECOMMENDED
                        </label>
                    </div>
                </div>
                <div class="filter-by mb-5">
                    <p class="text-gray">FILTER BY</p>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="Online"  wire:model="searchByFilter"  id="online">
                        <label class="form-check-label" for="online">
                            AVAILABLE ONLINE
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="New"  wire:model="searchByFilter"  id="new">
                        <label class="form-check-label" for="new">
                            NEW 
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="Must Have"  wire:model="searchByFilter"  id="must_have">
                        <label class="form-check-label" for="must_have">
                            MUST HAVE 
                        </label>
                    </div>
                </div>
                <div class="category mb-5">
                    <p class="text-gray">CATEGORY</p>
                    @foreach($collection->categories as $category)
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" wire:model="searchByCategories" value="{{  $category->id }}" id="cat{{ $category->slug }}">
                        <label class="form-check-label" for="cat{{ $category->slug }}">
                            {{ strtoupper($category->name) }}
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="selection mb-5">
                    <p class="text-gray">SELECTION FOR</p>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="Her"  wire:model="searchBySelection"  id="her">
                        <label class="form-check-label" for="her">
                            HER
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="Him" wire:model="searchBySelection"  id="him">
                        <label class="form-check-label" for="him">
                            HIM 
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="Children" wire:model="searchBySelection"  id="children">
                        <label class="form-check-label" for="children">
                            CHILDREN
                        </label>
                    </div>
                </div>
                <div class="collections mb-5">
                    <p class="text-gray">COLLECTION</p>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="collection" value="{{ $collection->slug }}" id="collection" checked disabled="">
                        <label class="form-check-label" for="collection">
                            {{ $collection->name }}
                        </label>
                    </div>
                </div>
                <div class="metal mb-5">
                    <p class="text-gray">METAL</p>
                    @foreach($materials as $material)
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" wire:model="searchByMaterials" value="{{  $material->id }}" id="cat{{ $material->slug }}" >
                        <label class="form-check-label" for="cat{{ $material->slug }}">
                            {{ strtoupper($material->name) }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</div>



</div>