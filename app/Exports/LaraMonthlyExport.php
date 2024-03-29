<?php

namespace App\Exports;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\packaging_material_logs;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Style;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use Carbon\Carbon;
class LaraMonthlyExport implements FromView, ShouldAutoSize
{
    // FILTERS - SEARCH
    public $filter_date;

    public $filter_date_range_first = '';
    public $filter_date_range_second = '';

    public $materials;
    public $dates;
    public $product_id;

    public $order_number;

    public $category;
    public $model;
    public $size;
    public $quantity;
    public $sold_from;

    public $year = 2024;
    public $month = 1;
    public $packaging_material_id;

    public function getDate(){
        $today = date('Y-m-d');
        return $today;
    }

    public function __construct($year, $month){
        $this->filter_date = $this->getDate();
        $this->year = $year;
        $this->month = $month;
    }

    public function view(): View
    {
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

        // if($this->sold_from){
        //     // $query->where('outgoing_product_logs.order_from', '=', $this->sold_from);
        //     // dd($products);
        // }

        $products = $query->get();
        
        // dd($products);
        // Prepare an associative array to store quantities based on model, color, heel height, and size
        $quantitiesUS = [];
        $quantitiesEURO = [];
        $quantitiesBELT = [];
        $totalQuantity = 0;

        foreach ($products as $product) {
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

            if($product->size >= 80 && $product->size <= 110){
                $key = "{$product->model},{$product->color},{$product->heel_height},{$product->order_from}";
                $size = $product->size;

                if (!isset($quantitiesBELT[$key])) {
                    $quantitiesBELT[$key] = [];
                }
                // If there's no quantity recorded for a size, it defaults to 0
                $quantitiesBELT[$key][$size] = $product->total_quantity;
            }
            
        }
        $test =0;
        return view('export.products.lara-monthly', compact('today', 'quantitiesUS', 'quantitiesEURO', 'quantitiesBELT', 'totalQuantity'));
    }

}
