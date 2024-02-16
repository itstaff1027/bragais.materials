<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Exports\LaraExport;
use Livewire\Attributes\Title;
use App\Exports\LaraMonthlyExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


#[Title('Lara Monthly')]
class LaraMonthly extends Component
{


    public $product_id;
    // FILTERS - SEARCH
    public $filter_date;

    public $filter_date_range_first = '';
    public $filter_date_range_second = '';
    public $order_from;

    public $year = 2024;
    public $month = 1;

    public function getDate(){
        $today = date('Y-m-d');
        return $today;
    }

    public function __construct(){
        $this->filter_date = $this->getDate();
    }

    public function export()
    {
        return Excel::download(new LaraMonthlyExport($this->year, $this->month), "OUTGOING_PRODUCT_{$this->getDate()}.xlsx");
    }

    public function filterBySoldFrom($value){
        $this->order_from = $value;
    }

    public function render(){
        $today = $this->filter_date;

        $query = DB::table('product_stocks')
            ->whereYear('created_at', '=', $this->year)
            ->whereMonth('created_at', '=', $this->month)
            ->where('product_stocks.status', '=', 'OUTGOING')
            ->join('products', 'products.id', '=', 'product_stocks.product_id')
            ->select(
                'products.model',
                'products.color',
                'products.heel_height',
                'products.size',
                'product_stocks.order_from',
                DB::raw('SUM(ABS(product_stocks.stocks)) as total_quantity')
            )
            ->groupBy(
                'products.model',
                'products.color',
                'products.heel_height',
                'products.size',
                'product_stocks.order_from',
            );

        // if($this->order_from){
        //     // $query->where('outgoing_product_logs.order_from', '=', $this->order_from);
        //     // dd($products);
        // }

        $products = $query->get();

        // dd($products);

        // dd($products);
        // dd($products);
        // Prepare an associative array to store quantities based on model, color, heel height, and size
        $quantitiesUS = [];
        $quantitiesEURO = [];
        $totalQuantity = 0;
        // dd($products);
        foreach ($products as $product) {
            // dd($product);
            $totalQuantity += $product->total_quantity;
            // $createdAtString = $product->created_at; // This is a string

            // Convert the string to a Carbon instance
            // $createdAt = Carbon::parse($createdAtString);

            // Format the created_at date as Y-m-d
            // $formattedDate = $createdAt->format('Y-m-d');
            if($product->size >= 5 && $product->size <= 12){
                $key = "{$product->model},{$product->color},{$product->heel_height},{$product->order_from}";
                $size = $product->size;

                if (!isset($quantitiesUS[$key])) {
                    $quantitiesUS[$key] = [];
                }
                // If there's no quantity recorded for a size, it defaults to 0
                $quantitiesUS[$key][$size] = $product->total_quantity;
            }
            if($product->size >= 35 && $product->size <= 45){
                $key = "{$product->model},{$product->color},{$product->heel_height},{$product->order_from}";
                $size = $product->size;

                if (!isset($quantitiesEURO[$key])) {
                    $quantitiesEURO[$key] = [];
                }
                // If there's no quantity recorded for a size, it defaults to 0
                $quantitiesEURO[$key][$size] = $product->total_quantity;
            }

        }       
        
        return view('livewire.products.lara-monthly', compact('today', 'quantitiesUS', 'quantitiesEURO', 'totalQuantity'));
    }
}
