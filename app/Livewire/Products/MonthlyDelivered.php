<?php

namespace App\Livewire\Products;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MonthlyDeliveredExport;

#[Title('Monthly Outgoing Summary')]
class MonthlyDelivered extends Component
{
    use WithPagination;


    public $product_id;
    // FILTERS - SEARCH
    public $filter_date;

    public $filter_date_range_first = '';
    public $filter_date_range_second = '';

    public $order_from;

    public function getDate(){
        $today = date('Y-m-d');
        return $today;
    }

    public function __construct(){
        $this->filter_date = $this->getDate();
    }

    
    public function filterBySoldFrom($value){
        $this->order_from = $value;
    }

    public function export() 
    {
        return Excel::download(new MonthlyDeliveredExport($this->order_from), "OUTGOING_PRODUCT_MONTHLY_{$this->getDate()}.xlsx");
    }
    public function render()
    {   
        $today = $this->filter_date;
        $month = Date('m');
        $year = Date('Y');
        $query = DB::table('outgoing_product_logs')
            ->whereDate(DB::raw('MONTH(created_at)'), '=', $month)
            ->whereDate(DB::raw('YEAR(created_at)'), '=', $year)
            ->join('products', 'products.id', '=', 'outgoing_product_logs.product_id')
            ->select(
                'outgoing_product_logs.closed_sale_date',
                'outgoing_product_logs.order_number',
                'outgoing_product_logs.created_at',
                'outgoing_product_logs.courier',
                'products.model',
                'products.color',
                'products.heel_height',
                'products.size',    
                DB::raw('SUM(outgoing_product_logs.quantity) as total_quantity')
            )
            ->groupBy(
                'outgoing_product_logs.closed_sale_date', 
                'outgoing_product_logs.order_number',
                'outgoing_product_logs.created_at',
                'outgoing_product_logs.courier',
                'products.model', 
                'products.color', 
                'products.heel_height', 
                'products.size',
            );


        if($this->order_from){
            $query->where('outgoing_product_logs.order_from', '=', $this->order_from);
            // dd($products);
        }

        $products = $query->get();
            
        // dd($products);
        // Prepare an associative array to store quantities based on model, color, heel height, and size
        $quantitiesUS = [];
        $quantitiesEURO = [];
        $totalQuantity = 0;

        foreach ($products as $product) {
            $totalQuantity += $product->total_quantity;
            $createdAtString = $product->created_at; // This is a string

            // Convert the string to a Carbon instance
            $createdAt = Carbon::parse($createdAtString);

            // Format the created_at date as Y-m-d
            $formattedDate = $createdAt->format('Y-m-d');
            if($product->size >= 5 && $product->size <= 12){
                $key = "{$product->model},{$product->color},{$product->heel_height},{$product->closed_sale_date},{$product->order_number},{$formattedDate},{$product->courier}";
                $size = $product->size;

                if (!isset($quantitiesUS[$key])) {
                    $quantitiesUS[$key] = [];
                }
                // If there's no quantity recorded for a size, it defaults to 0
                $quantitiesUS[$key][$size] = $product->total_quantity;
            }
            if($product->size >= 35 && $product->size <= 45){
                $key = "{$product->model},{$product->color},{$product->heel_height},{$product->closed_sale_date},{$product->order_number},{$formattedDate},{$product->courier}";
                $size = $product->size;

                if (!isset($quantitiesEURO[$key])) {
                    $quantitiesEURO[$key] = [];
                }
                // If there's no quantity recorded for a size, it defaults to 0
                $quantitiesEURO[$key][$size] = $product->total_quantity;
            }
            
        }
        return view('livewire.products.monthly-delivered', compact('today', 'quantitiesUS', 'quantitiesEURO', 'totalQuantity'));
    }
}
