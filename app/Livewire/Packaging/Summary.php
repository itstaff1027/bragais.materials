<?php

namespace App\Livewire\Packaging;

use App\Exports\MaterialLogsExport;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class Summary extends Component
{
    use WithPagination;

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
        return Excel::download(new MaterialLogsExport($this->filter_date_range_first, $this->filter_date_range_second), "OUT_PACKAGING_MATERIAL_{$this->getDate()}.xlsx");
    }

    public function render()
    {
        // SUMMARY TEST
        // $dates = DB::table('packaging_material_logs')
        //     ->select(DB::raw('DATE(created_at) as date'))
        //     ->whereBetween(DB::raw('DATE(packaging_material_logs.created_at)'), [$this->filter_date_range_first, $this->filter_date_range_second])
        //     ->orWhereDate('packaging_material_logs.created_at', 'LIKE', '%'.$this->filter_date.'%')
        //     ->groupBy(DB::raw('DATE(created_at)'))
        //     ->get();

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

        // return view('livewire.packaging.summary', compact('dates', 'materials', 'getMaterialStocks', 'getMaterialStockss', 'getTotalRibbon'));

        // ORIGINAL SUMMARY
        // $dates = DB::table('packaging_material_logs')
        //     ->select(DB::raw('DATE(created_at) as date'))
        //     ->groupBy(DB::raw('DATE(created_at)'))
        //     ->get();

        $datesQuery = DB::table('packaging_material_logs')
        ->select(DB::raw('DATE(created_at) as date'));
        
        if ($this->filter_date_range_first && $this->filter_date_range_second) {
            $datesQuery->whereBetween(DB::raw('DATE(packaging_material_logs.created_at)'), [$this->filter_date_range_first, $this->filter_date_range_second]);
        } elseif ($this->filter_date) {
            $datesQuery->orWhereDate('packaging_material_logs.created_at', 'LIKE', '%' . $this->filter_date . '%');
        }
        
        $dates = $datesQuery->groupBy(DB::raw('DATE(created_at)'))->get();
    

        $materials = DB::table('packaging_materials')->get();

        $getTotalRibbon = DB::table('packaging_material_logs')->where('packaging_material_logs.status', '=', 'OUTGOING')
        ->whereIn('packaging_materials.name', ['BROWN_RIBBON', 'WHITE_RIBBON'])
        ->leftJoin(DB::raw('packaging_materials'), 'packaging_materials.id', '=', 'packaging_material_logs.packaging_material_id')
        ->leftJoin(DB::raw('products'), 'products.id', '=', 'packaging_material_logs.product_id')
        ->select(DB::raw('DATE(packaging_material_logs.created_at) as ribbon_date'), DB::raw('SUM(packaging_material_logs.stocks) as material_stocks'), 'packaging_materials.name', 
            'products.id as products_id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id', 'packaging_material_logs.packaging_material_id')
        ->groupBy('packaging_materials.name', 'products.id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id', 'ribbon_date', 'packaging_material_logs.packaging_material_id')
        ->get();

        $getMaterialStocks = DB::table('packaging_material_logs')
                    ->select(DB::raw('DATE(created_at) as date'), 'packaging_material_id', DB::raw('SUM(stocks) as total_stocks'), 'status')
                    ->groupBy(DB::raw('DATE(created_at)'), 'packaging_material_id', 'status')
                    ->get();

        return view('livewire.packaging.summary', compact('dates', 'materials', 'getMaterialStocks', 'getTotalRibbon'));

    }
}
