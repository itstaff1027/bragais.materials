<?php

namespace App\Livewire\Inventory;

use App\Models\Materials;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
        // FILTERS - SEARCH
    public $material_sku_search = '';
    public $type_search = '';
    public $name_search = '';
    public $color_search = '';
    public $size_search = '';

    public $cart = [];

    public function addToCart($material){
        // Check if the material with the same ID already exists in the cart
        $existingItem = array_search($material['id'], array_column($this->cart, 'id'));

        if ($existingItem !== false) {
            // If the material already exists in the cart, increment the quantity by 1
            $this->cart[$existingItem]['quantity'] += 1;
        } else {
            // If the material does not exist in the cart, add it as a new item with quantity 1
            $material['quantity'] = 1;
            $this->cart[] = $material;
        }
    }

    
    public function removeFromCart($index)
    {
        if (isset($this->cart[$index])) {
            unset($this->cart[$index]);
            $this->cart = array_values($this->cart); // Re-index the array after removal
        }
    }

    public function store(){
        dd($this->cart);
    }
    
    public function render()
    {
        // return view('livewire.list-products', [
        //     'products' => ModelProducts::where('products.product_sku', 'like', '%'.$this->product_sku_search.'%')
        //         ->where('products.model', 'like', '%'.$this->model_search.'%')
        //         ->where('products.color', 'like', '%'.$this->color_search.'%')
        //         ->where('products.size', 'like', '%'.$this->size_search.'%')
        //         ->where('products.heel_height', 'like', '%'.$this->heel_search.'%')
        //         ->where('products.category', 'like', '%'.$this->category_search.'%')
        //         ->leftJoin(DB::raw('(SELECT product_id, SUM(stocks) as total_stocks FROM stock_logs GROUP BY product_id) as stock_logs'), 'products.id', '=', 'stock_logs.product_id')
        //         ->leftJoin(DB::raw('(SELECT product_id, SUM(stocks) as total_outlet_stocks FROM outlet_logs GROUP BY product_id) as outlet_logs'), 'products.id', '=', 'outlet_logs.product_id')
        //         ->leftJoin(DB::raw('(SELECT product_id, SUM(stocks) as total_display_stocks FROM display_logs GROUP BY product_id) as display_logs'), 'products.id', '=', 'display_logs.product_id')
        //         ->select('products.id', 'products.product_sku', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'products.price', 'products.order_from',
        //                   DB::raw('COALESCE(stock_logs.total_stocks, 0) as total_stocks'),
        //                   DB::raw('COALESCE(outlet_logs.total_outlet_stocks, 0) as total_outlet_stocks'),
        //                   DB::raw('COALESCE(display_logs.total_display_stocks, 0) as total_display_stocks'))
        //         ->groupBy('products.id', 'products.product_sku', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'products.price', 'products.order_from', 'stock_logs.total_stocks', 'outlet_logs.total_outlet_stocks', 'display_logs.total_display_stocks')
        //         ->paginate(25)
        // ]);
        return view('livewire.inventory.index', [
            'materials' => Materials::where('materials.material_sku', 'like', '%'.$this->material_sku_search.'%')
                ->where('materials.type', 'like', '%'.$this->type_search.'%')
                ->where('materials.name', 'like', '%'.$this->name_search.'%')
                ->where('materials.color', 'like', '%'.$this->color_search.'%')
                ->where('materials.size', 'like', '%'.$this->size_search.'%')
                ->leftJoin(DB::raw('(SELECT material_id, SUM(stocks) as total_stocks FROM materials_stocks GROUP BY material_id) as materials_stocks'), 'materials.id', '=', 'materials_stocks.material_id')
                ->select('materials.id', 'materials.material_sku', 'materials.type', 'materials.name', 'materials.color', 'materials.size', 'materials.unit_per',
                        DB::raw('COALESCE(materials_stocks.total_stocks, 0) as total_stocks'))
                ->groupBy('materials.id', 'materials.material_sku', 'materials.type', 'materials.name', 'materials.color', 'materials.size', 'materials.unit_per', 'materials_stocks.total_stocks')
                ->paginate(10)
        ]);
    }
}
