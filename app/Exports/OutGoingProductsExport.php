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
class OutGoingProductsExport implements FromView, ShouldAutoSize, WithStyles
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


    public $packaging_material_id;

    public function getDate(){
        $today = date('Y-m-d');
        return $today;
    }

    public function __construct($soldFrom){
        $this->filter_date = $this->getDate();
        $this->sold_from = $soldFrom;
    }

    public function styles(Worksheet $sheet)
    {
        // Get the number of rows in your data
        // $rowCount = count($this->materials) + 5; // Add 1 for the header row

        // $countDates = count($this->dates);
        
        // Apply background color to specific cells
        $sheet->getStyle('A1:R1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF00FF'); // Set header row background color to Light Salmon
        
        // // Apply background color to the first column (assuming it's the date column)
        $sheet->getStyle('A2:R2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF00FF'); // Set date column background color to Yellow

        // // Center the text in row 1 (header row)
        $sheet->getStyle('A1:R1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // // Center the text in row 2
        $sheet->getStyle('A2:R2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // $colors = ['00FF00', 'FF0000', '0000FF'];
        
        return [
            // Style the first row as bold text.
            1    => [
                'font' => [
                        'bold' => true,
                        'italic' => true,
                        'size' => 30,
                    ]
            ],
            2    => [
                'font' => [
                    'bold' => true,
                    'italic' => true,
                    'size' => 30,
                ]
            ],
        ];
    }

    public function view(): View
    {
        $today = $this->filter_date;

        $query = DB::table('outgoing_product_logs')
            ->whereDate(DB::raw('DATE(created_at)'), 'LIKE', '%' . $this->filter_date . '%')
            ->join('products', 'products.id', '=', 'outgoing_product_logs.product_id')
            ->select(
                'outgoing_product_logs.closed_sale_date',
                'outgoing_product_logs.order_number',
                'outgoing_product_logs.created_at',
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
                'products.model', 
                'products.color', 
                'products.heel_height', 
                'products.size',
            );


        if($this->sold_from){
            $query->where('outgoing_product_logs.order_from', '=', $this->sold_from);
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
                $key = "{$product->model},{$product->color},{$product->heel_height},{$product->closed_sale_date},{$product->order_number},{$formattedDate}";
                $size = $product->size;

                if (!isset($quantitiesUS[$key])) {
                    $quantitiesUS[$key] = [];
                }
                // If there's no quantity recorded for a size, it defaults to 0
                $quantitiesUS[$key][$size] = $product->total_quantity;
            }
            if($product->size >= 35 && $product->size <= 45){
                $key = "{$product->model},{$product->color},{$product->heel_height},{$product->closed_sale_date},{$product->order_number},{$formattedDate}";
                $size = $product->size;

                if (!isset($quantitiesEURO[$key])) {
                    $quantitiesEURO[$key] = [];
                }
                // If there's no quantity recorded for a size, it defaults to 0
                $quantitiesEURO[$key][$size] = $product->total_quantity;
            }
            
        }
        $test =0;
        return view('export.products.summary', compact('today', 'quantitiesUS', 'quantitiesEURO', 'totalQuantity'));
    }

}
