<?php

namespace App\Livewire\Products;

use App\Exports\OutGoingProductsExport;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class Summary extends Component
{
    use WithPagination;


    public $product_id;
    // FILTERS - SEARCH
    public $filter_date;

    public $filter_date_range_first = '';
    public $filter_date_range_second = '';

    public function getDate(){
        $today = date('Y-m-d');
        return $today;
    }

    public function __construct(){
        $this->filter_date = $this->getDate();
    }

    public function export() 
    {
        return Excel::download(new OutGoingProductsExport(), "OUTGOING_PRODUCT_{$this->getDate()}.xlsx");
    }

    public function render(){
        $today = $this->filter_date;

        $products = DB::table('outgoing_product_logs')
            ->whereDate(DB::raw('DATE(created_at)'), 'LIKE', '%' . $this->filter_date . '%')
            ->join('products', 'products.id', '=', 'outgoing_product_logs.product_id')
            ->select(
                'products.model',
                'products.color',
                'products.heel_height',
                'products.size',
                'outgoing_product_logs.quantity as total_quantity'
            )
            ->groupBy('products.model', 'products.color', 'products.heel_height', 'products.size', 'outgoing_product_logs.quantity')
            ->get();
            
            // dd($products);
        // Prepare an associative array to store quantities based on model, color, heel height, and size
        $quantitiesUS = [];
        $quantitiesEURO = [];

        foreach ($products as $product) {
            if($product->size >= 5 && $product->size <= 12){
                $key = "{$product->model}-{$product->color}-{$product->heel_height}";
                $size = $product->size;

                if (!isset($quantitiesUS[$key])) {
                    $quantitiesUS[$key] = [];
                }
                // If there's no quantity recorded for a size, it defaults to 0
                $quantitiesUS[$key][$size] = $product->total_quantity;
            }
            if($product->size >= 35 && $product->size <= 45){
                $key = "{$product->model}-{$product->color}-{$product->heel_height}";
                $size = $product->size;

                if (!isset($quantitiesEURO[$key])) {
                    $quantitiesEURO[$key] = [];
                }
                // If there's no quantity recorded for a size, it defaults to 0
                $quantitiesEURO[$key][$size] = $product->total_quantity;
            }
            
        }

        return view('livewire.products.summary', compact('today', 'quantitiesUS', 'quantitiesEURO'));
    }
}