<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\View\View;
use App\Models\ProductStocks;
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

class ProductSummaryExport implements FromView, ShouldAutoSize
{
    public $data;
    public $filter_date;
    public $dates = [];
    public $stocks = [];
    // public $products = [];
    public $newArray = [];

    public $first_range_date = '';
    public $second_range_date = '';

    public function __construct($firstDate, $secondDate){
        $this->first_range_date = $firstDate;
        $this->second_range_date = $secondDate;
        $this->filter_date = $this->getDate();
    }

    public function getDate(){
        $today = date('Y-m-d');
        return $today;
    }


    public function fetchData(){
        $datesQuery = DB::table('product_stocks')
        ->select(
            DB::raw('DATE(created_at) as date')
        )
        ->whereBetween(DB::raw('DATE(created_at)'), [$this->first_range_date, $this->second_range_date])
        ->groupBy(
            DB::raw('DATE(created_at)')
        )->get();

        $stocksQuery = ProductStocks::select(
            DB::raw('DATE(created_at) as date'),
            'product_id',
            DB::raw('SUM(stocks) as stocks' ),
            'status'
        )
        ->whereBetween(DB::raw('DATE(created_at)'), [$this->first_range_date, $this->second_range_date])
        ->groupBy(
            DB::raw('DATE(created_at)'),
            'product_id',
            'status'
        )->get();


        $productsQuery = ProductStocks::select(
            'products.id',
            'products.product_sku',
            'products.heel_height',
            DB::raw('SUM(stocks) as total_stocks')
        )
        ->leftJoin('products', 'products.id', '=', 'product_stocks.product_id')
        ->orderBy('products.heel_height', 'asc')
        ->orderBy('products.product_sku', 'asc')
        ->groupBy(
            'products.id',
            'products.product_sku',
            'products.heel_height',
        )
        ->get();


        $reArrays = array();

        foreach($productsQuery as $product){
            $productStocks = [];

            foreach($this->dates as $date){
                $dateStock = [
                    'date' => $date->date,
                    'incoming' => 0,
                    'outgoing' => 0
                ];

                foreach($stocksQuery as $stock){
                    if($stock->product_id == $product->id && $stock->date == $date->date){
                        if($stock->status == 'INCOMING'){
                            $dateStock['incoming'] = $stock->stocks;
                        } elseif ($stock->status == 'OUTGOING') {
                            $dateStock['outgoing'] = $stock->stocks;
                        }
                    }
                }

                $productStocks[] = $dateStock;
            }

            $reArrays[] = [
                'id' => $product->id,
                'product_sku' => $product->product_sku,
                'model' => $product->model,
                'color' => $product->color,
                'size' => $product->size,
                'heel_height' => $product->heel_height,
                'stocks' => $productStocks
            ];
        }

        $this->newArray = $reArrays;

        // dd($this->stocks);
    }

    public function view(): View
    {
        $datesQuery = DB::table('product_stocks')
        ->select(
            DB::raw('DATE(created_at) as date')
        )
        ->whereBetween(DB::raw('DATE(created_at)'), [$this->first_range_date, $this->second_range_date])
        ->groupBy(
            DB::raw('DATE(created_at)')
        )->get();

        $this->dates = $datesQuery;

        $stocksQuery = ProductStocks::select(
            DB::raw('DATE(created_at) as date'),
            'product_id',
            DB::raw('SUM(stocks) as stocks' ),
            'status'
        )
        ->whereBetween(DB::raw('DATE(created_at)'), [$this->first_range_date, $this->second_range_date])
        ->groupBy(
            DB::raw('DATE(created_at)'),
            'product_id',
            'status'
        )->get();


        $productsQuery = ProductStocks::select(
            'products.id',
            'products.product_sku',
            'products.heel_height',
            DB::raw('SUM(stocks) as total_stocks')
        )
        ->leftJoin('products', 'products.id', '=', 'product_stocks.product_id')
        ->orderBy('products.heel_height', 'asc')
        ->orderBy('products.product_sku', 'asc')
        ->groupBy(
            'products.id',
            'products.product_sku',
            'products.heel_height',
        )
        ->get();

        return view('export.products.product-summary', [
            'dates' => $this->dates ? $this->dates : [],
            'products' => $productsQuery,
            'stocks' => $stocksQuery,
        ]);
    }

}
