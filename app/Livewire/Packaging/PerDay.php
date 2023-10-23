<?php

namespace App\Livewire\Packaging;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PackagingMaterials;
use Illuminate\Support\Facades\DB;

class PerDay extends Component
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

    public function render()
    {
        // $today = date('Y-m-d');

        // $this->filter_date = $today;

        $getTotalPilon = PackagingMaterials::where('packaging_materials.name', 'like', '%PILON%')
        ->leftJoin(DB::raw('(SELECT packaging_material_id, SUM(STOCKS) as total_stocks FROM packaging_material_logs GROUP BY packaging_material_id) AS incoming_logs'), 'packaging_materials.id', '=', 'incoming_logs.packaging_material_id')
        ->leftJoin(DB::raw("(SELECT packaging_material_id, SUM(STOCKS) as released_stocks FROM packaging_material_logs WHERE status='OUTGOING' GROUP BY packaging_material_id) AS outgoing_logs"), 'packaging_materials.id', '=', 'outgoing_logs.packaging_material_id')
        ->select('packaging_materials.id', 'packaging_materials.name', 'packaging_materials.size', DB::raw('COALESCE(incoming_logs.total_stocks, 0) as total_stocks'), DB::raw('COALESCE(outgoing_logs.released_stocks, 0) as released_stocks'))
        ->groupBy('packaging_materials.id', 'packaging_materials.name', 'packaging_materials.size', 'incoming_logs.total_stocks', 'outgoing_logs.released_stocks')
        ->get();


        $getTotalRibbonToday = DB::table('packaging_material_logs')->where('packaging_material_logs.status', '=', 'OUTGOING')
        ->whereIn('packaging_material_logs.packaging_material_id', [19, 20])
        ->whereBetween(DB::raw('DATE(packaging_material_logs.created_at)'), [$this->filter_date_range_first, $this->filter_date_range_second])
        ->orWhereDate('packaging_material_logs.created_at', 'LIKE', '%'.$this->filter_date.'%')
        ->leftJoin(DB::raw('packaging_materials'), 'packaging_materials.id', '=', 'packaging_material_logs.packaging_material_id')
        ->leftJoin(DB::raw('products'), 'products.id', '=', 'packaging_material_logs.product_id')
        ->select(DB::raw('SUM(packaging_material_logs.stocks) as material_stocks'), 'packaging_materials.name', 
            'products.id as products_id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id')
        ->groupBy('packaging_materials.name', 'products.id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id')
        ->get();

        $getTotalRibbon = DB::table('packaging_material_logs')->where('packaging_material_logs.status', '=', 'OUTGOING')
        ->whereIn('packaging_material_logs.packaging_material_id', [19, 20])
        ->leftJoin(DB::raw('packaging_materials'), 'packaging_materials.id', '=', 'packaging_material_logs.packaging_material_id')
        ->leftJoin(DB::raw('products'), 'products.id', '=', 'packaging_material_logs.product_id')
        ->select(DB::raw('SUM(packaging_material_logs.stocks) as material_stocks'), 'packaging_materials.name', 
            'products.id as products_id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id')
        ->groupBy('packaging_materials.name', 'products.id', 'products.model', 'products.color', 'products.size', 'products.heel_height', 'products.category', 'packaging_material_logs.product_id')
        ->get();

        $incomingRibbonStocks = DB::table('packaging_material_logs')
        ->where('packaging_material_logs.status', '=', 'INCOMING')
        ->whereIn('packaging_material_logs.packaging_material_id', [19, 20])
        ->select(DB::raw('SUM(packaging_material_logs.stocks) as incoming_stocks'), 'packaging_material_logs.packaging_material_id')
        ->groupBy('packaging_material_logs.packaging_material_id')
        ->get();

        $outgoingRibbonStocks = DB::table('packaging_material_logs')
        ->where('packaging_material_logs.status', '=', 'OUTGOING')
        ->whereIn('packaging_material_logs.packaging_material_id', [19, 20])
        ->select(DB::raw('SUM(packaging_material_logs.stocks) as outgoing_stocks'), 'packaging_material_logs.packaging_material_id')
        ->groupBy('packaging_material_logs.packaging_material_id')
        ->get();


        return view('livewire.packaging.per-day', [
            'packaging_materials' => PackagingMaterials::leftJoin(DB::raw("(SELECT packaging_material_id, SUM(stocks) as total_stocks FROM packaging_material_logs WHERE status='INCOMING' and (DATE(created_at) LIKE '{$this->filter_date}%' OR DATE(created_at) BETWEEN '{$this->filter_date_range_first}' AND '{$this->filter_date_range_second}') GROUP BY packaging_material_id) AS added_stocks"), 'packaging_materials.id', '=', 'added_stocks.packaging_material_id')
                ->leftJoin(DB::raw('(SELECT packaging_material_id, SUM(stocks) as total_stocks FROM packaging_material_logs WHERE status=\'INCOMING\' GROUP BY packaging_material_id) AS beginning_stocks'), 'packaging_materials.id', '=', 'beginning_stocks.packaging_material_id')
                ->leftJoin(DB::raw('(SELECT packaging_material_id, SUM(stocks) as total_stocks FROM packaging_material_logs GROUP BY packaging_material_id) AS incoming_logs'), 'packaging_materials.id', '=', 'incoming_logs.packaging_material_id')
                ->leftJoin(DB::raw("(SELECT packaging_material_id, SUM(stocks) as released_stocks FROM packaging_material_logs WHERE status='OUTGOING' and (DATE(created_at) LIKE '{$this->filter_date}%' OR DATE(created_at) BETWEEN '{$this->filter_date_range_first}' AND '{$this->filter_date_range_second}') GROUP BY packaging_material_id) AS outgoing_logs"), 'packaging_materials.id', '=', 'outgoing_logs.packaging_material_id')
                ->select('packaging_materials.id', 'packaging_materials.name', 'packaging_materials.size', DB::raw('COALESCE(beginning_stocks.total_stocks, 0) as beginning_total_stocks'), DB::raw('COALESCE(added_stocks.total_stocks, 0) as added_total_stocks'), DB::raw('COALESCE(incoming_logs.total_stocks, 0) as total_stocks'), DB::raw('COALESCE(outgoing_logs.released_stocks, 0) as released_stocks'))
                ->groupBy('packaging_materials.id', 'packaging_materials.name', 'packaging_materials.size', 'incoming_logs.total_stocks', 'outgoing_logs.released_stocks', 'beginning_stocks.total_stocks', 'added_stocks.total_stocks')
                ->paginate(25),
            'getTotalPilon' => $getTotalPilon,
            'getTotalRibbonToday' => $getTotalRibbonToday,
            'getTotalRibbon' => $getTotalRibbon,
            'incomingRibbonStocks' => $incomingRibbonStocks,
            'outgoingRibbonStocks' => $outgoingRibbonStocks,
            'today' => $this->filter_date
        ]);
    }
}
