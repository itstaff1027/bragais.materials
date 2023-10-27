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


    public $packaging_material_id;

    public function getDate(){
        $today = date('Y-m-d');
        return $today;
    }

    public function __construct(){
        $this->filter_date = $this->getDate();
    }

    public function styles(Worksheet $sheet)
    {
        // Get the number of rows in your data
        // $rowCount = count($this->materials) + 5; // Add 1 for the header row

        // $countDates = count($this->dates);
        
        // Apply background color to specific cells
        $sheet->getStyle('A1:O1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF00FF'); // Set header row background color to Light Salmon
        
        // // Apply background color to the first column (assuming it's the date column)
        $sheet->getStyle('A2:O2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF00FF'); // Set date column background color to Yellow

        // // Center the text in row 1 (header row)
        $sheet->getStyle('A1:O1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // // Center the text in row 2
        $sheet->getStyle('A2:O2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
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
                $key = "{$product->model},{$product->color},{$product->heel_height}";
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
        $test =0;
        return view('export.products.summary', compact('today', 'quantitiesUS', 'quantitiesEURO'));
    }

}