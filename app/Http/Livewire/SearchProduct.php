<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class SearchProduct extends Component
{
    public $query;
    public $search_products;
    public $highlightIndex;

    public function mount()
    {
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->query = '';
        $this->search_products = [];
        $this->highlightIndex = 0;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->search_products) - 1) {
            $this->highlightIndex = 0;
            return;
        }
        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->search_products) - 1;
            return;
        }
        $this->highlightIndex--;
    }

    public function selectPost()
    {
        $post = $this->search_products[$this->highlightIndex] ?? null;
        if ($post) {
            $this->redirect(route('search_products.single', $post['slug']));
        }
    }

    public function updatedQuery()
    {
        $this->search_products = Product::where('status', 'Published')->withCount('attributes')->whereLike(['name'], $this->query)
        ->limit(6)->inRandomOrder()->get();
    }

    public function render()
    {
        // sleep(1);

        // $search_products = Post::where('title', 'like', '%'.$this->term.'%')->get()->toArray()
        // // $search_products = Post::search($this->term)->paginate(10);

        // $data = [
        //  'search_products' => $search_products,
        // ];
        return view('livewire.search-product');
    }
}
