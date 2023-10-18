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

class MaterialLogsExport implements FromView, ShouldAutoSize, WithStyles
// , WithStyles, WithBackgroundColor
{
    // FILTERS - SEARCH
    public $filter_date;

    public $filter_date_range_first = '';
    public $filter_date_range_second = '';

    public $materials;
    public $dates;

    public function getDate(){
        $today = date('Y-m-d');
        return $today;
    }

    public function __construct($range_first_date, $range_second_date){
        $this->filter_date = $this->getDate();
        $this->filter_date_range_first = $range_first_date;
        $this->filter_date_range_second = $range_second_date;
    }

    public function view(): View
    {
        // $dates = DB::table('packaging_material_logs')
        // ->select(DB::raw('DATE(created_at) as date'))
        // ->whereBetween(DB::raw('DATE(packaging_material_logs.created_at)'), [$this->filter_date_range_first, $this->filter_date_range_second])
        // ->orWhereDate('packaging_material_logs.created_at', 'LIKE', '%'.$this->filter_date.'%')
        // ->groupBy(DB::raw('DATE(created_at)'))
        // ->get();

        // $materials = DB::table('packaging_materials')->get();

        // $getTotalRibbon = DB::table('packaging_material_logs')->where('packaging_material_logs.status', '=', 'OUTGOING')
        // ->Join(DB::raw('packaging_materials'), 'packaging_materials.id', '=', 'packaging_material_logs.packaging_material_id')
        // ->Join(DB::raw('products'), 'products.id', '=', 'packaging_material_logs.product_id')
        // ->select(DB::raw('DATE(packaging_material_logs.created_at) as ribbon_date'), DB::raw('SUM(packaging_material_logs.stocks) as material_stocks'), 'packaging_materials.name', 
        //     'products.id as products_id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id')
        // ->groupBy('packaging_materials.name', 'products.id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id', 'ribbon_date')
        // ->get();

        // $getMaterialStocks = DB::table('packaging_material_logs')
        //             ->select(DB::raw('DATE(created_at) as date'), 'packaging_material_id', DB::raw('SUM(stocks) as total_stocks'), 'status')
        //             ->groupBy(DB::raw('DATE(created_at)'), 'packaging_material_id', 'status')
        //             ->get();
        // $getMaterialStockss = DB::table('packaging_material_logs')
        //             ->select(DB::raw('packaging_material_id'), 'status', DB::raw('SUM(stocks) as total_stocks'))
        //             ->groupBy(DB::raw('packaging_material_id'), 'status')
        //             ->get();

        // return view('summary', compact('dates', 'materials', 'getMaterialStocks', 'getMaterialStockss', 'getTotalRibbon'));

        $datesQuery = DB::table('packaging_material_logs')
        ->select(DB::raw('DATE(created_at) as date'));
        
        if ($this->filter_date_range_first && $this->filter_date_range_second) {
            $datesQuery->whereBetween(DB::raw('DATE(packaging_material_logs.created_at)'), [$this->filter_date_range_first, $this->filter_date_range_second]);
        } elseif ($this->filter_date) {
            $datesQuery->orWhereDate('packaging_material_logs.created_at', 'LIKE', '%' . $this->filter_date . '%');
        }
        
        $dates = $datesQuery->groupBy(DB::raw('DATE(created_at)'))->get();
        $this->dates = $dates;

        $materials = DB::table('packaging_materials')->get();
        $this->materials = $materials;

        $getTotalRibbon = DB::table('packaging_material_logs')->where('packaging_material_logs.status', '=', 'OUTGOING')
        ->Join(DB::raw('packaging_materials'), 'packaging_materials.id', '=', 'packaging_material_logs.packaging_material_id')
        ->Join(DB::raw('products'), 'products.id', '=', 'packaging_material_logs.product_id')
        ->select(DB::raw('DATE(packaging_material_logs.created_at) as ribbon_date'), DB::raw('SUM(packaging_material_logs.stocks) as material_stocks'), 'packaging_materials.name', 
            'products.id as products_id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id', 'packaging_material_logs.packaging_material_id')
        ->groupBy('packaging_materials.name', 'products.id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id', 'ribbon_date', 'packaging_material_logs.packaging_material_id')
        ->get();

        $getMaterialStocks = DB::table('packaging_material_logs')
                    ->select(DB::raw('DATE(created_at) as date'), 'packaging_material_id', DB::raw('SUM(stocks) as total_stocks'), 'status')
                    ->groupBy(DB::raw('DATE(created_at)'), 'packaging_material_id', 'status')
                    ->get();

        return view('summary', compact('dates', 'materials', 'getMaterialStocks', 'getTotalRibbon'));
    }

    public function styles(Worksheet $sheet)
    {
        // Get the number of rows in your data
        // $rowCount = count($this->materials) + 5; // Add 1 for the header row

        // $countDates = count($this->dates);
        
        // Apply background color to specific cells
        $sheet->getStyle('A1:O1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF00FF'); // Set header row background color to Light Salmon
        
        // Apply background color to the first column (assuming it's the date column)
        $sheet->getStyle('A2:O2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF00FF'); // Set date column background color to Yellow

        // Center the text in row 1 (header row)
        $sheet->getStyle('A1:O1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Center the text in row 2
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

    

    // public function backgroundColor()
    // {
    //     // Return RGB color code.
    //     return '000000';
    
    //     // Return a Color instance. The fill type will automatically be set to "solid"
    //     return new Color(Color::COLOR_BLUE);
    
    //     // Or return the styles array
    //     return [
    //          'fillType'   => Fill::FILL_GRADIENT_LINEAR,
    //          'startColor' => ['argb' => Color::COLOR_RED],
    //     ];
    // }
}
