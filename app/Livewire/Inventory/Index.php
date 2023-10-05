<?php

namespace App\Livewire\Inventory;

use App\Models\Materials;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
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
            'materials' => Materials::paginate(25)
        ]);
    }
}
