<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class ProductListing extends Component
{
    use WithPagination;

    // protected $products;
    public $materials, 
    $collection, 
    // $products, 
    $perPage = 12,
    $hasMorePages, 
    $total_products = 0, 
    $items_showing = 0,
    $currentPage = '', 
    $lastPage = '', 
    $pageNumber = 0, 
    $searchByMaterials = [], 
    $searchByCategories = [], 
    $searchByPrice, 
    $searchBySelection = [], 
    $searchByFilter = [];


    // public function mount()
    // {
    //     $this->products = new Collection();

    // }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function loadProducts()
    {   
        $this->perPage += 3;
    }


    public function render()
    {   

        sleep(1);
        $collection = $this->collection;

        $products = Product::query()->when($this->searchByMaterials, function($q_material){
            $q_material->whereIn('material_id', $this->searchByMaterials);
        })
        ->when($this->searchByCategories, function($q_category) {
            $q_category->join('product_categories', 'product_categories.product_id', '=', 'products.id')
            ->join('categories', 'product_categories.category_id', '=', 'categories.id')
            ->distinct('products.id')
            ->whereIn('product_categories.category_id', $this->searchByCategories)
            ->get();
        })
        ->when($this->searchBySelection, function($q_selection) {
            $q_selection->join('product_conditions as s_pc', 's_pc.product_id', '=', 'products.id')
            ->join('conditions as s_c', 's_pc.condition_id', '=', 's_c.id')
            ->distinct('products.id')
            ->whereIn('s_c.name', $this->searchBySelection)
            ->get();
        })
        ->when($this->searchByFilter, function($q_filter) {
            $q_filter->join('product_conditions as q_pc', 'q_pc.product_id', '=', 'products.id')
            ->join('conditions as f_c', 'q_pc.condition_id', '=', 'f_c.id')
            ->distinct('products.id')
            ->whereIn('f_c.name', $this->searchByFilter)
            ->get();
        })
        ->when($this->searchByPrice, function($q_price){

            $q_price->when($this->searchByPrice == 'high_to_low', function($q_price2){
                $q_price2->select('products.id', 'product_attributes.attribute_price', 'products.slug', 'products.thumbnail', 'products.price', 'products.name')
                ->join('product_attributes', 'product_attributes.product_id', '=', 'products.id')
                ->join('attributes', 'product_attributes.attribute_id', '=', 'attributes.id')
                ->whereIn('products.id', function ($query) {
                    $query->select('product_id')
                    ->from('product_attributes')
                    ->groupBy('product_id');
                })
                ->whereIn('product_attributes.attribute_price', function ($query) {
                    $query->selectRaw('MIN(attribute_price)')
                    ->from('product_attributes')
                    ->groupBy('product_id');
                })
                ->orderBy('product_attributes.attribute_price', 'desc')
                ->get();

            })->when($this->searchByPrice == 'low_to_high', function($q_price2){
                $q_price2->select('products.id', 'product_attributes.attribute_price', 'products.slug', 'products.thumbnail', 'products.price', 'products.name')
                ->join('product_attributes', 'product_attributes.product_id', '=', 'products.id')
                ->join('attributes', 'product_attributes.attribute_id', '=', 'attributes.id')
                ->whereIn('products.id', function ($query) {
                    $query->select('product_id')
                    ->from('product_attributes')
                    ->groupBy('product_id');
                })
                ->whereIn('product_attributes.attribute_price', function ($query) {
                    $query->selectRaw('MIN(attribute_price)')
                    ->from('product_attributes')
                    ->groupBy('product_id');
                })
                ->orderBy('product_attributes.attribute_price', 'asc')
                ->get();

            })
            ->when($this->searchByPrice == 'RECOMMENDED', function($q_recommended){
                $q_recommended->join('product_conditions as p_c', 'p_c.product_id', '=', 'products.id')
                ->join('conditions as c', 'p_c.condition_id', '=', 'c.id')
                ->distinct('products.id')
                ->where('c.name', 'RECOMMENDED')
                ->get();
            });
        })
        ->withCount('attributes')
        ->where(['products.collection_id' => $collection->id, 'products.status' => 'Published'])
        ->paginate($this->perPage, ['*'], 'page', $this->pageNumber);

        // $this->total_products += $products->total();

        // $this->items_showing +=  $products->count();

        // $this->lastPage =  $products->lastPage();

        // $this->pageNumber += 1;

        $this->hasMorePages = $products->hasMorePages();


        return view('livewire.product-listing', ['products' => $products]);
        
    }
}
