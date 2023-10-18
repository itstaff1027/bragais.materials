<?php

namespace App\Livewire\Inventory;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

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
        // return Excel::download(new MaterialLogsExport($this->filter_date_range_first, $this->filter_date_range_second), "OUT_PACKAGING_MATERIAL_{$this->getDate()}.xlsx");
    }

    public function render()
    {
        $today = $this->filter_date;

        $dates = DB::table('packaging_material_logs')
            ->whereDate(DB::raw('DATE(created_at)'), 'LIKE', '%'.$this->filter_date.'%')
            ->select(DB::raw('DATE(created_at) as date'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->first();
    
        $products = DB::table('packaging_material_logs')
            ->whereDate(DB::raw('DATE(created_at)'), 'LIKE', '%'.$this->filter_date.'%')
            ->Join(DB::raw('products'), 'products.id', '=', 'packaging_material_logs.product_id')
            ->select(DB::raw('DATE(packaging_material_logs.created_at) as date'), 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id')
            ->groupBy('products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id', 'date')
            ->get();

        return view('livewire.inventory.summary', compact('dates', 'today','products'));

    }
}
