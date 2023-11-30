<?php

namespace App\Livewire\Products;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

#[Title('On Stock')]
class OnStock extends Component
{
    // FILTERS - SEARCH
    public $product_sku_search = '';
    public $model_search = '';
    public $color_search = '';
    public $size_search = '';
    public $heel_search = '';
    public $category_search = '';
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
    public function render()
    {
        return view('livewire.products.on-stock', [
            'products' => Products::where('products.product_sku', 'like', '%'.$this->product_sku_search.'%')
                ->where('products.model', 'like', '%'.$this->model_search.'%')
                ->where('products.color', 'like', '%'.$this->color_search.'%')
                ->where('products.size', 'like', '%'.$this->size_search.'%')
                ->where('products.heel_height', 'like', '%'.$this->heel_search.'%')
                ->where('products.category', 'like', '%'.$this->category_search.'%')
                ->leftJoin(DB::raw('(SELECT product_id, SUM(stocks) as total_stocks FROM product_stocks WHERE status=\'INCOMING\' GROUP BY product_id) as product_stocks'), 'products.id', '=', 'product_stocks.product_id')
                ->select('products.id', 'products.product_sku', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', DB::raw('COALESCE(product_stocks.total_stocks, 0) as product_total_stocks'))
                ->groupBy('products.id', 'products.product_sku', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'product_total_stocks')
                ->paginate(25)
        ]);
    }
}
