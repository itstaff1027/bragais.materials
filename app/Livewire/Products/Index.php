<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Products;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class Index extends Component
{
    use WithPagination;

    public $product_id;

    #[Rule('required|max:15')] 
    public $product_sku;

    #[Rule('required|max:15')] 
    public $model;

    #[Rule('required|max:15')] 
    public $color;

    #[Rule('required|max:15')] 
    public $size;

    #[Rule('required|max:15')] 
    public $heel_height;

    #[Rule('required|max:15')] 
    public $category;

    #[Rule('required|max:15')] 
    public $price;

    #[Rule('required|max:15')] 
    public $stocks;

    // FILTERS - SEARCH
    public $product_sku_search = '';
    public $model_search = '';
    public $color_search = '';
    public $size_search = '';
    public $heel_search = '';
    public $category_search = '';
    public function render()
    {
        return view('livewire.products.index', [
            'products' => Products::where('products.product_sku', 'like', '%'.$this->product_sku_search.'%')
                ->where('products.model', 'like', '%'.$this->model_search.'%')
                ->where('products.color', 'like', '%'.$this->color_search.'%')
                ->where('products.size', 'like', '%'.$this->size_search.'%')
                ->where('products.heel_height', 'like', '%'.$this->heel_search.'%')
                ->where('products.category', 'like', '%'.$this->category_search.'%')
                ->paginate(25)
        ]);
    }
}

