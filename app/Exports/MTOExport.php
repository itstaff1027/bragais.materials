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
class MTOExport implements FromView, ShouldAutoSize
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
        $today = date('m');
        return $today;
    }

    public function __construct($month){
        $this->filter_date = $month;
    }

    public function view(): View
    {
        $today = $this->filter_date;

        $query = DB::table('mtos')
            ->whereMonth(DB::raw('DATE(created_at)'), '=', $this->filter_date)
            ->select(
                'agent_number',  
                'order_number',
                'customer_details',
                'model',
                'color',
                'size',
                'heel_height',
                'heel_type',
                'round',
                'packaging_type',
                'sold_date',
                'remarks',
                'notes',
                'is_replacement'
            )
            ->groupBy(
                'agent_number',  
                'order_number',
                'customer_details',
                'model',
                'color',
                'size',
                'heel_height',
                'heel_type',
                'round',
                'packaging_type',
                'sold_date',
                'remarks',
                'notes',
                'is_replacement'
            );

        $MTOs = $query->get();

        return view('export.products.mto', compact('MTOs'));
    }

}
