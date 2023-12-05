<?php

namespace App\Livewire\Products;

use App\Models\User;
use Livewire\Component;
use App\Models\Products;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\DB;

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

    public $filterProducts = 0;

    public $cart = [];

    public function addToCart($product){
        // Check if the product with the same ID already exists in the cart
        $existingItem = array_search($product['id'], array_column($this->cart, 'id'));

        if ($existingItem !== false) {
            // If the product already exists in the cart, increment the quantity by 1
            $this->cart[$existingItem]['quantity'] += 1;
        } else {
            // If the product does not exist in the cart, add it as a new item with quantity 1
            $product['quantity'] = 1;
            $this->cart[] = $product;
        }
    }

    
    public function removeFromCart($index)
    {
        if (isset($this->cart[$index])) {
            unset($this->cart[$index]);
            $this->cart = array_values($this->cart); // Re-index the array after removal
        }
        // dd($index);
    }

    public function store(){
        dd($this->cart);
    }

    public function filterStocks($value){
        $this->filterProducts = $value;
    }


    public function render()
    {
        
        $query = Products::select(
                'products.id', 
                'products.product_sku', 
                'products.model', 
                'products.color', 
                'products.size', 
                'products.heel_height', 
                'products.category', 
                DB::raw('COALESCE(product_stocks.total_stocks, 0) as product_total_stocks'),
                DB::raw('COALESCE(outlet_product_stocks.total_stocks, 0) as outlet_product_total_stocks')
            )
        ->where('products.product_sku', 'like', '%'.$this->product_sku_search.'%')
        ->where('products.model', 'like', '%'.$this->model_search.'%')
        ->where('products.color', 'like', '%'.$this->color_search.'%')
        ->where('products.size', 'like', '%'.$this->size_search.'%')
        ->where('products.heel_height', 'like', '%'.$this->heel_search.'%')
        ->where('products.category', 'like', '%'.$this->category_search.'%')
        ->leftJoin(
                DB::raw('(SELECT product_id, SUM(stocks) as total_stocks FROM product_stocks GROUP BY product_id) as product_stocks'), 'products.id', '=', 'product_stocks.product_id'
            )
        ->leftJoin(
            DB::raw('(SELECT product_id, SUM(stocks) as total_stocks FROM outlet_product_stocks GROUP BY product_id) as outlet_product_stocks'), 'products.id', '=', 'outlet_product_stocks.product_id'
        )
        ->groupBy(
                'products.id', 
                'products.product_sku', 
                'products.model', 
                'products.color', 
                'products.size', 
                'products.heel_height', 
                'products.category', 
                'product_total_stocks',
                'outlet_product_total_stocks'
            )
        ->orderBy('products.id', 'asc');

        if ($this->filterProducts == 1) {
            $query->where('product_stocks.total_stocks', '>=', 0);
        }

        $products = $query->paginate(25);

        return view('livewire.products.index', [
            'products' => $products
        ]);
    }
}

