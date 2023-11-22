<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class ProductLogs extends Component
{
    public function render()
    {
        $products = DB::table('product_stocks')
        ->select(
            'product_stocks.barcode_id',
            'product_stocks.order_number',
            DB::raw('SUM(product_stocks.stocks) as stocks'),
            'product_stocks.status',
            'products.model',
            'products.color',
            'products.size',
            'products.heel_height'
        )
        ->leftJoin('products', 'products.id', '=', 'product_stocks.product_id')
        ->groupBy(
            'product_stocks.barcode_id',
            'product_stocks.order_number',
            'product_stocks.status',
            'products.model',
            'products.color',
            'products.size',
            'products.heel_height'
        )
        ->orderBy('product_stocks.order_number', 'desc')
        ->paginate(10);

        return view('livewire.products.product-logs', [
            'products' => $products
        ]);
    }
}
