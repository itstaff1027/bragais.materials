<?php

namespace App\Livewire\Products;

use App\Exports\ProductSummaryExport;
use Livewire\Component;
use App\Models\Products;
use App\Models\ProductStocks;
use Livewire\Attributes\Title;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\CursorPaginator;
use Maatwebsite\Excel\Facades\Excel;

#[Title('Product Summary')]
class ProductSummary extends Component
{

    public $data;
    public $dates = [];
    public $stocks = [];
    public $newArray = [];
    public $first_range_date = '';
    public $second_range_date = '';
    public $filter_date;

    public function mount(){
        // $this->year = DATE('Y');
        // $this->month = DATE('m');
        $this->filter_date = $this->getDate();
    }

    public function getDate(){
        $today = date('Y-m-d');
        return $today;
    }

    public function export()
    {
        return Excel::download(new ProductSummaryExport($this->first_range_date, $this->second_range_date), "MONTHLY_OUTGOING_PRODUCT_{$this->getDate()}.xlsx");
    }

    public function fetchData(){
        $datesQuery = DB::table('product_stocks')
        ->select(
                DB::raw('DATE(created_at) as date')
            )
        ->groupBy(
                DB::raw('DATE(created_at)')
            )
        ->get();
        $this->dates = $datesQuery;

        $stocksQuery = ProductStocks::select(
            DB::raw('DATE(created_at) as date'),
            'product_id',
            DB::raw('SUM(stocks) as stocks' ),
            'status'
        )->groupBy(
            DB::raw('DATE(created_at)'),
            'product_id',
            'status'
        )->get();

        $this->stocks = $stocksQuery;

        $productsQuery = ProductStocks::select(
            'products.id',
            'products.product_sku',
        )
        ->leftJoin('products', 'products.id', '=', 'product_stocks.product_id')
        ->groupBy(
            'products.id',
            'products.product_sku',
        )
        ->paginate(15);

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
    }

    public function render()
    {
        
        $datesQuery = DB::table('product_stocks')
        ->select(
            DB::raw('DATE(created_at) as date')
        );
        // ->whereBetween(DB::raw('DATE(created_at)'), [$this->first_range_date, $this->second_range_date])

        $stocksQuery = ProductStocks::select(
            DB::raw('DATE(created_at) as date'),
            'product_id',
            DB::raw('SUM(stocks) as stocks' ),
            'status'
        );
        // ->whereBetween(DB::raw('DATE(created_at)'), [$this->first_range_date, $this->second_range_date])


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
        ->paginate(10);

        $dates = $datesQuery->groupBy(
            DB::raw('DATE(created_at)')
        )->get();
        
        $stocks = $stocksQuery->groupBy(
            DB::raw('DATE(created_at)'),
            'product_id',
            'status'
        )->get();

        $this->dates = $dates;
        $this->stocks = $stocks;

        return view('livewire.products.product-summary', [
            'dates' => $this->dates ? $this->dates : [],
            'products' => $productsQuery,
            'stocks' => $stocksQuery,
        ]);
    }
}
